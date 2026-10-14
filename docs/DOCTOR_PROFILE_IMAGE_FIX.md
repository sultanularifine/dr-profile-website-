# Doctor profile image upload and display fix (Laragon)

The Doctor Profile form accepts JPG, JPEG, PNG, and WebP images. Profile photos are saved to `storage/app/public/doctor/profile`; the homepage uses the saved image through `public/storage`.

## Run in Laragon Terminal (CMD)

```cmd
cd /d G:\laragon\www\doctor-dynamic-admin
if not exist storage\app\public mkdir storage\app\public
if not exist storage\app\public\doctor\profile mkdir storage\app\public\doctor\profile
if exist public\storage\.gitignore del public\storage\.gitignore
if exist public\storage rmdir public\storage
php artisan storage:link
php artisan optimize:clear
```

Only remove `public\storage` if it contains no real user-uploaded files. If it contains files, back them up first and move them into `storage\app\public` before removing the directory. `storage:link` must create `public/storage` as a symlink to `storage/app/public`.

## Upload requirements

- Use JPG/JPEG/PNG/WebP. Profile photo maximum is 5 MB; cover image maximum is 8 MB.
- In `php.ini`, `upload_max_filesize` must be at least `8M` and `post_max_size` at least `10M`; restart Laragon after changes.
- After upload, verify that a new file exists in `storage\app\public\doctor\profile`.
- If the file exists but is not visible, check `http://doctor-dynamic-admin.test/storage/doctor/profile/FILE_NAME` and verify the symlink.
- The homepage image is synced from the Doctor Profile after Save Profile; refresh the homepage after saving.
