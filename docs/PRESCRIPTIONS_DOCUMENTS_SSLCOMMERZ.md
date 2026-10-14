# Prescriptions, patient documents and SSLCommerz

## Doctor prescriptions
- Open Admin > Appointments and use **Prescription** on a confirmed/waiting/in-progress/completed appointment.
- Choose Digital to add diagnosis/medicines and publish to the patient, or Handwritten to take/select a photo or upload PDF.
- For a patient seen offline, first create a manual appointment from Admin > Appointments > Manual Appointment, then open its Prescription button.

## Patient reports / old prescription photos
- Patient signs in and opens **Upload reports / old prescription photos** on the dashboard.
- On supported phones, choose Take Photo; otherwise select the photo/PDF.
- Doctor/admin opens Admin > **Patient Reports & Photos**. Files use private local storage and are not public URLs.

## SSLCommerz sandbox setup
1. Create a sandbox merchant account at https://sandbox-gw.sslcommerz.com/ and copy its Store ID and Store Password.
2. Admin > Payment Settings (or Website Settings > Manual payment instructions/SSLCommerz fields): enable SSLCommerz, set environment to `sandbox`, enter Store ID and Store Password, then Save Settings.
3. Use a publicly reachable HTTPS staging URL for IPN/callback testing. Configure the IPN URL in the SSLCommerz sandbox merchant panel as `https://YOUR-DOMAIN/api/sslcommerz/ipn`.
4. Patients choose Continue to SSLCommerz on the appointment payment page. The server validates `val_id`, transaction ID, amount and currency before marking paid.
5. Localhost is not reachable by SSLCommerz IPN unless you expose a secure public tunnel; browser return callbacks still do not replace server-side validation.
6. For production, switch environment to `live` only after live credentials and end-to-end tests. Live payments are real charges.

Do not commit Store Passwords to source control. Secrets are encrypted using Laravel `APP_KEY`. Keep the same APP_KEY after saving credentials.


## SSLCommerz payment settings

Super Admin configures the gateway from Admin Sidebar → System Settings → Payment Settings. Save the Sandbox Store ID and Store Password, choose Sandbox, and enable the gateway. The Store Password is encrypted using Laravel's APP_KEY. Keep the same APP_KEY that was used to save it; if APP_KEY changes, re-enter and save the password. The status card only confirms that values are present; a sandbox payment is still required to verify the merchant credentials.
