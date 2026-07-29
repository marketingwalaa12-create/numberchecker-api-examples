# NumberChecker API Examples

Practical API examples for using NumberChecker.cloud to validate bulk TXT contact lists, create processing jobs, poll job status, and download completed results.

NumberChecker.cloud supports bulk CSV/TXT style contact verification workflows for services such as WhatsApp number checking, phone number status detection, RCS status detection, iOS/iMessage status checks, email verification, Telegram checks, and carrier/network lookup.

API docs: https://docs.numberchecker.cloud  
API base URL: `https://api.numberchecker.cloud/api/v1`  
Website: https://numberchecker.cloud

## Why This Repo Exists

This repository is meant to become the public GitHub examples package for NumberChecker.cloud.

It gives developers, agencies, SaaS builders, CRM owners, and automation teams a simple way to understand how the API works before they buy credits or integrate it into their own tools. Instead of only saying "we have an API", this repo shows real implementation flows in cURL, Python, Node.js, and PHP.

It also creates a clean SEO asset. A useful GitHub repo can appear in Google and GitHub search for searches such as:

- `WhatsApp number checker API`
- `bulk WhatsApp number validation`
- `phone number status checker API`
- `RCS number checker API`
- `iMessage status checker API`
- `Telegram number checker API`
- `bulk email verification API`
- `CSV lead cleaning API`
- `TXT contact list verification`

The benefit is simple: people who search for technical ways to clean, verify, or filter contact lists can find the examples, understand the API, and then move to the official NumberChecker.cloud website or docs.

## What Good This Can Bring NumberChecker.cloud

- More trust: buyers can see real code instead of only sales copy.
- More search visibility: GitHub and docs pages can rank for API and developer keywords.
- More qualified leads: technical users can test the workflow before contacting you.
- Easier support: you can send customers one repo instead of explaining the same setup repeatedly.
- Better internal automation: your own tools can reuse the same examples and service slugs.
- Safer parasite SEO: the content is useful, branded, relevant, and points to the official service.

This is not a magic ranking trick. It is a public proof asset. It helps because the content is useful and directly connected to the product.

## Who Should Use This

- Developers integrating bulk contact verification into a CRM, panel, SaaS, or internal tool.
- Agencies cleaning WhatsApp, phone, email, RCS, iOS, or Telegram lists before campaigns.
- Businesses that want to validate contact files before spending money on outreach.
- NumberChecker.cloud customers who need working examples in common languages.

## What This Repo Shows

- Check API access with `GET /test`
- List supported services with `GET /services`
- Check account balance with `GET /balance`
- Validate an upload without spending credits using `POST /jobs/validate`
- Create a real job using `POST /jobs`
- Poll `GET /jobs/{job_id}`
- Download completed results from `GET /jobs/{job_id}/download`

## Quick Start

1. Copy `.env.example` to `.env`.
2. Put your API key in `.env`.
3. Prepare a TXT file with one phone number or email per line.
4. Run a dry-run validation first.
5. Only create the real job after validation passes.

Important: real uploads require at least 2,000 valid entries and no more than 1,000,000 valid entries per file.

The included `sample-data/numbers.txt` file is only a format example. Replace it with your own compliant 2,000+ row file before creating a real job.

## Authentication

Use a bearer token:

```bash
Authorization: Bearer YOUR_API_KEY
```

Never commit real API keys to GitHub.

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

For the latest live service list, call:

```bash
curl -H "Authorization: Bearer YOUR_API_KEY" \
  https://api.numberchecker.cloud/api/v1/services
```

## Examples

- `examples/curl/whatsapp-checker.sh`
- `examples/python/whatsapp_checker.py`
- `examples/node/whatsapp-checker.mjs`
- `examples/php/whatsapp_checker.php`

## Required Upload Fields

Most phone-number services require:

- `service_slug`
- `country_cc`
- `compliance_confirm=1`
- `file`

Example:

```bash
service_slug=whatsapp-checker
country_cc=92
compliance_confirm=1
file=@numbers.txt
```

Use only lawful, permission-based, or otherwise compliant contact data.

## Safe Production Workflow

1. Validate first with `/jobs/validate`.
2. Generate a unique `Idempotency-Key`.
3. Create the job with `/jobs`.
4. Poll every 30-60 seconds.
5. Download once `download_available` is `true`.

## How To Publish This On GitHub

Create a public repository named:

```text
numberchecker-api-examples
```

Recommended GitHub description:

```text
API examples for bulk WhatsApp number checker, phone status, RCS, iOS, Telegram, and email verification with NumberChecker.cloud
```

Recommended GitHub topics:

```text
whatsapp-api, number-checker, phone-validation, csv-verification, lead-cleaning, rcs-checker, imessage-checker, email-verification
```

After publishing, link the repo from:

- https://docs.numberchecker.cloud
- https://numberchecker.cloud
- Relevant product pages
- Relevant blog posts
- YouTube descriptions when the video is about API usage or list cleaning
- Telegram posts when the post discusses automation or developer usage

Full publishing checklist: [docs/GITHUB_PUBLISHING_CHECKLIST.md](docs/GITHUB_PUBLISHING_CHECKLIST.md)

## Safe SEO Usage

Use this repo as a helpful documentation asset. Do not use it for spam, copied posts, fake reviews, doorway pages, or irrelevant backlink drops.

Good usage:

- Publish useful code examples.
- Keep the README accurate.
- Link to the official docs and relevant product pages.
- Add real screenshots or API response examples later.
- Update the repo when API behavior changes.

Bad usage:

- Publishing fake claims.
- Adding unrelated keywords.
- Posting the same README on many websites.
- Uploading customer data.
- Promising guaranteed marketing results.

## Links

- API docs: https://docs.numberchecker.cloud
- WhatsApp Number Checker: https://www.numberchecker.cloud/products/whatsapp-checker.html
- Number Status Detection: https://www.numberchecker.cloud/products/number-status.html
- RCS Status Detection: https://www.numberchecker.cloud/products/rcs-status.html
- iOS Status Detection: https://www.numberchecker.cloud/products/ios-status.html
- Email Verification: https://www.numberchecker.cloud/products/email-verification.html
