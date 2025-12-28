@extends('layouts.app')

@section('content')
<article class="pt-16 pb-24">
    {{-- Hero Section --}}
    <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="mb-8 overflow-hidden rounded-3xl bg-neutral-100 aspect-[21/9]">
            @if($post->cover_image)
               <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center text-neutral-400">
                    <svg class="w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
        </div>

        <div class="space-y-6 text-center">
            <div class="inline-flex items-center px-3 py-1 bg-neutral-100 text-neutral-600 text-xs font-semibold rounded-full uppercase tracking-wider">
                Story
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight text-neutral-900 leading-[1.1]">
                {{ $post->title }}
            </h1>
            <div class="flex items-center justify-center space-x-4 text-neutral-500 text-sm">
                <time datetime="{{ $post->created_at->toW3cString() }}">
                    Published {{ $post->created_at->format('M j, Y') }}
                </time>
                <span class="text-neutral-300">•</span>
                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
            </div>
        </div>
    </header>

    {{-- Content --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-neutral prose-lg max-w-none prose-headings:font-bold prose-a:text-neutral-900 prose-img:rounded-3xl">
            {!! Str::markdown($post->content) !!}
        </div>

        <div class="mt-20 pt-10 border-t border-neutral-200">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-neutral-900 hover:text-neutral-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    Back to stories
                </a>
                <div class="flex items-center space-x-4 uppercase tracking-widest text-[10px] font-bold text-neutral-400">
                    <span>Share</span>
                    <div class="w-12 h-px bg-neutral-200"></div>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection
