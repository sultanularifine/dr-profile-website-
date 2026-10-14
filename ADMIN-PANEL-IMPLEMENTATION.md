# Doctor Website Admin Panel — Implementation Notes

> **Current status:** This document preserves the original implementation notes. For the latest patient booking, queue-gated meeting, private prescription and manual-payment changes, follow `docs/FEATURE_AUDIT_AND_SETUP.md` and `docs/TEST_REPORT.md`; that file is authoritative for this delivery.

## Architecture and coding conventions

This upgrade keeps the existing Laravel 10 / Blade public website and Stisla admin shell. It adds focused modules instead of introducing a new frontend framework.

- `app/Http/Controllers/Admin/` contains focused admin request handlers for appointments, chambers, doctor profile, prescriptions, page content, SEO, site settings, and the dashboard.
- `app/Support/PublicSitePages.php` is the single source of truth for public page keys, SEO editor options, and page-route mapping.
- `app/Models/SiteSetting.php`, `PageSeo.php`, and `ConsentRecord.php` back configurable settings, page metadata and consent records.
- `app/Http/Controllers/Patient/` contains patient dashboard and patient-owned prescription access endpoints.
- `app/Services/AppointmentBookingService.php` contains appointment-booking business rules and transaction-safe checks so the controller remains small.
- `app/Models/` contains Eloquent models and relationships for appointments, chambers, schedules, doctor profile, prescriptions, prescription rows, and appointment status history.
- `database/migrations/` adds missing management tables and fields without replacing the existing users, blog, permission, or content tables.
- `resources/views/backend/medical/` contains focused Stisla-style clinic forms and lists. `resources/views/backend/page-content/` contains the page-by-page CMS editor.
- `resources/views/patient/` contains the patient dashboard and prescription views.
- `config/page_content_defaults.php` preserves the existing fallback text; `config/page_content_active_keys.php` and `config/page_content_sections.php` make the CMS editor ordered and grouped for easier use.

Use Laravel validation in request handlers, Eloquent for data access, transactions for multi-record writes, and authorization checks in controllers in addition to hiding menu items.

## Implemented in this delivery

- A role-aware dashboard using actual database records when medical tables exist; no hardcoded demo statistics.
- A simplified, grouped sidebar with relevant links, page-name submenus, account links, and a public website shortcut. Obsolete placeholder navigation entries were removed from the visible sidebar. User, role, permission, and blog controllers enforce backend permissions rather than relying on hidden menu links.
- Page-by-page content editor with semantic groups, collapsible sections, field search, original text preview, image upload for the existing homepage doctor photo, and blank-text fallback to the original site text.
- Doctor profile editor for name, title, registration number, biography, qualifications, specialties, experience, memberships, awards, publications, languages, services, profile image, and cover image. Visibility/featured metadata is stored, but public visibility/reordering logic still needs a template-specific integration phase. Verification status is not self-editable.
- Chamber and weekly schedule management, including consultation type, fees, default/active status, slot duration, and patient-per-shift limit.
- Appointment list, filtering, constrained status transitions, manually saved Google Meet / Zoom links, HTTPS/domain validation, encrypted meeting passcodes, role restrictions for private meeting fields, appointment status history, and a patient join gate tied to serial status/time/payment. Patient-submitted payment records are reviewed separately in Payment Management; appointment rows do not directly mark payments paid.
- Patient appointment-request flow with schedule validation, slot checks, a transaction, and a status-history row.
- Prescription creation for digital clinical text/medication rows or private handwritten image/PDF upload, draft/publish, and authenticated patient-owned file access.
- Patient dashboard showing the signed-in patient's appointments and their published prescriptions only.
- Profile avatar validation and role-safe default Patient assignment at registration, when the Spatie role tables exist.
- Existing blog CRUD/image upload and post-level SEO fields are preserved; featured image alt text is editable and displayed as the image alt attribute. Blog image cleanup is limited to files in the uploader-managed blog directory, so legacy files elsewhere are not accidentally deleted.
- Role-permission administration renders permission names as text, validates submitted permission IDs, and locks the Super Admin role permissions against accidental removal. User/role/blog controllers also enforce permissions on direct requests; sensitive account/medical records are not deleted through user cleanup actions.
- Appointment booking rules live in `app/Services/AppointmentBookingService.php`; appointment status history is recorded separately. Meeting passcodes use Laravel encrypted model casting.
- Configurable timezone applied from Website Settings (falls back to `APP_TIMEZONE` / `Asia/Dhaka`).
- Super Admin-only Website Settings screen for site identity, phone/email, logo image, default SEO metadata, social-sharing image, GTM/GA4/Meta Pixel/Google Ads settings and encrypted provider credential fields.
- Super Admin-only page-level SEO editor for existing static public pages, including preview, title/description, canonical URL, robots flags, Open Graph/X card metadata, social image and sitemap inclusion.
- `/sitemap.xml` includes indexable static pages and published blog posts only; private patient/admin routes are never added to the sitemap.
- Consent preferences are posted to the application, stored in the session and logged with a pseudonymous session hash; optional GA4 tags load only after analytics consent and marketing tags only after marketing consent.
- GTM, GA4, Meta Pixel and Google Ads base-tag injection validates ID formats before rendering scripts. This does not configure provider accounts, prove delivery, or implement conversion events.
- PHP syntax checks run across PHP files in `app`, `routes`, `database/migrations`, `config`, and `tests`.

