# Using MySQL for Users and MongoDB for Blog Posts — Best Beginner Setup

One of the biggest questions beginners ask: **"Should I use MongoDB for everything or just some models?"**

The answer: **Use both!** Keep your User model in MySQL and use MongoDB for your blog posts. Let me explain why.

## The Hybrid Database Strategy

Think of your database like a toolbox:
- **MySQL** = Screwdriver (perfect for structured, relational data)
- **MongoDB** = Hammer (perfect for flexible, document-based data)

You wouldn't use a hammer to tighten a screw, right? Same with databases!

## Why Keep Users in MySQL?

Laravel's authentication system is **built for SQL databases**. Here's why you should keep it that way:

### ✅ Reasons to Use MySQL for Users:

1. **Laravel Auth expects it** — All authentication features work out of the box
2. **Relationships are easier** — User has many posts, comments, etc.
3. **Fewer errors** — No compatibility issues with packages like Filament, Jetstream, or Breeze
4. **Migrations work perfectly** — User table structure is well-defined
5. **Security is proven** — Laravel's auth has been tested with SQL for years

### ❌ Problems You'll Face with MongoDB Users:

- `Call to a member function prepare() on null` errors
- Authentication middleware breaks
- Password reset doesn't work properly
- Third-party packages throw errors
- More debugging, less building

## Why Use MongoDB for Blog Posts?

Blog posts are **perfect** for MongoDB because:

### ✅ Reasons to Use MongoDB for Posts:

1. **Flexible schema** — Add tags, categories, metadata without migrations
2. **Fast reads** — Great for displaying lots of posts
3. **Nested data** — Store comments, likes, and views in the same document
4. **No joins needed** — Everything is in one place
5. **Easy to scale** — MongoDB handles large amounts of content well

## The Perfect Setup

Here's how to configure your Laravel app for the best of both worlds:

### Step 1: Keep Default Connection as SQLite/MySQL

In `.env`:
```env
DB_CONNECTION=sqlite
# or
DB_CONNECTION=mysql
```

This ensures authentication and core Laravel features work perfectly.

### Step 2: Add MongoDB Connection

In `.env`, add:
```env
MONGODB_URI="your-mongodb-connection-string"
MONGODB_DATABASE=blog_posts
```

In `config/database.php`:
```php
'connections' => [
    'sqlite' => [
        // ... default config
    ],
    
    'mongodb' => [
        'driver' => 'mongodb',
        'dsn' => env('MONGODB_URI'),
        'database' => env('MONGODB_DATABASE'),
    ],
],
```

### Step 3: Configure Your User Model (Keep It Default!)

Your `app/Models/User.php` should look like this:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // No $connection property needed!
    // Uses default database (SQLite/MySQL)
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

**Important:** Do NOT add `protected $connection = 'mongodb';` to the User model!

### Step 4: Configure Your Post Model for MongoDB

Create `app/Models/Post.php`:

```php
<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';
    
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
```

**Key differences:**
- Extends `MongoDB\Laravel\Eloquent\Model` (not the standard Model)
- Uses `$collection` instead of `$table`
- Explicitly sets `$connection = 'mongodb'`

## How It Works Together

### Creating a User (Uses MySQL/SQLite):
```php
User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password'),
]);
```

### Creating a Post (Uses MongoDB):
```php
Post::create([
    'title' => 'My First Blog Post',
    'slug' => 'my-first-blog-post',
    'content' => 'This is stored in MongoDB!',
    'author_id' => auth()->id(), // References the MySQL user
]);
```

### Querying Posts:
```php
$posts = Post::where('author_id', auth()->id())->get();
```

## Common Errors and How to Avoid Them

### ❌ Error: "Call to a member function prepare() on null"

**Cause:** You set `protected $connection = 'mongodb'` on the User model

**Fix:** Remove that line from User.php

### ❌ Error: "Class 'MongoDB\Laravel\Eloquent\Model' not found"

**Cause:** You're using the wrong base class for Post model

**Fix:** Make sure Post extends `MongoDB\Laravel\Eloquent\Model`

### ❌ Error: "Unknown database 'mongodb'"

**Cause:** You set `DB_CONNECTION=mongodb` in `.env`

**Fix:** Keep `DB_CONNECTION=sqlite` or `DB_CONNECTION=mysql`

## Quick Reference: Do's and Don'ts

### ✅ DO:
- Keep User model using default database
- Use MongoDB for Post, Comment, Category models
- Test authentication before adding MongoDB models
- Use `$collection` for MongoDB models
- Extend `MongoDB\Laravel\Eloquent\Model` for MongoDB models

### ❌ DON'T:
- Set User model connection to MongoDB
- Set `DB_CONNECTION=mongodb` as default
- Use `$table` property on MongoDB models
- Extend standard `Model` class for MongoDB models
- Mix SQL and MongoDB queries in the same model

## What's Next?

Now that you understand the hybrid database strategy, let's look at common errors you might encounter and how to fix them.

**Coming up next:** MongoDB + Laravel — Common Errors and How to Fix Them

---

**Still confused?** Ask in the comments and I'll clarify!
