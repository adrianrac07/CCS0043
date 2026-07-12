# Simple CMS (PHP + MySQL + Bootstrap 5)

A small, beginner-friendly content management system. Admins organize
files into subjects; logged-in users browse subjects and download files.

## Tech
- Plain PHP (no framework, no MVC)
- MySQL via **mysqli** with **prepared statements**
- Bootstrap 5 (loaded from CDN)
- Sessions for login state
- Passwords hashed with `password_hash()` / checked with `password_verify()`

## Folder structure
```
cms_simple/
├── admin/          - admin-only pages (dashboard, users, subjects, files)
├── auth/           - login, register, logout
├── assets/         - custom CSS
├── config/         - database connection (config/db.php)
├── includes/       - shared header, navbar, footer, auth helper
├── setup/          - one-time script to create the first admin
├── uploads/        - uploaded files are stored here
├── index.php       - landing page (subjects + files)
├── about.php
├── contact.php
├── download.php    - handles file downloads
└── database.sql    - database schema
```

## Setup

1. **Create the database.** Import `database.sql` into MySQL / phpMyAdmin.
   This creates the `cms_db` database and the `users`, `subjects`, and
   `files` tables.

2. **Set your DB credentials.** Open `config/db.php` and update
   `$db_host`, `$db_user`, `$db_pass`, `$db_name` if needed (defaults
   match a typical local XAMPP/WAMP setup: user `root`, no password).

3. **Set BASE_URL.** Still in `config/db.php`, set `BASE_URL` to the
   folder the project lives in. Example: if you browse to
   `http://localhost/cms_simple/`, set it to `/cms_simple/`.

4. **Place the project** inside your web server's document root
   (e.g. `htdocs/cms_simple` for XAMPP).

5. **Create your first admin.** Visit `setup/create_admin.php` in your
   browser, fill in a username/password, submit, then **delete that
   file** — leaving it online would let anyone create an admin account.

6. **Log in** at `auth/login.php` with your new admin account, then go
   to `admin/dashboard.php` to add subjects and upload files.

## Notes for learning
- Every SQL query that includes user input uses a **prepared
  statement** (`$conn->prepare(...)` + `bind_param(...)`) to prevent
  SQL injection.
- `includes/auth.php` has `requireLogin()` and `requireAdmin()` — call
  these at the top of any page that should be protected.
- Uploaded files are renamed with a timestamp prefix so two files with
  the same name never overwrite each other on disk; the database
  stores that final filename.
- This is a teaching project, not a production-hardened one. For a
  real deployment you'd also want things like file-type/size
  validation on uploads, CSRF tokens on forms, and HTTPS.
