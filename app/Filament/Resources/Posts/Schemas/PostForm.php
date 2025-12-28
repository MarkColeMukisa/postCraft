<?php

namespace App\Filament\Resources\Posts\Schemas;

use chillerlan\QRCode\Common\Mode;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->required()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->suffixAction(
                        action::make('generate-post-content')
                        ->icon('heroicon-m-sparkles')
                        ->action(function (?string $state, Set $set): void {

                            $title = $state;

                            if (blank($state)) {
                                Notification::make()
                                    ->title('Error')
                                    ->body('Please provide a title before generating content.')
                                    ->danger()
                                    ->send();

                                return;
                            }

                            try {
                                $prompt = "Generate content about; . '{$title}' .
                                The content should be precise and up to point
                                .
                                Format using clean HTML:
                                                        - No <h2> for section headings
                                                        - No <p> for paragraphs
                                                        - No <strong> for emphasis on key terms
                                                        - No <ul> and <li> for lists if appropriate
                                                        - Do NOT include the main title as <h1>
                                                        - Keep formatting clean and minimal.";

                                $response = Gemini::generativeModel(model: 'gemini-2.5-flash')
                                    ->generateContent($prompt);

                                // Logic to generate Content
                                $generatedContent = $response->text();

                                //2 Generate Image
                                $imagePath = \App\Services\AiImageService::generate($title);

                                if(empty($generatedContent)) {
                                    Notification::make()
                                        ->title('Empty')
                                        ->body('There is no content generated for this post. ')
                                        ->warning()
                                        ->send();
                                    return;
                                }

                                // Fill the form fields
                                $set('content', $generatedContent);
                                $set('cover_image', $imagePath);

                            } catch (\Throwable $th) {
                                Notification::make()
                                    ->title('Error')
                                    ->body('Failed to generate Content by the AI. ' . $th->getMessage())
                                    ->danger()
                                    ->send();
                                return;
                            }


                        })
                    ),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->label('Cover Image')
                    ->disk('public')
                    ->image()
                    ->directory('posts/covers')
                    ->imageEditor() // optional: crop / rotate
                    ->maxSize(2048) // 2MB
            ]);
    }
}
