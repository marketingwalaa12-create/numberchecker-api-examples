import crypto from "crypto";
import fs from "fs";
import FormData from "form-data";
import fetch from "node-fetch";
import "dotenv/config";

const API_KEY = process.env.NUMBERCHECKER_API_KEY || "YOUR_API_KEY";
const BASE = process.env.NUMBERCHECKER_BASE_URL || "https://api.numberchecker.cloud/api/v1";
const SERVICE_SLUG = process.env.NUMBERCHECKER_SERVICE_SLUG || "whatsapp-checker";
const COUNTRY_CC = process.env.NUMBERCHECKER_COUNTRY_CC || "92";
const INPUT_FILE = process.env.NUMBERCHECKER_INPUT_FILE || "sample-data/numbers.txt";

const auth = { Authorization: `Bearer ${API_KEY}` };

async function json(response) {
  const data = await response.json();
  if (!response.ok) throw new Error(JSON.stringify(data));
  return data;
}

function uploadForm() {
  const form = new FormData();
  form.append("service_slug", SERVICE_SLUG);
  form.append("country_cc", COUNTRY_CC);
  form.append("compliance_confirm", "1");
  form.append("file", fs.createReadStream(INPUT_FILE));
  return form;
}

console.log(await json(await fetch(`${BASE}/test`, { headers: auth })));
console.log(await json(await fetch(`${BASE}/balance`, { headers: auth })));

let form = uploadForm();
console.log(await json(await fetch(`${BASE}/jobs/validate`, {
  method: "POST",
  headers: auth,
  body: form,
})));

form = uploadForm();
const job = await json(await fetch(`${BASE}/jobs`, {
  method: "POST",
  headers: { ...auth, "Idempotency-Key": crypto.randomUUID(), ...form.getHeaders() },
  body: form,
}));

console.log("created job:", job.job_id);

let status;
do {
  await new Promise(resolve => setTimeout(resolve, 30000));
  status = await json(await fetch(`${BASE}/jobs/${job.job_id}`, { headers: auth }));
  console.log(status.job.status, "download_available=", status.job.download_available);
} while (!status.job.download_available);

const file = await fetch(`${BASE}/jobs/${job.job_id}/download`, { headers: auth });
if (!file.ok) throw new Error(await file.text());
fs.writeFileSync(`result_${job.job_id}.txt`, Buffer.from(await file.arrayBuffer()));
console.log(`saved result_${job.job_id}.txt`);

