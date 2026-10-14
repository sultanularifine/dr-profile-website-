# Manual / Priority Appointments

## Use case
Use **Admin → Appointments → Manual / Priority Appointment** when a known patient needs a custom time outside the public weekly schedule or has been offered a fee waiver.

## Roles
- Super Admin, Doctor, Receptionist, or Admin can create the manual appointment.
- Only Super Admin and Doctor can tick **Waive the consultation fee**. A reason is mandatory and saved for internal audit.
- The selected user must already have the Patient role/account.

## Scheduling rules
- The selected date/time must be in the future.
- The appointment may be outside the standard chamber schedule.
- The system rejects overlap with another active appointment for this single-doctor practice, including appointments in another chamber. Cancelled, rejected, and completed appointments do not block a new time.
- A manual appointment is created as Confirmed and appears in the patient dashboard.

## Fee waiver behavior
- The normal fee remains recorded as a reference, while `fee_waived=true` records that the patient is not expected to pay.
- A waiver reason is required.
- A waived appointment is not counted as collected revenue and does not require payment verification before joining an online consultation.
- The patient does not see a Submit Payment action for a waived appointment.

## Install
Back up your project and database, merge the supplied files, keep your current `.env` and `APP_KEY`, then run:

```bash
php artisan migrate
php artisan optimize:clear
php artisan route:list
php artisan test
```

## Limitations
No external payment is collected by the fee-waiver feature. Appointment and fee-waiver behavior should be tested against the local database before real patient use. This package's build environment did not have the project's Composer `vendor/` dependencies or local database, so full Laravel runtime tests could not be run here.
