# Personal CMS — Simple PHP + MySQL (mysqli) + Bootstrap 5

Same features as before (register/login, dynamic landing page, admin dashboard with
full CRUD), but written in plain, beginner-friendly procedural PHP using `mysqli`
instead of PDO/OOP — no classes, no CSRF tokens, no custom abstractions.

## Folder Structure

```
/config
  db.php                Simple mysqli connection
/includes
  header.php            Shared <head> + opens <body>/<main>
  navbar.php             Responsive navbar with dropdown (Home/Dashboard/Login/Logout)
  footer.php             Closes </main>, footer, scripts, closes </body></html>
/auth
  register.php          Registration with validation + password_hash
  login.php               Login with sessions + password_verify
  logout.php             Destroys session
/admin
  dashboard.php          Post list, search, pagination, edit/delete actions
  create.php               Create a post
  edit.php                   Edit a post
  delete.php               Delete a post
/assets
  style.css              Custom design (colors, cards, animations)
/setup
  schema.sql             Creates the `cms_db` database + `users`/`posts` tables
  create_admin.php    One-time script to create a working admin account (delete after use)
index.php               Public landing page: hero + dynamic post cards
```

## Setup (XAMPP / WAMP / MAMP)

1. Copy this folder into your web root (e.g. `htdocs/personal-cms`).
2. Start Apache and MySQL.
3. Import `setup/schema.sql` into phpMyAdmin. This creates the `cms_db` database,
   the `users` and `posts` tables, and 3 sample posts.
4. Open `config/db.php` and adjust the username/password if your MySQL setup isn't
   the XAMPP default (`root` / empty password).
5. Create your first account:
   - Visit `auth/register.php` and sign up normally, **or**
   - Visit `setup/create_admin.php` once to instantly create
     `admin@example.com` / `Admin123!` — then **delete that file**.
6. Visit `index.php`, then log in and go to `admin/dashboard.php`.

## What "simple" means here

- `mysqli` procedural style (`$conn->prepare()`, `bind_param()`, `get_result()`)
  instead of PDO or object-oriented database wrappers.
- No CSRF tokens, no helper functions file — logic lives directly in each page,
  the way the rest of your project is written.
- Still keeps the two non-negotiables for a real login system:
  - **Prepared statements** everywhere (`bind_param`) to stop SQL injection.
  - **`password_hash()` / `password_verify()`** instead of storing plain-text passwords.
  - **`htmlspecialchars()`** on anything printed back to the page, to stop XSS.

## Notes

- `role` (`admin`/`user`) exists in `users` for future use, but any logged-in user
  can currently manage posts — keeping it a simple personal CMS.
