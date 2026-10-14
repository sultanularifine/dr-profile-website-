# Admin Panel — User Guide

The admin panel reuses the existing Stisla design. The sidebar is grouped by task so common actions are easy to find.

## Dashboard

The dashboard shows totals computed from saved database records, upcoming bookings, recent appointments, and the existing task list. Quick action cards open the main clinic and website tasks. If the clinic migrations have not been applied, a setup warning is shown instead of fake statistics.

## Clinic

### Appointments

Use **Appointments** to filter by status or date and review patient booking requests. Reception/Admin can apply permitted request decisions; only Doctor/Super Admin can call the patient to Waiting or In Progress, complete the consultation, or mark no-show. Do not mark a payment paid from this form: review patient-submitted records in **Payment Management**. Doctors and Super Admins can save a Google Meet or Zoom URL and enable the patient join gate. Meeting URLs must use HTTPS and an approved provider domain. A manually pasted URL is not an automatically created meeting.

### Doctor Profile

Use **Doctor Profile** to edit the profile fields and upload a profile photo or cover image. The profile photo is synchronized with the existing homepage doctor-photo CMS field without changing the current design. Upload preview is displayed before saving.

### Chambers & Schedule

Active chamber cards feed the public Home and Appointment pages. The patient booking form only offers active chambers and active shifts. Use the schedule edit/activate controls to maintain the weekday, hours, slot duration and per-shift patient capacity.

Add/edit chambers and their weekly schedule slots. Each schedule has a weekday, start/end time, slot duration and shift patient limit. Only active chambers/schedules are available for patient booking.

### Prescriptions

Open an appointment marked **In Progress** or **Completed**, then select **Prescription**. The doctor can save a digital prescription record with repeatable medicine rows or upload a handwritten image/scanned PDF. Drafts are not visible to patients; published records are visible only to the patient linked to that appointment. Files are delivered through authenticated routes.

## Website Management

### Pages & Sections

Expand **Pages & Sections** and pick a page such as Home, About, Services, Blog, Blog Details, Testimonials, FAQ, Contact, Appointment, Header or Footer.

- Use the field search to find a label or phrase.
- Expand/collapse content groups to reduce scrolling.
- Fields show their original text and whether an override is active.
- Save all changes at the bottom of the page.
- Leave text blank to restore that field's original text.
- Image fields display a preview and offer Replace / Restore Original.
- Use the **View Website** shortcut to review the public pages in a new tab.

The CMS currently provides an upload field for the existing homepage doctor image; the Blog CRUD separately manages post featured images. Other future image-bearing sections need to be mapped to CMS fields before they can be changed through this panel.

### Blog Management

Use **Add Blog Post** or **All Blog Posts** to manage posts, image, alt text, SEO title/description, slug, canonical URL and publish status according to the existing blog form.

## System Settings

### Website Settings

Super Admins can update the website name, primary/secondary public phone, public email, timezone, currency, website logo image and default social-sharing image. The logo image is displayed instead of the existing icon mark only after an image is uploaded; the original icon remains the fallback. Phone/email settings are linked to the existing header/footer contact links.

The Analytics and Marketing section accepts GTM, GA4, Meta Pixel and Google Ads IDs. Tags are loaded only after the visitor gives the relevant consent. Do not configure GA4 both directly and as a GTM tag at the same time, or duplicate page views may occur. A configured ID does not prove events are reaching the provider. Conversion events, live API reports and provider-side status verification are not included in this phase.

Credential fields are encrypted using the current `APP_KEY`; existing encrypted credentials may become unreadable if that key is changed. Blank credential inputs keep their saved value, unless the explicit remove checkbox is selected.

### SEO Management

Open **SEO Management** to edit title, meta description, canonical URL, robots indexing/following, Open Graph title/description/image, X/Twitter card format and sitemap inclusion for each existing static public page. Blog details use the existing blog's per-post SEO fields. The generated sitemap is available at `/sitemap.xml`; it lists indexable configured public pages and published blogs, not patient or admin pages. Google may choose a different title/snippet than the preview.

### Cookie preferences

The public banner lets visitors accept all, reject optional cookies, or save separate Analytics and Marketing choices. A small **Cookie preferences** control remains visible after a choice during the current session. Optional tags remain blocked unless the matching consent was recorded.

## Users & Permissions

Only accounts with the required Spatie permission see relevant menu options; controllers also check permission for direct requests. Review role assignments before inviting staff. Avoid giving receptionist or patient accounts administrative roles.

## Local setup

1. Back up the project folder and database.
2. Keep your existing `.env` file.
3. Run `composer install`.
4. Check database settings in `.env`.
5. Run `php artisan migrate`.
6. Run `php artisan storage:link`.
7. Run `php artisan optimize:clear`.
8. Review role assignments and test all workflows using non-production data.
9. Run `php artisan route:list` and `php artisan test`.

Do not use `php artisan key:generate` on a site that already has data encrypted with an existing `APP_KEY`.
