# Doctor Website: Feature Audit, Patient Workflow and Setup

## 1. Existing-project audit

This package is an incremental Laravel 10 / PHP 8.1+ upgrade. The existing public Blade pages and Stisla admin layout are retained.

| Area | Audit finding | Current integration after this change |
|---|---|---|
| Appointments | Admin list/status workflow existed; public appointment page was informational/static and did not create bookings. | Patient booking form uses active chamber schedules and available slots. Admin staff can review requests. Doctor/Super Admin control serial-call states. The old appointment-page content remains as fallback when no active chamber is configured. |
| Doctor profile | Admin profile form existed, but changes were not automatically reflected in all homepage fields. | Profile name/title/biography/photo are synchronized to existing homepage content keys. Other page sections remain managed through Pages & Sections. |
| Chambers & schedules | Admin chamber/schedule CRUD existed. | Active chambers and their active schedules feed the public Home and Appointment chamber cards and the patient booking form. Shifts can be edited or activated/deactivated; availability is rechecked server-side during booking. |
| Patient account | Public registration assigned the Patient role and a dashboard existed. | Patient portal includes booking, appointment status, payment history, published prescriptions and secure private-file endpoints. |
| Meeting links | Admin could save provider/link, but patient access did not fully depend on queue/time/payment. | Doctor/Super Admin can save an official HTTPS Google Meet/Zoom URL and enable patient access. Backend checks status, meeting flag, time window, fee payment and earlier active serials before displaying the Join action. |
| Prescriptions | Digital/handwritten prescription creation and private uploads existed; digital download was print-to-PDF only. | Patient can view published digital prescriptions, preview uploaded handwritten image/PDF and download original file. A server-generated PDF route is added for published digital prescriptions; it requires the optional DomPDF install step below. |
| Payments | Appointment had fee/payment-status fields but no payment submission/review records. | Manual patient payment submission (TrxID and optional private proof), history, admin verification/rejection and refund bookkeeping are added. Live gateway charges/refunds are not implemented. |
| SEO/settings | Website content, settings and page SEO modules existed. | These existing settings remain available; payment instructions have a dedicated settings group. |

## 2. Patient flow

1. The patient opens **Appointment** and selects a database-managed chamber, or selects **Online Appointment**.
2. If not signed in, Laravel redirects the user to login/registration, then back to the intended patient booking form.
3. The patient selects online/offline consultation, date, an available serial and an optional reason. The server revalidates schedule, slot duration, overlap and shift capacity before saving a pending request.
4. Reception/Admin can review and confirm or reject. Only Doctor/Super Admin can move an appointment to **Waiting**, **In Progress**, **Completed**, or **No-show** (and can still cancel allowed appointments).
5. For online consultations, Doctor/Super Admin save a Google Meet/Zoom URL and tick **Allow patient to join when serial is called**. The URL is shown only during the configured time window, for a waiting/in-progress appointment, after payment is verified for fee-bearing appointments, and if no earlier confirmed/waiting/in-progress serial remains active in the same chamber/day.
6. Patient payment is manual in this phase. The patient submits a supported payment method, transaction reference and optional proof; status remains pending until Doctor/Super Admin verifies it.
7. After a consultation is **In Progress** or **Completed**, Doctor/Super Admin can create a digital prescription or upload a handwritten prescription image/PDF. Published prescriptions appear only for their assigned patient in the patient dashboard.
8. The patient can preview/download the private original scan. A published digital prescription can be downloaded as a server-generated PDF after the optional PDF dependency is installed.

## 3. Admin menu and settings

