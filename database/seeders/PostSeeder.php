<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Services\AiImageService;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing posts
        Post::truncate();

        $posts = [
            [
                'title' => 'Installing MongoDB for Laravel — A Beginner\'s Guide',
                'slug' => 'mongodb-installation',
                'excerpt' => 'Learn how to install MongoDB and set up MongoDB Atlas for your Laravel application. This comprehensive guide covers both cloud and local installation options.',
                'content' => file_get_contents(public_path('blog-posts/mongodb_installation.md')),
                'tags' => ['mongodb', 'laravel', 'tutorial', 'beginner'],
                'category' => 'Database',
                'reading_time' => 8,
                'published_at' => now()->subDays(30),
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30),
            ],
            [
                'title' => 'Fixing the Missing MongoDB PHP DLL Error in XAMPP',
                'slug' => 'php-extension-fix',
                'excerpt' => 'Solve the most common MongoDB error beginners face in XAMPP. Step-by-step guide to downloading and installing the php_mongodb.dll extension.',
                'content' => file_get_contents(public_path('blog-posts/php_extension_fix.md')),
                'tags' => ['xampp', 'php', 'mongodb', 'troubleshooting'],
                'category' => 'Troubleshooting',
                'reading_time' => 6,
                'published_at' => now()->subDays(25),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'title' => 'Connecting Laravel to MongoDB — Step-by-Step Setup',
                'slug' => 'laravel-mongodb-setup',
                'excerpt' => 'Complete guide to installing mongodb/laravel-mongodb package, configuring your environment, and testing the connection with Artisan Tinker.',
                'content' => file_get_contents(public_path('blog-posts/laravel_mongodb_setup.md')),
                'tags' => ['laravel', 'mongodb', 'configuration', 'setup'],
                'category' => 'Configuration',
                'reading_time' => 10,
                'published_at' => now()->subDays(20),
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
            [
                'title' => 'Using MySQL for Users and MongoDB for Blog Posts — Best Beginner Setup',
                'slug' => 'hybrid-database-strategy',
                'excerpt' => 'Learn why keeping Users in MySQL and Posts in MongoDB is the best approach for beginners. Avoid common authentication errors with this hybrid strategy.',
                'content' => file_get_contents(public_path('blog-posts/hybrid_database_strategy.md')),
                'tags' => ['mysql', 'mongodb', 'architecture', 'best-practices'],
                'category' => 'Architecture',
                'reading_time' => 12,
                'published_at' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'title' => 'MongoDB + Laravel — Common Errors and How to Fix Them',
                'slug' => 'mongodb-troubleshooting',
                'excerpt' => 'Comprehensive troubleshooting guide covering the 8 most common MongoDB errors in Laravel and their solutions. Includes PDO errors, connection timeouts, and more.',
                'content' => file_get_contents(public_path('blog-posts/mongodb_troubleshooting.md')),
                'tags' => ['mongodb', 'laravel', 'debugging', 'errors'],
                'category' => 'Troubleshooting',
                'reading_time' => 15,
                'published_at' => now()->subDays(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'title' => 'Creating a PostSeeder for MongoDB Blog Posts in Laravel',
                'slug' => 'post-seeder-setup',
                'excerpt' => 'Learn how to create seeders for MongoDB models in Laravel. Includes factory setup, realistic test data generation, and common seeder errors.',
                'content' => file_get_contents(public_path('blog-posts/post_seeder_setup.md')),
                'tags' => ['laravel', 'mongodb', 'seeder', 'testing'],
                'category' => 'Development',
                'reading_time' => 9,
                'published_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'How I Generated Professional Blog Cover Images Using AI — A Developer\'s Guide',
                'slug' => 'ai-cover-image-generation',
                'excerpt' => 'Learn how to generate professional, custom cover images for your blog posts using AI. Includes detailed prompts, tips, and automation code for Laravel developers.',
                'content' => file_get_contents(public_path('blog-posts/ai_cover_image_generation.md')),
                'tags' => ['ai', 'design', 'automation', 'gemini'],
                'category' => 'Tools & Tips',
                'reading_time' => 12,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'From MongoDB to NeonDB: A Laravel Migration Journey',
                'slug' => 'from-mongodb-to-neondb',
                'excerpt' => 'A step-by-step guide to migrating your Laravel application from MongoDB to NeonDB, a serverless PostgreSQL provider.',
                'content' => file_get_contents(public_path('blog-posts/from_mongodb_to_neondb.md')),
                'tags' => ['laravel', 'mongodb', 'neondb', 'postgresql', 'migration'],
                'category' => 'Database',
                'reading_time' => 10,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($posts as $key => $postData) {
            if ($postData['slug'] === 'from-mongodb-to-neondb') {
                $postData['cover_image'] = AiImageService::generate($postData['title']);
            } else {
                // assume the image is already present in the public/images/blog directory
                $postData['cover_image'] = '/images/blog/' . $postData['slug'] . '.jpg';
            }
            Post::create($postData);
        }

        $this->command->info('✅ Successfully seeded ' . count($posts) . ' blog posts!');
        $this->command->info('🔗 View them at: http://localhost:8000');
    }
}
