# NumberChecker Service Slugs

Use `GET /services` for the current live catalog. These common slugs are useful for examples and automation.

| Slug | Service | Typical Required Fields |
|---|---|---|
| `whatsapp-checker` | WhatsApp Number Checker | `service_slug`, `country_cc`, `compliance_confirm`, `file` |
| `number-status` | Number Status Detection | `service_slug`, `country_cc`, `compliance_confirm`, `file` |
| `rcs-status` | RCS Status Detection | `service_slug`, `country_cc`, `compliance_confirm`, `file` |
| `ios-dynamics` | iOS Status Dynamics Detection | `service_slug`, `country_cc`, `compliance_confirm`, `file` |
| `ios-static` | iOS Status Static Detection | `service_slug`, `country_cc`, `compliance_confirm`, `file` |
| `telegram-status` | Telegram Status Detection | `service_slug`, `country_cc`, `compliance_confirm`, `file` |
| `telegram-days` | Telegram Activity Detection | `service_slug`, `country_cc`, `gender`, `start_age`, `end_age`, `days`, `compliance_confirm`, `file` |

Phone-number services expect one country per file. Use `country_cc` such as `92`, `1`, `44`, `966`, or `971`.

Email services expect one email address per line and may not require `country_cc`.

