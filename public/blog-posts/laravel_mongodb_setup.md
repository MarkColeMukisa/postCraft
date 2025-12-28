# Connecting Laravel to MongoDB — Step-by-Step Setup

You've installed MongoDB and fixed the PHP extension. Now it's time to connect everything together! This guide will show you exactly how to set up MongoDB in your Laravel application.

## Step 1: Install the Laravel MongoDB Package

Open your terminal in your Laravel project folder and run:

```bash
composer require mongodb/laravel-mongodb
```

This installs the official MongoDB package for Laravel. It might take a minute or two.

You should see:
```
Using version ^5.5 for mongodb/laravel-mongodb
```

## Step 2: Configure Your Environment Variables

Open your `.env` file and add these lines:

```env
DB_CONNECTION=mongodb
MONGODB_URI="mongodb+srv://username:password@cluster0.xxxxx.mongodb.net/?retryWrites=true&w=majority"
MONGODB_DATABASE=your_database_name
```

**Replace:**
- `username` and `password` with your MongoDB credentials
- `cluster0.xxxxx.mongodb.net` with your actual cluster address
- `your_database_name` with the name you want (e.g., `blog_posts`)

**For local MongoDB**, use:
```env
MONGODB_URI="mongodb://localhost:27017"
MONGODB_DATABASE=your_database_name
```

## Step 3: Add MongoDB Connection to config/database.php

Open `config/database.php` and add this to the `connections` array:

```php
'mongodb' => [
    'driver' => 'mongodb',
    'dsn' => env('MONGODB_URI'),
    'database' => env('MONGODB_DATABASE'),
],
```

It should look like this:

```php
'connections' => [
    'sqlite' => [
        // ... existing config
    ],
    
    'mysql' => [
        // ... existing config
    ],
    
    'mongodb' => [
        'driver' => 'mongodb',
        'dsn' => env('MONGODB_URI'),
        'database' => env('MONGODB_DATABASE'),
    ],
],
```

## Step 4: Test the Connection with Tinker

Let's make sure everything works! Run:

```bash
php artisan tinker
```

Then type:

```php
DB::connection('mongodb')->getMongoDB()->command(['ping' => 1]);
```

**If it works**, you'll see:
```php
=> MongoDB\Driver\Cursor {#...}
```

**If it fails**, you'll see an error message. Common issues:
- Wrong connection string
- Wrong password
- IP not whitelisted in MongoDB Atlas

Type `exit` to leave Tinker.

## Step 5: Set MongoDB as Default (Optional)

If you want MongoDB to be your default database, update `.env`:

```env
DB_CONNECTION=mongodb
```

**But wait!** For beginners, I recommend keeping MySQL for users and using MongoDB only for specific models (like blog posts). We'll cover this in the next post.

## Understanding the Connection

Let's break down what we just did:

1. **Installed the package** — Gives Laravel the ability to talk to MongoDB
2. **Added environment variables** — Stores your MongoDB credentials securely
3. **Configured the connection** — Tells Laravel how to connect
4. **Tested with Tinker** — Verified everything works

## Common Errors and Fixes

### Error: "Connection timeout"
**Cause:** Your IP isn't whitelisted in MongoDB Atlas  
**Fix:** Go to Network Access in Atlas and add your IP

### Error: "Authentication failed"
**Cause:** Wrong username or password  
**Fix:** Double-check your credentials in `.env`

### Error: "Failed to resolve hostname"
**Cause:** Wrong connection string  
**Fix:** Copy the connection string again from MongoDB Atlas

### Error: "Call to undefined method"
**Cause:** Package not installed correctly  
**Fix:** Run `composer dump-autoload` and try again

## Pro Tips

### Use Different Databases for Different Environments

In `.env`:
```env
# Development
MONGODB_DATABASE=blog_dev

# Production
MONGODB_DATABASE=blog_production
```

### Keep Sensitive Data Secure

Never commit your `.env` file to Git! It contains your database password.

### Test Connection on Every Deploy

Add this to your deployment script:
```bash
php artisan tinker --execute="DB::connection('mongodb')->getMongoDB()->command(['ping' => 1]);"
```

## What's Next?

Now that MongoDB is connected, you need to decide: should you keep your User model in MySQL or move it to MongoDB?

**Coming up next:** Using MySQL for Users and MongoDB for Blog Posts — Best Beginner Setup

---

**Questions?** Drop a comment and I'll help you troubleshoot!
