#!/usr/bin/env bash
set -euo pipefail

API_KEY="${NUMBERCHECKER_API_KEY:-YOUR_API_KEY}"
BASE="${NUMBERCHECKER_BASE_URL:-https://api.numberchecker.cloud/api/v1}"
SERVICE_SLUG="${NUMBERCHECKER_SERVICE_SLUG:-whatsapp-checker}"
COUNTRY_CC="${NUMBERCHECKER_COUNTRY_CC:-92}"
INPUT_FILE="${NUMBERCHECKER_INPUT_FILE:-sample-data/numbers.txt}"

echo "Checking API access..."
curl -sS -H "Authorization: Bearer ${API_KEY}" "${BASE}/test"
echo

echo "Checking balance..."
curl -sS -H "Authorization: Bearer ${API_KEY}" "${BASE}/balance"
echo

echo "Validating upload without spending credits..."
curl -sS -X POST "${BASE}/jobs/validate" \
  -H "Authorization: Bearer ${API_KEY}" \
  -F "service_slug=${SERVICE_SLUG}" \
  -F "country_cc=${COUNTRY_CC}" \
  -F "compliance_confirm=1" \
  -F "file=@${INPUT_FILE}"
echo

echo "Create the real job only after validation passes:"
echo "curl -X POST ${BASE}/jobs -H 'Authorization: Bearer ...' -H 'Idempotency-Key: unique-key' -F ..."

