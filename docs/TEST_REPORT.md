# Static Test Report

Date: 2026-10-11

## Passed checks

- `php -l` was run on 120 PHP files across `app/`, `routes/`, `config/`, `database/migrations/`, and `tests/`: **120 passed, 0 parse failures**. Raw command output is available in `PHP_SYNTAX_CHECK.txt`.
- A static Blade-directive balance check was run on 18 key public, patient, admin, payment, chamber and prescription views. Directive pairs were balanced in the heuristic check.
- The original uploaded ZIP passed `unzip -t` before editing.
- The updated code includes server-side ownership checks for patient appointments, payment proof and prescription access, and private uploads use Laravel's local storage disk.

## Not run in this delivery sandbox

- `php artisan route:list`, `php artisan migrate`, Laravel Blade compilation, and PHPUnit tests were **not run**: the extracted project has no `vendor/` directory and no database connection to the user's local Laragon environment.
- Digital prescription PDF generation was not run because the optional DomPDF package is not installed in this archive. Use `install-prescription-pdf.cmd` locally after enabling the PHP `dom` and `mbstring` extensions.
- External payment capture/refunds, Google Meet/Zoom API creation, email/SMS/WhatsApp delivery, GA4 reporting and Search Console reporting were not represented as live or tested integrations.
- Bangla Unicode output in server-generated PDF needs a suitable embedded Bengali font and a real output check; the default PDF font has not been validated for Bangla.

## Required local verification before production

1. Back up the current code and database.
2. Run `composer install` if dependencies are absent.
3. Run `php artisan config:clear`, `php artisan migrate`, `php artisan storage:link`, `php artisan optimize:clear`, `php artisan route:list`, and `php artisan test`.
4. Use a test patient to book two overlapping serials, verify the second is blocked, test access-control between two patients, and confirm the meeting link does not show until the doctor calls that serial.
5. Test draft/published prescription access, image preview, private download, PDF generation, and payment proof review.
6. Only enable manual payments after entering verified clinic payment details in Site Settings.
