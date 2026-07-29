import os
import time
import uuid
from pathlib import Path

import requests
from dotenv import load_dotenv

load_dotenv()

API_KEY = os.getenv("NUMBERCHECKER_API_KEY", "YOUR_API_KEY")
BASE = os.getenv("NUMBERCHECKER_BASE_URL", "https://api.numberchecker.cloud/api/v1")
SERVICE_SLUG = os.getenv("NUMBERCHECKER_SERVICE_SLUG", "whatsapp-checker")
COUNTRY_CC = os.getenv("NUMBERCHECKER_COUNTRY_CC", "92")
INPUT_FILE = Path(os.getenv("NUMBERCHECKER_INPUT_FILE", "sample-data/numbers.txt"))

HEADERS = {"Authorization": f"Bearer {API_KEY}"}


def require_ok(response):
    data = response.json()
    if not response.ok:
        raise RuntimeError(data)
    return data


def form_data():
    return {
        "service_slug": SERVICE_SLUG,
        "country_cc": COUNTRY_CC,
        "compliance_confirm": "1",
    }


print(require_ok(requests.get(f"{BASE}/test", headers=HEADERS, timeout=20)))
print(require_ok(requests.get(f"{BASE}/balance", headers=HEADERS, timeout=20)))

with INPUT_FILE.open("rb") as file_obj:
    dry_run = require_ok(
        requests.post(
            f"{BASE}/jobs/validate",
            headers=HEADERS,
            data=form_data(),
            files={"file": file_obj},
            timeout=60,
        )
    )
print("dry_run:", dry_run)

upload_headers = {**HEADERS, "Idempotency-Key": str(uuid.uuid4())}
with INPUT_FILE.open("rb") as file_obj:
    job = require_ok(
        requests.post(
            f"{BASE}/jobs",
            headers=upload_headers,
            data=form_data(),
            files={"file": file_obj},
            timeout=120,
        )
    )

job_id = job["job_id"]
print("created job:", job_id)

while True:
    status = require_ok(requests.get(f"{BASE}/jobs/{job_id}", headers=HEADERS, timeout=20))["job"]
    print(status["status"], "download_available=", status["download_available"])
    if status["download_available"]:
        break
    time.sleep(30)

download = requests.get(f"{BASE}/jobs/{job_id}/download", headers=HEADERS, timeout=120)
download.raise_for_status()
Path(f"result_{job_id}.txt").write_bytes(download.content)
print(f"saved result_{job_id}.txt")

