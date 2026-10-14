# SSLCommerz payment settings fix

This update adds a dedicated Super Admin sidebar page at **System Settings → Payment Settings**, moves the SSLCommerz credentials into one form, shows configuration status, saves the Store Password encrypted through the existing `SiteSetting` model, and redirects patients back to the payment form with a useful error when credentials are missing.

## After extracting the updated ZIP

1. Back up your project and database first. Extract the ZIP over the existing project. Keep your existing `.env` and `APP_KEY`.
2. In Laragon Terminal run:

   ```bat
   cd /d G:\laragon\www\doctor-dynamic-admin
   php artisan optimize:clear
   ```

3. Sign in with a **Super Admin** account. Open **Admin Sidebar → System Settings → Payment Settings**.
4. Select **Sandbox**, enter the Sandbox Store ID and Store Password issued to your sandbox merchant account, enable online payment, and save. The status panel should show Enabled, Store ID Configured, and Store Password Configured.
5. Try checkout for an appointment with an outstanding fee. A configuration badge only means the values are present; the credentials still need to be accepted by the gateway.

The Store Password is encrypted using Laravel's `APP_KEY`. If that key has changed since the password was saved, enter the password again and save it. Do not send store credentials in screenshots or support messages.

A `doctor-dynamic-admin.test` local site can attempt the hosted checkout, but a local domain cannot receive external IPN requests. Use a public HTTPS staging URL for complete end-to-end/IPN testing. The browser success callback still performs server-side transaction validation, but public staging is recommended.
