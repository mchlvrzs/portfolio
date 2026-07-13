{{-- Single project card used in both Development and CMS grids --}}
@php
    $cardClass = !empty($skipReveal) ? 'project-card group' : 'reveal-scale project-card group';
@endphp
<article class="{{ $cardClass }}">
    <div class="glass-card overflow-hidden !rounded-3xl h-full flex flex-col">
        <div class="h-44 project-thumb relative overflow-hidden">
            @if ($project->image_path)
                {{-- Click opens zoomable lightbox preview --}}
                <button
                    type="button"
                    class="absolute inset-0 w-full h-full cursor-zoom-in focus:outline-none focus-visible:ring-2 focus-visible:ring-purple-400 focus-visible:ring-inset"
                    data-lightbox-trigger
                    data-lightbox-src="{{ asset($project->image_path) }}"
                    data-lightbox-alt="{{ $project->title }} preview"
                    aria-label="View {{ $project->title }} screenshot"
                >
                    <img
                        src="{{ asset($project->image_path) }}"
                        alt="{{ $project->title }} preview"
                        class="project-shot absolute inset-0 w-full h-full object-cover object-top pointer-events-none"
                    >
                </button>
            @else
                <div class="absolute inset-0 project-thumb"></div>
            @endif
            @if ($project->featured)
                <span class="absolute top-4 left-4 px-3 py-1 bg-off-white/90 text-purple-500 text-xs font-bold rounded-full backdrop-blur-sm pointer-events-none z-10">
                    ★ Featured
                </span>
            @endif
        </div>
        <div class="p-6 flex-1 flex flex-col">
            <h3 class="text-xl font-bold text-purple-600 mb-2">
                {{ $project->title }}
            </h3>
            <p class="text-body text-sm leading-relaxed mb-5 flex-1">
                {{ $project->description }}
            </p>
            <div class="flex flex-wrap gap-2 mb-5">
                @foreach ($project->tech_stack as $tech)
                    <span class="px-2.5 py-1 bg-purple-25 text-purple-500 text-xs font-semibold rounded-lg border border-purple-25">
                        {{ $tech }}
                    </span>
                @endforeach
            </div>
            <div class="flex gap-5 pt-4 border-t border-purple-25">
                @if ($project->live_url)
                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                       class="text-sm font-bold text-purple-500 hover:text-purple-400 transition-colors inline-flex items-center gap-1">
                        Live demo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</article>
