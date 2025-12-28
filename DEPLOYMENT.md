# Quick Reference: Sevalla Environment Variables

Copy and paste these into your Sevalla **Environment variables** section:

## Required Variables

```env
APP_NAME="Blog Post"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://blog-post-[your-hash].sevalla.app
APP_KEY=
```

> **Generate APP_KEY:** Run `php artisan key:generate --show` locally and paste the output

## MongoDB Configuration

```env
DB_CONNECTION=mongodb
MONGODB_URI=mongodb+srv://joegapp256:joegapp256%40wave@cluster0.0g1tips.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0
MONGODB_DATABASE=blog_production
```

## Session & Cache

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
```

## Logging

```env
LOG_CHANNEL=stack
LOG_LEVEL=error
```

## Build Commands

**Build command:**
```bash
composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**After first deployment, run in Web Terminal:**
```bash
php artisan db:seed --class=PostSeeder --force
```

## MongoDB Atlas Setup

1. Go to **Network Access**
2. Click **Add IP Address**
3. Select **Allow Access from Anywhere** (0.0.0.0/0)
4. Click **Confirm**

## Troubleshooting

**500 Error?**
```bash
tail -n 50 storage/logs/laravel.log
```

**Connection timeout?**
- Check MongoDB Atlas Network Access
- Verify MONGODB_URI is correct

**Images not loading?**
```bash
php artisan storage:link
```
