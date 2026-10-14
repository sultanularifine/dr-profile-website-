# SSLCommerz checkout endpoint fix

The sandbox payment-session API endpoint is `https://sandbox.sslcommerz.com/gwprocess/v4/api.php`. The merchant sandbox site or docs link (`sandbox-gw.sslcommerz.com`) is not the API base URL for starting a transaction. The live API endpoint remains `https://securepay.sslcommerz.com/gwprocess/v4/api.php`.

This update corrects the endpoint and reports a sanitized gateway failure reason on the payment page. It also only redirects to an HTTPS `GatewayPageURL` hosted on an `sslcommerz.com` subdomain.

After replacing the project files, run:

```bat
cd /d G:\laragon\www\doctor-dynamic-admin
php artisan optimize:clear
```

Then open Admin → System Settings → Payment Settings, choose Sandbox, re-enter the sandbox Store ID and Store Password, enable SSLCommerz, and save. The Store ID/Password must be issued for the sandbox environment, not the live merchant account. Check `storage/logs/laravel.log` if checkout still fails; do not share Store Passwords publicly.
