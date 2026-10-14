# Doctor Website — Project Audit

## Existing application preserved

- **Framework:** Laravel 10-compatible application (`laravel/framework` `^10.10`).
- **PHP:** Composer requires PHP `^8.1`.
- **Frontend:** Existing Blade templates and static files under `resources/views/frontend` and `public/frontend`.
- **Admin UI:** Existing Stisla layout, CSS, JavaScript and components under `resources/views/backend` and `public/backend`.
- **Authentication:** Existing Laravel UI authentication routes and user model are retained.
- **Authorization:** Existing Spatie Laravel Permission roles and permissions are reused.
- **Blog:** Existing `Blog` and `BlogImage` models, backend CRUD and public blog routes are retained.
- **Website CMS:** Existing original content remains in `config/page_content_defaults.php`; saved content overrides are stored in `page_contents` and fall back to original template text when an override is blank or absent.
- **Website settings and SEO:** New `site_settings`, `page_seo`, and `consent_records` tables support Super Admin-only global settings, page-level metadata, privacy choices, and `/sitemap.xml`. Secret settings are encrypted using the existing `APP_KEY`.

## Main code areas

| Area | Location | Responsibility |
|---|---|---|
| HTTP routes | `routes/web.php` | Existing public URLs, authenticated workspace and new medical/CMS routes |
| Admin controllers | `app/Http/Controllers/Admin/` | Dashboard, profile, chambers, appointments, prescriptions and website content |
| Patient controllers | `app/Http/Controllers/Patient/` | Patient dashboard and authenticated prescription access |
| Booking rules | `app/Services/AppointmentBookingService.php` | Slot validation, overlap checks and transaction-safe booking workflow |
| Eloquent models | `app/Models/` | Appointments, chambers, schedules, doctor profile, prescriptions and content |
| Database changes | `database/migrations/` | Additive clinic/CMS schema changes; existing project tables are not dropped |
| Existing admin layout | `resources/views/backend/layouts/` and `backend/components/` | Reuses the existing visual system |
| CMS views | `resources/views/backend/page-content/` | Searchable, grouped, page-by-page editable fields and image controls |
| Clinic views | `resources/views/backend/medical/` | Doctor profile, chambers/schedules, appointment and prescription forms |
| Global settings / SEO | `app/Http/Controllers/Admin/SiteSettingsController.php`, `SeoController.php`, `resources/views/backend/settings/` | Protected site identity, tracking-ID configuration, credentials, and page-level SEO forms |
| Consent / sitemap | `ConsentController.php`, `SitemapController.php`, `resources/views/frontend/sitemap.blade.php` | Session consent preferences and a sitemap containing public static pages and published blog posts |
| Patient views | `resources/views/patient/` | Patient dashboard, appointment request and prescription view |
| Content metadata | `config/page_content_active_keys.php`, `config/page_content_sections.php` | Ordered active fields and human-friendly group labels |

## Compatibility and safety notes

1. The original `.env` is not included or overwritten. Configure local credentials in your own `.env`.
2. Do not rotate `APP_KEY` on an existing deployment. Meeting passcodes use Laravel's encrypted cast.
3. New medical files are stored on Laravel's non-public `local` disk and downloaded through authenticated routes. Verify the storage directory is not exposed by custom web-server rules.
4. Public marketing images and private clinical documents are separate storage concerns. Never move prescription uploads to `public/uploads`.
5. Appointment, payment and prescription status fields do **not** constitute a payment-gateway integration.
6. External provider APIs are not reported as connected unless configured and tested with real credentials.

## Verification performed for this package

- PHP syntax lint passed for 120 PHP source files in the current delivery worktree. Laravel runtime, route registration, migrations and PHPUnit were not run because the delivery environment has no Composer `vendor/` dependencies or access to the user’s local database.
- A focused PHPUnit unit test was added for public SEO page/route mapping, but it has not been executed in this environment.
- Full Laravel runtime tests, route resolution and Blade compilation could not be run in the packaging environment because Composer and the `vendor/` directory are unavailable here. Run them locally after `composer install`.

## Production readiness

This package is an additive first implementation phase. Do not use it to process real patient health records in production until the remaining modules documented in `ADMIN-PANEL-IMPLEMENTATION.md` are implemented, independently reviewed and tested in a staging environment. In particular, server-generated PDF delivery depends on installing DomPDF and testing Unicode/Bangla output; prescription revisions/addenda, a complete clinical access audit trail, actual notification-provider delivery, payment-gateway verification, live OAuth/API reports, conversion tracking, and end-to-end authorization/consent tests remain follow-up work.