## Important features still requiring a later phase

This is a substantial first implementation phase, not a claim that every item in the master prompt is production-complete.

- A full notification center, delivery logs, queued email/SMS/WhatsApp providers, and automatic reminders.
- Payment-gateway adapters and server-side verification for bKash/Nagad/cards; current feature supports manual payment submission and admin verification, not automated collection/refunds.
- Live GA4 Data API reports, Search Console API reporting/OAuth, provider-side verification, Google Ads conversion events, and fully validated integration status.
- SEO redirect management, robots.txt managed through the admin, structured data generation/validation, and end-to-end sitemap/SEO regression tests.
- Chamber image/map embed details, breaks, holidays, temporary leave, special-date schedules, and complete availability calendar.
- Broader image controls for any future image-bearing frontend sections; currently editable public media includes the homepage doctor image, website logo, social-sharing images and blog images. The profile cover upload is stored in the profile record but is not forced into a public section where the current template has no cover-image block.
- Fine-grained policies/permissions and detailed audit logging for all clinical-record access, plus a complete payment/refund/revenue subsystem.
- PDF generation code is implemented through optional DomPDF and requires installation in the target environment; Bangla font rendering and print layout remain unverified. Prescription revisions/addenda and a clinical-record correction workflow remain future work.
- Automated end-to-end, authorization, race-condition, PDF, integration, consent behavior, and full existing-feature regression tests.

Do not expose this deployment publicly for handling real medical records until the remaining security, audit, backup, and operational requirements have been completed and tested in the target environment.

## Local setup (Windows / Laragon)

1. Make a backup of the existing project folder and database.
2. Extract the ZIP and copy its project files into the intended Laravel project folder. Keep your existing `.env` file and real credentials; do not replace them with `.env.example`.
3. Open Laragon Terminal in the project directory and install dependencies:

   ```bash
   composer install
   ```

4. Configure the existing `.env` connection to your local database and ensure `APP_TIMEZONE=Asia/Dhaka` (or your required timezone). For a fresh installation, set `SEED_ADMIN_NAME`, `SEED_ADMIN_EMAIL`, and a strong `SEED_ADMIN_PASSWORD` before running `php artisan db:seed`; the seeders intentionally do not create a known default password.
5. Run migrations and create the public-storage link:

   ```bash
   php artisan migrate
   php artisan storage:link
   php artisan optimize:clear
   ```

6. If this is a brand-new local installation and `APP_KEY` is empty only, run `php artisan key:generate`. Do not regenerate the key on a live/previously encrypted installation. Meeting passcodes are encrypted with `APP_KEY`; keep that key backed up and unchanged or existing encrypted passcodes can no longer be decrypted.
7. Sign in with the configured Super Admin account or an existing authorized account. The roles expected by these menus are `Super Admin`, `Doctor`, `Receptionist`, and/or `Admin`, using the existing Spatie permission tables. Existing roles and permissions should be reviewed before production use.
8. Run checks in the target local environment:

   ```bash
   php artisan route:list
   php artisan test
   ```

   These runtime checks could not be executed in the packaging environment because dependencies under `vendor/` are intentionally not bundled.

## Deployment and rollback

- Back up both the full project and the database before deploying.
- Keep `.env`, database credentials, payment secrets, OAuth credentials, and uploaded private prescription documents out of public repositories and ZIP sharing.
- Apply migrations to a staging copy first. The new clinical migrations intentionally avoid destructive `down()` behavior so record tables are not silently dropped by routine rollback.
- Verify `storage/app/private` cannot be served directly from the web root; the patient download controllers use authenticated, ownership-checked Laravel routes.
- Verify `public/storage` is linked for profile images, and set sensible upload-size limits in PHP/web server configuration.
- If reverting the code, keep any newly created medical tables and records unless a verified backup and explicit data-retention decision authorize removal.
