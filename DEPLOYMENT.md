# Teatrino — Deployment Guide

This guide covers deploying **Teatrino Nursery Management System** to shared hosting (cPanel) or a VPS using a **git pull** deployment pipeline.

---

## A. Server Requirements

### Software
| Requirement | Version |
|-------------|---------|
| PHP | 8.3+ |
| Composer | 2.x |
| MySQL | 5.7+ / 8.x |
| Node.js & npm | 18+ (if building assets on the server) |
| Git | Recommended for pull-based deploys |

### PHP Extensions (Laravel + DomPDF + image processing)

Enable these extensions on the server:

- `pdo_mysql`
- `mbstring`
- `openssl`
- `tokenizer`
- `xml`
- `ctype`
- `json`
- `bcmath`
- `fileinfo`
- `curl`
- `gd` — image thumbnail/optimization
- `dom` — DomPDF
- `libxml` — DomPDF / XML parsing
- `zip` — Composer (recommended)

### Web server
- Apache with `mod_rewrite` **or** Nginx with Laravel-friendly rewrite rules

---

## B. First-Time Deployment Steps

SSH into your server (or use cPanel Terminal) and run:

```bash
cd /home/USERNAME/public_html
git clone https://github.com/USERNAME/teatrino-nursery-management.git teatrino
cd teatrino

composer install --no-dev --optimize-autoloader

cp .env.example .env
php artisan key:generate

# Edit .env with production database credentials and APP_URL
nano .env

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

npm install
npm run build

php artisan filament:cache-components
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Production `.env` essentials

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=database
```

> Do not commit `.env` to git. Use strong, unique database and admin credentials.

---

## C. Public Folder Setup

Laravel's web root must be the `public/` directory. **Never expose the project root** (where `.env`, `app/`, and `vendor/` live) directly to the internet.

### Option 1 — Recommended: point document root to `public/`

Configure your domain or subdomain document root to:

```
/home/USERNAME/teatrino/public
```

This is the safest and standard Laravel setup.

**Examples:**
- **cPanel:** Domains → your domain → Document Root → set to `teatrino/public`
- **Nginx:** `root /home/USERNAME/teatrino/public;`

### Option 2 — Subdirectory or hosting that cannot change document root

If you must keep files inside `public_html/teatrino/` and cannot point the domain to `public/`:

1. Prefer moving only the contents of `public/` into the web-visible folder, **or**
2. Use the included root `.htaccess` rewrite (already in this project) to route requests through `public/` and `index.php` without exposing sensitive files

The root `.htaccess` serves static assets from `public/build`, `public/storage`, etc., and forwards other requests to Laravel.

**Important:**
- `.env`, `composer.json`, `vendor/`, and `storage/` must remain **outside** the publicly browsable directory when possible
- Production should **not** expose Laravel root files publicly
- Set `APP_URL` to the exact public URL (no trailing slash), e.g. `https://yourdomain.com` or `https://yourdomain.com/teatrino`

---

## D. Deploy Updates with Git Pull

Use this pipeline for routine updates after the initial deployment:

```bash
cd /home/USERNAME/teatrino
git pull origin main

composer install --no-dev --optimize-autoloader

php artisan migrate --force

npm install
npm run build

php artisan optimize:clear
php artisan filament:cache-components
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Optional: build assets locally instead of on the server

If the server has no Node.js, build on your machine and deploy the `public/build` folder:

```bash
# On your local machine
npm install
npm run build

# Commit public/build or upload it to the server, then on server:
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## E. After Deployment Checklist

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL=https://yourdomain.com` (correct scheme and path)
- [ ] Database credentials are correct and migrations ran successfully
- [ ] `php artisan storage:link` completed — uploaded images load at `/storage/...`
- [ ] File uploads work in admin (articles, portfolio, hero image, logo)
- [ ] PDF generation works (weekly child reports)
- [ ] WhatsApp links open correctly on mobile and desktop
- [ ] Default admin password changed from placeholder credentials
- [ ] Public pages load in EN / AR / FR
- [ ] CSS and JS load (Vite build present in `public/build`)
- [ ] HTTPS enabled (recommended)

---

## F. File Permissions

Laravel needs write access to `storage/` and `bootstrap/cache/`.

### Linux / VPS (Apache/Nginx)

```bash
cd /home/USERNAME/teatrino
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

> The web server user may be `apache`, `nginx`, or `www-data` depending on your OS.

### Shared hosting (cPanel)

Use **File Manager → Permissions**:
- `storage/` → **775** (recursive)
- `bootstrap/cache/` → **775** (recursive)

If uploads or logs fail, your host may require **755** for directories and **644** for files — follow your host's Laravel documentation.

---

## G. Troubleshooting

### 500 error after deploy
- Check `storage/logs/laravel.log`
- Ensure `APP_KEY` is set (`php artisan key:generate`)
- Run `php artisan optimize:clear` and re-cache config
- Verify PHP version is 8.3+ and required extensions are enabled
- Confirm `storage/` and `bootstrap/cache/` are writable

### Storage images not showing
- Run `php artisan storage:link`
- Confirm files exist in `storage/app/public/media/`
- Verify `public/storage` symlink points to `storage/app/public`
- Check `APP_URL` matches how users access the site
- On Apache, ensure `mod_rewrite` is enabled

### CSS / JS not loading
- Run `npm run build` and confirm `public/build/manifest.json` exists
- Clear browser cache
- Verify document root or `.htaccess` serves `/build/assets/...`
- Check `APP_URL` — wrong base URL breaks asset paths in some setups

### Migration errors
- Backup the database before deploying
- Run `php artisan migrate --force` manually and read the error output
- Ensure DB user has CREATE/ALTER privileges
- If a migration partially ran, restore from backup or fix the migration state carefully

### PDF not generating
- Confirm PHP extensions: `dom`, `mbstring`, `gd`, `libxml`
- Check `storage/` is writable (DomPDF may write temp files)
- Review `storage/logs/laravel.log` for DomPDF errors
- Ensure server memory limits are adequate (`memory_limit` ≥ 128M recommended)

### `/public` appearing in URLs
- Set `APP_URL` without `/public`
- Point document root to `public/` (Option 1), or use the root `.htaccess` rewrite (Option 2)
- Run `php artisan optimize:clear` after changing `APP_URL`

### Admin login not working
- Confirm admin user exists (`php artisan db:seed --class=AdminUserSeeder --force` on fresh install only)
- Reset password via **System → System Settings** if you have another admin account
- Clear config cache: `php artisan optimize:clear`
- Verify session driver and `storage/framework/sessions` permissions

### WhatsApp links not working
- Configure `SITE_WHATSAPP_NUMBER` or admin Site Settings WhatsApp number
- Number should be digits only with country code (no `+` in env; the app formats the link)
- WhatsApp actions open `wa.me` — they do not send messages automatically

---

## Support Files

- [README.md](README.md) — project overview and local setup
- `.env.example` — environment variable reference
