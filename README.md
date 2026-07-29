# NumberChecker API Examples

Code examples for integrating the NumberChecker.cloud API into bulk contact verification workflows.

NumberChecker.cloud helps verify and clean contact lists before outreach, CRM import, campaign preparation, or internal data processing. The API supports services such as WhatsApp number checking, phone number status detection, RCS status checks, iOS/iMessage status checks, Telegram checks, email verification, and carrier/network lookup.

API docs: https://docs.numberchecker.cloud  
API base URL: `https://api.numberchecker.cloud/api/v1`  
Website: https://www.numberchecker.cloud

## What's Included

This repository includes working examples for common API tasks:

- Testing API access with `GET /test`
- Listing available services with `GET /services`
- Checking account balance with `GET /balance`
- Validating a TXT upload before processing with `POST /jobs/validate`
- Creating a processing job with `POST /jobs`
- Polling job status with `GET /jobs/{job_id}`
- Downloading completed results with `GET /jobs/{job_id}/download`

Examples are included for:

- cURL
- Python
- Node.js
- PHP

## Use Cases

These examples are useful when building tools for:

- Bulk WhatsApp number checker integrations
- Phone number status verification
- RCS availability checking
- iOS/iMessage number status checking
- Telegram number or activity checks
- Bulk email verification
- CRM contact list cleaning
- Lead file filtering before campaign launch
- TXT or CSV contact validation workflows

## Quick Start

Copy `.env.example` to `.env` and add your API key:

```bash
NUMBERCHECKER_API_KEY=your_api_key_here
```

Prepare a TXT file with one phone number or email address per line.

Important: the included `sample-data/numbers.txt` file is only a small format example. Real uploads must follow the current API limits shown in the official docs.

## Authentication

Send your API key as a bearer token:

```bash
Authorization: Bearer YOUR_API_KEY
```

Never commit real API keys, customer lists, or private contact data to a public repository.

## Common Service Slugs

| Service | Slug |
|---|---|
| WhatsApp Number Checker | `whatsapp-checker` |
| Number Status Detection | `number-status` |
| RCS Status Detection | `rcs-status` |
| iOS Dynamic Status Detection | `ios-dynamics` |
| iOS Static Status Detection | `ios-static` |
| Telegram Status Detection | `telegram-status` |
| Telegram Activity Detection | `telegram-days` |

For the current live service catalog, call:

```bash
curl -H "Authorization: Bearer YOUR_API_KEY" \
  https://api.numberchecker.cloud/api/v1/services
```

## Upload Flow

The recommended production flow is:

1. Validate the file first with `/jobs/validate`.
2. Create the job only after validation passes.
3. Send a unique `Idempotency-Key` when creating a job.
4. Poll the job status every 30-60 seconds.
5. Download the result when `download_available` is `true`.

Most phone-number services require:

```text
service_slug
country_cc
compliance_confirm=1
file
```

Email verification services may not require `country_cc`.

## Example Files

| File | Purpose |
|---|---|
| `examples/curl/whatsapp-checker.sh` | Simple terminal example for API access, balance, and validation |
| `examples/python/whatsapp_checker.py` | Python example for validate, upload, poll, and download |
| `examples/node/whatsapp-checker.mjs` | Node.js example using `fetch` and multipart upload |
| `examples/php/whatsapp_checker.php` | PHP/cURL example for server-side integrations |
| `SERVICES.md` | Quick reference for common service slugs |
| `.env.example` | Environment variable template |
| `sample-data/numbers.txt` | Format-only sample data |

## Safety Notes

Use only contact data that you are allowed to process. Do not upload scraped private data, leaked lists, customer files, or personal information into public examples.

Keep API keys private and rotate any key that may have been exposed.

## Useful Links

- API documentation: https://docs.numberchecker.cloud
- WhatsApp Number Checker: https://www.numberchecker.cloud/products/whatsapp-checker.html
- Number Status Detection: https://www.numberchecker.cloud/products/number-status.html
- RCS Status Detection: https://www.numberchecker.cloud/products/rcs-status.html
- iOS Status Detection: https://www.numberchecker.cloud/products/ios-status.html
- Email Verification: https://www.numberchecker.cloud/products/email-verification.html
