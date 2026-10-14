# UI and manual payment update

## Included changes

- Responsive public blog index styles and mobile-first blog single article styles (images, wide tables, embeds and long URLs are constrained on small screens).
- Responsive patient portal navigation and dashboard cards for appointments, payment status, medical documents and published prescriptions.
- Reworked admin appointment management into responsive cards without removing existing status transitions, meeting provider/URL/ID/passcode/instructions, meeting-enabled switch, notes, manual join override, priority/manual appointments and prescription action. Bangla help text explains the workflow.
- Payment Settings now contains SSLCommerz fields and a manual payment section for enabling/disabling manual submissions, bKash number, Nagad number, general instructions and optional bank transfer values.
- Patients see the configured bKash/Nagad numbers on the appointment payment page, can copy the number, enter their TrxID and optionally attach a payment proof.
- Doctor/Super Admin can review a manual payment directly from the admin appointments card. Verifying a pending manual payment sets the appointment payment status to paid. SSLCommerz payments are intentionally excluded from manual verification and must pass gateway validation/IPN.
- Blog Create includes a modal button for the provided Feature Image Maker. The generated WEBP image is sent to the native featured-image upload field and is submitted with the existing blog form.
- SSLCommerz success/fail/cancel callback routes accept GET and POST. The existing CSRF exclusions in `VerifyCsrfToken` are retained.

## Setup in local Laragon

1. Back up the project and database.
2. Extract this archive into the project directory and replace matching source files. Keep the local `.env` and `APP_KEY` unchanged.
3. Run:

```bat
cd /d G:\laragon\www\doctor-dynamic-admin
php artisan optimize:clear
```

4. Open Admin → System Settings → Payment Settings. Add the receiving bKash/Nagad number(s), enable manual payment submissions, enter instructions and save all settings.
5. From a patient account, open an unpaid appointment → Payment. The configured number(s) appear there. The patient sends the amount, submits the TrxID and optional screenshot/PDF. Review the transaction in the admin appointment card and only click Verify after checking the actual merchant/mobile-wallet transaction.
6. In Blog → Create Blog, click “Feature Image Maker খুলুন”; create the 1200×630 image, then click “এই ছবিটি ব্লগে ব্যবহার করুন”. Close the modal, check the preview, and save the blog.

## Important boundaries

- bKash/Nagad handling here is manual proof/TrxID review, not an automatic bKash/Nagad API charge or provider verification.
- SSLCommerz must remain in Sandbox until the merchant's correct credentials and public HTTPS callback/IPN are tested. A `.test` local domain is not a public callback endpoint.
- This update adds no new database tables; it uses the project's existing appointment payment, site setting, blog and prescription tables.
- PHP syntax and ZIP integrity are checked in the build environment. The user's local database, rendered Blade pages and real gateway transactions were not available for end-to-end runtime testing.
