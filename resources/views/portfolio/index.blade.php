@extends('layouts.app')

@section('content')
    {{-- Navigation --}}
    <nav id="navbar" class="fixed top-0 inset-x-0 z-50 transition-all duration-500 border-b border-transparent [&.nav-scrolled]:bg-off-white/90 [&.nav-scrolled]:backdrop-blur-xl [&.nav-scrolled]:border-purple-25 [&.nav-scrolled]:shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="#home" class="brand-logo group" aria-label="Michaela Verzosa — home">
                <span>MV</span><span class="brand-logo__dot">.</span>
            </a>

            <div class="hidden md:flex items-center gap-6 lg:gap-8 text-sm">
                <a href="#services" class="nav-link">Services</a>
                <a href="#projects" class="nav-link">Projects</a>
                <a href="#experience-skills" class="nav-link">Experience</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>

            <a href="#contact" class="hidden sm:inline-flex btn-primary text-sm !py-2.5 !px-5">
                Get in touch
            </a>

            <button id="mobile-menu-btn" type="button" class="md:hidden p-2 text-purple-500 hover:text-purple-600 transition-colors" aria-label="Open menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-purple-25 bg-off-white/95 backdrop-blur-xl px-6 py-4 space-y-3">
            <a href="#services" class="block text-purple-400 hover:text-purple-600 transition-colors">Services</a>
            <a href="#projects" class="block text-purple-400 hover:text-purple-600 transition-colors">Recent Projects</a>
            <a href="#experience-skills" class="block text-purple-400 hover:text-purple-600 transition-colors">Experience & Skills</a>
            <a href="#contact" class="block text-purple-400 hover:text-purple-600 transition-colors">Contact</a>
        </div>
    </nav>

    {{-- Hero --}}
    <section id="home" class="relative min-h-screen flex flex-col justify-center pt-24 pb-0 overflow-hidden bg-section">
        {{-- Floating orbs — secondary-emphasis & purple-25 only --}}
        <div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none">
            <div data-parallax="0.12" class="absolute top-24 -right-20 w-[28rem] h-[28rem] bg-secondary-emphasis/70 rounded-full blur-3xl animate-pulse-glow"></div>
            <div data-parallax="0.2" class="absolute -bottom-32 -left-20 w-96 h-96 bg-purple-25/80 rounded-full blur-3xl animate-float-delayed"></div>
        </div>

        <div class="max-w-6xl mx-auto w-full flex-1 flex items-center px-6">
            <div class="flex flex-col lg:flex-row items-center gap-14 lg:gap-20 w-full">
                <div class="flex-1 text-center lg:text-left">
                    <div class="hero-enter inline-flex items-center gap-2 px-4 py-2 rounded-full bg-secondary-emphasis border border-purple-25 text-label text-sm font-medium mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-500 opacity-40"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-purple-500"></span>
                        </span>
                        Available for work
                    </div>

                    <p class="hero-enter hero-enter-delay-1 text-label font-medium mb-3 tracking-[0.2em] uppercase text-sm">Hello, I'm</p>
                    <h1 class="hero-enter hero-enter-delay-2 text-5xl md:text-6xl lg:text-8xl font-bold leading-[1.05] mb-5 text-heading">
                        {{ $profile?->name ?? 'Your Name' }}
                    </h1>
                    <p class="hero-enter hero-enter-delay-3 text-2xl md:text-3xl text-purple-500 font-semibold mb-6">
                        {{ $profile?->title ?? 'Developer' }}
                    </p>
                    <p class="hero-enter hero-enter-delay-3 text-body text-lg max-w-xl mx-auto lg:mx-0 leading-relaxed mb-10">
                        {{ $profile?->bio }}
                    </p>

                    <div class="hero-enter hero-enter-delay-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 mb-10">
                        <a href="#projects" class="btn-primary group">
                            View my work
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        @if ($profile?->resume_url)
                            <a href="{{ $profile->resume_url }}" target="_blank" rel="noopener" class="btn-outline">Download CV</a>
                        @endif
                    </div>

                    @if ($profile?->linkedin_url || $profile?->facebook_url || $profile?->instagram_url || $profile?->github_url)
                        <div class="hero-enter hero-enter-delay-4 flex items-center justify-center lg:justify-start gap-3">
                            @if ($profile->linkedin_url)
                                <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener"
                                   class="p-3 rounded-2xl bg-off-white/60 border border-purple-25 text-purple-400 hover:text-purple-600 hover:border-purple-100 hover:shadow-[0_0_24px_color-mix(in_lab,var(--color-purple-300)_35%,transparent)] transition-all duration-300 backdrop-blur-sm" aria-label="LinkedIn">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 114.126 0 2.063 2.063 0 01-2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            @endif
                            @if ($profile->facebook_url)
                                <a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener"
                                   class="p-3 rounded-2xl bg-off-white/60 border border-purple-25 text-purple-400 hover:text-purple-600 hover:border-purple-100 hover:shadow-[0_0_24px_color-mix(in_lab,var(--color-purple-300)_35%,transparent)] transition-all duration-300 backdrop-blur-sm" aria-label="Facebook">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if ($profile->instagram_url)
                                <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener"
                                   class="p-3 rounded-2xl bg-off-white/60 border border-purple-25 text-purple-400 hover:text-purple-600 hover:border-purple-100 hover:shadow-[0_0_24px_color-mix(in_lab,var(--color-purple-300)_35%,transparent)] transition-all duration-300 backdrop-blur-sm" aria-label="Instagram">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </a>
                            @endif
                            @if ($profile->github_url)
                                <a href="{{ $profile->github_url }}" target="_blank" rel="noopener"
                                   class="p-3 rounded-2xl bg-off-white/60 border border-purple-25 text-purple-400 hover:text-purple-600 hover:border-purple-100 hover:shadow-[0_0_24px_color-mix(in_lab,var(--color-purple-300)_35%,transparent)] transition-all duration-300 backdrop-blur-sm" aria-label="GitHub">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.395-.135-.345-.72-1.395-1.23-1.665-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Profile photo — bottom fades into hero background --}}
                <div class="hero-enter hero-enter-delay-4 flex-shrink-0 relative">
                    <div class="hero-portrait relative w-80 h-[26rem] sm:w-96 sm:h-[30rem] lg:w-[28rem] lg:h-[34rem]">
                        @if ($profile?->avatar_path)
                            <img
                                src="{{ asset($profile->avatar_path) }}"
                                alt="{{ $profile->name }} — professional portrait"
                                class="w-full h-full object-contain border-0 outline-none shadow-none rounded-none"
                                width="672"
                                height="896"
                                loading="eager"
                            >
                        @else
                            <div class="avatar-block w-full h-full">
                                <span class="avatar-block-initials">
                                    {{ $profile?->avatar_initials ?? 'MV' }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Tech marquee — technical skills only (JS-driven infinite scroll) --}}
        @php
            $allTech = ($skills->get('Technical Skills') ?? collect())->pluck('name')->unique()->values();
            // Repeat enough times so the strip always fills wide screens
            $marqueeTech = $allTech->concat($allTech)->concat($allTech);
        @endphp
        @if ($allTech->isNotEmpty())
            <div class="w-full mt-10 bg-purple-600 py-5 overflow-hidden">
                <div class="marquee-track" data-marquee>
                    <div class="marquee-group">
                        @foreach ($marqueeTech as $tech)
                            <span class="px-5 py-2 rounded-full bg-purple-500/50 border border-purple-400/40 text-off-white text-sm font-medium whitespace-nowrap">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                    <div class="marquee-group" aria-hidden="true">
                        @foreach ($marqueeTech as $tech)
                            <span class="px-5 py-2 rounded-full bg-purple-500/50 border border-purple-400/40 text-off-white text-sm font-medium whitespace-nowrap">
                                {{ $tech }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{-- Services --}}
    <section id="services" class="py-28 px-6 bg-section relative overflow-hidden">
        <div class="max-w-6xl mx-auto">
            <div class="reveal text-center mb-16">
                <p class="text-label text-sm font-semibold uppercase tracking-[0.2em] mb-2">Services</p>
                <h2 class="section-heading">What I work on</h2>
                <div class="section-line w-24 mx-auto"></div>
                <p class="text-body text-lg max-w-2xl mx-auto mt-6">
                    Custom development and CMS builds for teams that need a site shipped — and kept running.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-stagger>
                @forelse ($services as $service)
                    <div class="reveal-scale glass-card p-7 group">
                        <div class="w-14 h-14 rounded-2xl icon-badge mb-5 transition-shadow duration-300 group-hover:shadow-[0_0_20px_color-mix(in_lab,var(--color-purple-300)_40%,transparent)]">
                            @switch($service->icon)
                                @case('layout')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                                    @break
                                @case('database')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                                    @break
                                @case('wrench')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    @break
                                @default
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                            @endswitch
                        </div>
                        <h3 class="text-lg font-bold text-purple-600 mb-3">{{ $service->title }}</h3>
                        <p class="text-body text-sm leading-relaxed">{{ $service->description }}</p>
                    </div>
                @empty
                    <p class="text-muted col-span-full text-center">No services listed yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Recent Projects — tabbed: Development | CMS --}}
    <section id="projects" class="py-28 px-6 bg-section-alt relative overflow-hidden">
        <div class="max-w-6xl mx-auto">
            <div class="reveal mb-10 text-center">
                <p class="text-label text-sm font-semibold uppercase tracking-[0.2em] mb-2">My work</p>
                <h2 class="section-heading">Recent Projects</h2>
                <div class="section-line w-24 mx-auto"></div>
            </div>

            {{-- Tabs — high-contrast so visitors can tell they switch project categories --}}
            <div class="reveal mb-10 flex flex-col items-center" data-project-tabs>
                <p class="text-sm text-purple-400 mb-3">Switch category</p>
                <div
                    class="project-tablist inline-flex items-center"
                    role="tablist"
                    aria-label="Project categories"
                >
                    <button
                        type="button"
                        role="tab"
                        id="tab-development"
                        aria-selected="true"
                        aria-controls="panel-development"
                        data-tab="development"
                        class="project-tab is-active px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    >
                        Custom Development
                    </button>
                    <button
                        type="button"
                        role="tab"
                        id="tab-cms"
                        aria-selected="false"
                        aria-controls="panel-cms"
                        data-tab="cms"
                        class="project-tab px-5 py-2.5 rounded-xl text-sm font-semibold transition-all"
                    >
                        CMS Platforms
                    </button>
                </div>
            </div>

            {{-- Development panel --}}
            <div
                id="panel-development"
                role="tabpanel"
                aria-labelledby="tab-development"
                data-tab-panel="development"
                class="grid md:grid-cols-2 lg:grid-cols-3 gap-8"
            >
                @forelse ($projects->get('development', collect()) as $project)
                    @include('portfolio.partials.project-card', ['project' => $project, 'skipReveal' => true])
                @empty
                    <p class="text-muted col-span-full">No development projects yet.</p>
                @endforelse
            </div>

            {{-- CMS panel (hidden by default) --}}
            <div
                id="panel-cms"
                role="tabpanel"
                aria-labelledby="tab-cms"
                data-tab-panel="cms"
                hidden
                class="grid md:grid-cols-2 lg:grid-cols-3 gap-8"
            >
                @forelse ($projects->get('cms', collect()) as $project)
                    @include('portfolio.partials.project-card', ['project' => $project, 'skipReveal' => true])
                @empty
                    <p class="text-muted col-span-full">No CMS projects yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Experience & Skills --}}
    <section id="experience-skills" class="py-28 px-6 bg-section">
        <div class="max-w-6xl mx-auto">
            <div class="reveal mb-16">
                <p class="text-label text-sm font-semibold uppercase tracking-[0.2em] mb-2">Background</p>
                <h2 class="section-heading">Experience & Skills</h2>
                <div class="section-line w-24"></div>
            </div>

            <div class="grid lg:grid-cols-2 gap-14">
                {{-- Experience column --}}
                <div>
                    <h3 class="text-xl font-bold text-purple-600 mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg icon-badge">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </span>
                        Experience
                    </h3>

                    <div class="relative">
                        <div class="timeline-line absolute left-4 top-0 bottom-0 w-0.5 bg-purple-100"></div>
                        <div class="space-y-8" data-stagger>
                            @forelse ($experiences as $experience)
                                <div class="reveal relative pl-12">
                                    <div class="absolute left-2 top-5 w-4 h-4 rounded-full bg-purple-500 border-4 border-off-white z-10"></div>
                                    <div class="glass-card p-6 !rounded-2xl">
                                        <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                            <div>
                                                <h4 class="font-bold text-purple-600">{{ $experience->role }}</h4>
                                                <p class="text-purple-400 text-sm font-semibold">{{ $experience->company }}</p>
                                            </div>
                                            <span class="text-xs text-muted font-medium whitespace-nowrap">
                                                {{ $experience->start_date->format('M Y') }} — {{ $experience->is_current ? 'Present' : $experience->end_date?->format('M Y') }}
                                            </span>
                                        </div>
                                        @php
                                            $bullets = preg_split('/\r\n|\r|\n/', (string) $experience->description) ?: [];
                                            $bullets = array_values(array_filter(array_map('trim', $bullets)));
                                        @endphp
                                        @if (count($bullets) > 0)
                                            <ul class="experience-bullets mt-3 space-y-2">
                                                @foreach ($bullets as $bullet)
                                                    <li class="text-body text-sm leading-relaxed">
                                                        <span class="experience-bullets__mark" aria-hidden="true">•</span>
                                                        <span>{{ $bullet }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted pl-12 text-sm">No experience added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Skills column --}}
                <div>
                    <h3 class="text-xl font-bold text-purple-600 mb-8 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg icon-badge">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </span>
                        Skills
                    </h3>

                    <div class="space-y-6" data-stagger>
                        @forelse ($skills as $category => $categorySkills)
                            <div class="reveal-scale glass-card p-6">
                                <h4 class="text-sm font-bold text-purple-500 uppercase tracking-wider mb-4">{{ $category }}</h4>
                                <ul class="space-y-4">
                                    @foreach ($categorySkills as $skill)
                                        <li>
                                            <div class="flex justify-between text-sm mb-1.5">
                                                <span class="font-semibold text-purple-600">{{ $skill->name }}</span>
                                                <span class="text-muted">{{ $skill->proficiency }}%</span>
                                            </div>
                                            <div class="h-2 bg-purple-25 rounded-full overflow-hidden">
                                                <div class="skill-bar-fill h-full bg-purple-200 rounded-full"
                                                     data-width="{{ $skill->proficiency }}%"></div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <p class="text-muted text-sm">No skills added yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Contact — dark violet band --}}
    <section id="contact" class="contact-section py-28 px-6 relative overflow-hidden">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <div class="reveal-left">
                    <p class="text-purple-100 text-sm font-semibold uppercase tracking-[0.2em] mb-3">Contact</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-off-white mb-6 leading-tight">Have a project in mind?</h2>
                    <p class="text-purple-50 text-lg leading-relaxed mb-8">
                        Send a message about a new build or an existing site. I'll get back to you as soon as I can.
                    </p>
                    <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                        @if ($profile?->email)
                            <a href="mailto:{{ $profile->email }}"
                               class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-purple-500/40 border border-purple-300/40 text-off-white font-semibold hover:bg-purple-500/55 hover:shadow-[0_0_24px_color-mix(in_lab,var(--color-purple-300)_45%,transparent)] transition-all duration-300">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $profile->email }}
                            </a>
                        @endif
                        @if ($profile?->whatsapp)
                            @php
                                $waDigits = preg_replace('/\D+/', '', $profile->whatsapp);
                            @endphp
                            <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-purple-500/40 border border-purple-300/40 text-off-white font-semibold hover:bg-purple-500/55 hover:shadow-[0_0_24px_color-mix(in_lab,var(--color-purple-300)_45%,transparent)] transition-all duration-300">
                                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.198.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                {{ $profile->whatsapp }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="reveal-right">
                    <div class="glass-card p-8 md:p-10">
                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5" id="contact-form">
                            @csrf

                            <div>
                                <label for="name" class="block text-sm font-semibold text-purple-500 mb-2">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3.5 rounded-xl border border-purple-100 bg-off-white text-purple-600 placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent transition-all hover:border-purple-200">
                                @error('name')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-purple-500 mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3.5 rounded-xl border border-purple-100 bg-off-white text-purple-600 placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent transition-all hover:border-purple-200">
                                @error('email')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-semibold text-purple-500 mb-2">Subject <span class="text-purple-200 font-normal">(optional)</span></label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                       class="w-full px-4 py-3.5 rounded-xl border border-purple-100 bg-off-white text-purple-600 placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent transition-all hover:border-purple-200">
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-semibold text-purple-500 mb-2">Message</label>
                                <textarea name="message" id="message" rows="4" required
                                          class="w-full px-4 py-3.5 rounded-xl border border-purple-100 bg-off-white text-purple-600 placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent transition-all hover:border-purple-200 resize-none">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="btn-primary w-full !rounded-xl">
                                Send message
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-10 px-6 bg-purple-600 border-t border-purple-500 text-purple-100 relative">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-sm">
            <p>&copy; {{ date('Y') }} {{ $profile?->name ?? 'Portfolio' }}. Built with Laravel & Tailwind.</p>
            <a href="#home" class="hover:text-off-white transition-colors inline-flex items-center gap-1 group">
                Back to top
                <svg class="w-4 h-4 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            </a>
        </div>
    </footer>

    {{-- Project screenshot lightbox (zoomable) --}}
    <div
        id="project-lightbox"
        class="project-lightbox"
        hidden
        role="dialog"
        aria-modal="true"
        aria-label="Project screenshot"
    >
        <button type="button" class="project-lightbox__backdrop" data-lightbox-close aria-label="Close preview"></button>
        <div class="project-lightbox__panel">
            <div class="project-lightbox__toolbar">
                <button type="button" data-lightbox-zoom-out class="project-lightbox__btn" aria-label="Zoom out">−</button>
                <button type="button" data-lightbox-zoom-in class="project-lightbox__btn" aria-label="Zoom in">+</button>
                <button type="button" data-lightbox-close class="project-lightbox__btn" aria-label="Close">✕</button>
            </div>
            <div class="project-lightbox__stage" data-lightbox-stage>
                <img src="" alt="" data-lightbox-image class="project-lightbox__image" draggable="false">
            </div>
            <p class="project-lightbox__hint">Scroll or use + / − to zoom · Esc to close</p>
        </div>
    </div>

    {{-- Contact form result modal (success / error) --}}
    @php
        $contactModal = session('contact_modal');
        if (! $contactModal && $errors->any()) {
            $contactModal = [
                'type' => 'error',
                'title' => 'Please check the form',
                'message' => $errors->first(),
            ];
        }

        $flashType = $contactModal['type'] ?? 'success';
        $flashTitle = $contactModal['title'] ?? 'Message sent';
        $flashMessage = $contactModal['message'] ?? '';
        $flashHiddenAttr = filled($contactModal) ? '' : 'hidden';
        $flashIsError = ($flashType === 'error');
    @endphp

    <div id="flash-modal" class="flash-modal" role="dialog" aria-modal="true" aria-labelledby="flash-modal-title" data-flash-type="{{ $flashType }}" {{ $flashHiddenAttr }}>
        <button type="button" class="flash-modal__backdrop" data-flash-close aria-label="Close"></button>
        <div class="flash-modal__panel" data-flash-panel>
            <div class="flash-modal__icon" data-flash-icon aria-hidden="true">
                @if ($flashIsError)
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>
            <h3 id="flash-modal-title" class="flash-modal__title" data-flash-title>{{ $flashTitle }}</h3>
            <p class="flash-modal__message" data-flash-message>{{ $flashMessage }}</p>
            <button type="button" class="btn-primary !rounded-xl mt-2" data-flash-close>Got it</button>
        </div>
    </div>
@endsection
