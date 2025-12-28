<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;
use Gemini\Data\Part;

class AiImageService
{
    public static function generate(string $title): ?string
    {
        try {
            if (empty(env('GEMINI_API_KEY'))) {
                return '/images/blog/default.jpg';
            }

            $prompt = "
                Create a clean, modern, high-quality cover image for a blog post titled:
                '{$title}'.

                Rules:
                - No text in the image
                - Professional blog cover style
            ";

            $model = Gemini::generativeModel('gemini-2.0-flash');

            $response = $model->generateContent(
                new Content(
                    parts: [new Part(text: $prompt)]
                )
            );

            // Extract base64 image from response
            $imageBase64 = $response
                ->candidates[0]
                ->content
                ->parts[0]
                ->inlineData
                ->data;

            $binary = base64_decode($imageBase64);

            $path = 'posts/covers/' . uniqid() . '.png';

            Storage::disk('public')->put($path, $binary);

            return $path;
        } catch (\Throwable $e) {
            // Log error if needed: Log::error($e->getMessage());
            return '/images/blog/default.jpg';
        }
    }
}
