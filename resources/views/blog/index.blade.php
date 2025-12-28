@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="mb-16">
        <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-neutral-900 mb-4">
            Recent Stories
        </h1>
        <p class="text-lg text-neutral-500 max-w-2xl">
            Thoughts, insights, and stories from the interface of design and technology.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($posts as $post)
            <article class="group relative flex flex-col bg-white rounded-3xl overflow-hidden border border-neutral-200/50 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <a href="{{ route('blog.show', $post) }}" class="absolute inset-0 z-10" aria-label="Read {{ $post->title }}"></a>

                <div class="aspect-[16/10] overflow-hidden bg-neutral-100">
                    @if($post->cover_image)
                        <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-neutral-400">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-8 flex flex-col flex-grow">
                    <div class="mb-4 text-xs font-semibold tracking-wider text-neutral-400 uppercase">
                        Published {{ $post->created_at->format('M j, Y') }}
                    </div>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-4 leading-tight group-hover:text-neutral-700 transition-colors">
                        {{ $post->title }}
                    </h2>
                    <p class="text-neutral-500 line-clamp-3 mb-6 flex-grow leading-relaxed">
                        {{ strip_tags($post->content) }}
                    </p>
                    <div class="flex items-center text-sm font-semibold text-neutral-900 space-x-2">
                        <span>Read article</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-16">
        {{ $posts->links() }}
    </div>
</div>
@endsection
