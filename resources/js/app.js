import './bootstrap';

const STORAGE_KEY = 'robanis-theme';

/**
 * Theme toggle — flips data-theme on <html> and persists the choice.
 * The initial theme is already set by the blocking inline script in
 * <head>, so this only handles the user explicitly changing it.
 */
function initThemeToggle() {
    const toggle = document.querySelector('[data-theme-toggle]');
    if (!toggle) return;

    const setLabel = (theme) => {
        const next = theme === 'robanis-dark' ? 'light' : 'dark';
        toggle.setAttribute('aria-label', `Switch to ${next} theme`);
        toggle.setAttribute('aria-pressed', theme === 'robanis-dark' ? 'true' : 'false');
    };

    setLabel(document.documentElement.getAttribute('data-theme') || 'robanis-light');

    toggle.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'robanis-dark' ? 'robanis-light' : 'robanis-dark';
        document.documentElement.setAttribute('data-theme', next);
        setLabel(next);
        try {
            localStorage.setItem(STORAGE_KEY, next);
        } catch {
            // Private browsing / blocked storage — the toggle still works
            // for this page view, it just won't persist.
        }
    });
}

/**
 * Header gains a hairline bottom border once the page has scrolled past
 * the hero, so it reads as transparent-over-hero and solid elsewhere.
 */
function initHeaderScroll() {
    const header = document.querySelector('[data-header]');
    if (!header) return;

    let ticking = false;
    const update = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 8);
        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        },
        { passive: true },
    );
    update();
}

/**
 * Full-screen mobile overlay menu: locks scroll, makes the rest of the
 * page inert, traps focus, and closes on Escape or link click.
 */
function initMobileMenu() {
    const toggles = document.querySelectorAll('[data-menu-toggle]');
    const menu = document.querySelector('[data-menu]');
    if (!toggles.length || !menu) return;

    const opener = toggles[0]; // the header's own menu button — focus returns here on close
    const inertTargets = document.querySelectorAll('[data-inert-on-menu]');
    let isOpen = false;

    const setExpanded = (value) => toggles.forEach((el) => el.setAttribute('aria-expanded', value));

    const open = () => {
        isOpen = true;
        menu.classList.remove('hidden');
        menu.classList.add('flex');
        setExpanded('true');
        document.body.classList.add('overflow-hidden');
        inertTargets.forEach((el) => el.setAttribute('inert', ''));
        menu.querySelector('a, button')?.focus();
    };

    const close = ({ restoreFocus = true } = {}) => {
        isOpen = false;
        menu.classList.add('hidden');
        menu.classList.remove('flex');
        setExpanded('false');
        document.body.classList.remove('overflow-hidden');
        inertTargets.forEach((el) => el.removeAttribute('inert'));
        if (restoreFocus) opener.focus();
    };

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', () => (isOpen ? close() : open()));
    });

    menu.addEventListener('click', (event) => {
        if (event.target.closest('a')) close({ restoreFocus: false });
    });

    document.addEventListener('keydown', (event) => {
        if (isOpen && event.key === 'Escape') close();
    });
}

/**
 * Desktop Services dropdown — a disclosure button, not an ARIA menu.
 * Opens on click (and on hover for mouse users); closes on Escape, an
 * outside click, or focus leaving the group.
 */
function initSubmenus() {
    document.querySelectorAll('[data-submenu]').forEach((group) => {
        const toggle = group.querySelector('[data-submenu-toggle]');
        const panel = group.querySelector('[data-submenu-panel]');
        if (!toggle || !panel) return;

        let closeTimer;

        const setOpen = (open) => {
            clearTimeout(closeTimer);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            panel.classList.toggle('hidden', !open);
        };
        const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

        // Keyboard activation (detail === 0) toggles. A pointer click keeps it
        // open, since hovering has usually opened it already.
        toggle.addEventListener('click', (event) => setOpen(event.detail === 0 ? !isOpen() : true));

        group.addEventListener('mouseenter', () => setOpen(true));
        group.addEventListener('mouseleave', () => {
            closeTimer = setTimeout(() => setOpen(false), 150);
        });

        group.addEventListener('focusout', (event) => {
            if (!group.contains(event.relatedTarget)) setOpen(false);
        });

        group.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isOpen()) {
                setOpen(false);
                toggle.focus();
            }
        });

        document.addEventListener('click', (event) => {
            if (isOpen() && !group.contains(event.target)) setOpen(false);
        });
    });
}

/**
 * Reveal-on-scroll: the one motion pattern used across the site. Skips
 * entirely when the user prefers reduced motion — the CSS behind
 * html.js [data-reveal] is already scoped to that media query, so the
 * observer just adds a class it's free to add regardless.
 */
function initReveal() {
    const targets = document.querySelectorAll('[data-reveal]');
    if (!targets.length) return;

    if (!('IntersectionObserver' in window)) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 },
    );

    targets.forEach((el) => observer.observe(el));
}

document.documentElement.classList.add('js');

initThemeToggle();
initHeaderScroll();
initMobileMenu();
initSubmenus();
initReveal();
