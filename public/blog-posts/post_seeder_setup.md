# Creating a PostSeeder for MongoDB Blog Posts in Laravel

You've set up MongoDB, fixed the errors, and configured your models. Now it's time to fill your blog with content! Let's create a seeder that populates your database with sample blog posts.

## What is a Seeder?

A **seeder** is a Laravel class that fills your database with test data. Think of it like planting seeds in a garden — you're planting data in your database!

**Why use seeders?**
- Test your blog with realistic content
- Demo your application to clients
- Develop features without manually creating posts
- Reset your database to a known state

## Step 1: Create the Post Model

First, make sure you have a Post model configured for MongoDB.

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

**Key points:**
- Extends `MongoDB\Laravel\Eloquent\Model`
- Uses `$collection` (not `$table`)
- Sets connection to `mongodb`

## Step 2: Create the Seeder

Run this Artisan command:

```bash
php artisan make:seeder PostSeeder
```

This creates `database/seeders/PostSeeder.php`.

## Step 3: Write the Seeder Code

Open `database/seeders/PostSeeder.php` and replace it with:

```php
<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing posts
        Post::truncate();

        // Create sample posts
        $posts = [
            [
                'title' => 'Installing MongoDB for Laravel — A Beginner\'s Guide',
                'slug' => 'mongodb-installation',
                'excerpt' => 'Learn how to install MongoDB and set up MongoDB Atlas for your Laravel application.',
                'content' => 'Welcome to your first step in learning MongoDB with Laravel...',
                'cover_image' => '/images/mongodb-installation.jpg',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Fixing the Missing MongoDB PHP DLL Error in XAMPP',
                'slug' => 'php-extension-fix',
                'excerpt' => 'Solve the most common MongoDB error beginners face in XAMPP.',
                'content' => 'If you\'re using XAMPP and trying to use MongoDB with Laravel...',
                'cover_image' => '/images/php-extension-fix.jpg',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more posts here
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }

        $this->command->info('Posts seeded successfully!');
    }
}
```

## Step 4: Register the Seeder

Open `database/seeders/DatabaseSeeder.php` and add:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PostSeeder::class,
        ]);
    }
}
```

## Step 5: Run the Seeder

Execute the seeder:

```bash
php artisan db:seed
```

Or run just the PostSeeder:

```bash
php artisan db:seed --class=PostSeeder
```

You should see:
```
Seeding database.
Posts seeded successfully!
```

## Step 6: Verify in MongoDB Compass

1. Open MongoDB Compass
2. Connect to your database
3. Look for the `posts` collection
4. You should see your seeded posts!

## Advanced: Using Factories

For more realistic data, you can create a factory:

```bash
php artisan make:factory PostFactory
```

Edit `database/factories/PostFactory.php`:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence();
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'cover_image' => fake()->imageUrl(1200, 630, 'technology'),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
```

Then use it in your seeder:

```php
public function run(): void
{
    Post::factory(20)->create();
}
```

## Common Errors and Fixes

### Error: "Call to a member function prepare() on null"

**Cause:** Post model isn't configured for MongoDB

**Fix:** Make sure Post extends `MongoDB\Laravel\Eloquent\Model` and has `protected $connection = 'mongodb';`

### Error: "Collection not found"

**Cause:** MongoDB connection isn't working

**Fix:** Test connection in Tinker:
```php
DB::connection('mongodb')->getMongoDB()->command(['ping' => 1]);
```

### Error: "Class 'Post' not found"

**Cause:** Model doesn't exist or isn't imported

**Fix:** Add `use App\Models\Post;` at the top of your seeder

## Pro Tips

### Reset and Seed in One Command

```bash
php artisan migrate:fresh --seed
```

This drops all tables, runs migrations, and seeds data.

### Seed Only in Development

```php
public function run(): void
{
    if (app()->environment('production')) {
        $this->command->warn('Cannot seed in production!');
        return;
    }

    // Seeding code here
}
```

### Add Timestamps

Always include timestamps for realistic data:

```php
'created_at' => now()->subDays(rand(1, 30)),
'updated_at' => now(),
```

### Use Realistic Slugs

```php
use Illuminate\Support\Str;

'slug' => Str::slug($title),
```

## What You've Accomplished

Congratulations! You now know how to:
- ✅ Create a MongoDB model
- ✅ Write a seeder for MongoDB
- ✅ Populate your database with sample data
- ✅ Use factories for realistic test data
- ✅ Troubleshoot common seeder errors

## What's Next?

Now that your blog has content, you can:
1. Build a frontend to display posts
2. Add pagination and search
3. Create an admin panel with Filament
4. Deploy to production

You've completed the MongoDB + Laravel beginner series! You should now feel confident working with MongoDB in your Laravel applications.

---

**Questions about seeders?** Drop a comment and I'll help you out!

**Want more Laravel tutorials?** Subscribe to get notified of new posts!
