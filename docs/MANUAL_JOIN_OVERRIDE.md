# Manual Join Override

## Purpose

A Doctor or Super Admin can manually enable a patient's Google Meet/Zoom Join button without waiting for the scheduled time, payment verification, or queue gate. This is intended for exceptions such as a familiar patient, an early consultation, or a clinical/operational exception.

## Admin workflow

1. Open **Admin → Appointments**.
2. Make sure the online appointment is **Confirmed**, **Waiting**, or **In Progress**.
3. Enter an official HTTPS Google Meet (`meet.google.com`) or Zoom (`*.zoom.us`) URL in the appointment row and click **Save status / meeting details** first.
4. In **Manual Join access**, enter a reason and click **Manually Enable Join Now**.
5. The patient dashboard will show the Join button immediately, even when the scheduled-time window has not started, payment is unpaid, normal meeting-enabled switch is off, or an earlier serial is still active.
6. Click **Disable override / restore normal rules** when the exception should end.

## What this does not do

- It does not mark an unpaid bill as paid.
- It does not set the consultation fee to zero or waive it. To make the consultation free, use the fee-waiver option separately when creating a manual appointment.
- It does not allow access for pending, cancelled, rejected, completed, or no-show appointments.
- It does not create a Meet/Zoom meeting. The doctor must create the link in Google Meet/Zoom and save it in the appointment.

## Security and audit

- Only Doctor and Super Admin may activate or disable the override; Receptionist and Patient roles cannot.
- The link must be an official HTTPS Google Meet/Zoom URL.
- The reason, actor, timestamp and state are stored on the appointment, and each enable/disable action is also added to appointment history.
- The override remains limited to the appointment's patient dashboard; it does not expose the link through a public page.

## Upgrade

Back up the project and database, merge the changed files without overwriting `.env`, then run:

```bash
php artisan migrate
php artisan optimize:clear
php artisan route:list
php artisan test --filter=ConsultationAccessManualOverrideTest
```

The runtime test command must be run in the local project where Composer dependencies and the database are configured.
