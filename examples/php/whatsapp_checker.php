<?php

declare(strict_types=1);

$apiKey = getenv('NUMBERCHECKER_API_KEY') ?: 'YOUR_API_KEY';
$base = getenv('NUMBERCHECKER_BASE_URL') ?: 'https://api.numberchecker.cloud/api/v1';
$serviceSlug = getenv('NUMBERCHECKER_SERVICE_SLUG') ?: 'whatsapp-checker';
$countryCc = getenv('NUMBERCHECKER_COUNTRY_CC') ?: '92';
$inputFile = getenv('NUMBERCHECKER_INPUT_FILE') ?: __DIR__ . '/../../sample-data/numbers.txt';

function api_json(string $method, string $url, string $apiKey, array $fields = [], array $extraHeaders = []): array {
    $headers = array_merge(['Authorization: Bearer ' . $apiKey], $extraHeaders);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $method === 'POST' ? $fields : null,
        CURLOPT_TIMEOUT => 120,
    ]);

    $body = curl_exec($ch);
    if ($body === false) {
        throw new RuntimeException(curl_error($ch));
    }
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $decoded = json_decode((string)$body, true);
    if ($status >= 400) {
        throw new RuntimeException($body);
    }
    return is_array($decoded) ? $decoded : [];
}

function upload_fields(string $serviceSlug, string $countryCc, string $inputFile): array {
    return [
        'service_slug' => $serviceSlug,
        'country_cc' => $countryCc,
        'compliance_confirm' => '1',
        'file' => new CURLFile($inputFile, 'text/plain', basename($inputFile)),
    ];
}

print_r(api_json('GET', "$base/test", $apiKey));
print_r(api_json('GET', "$base/balance", $apiKey));

$dryRun = api_json('POST', "$base/jobs/validate", $apiKey, upload_fields($serviceSlug, $countryCc, $inputFile));
print_r($dryRun);

$job = api_json(
    'POST',
    "$base/jobs",
    $apiKey,
    upload_fields($serviceSlug, $countryCc, $inputFile),
    ['Idempotency-Key: ' . bin2hex(random_bytes(16))]
);
print_r($job);

$jobId = (int)$job['job_id'];
do {
    sleep(30);
    $status = api_json('GET', "$base/jobs/$jobId", $apiKey);
    print_r($status);
} while (empty($status['job']['download_available']));

$ch = curl_init("$base/jobs/$jobId/download");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
    CURLOPT_TIMEOUT => 120,
]);
$file = curl_exec($ch);
if ($file === false) {
    throw new RuntimeException(curl_error($ch));
}
curl_close($ch);
file_put_contents(__DIR__ . "/result_$jobId.txt", $file);
echo "saved result_$jobId.txt\n";

