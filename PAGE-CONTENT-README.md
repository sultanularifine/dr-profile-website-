# Page Content Manager

The frontend templates retain their original wording and layout. Static visible text nodes in the existing pages are connected to `site_content(key, fallback)`. The fallback is stored in `config/page_content_defaults.php`; database overrides are optional.

## Setup

1. Back up the current project and database.
2. Copy the updated project files to the Laravel application.
3. Ensure `.env` has the correct database and application settings. Do not replace production `.env` with an example file.
4. Run `php artisan migrate` to create the `page_contents` table.
5. Log in using an existing application account and open **Admin → Page Content**.
6. Search or filter by page, select **Edit**, and save a replacement. Leave the replacement empty or use **Reset** to restore the original default text.

The manager is built with the project's existing Stisla backend layout and responsive Bootstrap table/form components. Blog records continue to use the existing blog CRUD.

## Notes

- The original page text remains the fallback when no override exists.
- The page templates and their CSS/layout were not redesigned.
- New custom keys are stored for future template use; they do not appear on the frontend unless a template calls `site_content()` with that key.
- Run `php artisan config:clear` after deploying if configuration is cached.
- The current development runtime used for inspection lacks the PHP DOM extension, so `php artisan view:cache` could not be executed here. All edited Blade files passed direct Blade compiler parsing.
