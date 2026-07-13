// Mobile navigation
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu?.classList.toggle('hidden');
});

document.querySelectorAll('#mobile-menu a').forEach((link) => {
    link.addEventListener('click', () => mobileMenu?.classList.add('hidden'));
});

// Navbar scroll state
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (!navbar) return;
    navbar.classList.toggle('nav-scrolled', window.scrollY > 40);
}, { passive: true });

// Intersection Observer — scroll reveal animations
const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
);

document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .section-line, .timeline-line').forEach((el) => {
    revealObserver.observe(el);
});

// Stagger child reveal delays
document.querySelectorAll('[data-stagger]').forEach((parent) => {
    parent.querySelectorAll('.reveal, .reveal-scale').forEach((child, index) => {
        child.style.setProperty('--stagger-index', index);
    });
});

// Skill bars animate width when scrolled into view
const skillObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            skillObserver.unobserve(entry.target);
        });
    },
    { threshold: 0.5 }
);

document.querySelectorAll('.skill-bar-fill').forEach((bar) => {
    bar.style.setProperty('--skill-width', bar.dataset.width);
    skillObserver.observe(bar);
});

// Active nav link on scroll
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

const sectionObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const id = entry.target.getAttribute('id');
            navLinks.forEach((link) => {
                link.classList.toggle('is-active', link.getAttribute('href') === `#${id}`);
            });
        });
    },
    { threshold: 0.35, rootMargin: '-20% 0px -55% 0px' }
);

sections.forEach((section) => sectionObserver.observe(section));

// Subtle parallax on hero floating orbs
const orbs = document.querySelectorAll('[data-parallax]');
if (orbs.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        orbs.forEach((orb) => {
            const speed = parseFloat(orb.dataset.parallax) || 0.15;
            orb.style.transform = `translateY(${scrollY * speed}px)`;
        });
    }, { passive: true });
}

// Infinite skill marquee — JS so it always runs (OS "reduce motion" was killing CSS animation)
document.querySelectorAll('[data-marquee]').forEach((track) => {
    const firstGroup = track.querySelector('.marquee-group');
    if (!firstGroup) return;

    let offset = 0;
    let paused = false;
    // pixels per second
    const speed = 60;

    track.addEventListener('mouseenter', () => { paused = true; });
    track.addEventListener('mouseleave', () => { paused = false; });

    let last = performance.now();

    const tick = (now) => {
        const delta = (now - last) / 1000;
        last = now;

        if (!paused) {
            offset += speed * delta;
            const loopWidth = firstGroup.offsetWidth;
            if (loopWidth > 0 && offset >= loopWidth) {
                offset -= loopWidth;
            }
            track.style.transform = `translate3d(${-offset}px, 0, 0)`;
        }

        requestAnimationFrame(tick);
    };

    requestAnimationFrame(tick);
});

// Project screenshot lightbox — open, zoom, pan, close
(() => {
    const lightbox = document.getElementById('project-lightbox');
    if (!lightbox) return;

    const image = lightbox.querySelector('[data-lightbox-image]');
    const stage = lightbox.querySelector('[data-lightbox-stage]');
    const zoomInBtn = lightbox.querySelector('[data-lightbox-zoom-in]');
    const zoomOutBtn = lightbox.querySelector('[data-lightbox-zoom-out]');
    const closeBtns = lightbox.querySelectorAll('[data-lightbox-close]');

    let scale = 1;
    const minScale = 1;
    const maxScale = 3;
    const step = 0.25;

    let isDragging = false;
    let startX = 0;
    let startY = 0;
    let scrollLeft = 0;
    let scrollTop = 0;

    const applyZoom = () => {
        if (!image) return;
        image.style.transform = `scale(${scale})`;
    };

    const openLightbox = (src, alt) => {
        if (!image) return;
        image.src = src;
        image.alt = alt || 'Project screenshot';
        scale = 1;
        applyZoom();
        lightbox.hidden = false;
        document.body.classList.add('lightbox-open');
        if (stage) {
            stage.scrollLeft = 0;
            stage.scrollTop = 0;
        }
    };

    const closeLightbox = () => {
        lightbox.hidden = true;
        document.body.classList.remove('lightbox-open');
        if (image) {
            image.removeAttribute('src');
            image.alt = '';
        }
        scale = 1;
        applyZoom();
    };

    document.querySelectorAll('[data-lightbox-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            openLightbox(trigger.dataset.lightboxSrc, trigger.dataset.lightboxAlt);
        });
    });

    closeBtns.forEach((btn) => btn.addEventListener('click', closeLightbox));

    zoomInBtn?.addEventListener('click', () => {
        scale = Math.min(maxScale, scale + step);
        applyZoom();
    });

    zoomOutBtn?.addEventListener('click', () => {
        scale = Math.max(minScale, scale - step);
        applyZoom();
    });

    // Wheel zoom while lightbox is open
    stage?.addEventListener('wheel', (e) => {
        if (lightbox.hidden) return;
        e.preventDefault();
        scale = e.deltaY < 0
            ? Math.min(maxScale, scale + step)
            : Math.max(minScale, scale - step);
        applyZoom();
    }, { passive: false });

    // Drag to pan when zoomed
    stage?.addEventListener('mousedown', (e) => {
        if (scale <= 1) return;
        isDragging = true;
        stage.classList.add('is-dragging');
        startX = e.pageX - stage.offsetLeft;
        startY = e.pageY - stage.offsetTop;
        scrollLeft = stage.scrollLeft;
        scrollTop = stage.scrollTop;
    });

    window.addEventListener('mouseup', () => {
        isDragging = false;
        stage?.classList.remove('is-dragging');
    });

    stage?.addEventListener('mousemove', (e) => {
        if (!isDragging || !stage) return;
        e.preventDefault();
        const x = e.pageX - stage.offsetLeft;
        const y = e.pageY - stage.offsetTop;
        stage.scrollLeft = scrollLeft - (x - startX);
        stage.scrollTop = scrollTop - (y - startY);
    });

    document.addEventListener('keydown', (e) => {
        if (lightbox.hidden) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === '+' || e.key === '=') {
            scale = Math.min(maxScale, scale + step);
            applyZoom();
        }
        if (e.key === '-' || e.key === '_') {
            scale = Math.max(minScale, scale - step);
            applyZoom();
        }
    });
})();

// Project category tabs (Custom Development | CMS Platforms)
document.querySelectorAll('[data-project-tabs]').forEach((tabsRoot) => {
    const buttons = tabsRoot.querySelectorAll('[data-tab]');

    const showTab = (key) => {
        buttons.forEach((btn) => {
            const active = btn.dataset.tab === key;
            btn.classList.toggle('is-active', active);
            btn.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        document.querySelectorAll('[data-tab-panel]').forEach((panel) => {
            const match = panel.dataset.tabPanel === key;
            panel.hidden = !match;
        });
    };

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => showTab(btn.dataset.tab));
    });
});

// Contact form flash modal (success / error)
(() => {
    const modal = document.getElementById('flash-modal');
    if (!modal) return;

    const openModal = () => {
        modal.hidden = false;
        document.body.classList.add('flash-modal-open');
    };

    const closeModal = () => {
        modal.hidden = true;
        document.body.classList.remove('flash-modal-open');
    };

    // Open automatically when the server rendered flash content
    if (!modal.hidden) {
        openModal();
        // Keep hash on contact so the form stays in view after redirect
        if (!window.location.hash) {
            window.location.hash = 'contact';
        }
    }

    modal.querySelectorAll('[data-flash-close]').forEach((el) => {
        el.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.hidden) {
            closeModal();
        }
    });
})();
