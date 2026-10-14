# Features and Next Steps

Start with `docs/FEATURE_AUDIT_AND_SETUP.md` for a full audit, the workflow, exact setup commands, and known limitations.

## Implemented in this delivery
- Database-backed public chamber cards and patient appointment form.
- Availability endpoint based on active chamber schedules.
- Server-side serial overlap and shift capacity checks.
- Patient appointment and prescription views.
- Patient-owned prescription image/PDF preview and private download.
- Server-generated digital prescription PDF route (after installing the optional package).
- Manual patient payment submission and admin review records.
- Doctor-controlled meeting URL activation and serial/time/payment gating.
- Doctor/Super Admin Manual Join Override: bypasses the time window, payment gate and serial queue when explicitly activated with a reason; it does not mark payment as paid or waive the fee. See `docs/MANUAL_JOIN_OVERRIDE.md`.
- Doctor profile values synchronized to existing homepage bindings.
- Dashboard payment-review statistics and payment-management shortcut.

## Still requiring local or provider configuration
- Run the new database migrations against a backed-up local database.
- Install the optional DomPDF package and validate PDF/Unicode output.
- Configure manual payment details in Site Settings before enabling submissions.
- Add official payment provider adapters/webhooks for automatic transactions if required.
- Configure OAuth/API credentials and handlers for automatic Meet/Zoom creation, email/SMS/WhatsApp and live analytics reports.
- Complete any further page-by-page frontend image mapping not included in the existing CMS field definitions.

Never overwrite `.env`, rotate `APP_KEY` on an existing deployment, or place medical uploads in public storage.