- **Appointments**: filter by status/date, approve/reject requests, manage allowed status transitions, save meeting link and open the patient join gate.
- **Doctor Profile**: update public name, title, biography and doctor images; relevant homepage fields are synchronized.
- **Chambers & Schedule**: create/activate chambers and configure weekday shifts, slot duration and maximum patients. Active settings feed the public Home and Appointment card lists and online booking. Existing frontend design remains; old hardcoded content acts as fallback when no active chamber is configured.
- **Prescriptions**: create digital or handwritten prescriptions, save drafts and publish.
- **Payment Management**: review patient payment submissions, download private proof, verify/reject, or record a refund after an actual refund is handled with the provider.
- **Site Settings → Manual payment instructions**: set general instructions, bKash/Nagad number and bank details; enable manual payment submissions only after checking the details.
- **Pages & Sections**: edit content sections and supported image fields.

New patient registrations are assigned the **Patient** role. Do not manually grant admin roles to public registrants.

## 4. Database migration and local startup (Windows / Laragon)

1. Back up the project folder and database first. Keep the existing `.env`, `APP_KEY`, database credentials and real uploaded files. `config/view.php` uses a direct `storage_path()` fallback for compiled Blade views to avoid a false result from `realpath()` when the folder was absent.
2. Extract/merge this project into your working folder without replacing your local `.env`.
3. From CMD/PowerShell in the project directory, run:

```bat
composer install
php artisan config:clear
php artisan migrate
php artisan storage:link
php artisan optimize:clear
php artisan route:list
php artisan test
```

`composer install` is needed if the project's `vendor` directory is not present. Check that Laragon's PHP CLI and Apache use a compatible PHP version and required extensions.

### Required migration safety notes

- The new migrations add the payment-submission table, the appointment meeting-access flag and generated-PDF metadata only when needed.
- The new migration `down()` methods intentionally do not drop payment or clinical document data. If rolling back, this preserves sensitive records; it also means rollback does not remove these new structures automatically.
- Migrations were not executed against your local database from this delivery environment. Review/back up before running `php artisan migrate` on a database that contains real patient data.

## 5. Digital prescription PDF dependency

The PDF generator is implemented in `App\Services\PrescriptionPdfService`, but the DomPDF package is optional and is not vendored in this archive. In Laragon, enable the PHP `dom` and `mbstring` extensions, then run:

```bat
composer require "barryvdh/laravel-dompdf:^3.1"
php artisan optimize:clear
```

Or run `install-prescription-pdf.cmd` from the project directory. Test the output with a published digital prescription. Bangla font rendering has not been validated in this delivery build; configure and test an appropriate Bengali Unicode font if prescriptions will be generated in Bangla.

## 6. External integrations and explicit limitations

- **Payments**: this phase records manual bKash/Nagad/bank/cash submissions, references, proof and review status. It does not initiate, capture, or refund money through a gateway. A merchant account and provider-specific signed API/webhook integration are required for automatic payments.
- **Meet/Zoom**: links are generated separately by the doctor and pasted into the admin form. Automated meeting creation through Google/Zoom API is not enabled.
- **Email/SMS/WhatsApp**: a submission does not prove an external message was delivered; provider configuration and delivery handlers remain separate work.
- **Analytics APIs**: settings for IDs do not by themselves enable Google Analytics Data API or Search Console reports.
- **Medical PDF**: code is added, but the package is optional and must be installed locally. Bengali font output, print layout and real patient workflows must be tested in the target environment.
- **Frontend mapping**: appointment cards are now database-backed when an active chamber exists. The existing website layout and other content remain; not every historical image/text binding on every page is automatically mapped to the Doctor Profile table. Use Pages & Sections or implement additional mappings as a later phase.

## 7. Validation/test status from the delivery environment

- PHP syntax: static `php -l` check passed for 120 PHP files across application code, routes, config, migrations and tests before packaging.
- Archive integrity: ZIP integrity is checked before delivery.
- Laravel runtime routes, Blade compilation, migrations and PHPUnit: not runnable in the delivery sandbox because the extracted upload has no `vendor/` dependencies and no connection to your local database. Run the commands above in Laragon and share any error output to diagnose it.

Do not use this version with real patient data until local migrations, authorization tests, private-file access tests and the PDF workflow have been run successfully.
