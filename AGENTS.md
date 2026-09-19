# AGENTS.md — Robanis technical guide

Instructions for AI coding agents and developers working on this repo. For
the visual/design system (palette, type, motion, voice), see
[DESIGN.md](DESIGN.md) — read both before changing anything user-facing.

## Project snapshot

- **Laravel 12.69**, PHP 8.2, Blade templates.
- **Tailwind CSS 4.3 + daisyUI 5.7**, CSS-first config. There is **no**
  `tailwind.config.js` — theme, plugins and tokens all live in
  `resources/css/app.css` via `@plugin`/`@theme`. Don't add one; don't mix
  daisyUI v4's JS-config syntax in with this.
- **Vite 7** for assets. Fonts are self-hosted
  (`@fontsource-variable/inter`, `@fontsource-variable/jetbrains-mono`) —
  no Google Fonts requests.
- **Pest 3** for tests, against an **in-memory SQLite** DB (`phpunit.xml`
  overrides `DB_CONNECTION`/`DB_DATABASE` for the test environment only —
  the app itself runs on MySQL).
- No queue workers, no outbound email. The only persistence is the `leads`
  table.

## Commands

```bash
composer install          # full install, needed for tests/Pint
npm install
composer dev               # php artisan serve + queue:listen + pail + vite, concurrently
php artisan test           # Pest — needs dev deps
vendor/bin/pint            # code style — needs dev deps
npm run build               # production assets
php artisan migrate
```

**If `vendor/` was built with `composer install --no-dev`** (e.g. after
prepping a cPanel upload), `php artisan test` and `vendor/bin/pint` won't
exist — Pest, Pint and friends are dev-only. Run plain `composer install`
(no flags) to bring them back before doing any further development.

## Architecture map

### Routes (`routes/web.php`) — 8 total

| Method | URI | Action | Name |
|---|---|---|---|
| GET | `/` | `PageController@home` | `home` |
| GET | `/services` | `PageController@services` | `services` |
| GET | `/services/{service}` | `PageController@service` | `services.show` |
| GET | `/why-us` | `PageController@whyUs` | `why-us` |
| GET | `/contact` | `PageController@contact` | `contact` |
| POST | `/leads` | `LeadController@store` | `leads.store` (`throttle:5,1`) |
| ANY | `/approach` | 301 → `/services#approach` | — |
| ANY | `/about` | 301 → `/why-us` | — |

`{service}` is constrained with `->whereIn('service', array_keys(config('offerings')))`,
so an unknown slug 404s before it ever reaches the controller.

### Leads

- `app/Http/Requests/StoreLeadRequest.php` — validation rules:
  `name` (max 120), `email` (`email:rfc`, max 190), `company` (nullable, max
  160), `tier_interest` (nullable, `Rule::in(Offerings::tierSlugs())`),
  `message` (max 2000), `source_page` (max 255), `website` (honeypot,
  always nullable). `getRedirectUrl()` overrides the default to always
  return `route('contact')`, so a failed submit lands back on Contact
  regardless of referer.
- `app/Http/Controllers/LeadController.php` — if `website` is filled, it
  returns the same success redirect without writing a row (bots learn
  nothing). Otherwise creates a `Lead` and redirects to `route('contact')`
  with a flash `status`.
- `app/Models/Lead.php` — `$fillable` covers every column except `id`/timestamps.
- `leads` table: `name`, `email` (indexed), `company` (nullable),
  `tier_interest` (nullable, **`varchar(40)`** — widened from the original
  20 by `2026_09_18_104743_widen_leads_tier_interest_column.php` because
  `agentic-ai-enterprise` is 22 chars), `message` (text), `source_page`,
  `ip_address`, timestamps.

### Offerings (services + tiers)

`config/offerings.php` is the **single source of truth** for the three
service lines (`seo`, `agentic-ai`, `software-solutions`) and their tiers.
Every line has exactly four tiers with the same names and `level`:

| Level | Tier | Slug pattern |
|---|---|---|
| 1 | Advice | `{line}-advice` |
| 2 | Starter | `{line}-starter` |
| 3 | Business (`featured: true`) | `{line}-business` |
| 4 | Enterprise | `{line}-enterprise` |

Each tier has `slug`, `name`, `level`, `featured`, `for` (one-line
description), `features` (list — this is all that's shown; **there are no
prices, no stats, no comparison table**). Each service also has `name`,
`nav_label`, `nav_blurb`, `headline`, `intro`, `highlights`.

`app/Support/Offerings.php` is the only place that reads this config:

- `Offerings::all()` — `Collection<string,array>` keyed by service slug.
- `Offerings::find($slug)` — one service or `null`.
- `Offerings::tierSlugs()` — flat list of every tier slug, used by the
  `StoreLeadRequest` whitelist.
- `Offerings::tierLabel($tierSlug)` — `"{Service name} — {Tier name}"`,
  used on the Contact page's "Enquiring about:" line.

**To add or rename a service or tier**: edit `config/offerings.php` only.
The route constraint, header dropdown, `/services` overview, each service
page and the lead-form whitelist all read from it — nothing else needs
touching. Keep tier slugs at 40 characters or fewer (the DB column width).

### Views

```
resources/views/
├── layouts/app.blade.php       # <head>, blocking theme script, header/footer include
├── partials/
│   ├── header.blade.php        # nav, Services dropdown, mobile overlay
│   ├── footer.blade.php
│   └── theme-toggle.blade.php
├── components/                 # see DESIGN.md § Component catalogue
│   ├── section-heading.blade.php
│   ├── service-line.blade.php
│   ├── tier-card.blade.php
│   ├── faq-item.blade.php
│   ├── field.blade.php
│   └── placeholder-image.blade.php
└── pages/
    ├── home.blade.php
    ├── services.blade.php      # overview + #approach section + #faq
    ├── service.blade.php       # one template, reused for all 3 service lines
    ├── why-us.blade.php
    └── contact.blade.php
```

### Frontend JS (`resources/js/app.js`)

Vanilla JS, no framework. Five init functions, all called unconditionally
at the bottom of the file:

- `initThemeToggle` — flips `data-theme` on `<html>`, persists to
  `localStorage['robanis-theme']`, wrapped in try/catch.
- `initHeaderScroll` — adds `.is-scrolled` to `[data-header]` past 8px of
  scroll (rAF-throttled). The header's own background is **always** solid
  (`bg-base-100` in the Blade markup) — this only toggles the hairline
  border. See Gotchas below for why that split matters.
- `initMobileMenu` — full-screen overlay, toggled via `hidden`/`flex`
  classes (not the native `hidden` attribute), locks body scroll, sets
  `inert` on `[data-inert-on-menu]` elements while open, Escape closes and
  returns focus to the opener.
- `initSubmenus` — the desktop Services dropdown: opens on hover or click,
  closes on Escape/outside-click/focus-out.
- `initReveal` — `IntersectionObserver` that adds `.is-visible` to
  `[data-reveal]` elements once, then unobserves them.

The theme itself is set **before** any of this runs, by a blocking inline
`<script>` in `layouts/app.blade.php`'s `<head>`, so there's no flash of
the wrong theme. **Light is the default**: the script picks
`robanis-dark` only if `localStorage['robanis-theme']` is exactly
`robanis-dark` (i.e. the visitor chose it with the toggle) and
`robanis-light` otherwise. It deliberately does **not** read
`prefers-color-scheme`, and `robanis-dark` has `prefersdark: false` in
`app.css` for the same reason — don't re-enable either without being
asked, or no-JS visitors and first-time visitors with a dark OS will get
dark mode again.

## How-to recipes

**Add a new page**: add a route + `PageController` action (or a new
controller if it doesn't fit there), a view under `pages/` extending
`layouts.app` with exactly one `<h1>`, add it to the header nav array and
footer link row, and add its path to the `pages` dataset in
`tests/Feature/PagesTest.php`.

**Add a new colour/token**: define it in *both* `@plugin "daisyui/theme"`
blocks in `app.css` (light and dark), check its contrast against every
surface it'll actually sit on (not just base-100), and update the token
table in DESIGN.md.

**Change tier/service copy**: edit `config/offerings.php` only — see
"Offerings" above.

## Rules

- Never introduce a `tailwind.config.js` or daisyUI v4 theme syntax.
- Never use font-weight 600/700, `shadow-*`, `rounded-full/lg/xl`, or a
  color gradient (the one dot-grid texture is the sole exception, and it's
  already in place — don't add another).
- No lorem ipsum. No banned words (see DESIGN.md § Voice). No exclamation
  marks in copy.
- Don't add testimonials, logo strips or invented stats (team size, years
  in business) — real placeholders (like `<x-placeholder-image>`) are fine;
  fabricated facts are not.
- Don't commit secrets. Any `.env*` template file must ship with `APP_KEY`
  blank — see the `.env.production.example` incident in Gotchas.
- Don't run `php artisan config:cache`/`route:cache`/`view:cache` in this
  working copy for a deploy — those bake in *this machine's* `.env` values.
  They belong on the production server, after its own `.env` exists there.
- Commit and push only when the user asks.

## Gotchas hit on this project (read before touching the header or CSS)

- **Tailwind's cascade layers, not specificity, decide winners.** A
  Tailwind utility class (`@layer utilities`) always beats a rule in
  `@layer components`, regardless of selector specificity. This is exactly
  what caused the header to stay see-through: the header had
  `bg-transparent` (a utility), and a component-layer rule tried to set
  `background-color` on scroll — the utility always won, silently. Fix:
  the header's own class is `bg-base-100` (always solid); the scroll state
  only toggles a border-color hairline, which no utility fights over. If
  you ever see a component-layer style not applying, suspect this first.
- **The native `hidden` attribute loses to a `flex`/`block` utility
  class**, because those are author-level CSS and `[hidden]` is only a
  user-agent default. The mobile menu therefore toggles between the
  `hidden` and `flex` *classes* (never adds `flex` alongside the `hidden`
  *attribute*) — see `initMobileMenu` and the CSS gotcha above for the same
  underlying cause.
- **HTML entities written inside a Blade component attribute get
  double-escaped.** `<x-faq-item question="...&quot;agentic&quot;...">`
  would render literal `&amp;quot;` text, because `{{ $question }}` inside
  the component escapes the string again. Use a real `"` character with a
  single-quoted Blade attribute instead:
  `question='What does "agentic" mean?'`.
- **`route('home')` (and any route to `/`) never has a trailing slash.**
  `route('home').'?tier=x'` produces `.../?` — no `/` before `?`. It's a
  valid URL either way, but don't assert on a literal `/?` in tests.
- **Browsers never send URL fragments in the `Referer` header.**
  `$this->from('/page#section')` in a test is unrealistic — real referers
  never include `#section`. Don't rely on `url()->previous()` still having
  a fragment.
- **daisyUI's `@plugin "daisyui/theme"` block passes unrecognized
  `--custom-properties` straight through** as CSS custom properties on the
  theme selector. This is how `--rule`, `--field-line`, `--tier-1..4` etc.
  work — they don't need to be "real" daisyUI tokens.
- **`placehold.co` is a live external service.** Every `<x-placeholder-image>`
  render is an outbound network request. Fine for a working preview; not
  fine to ship — see DESIGN.md.
- **An edit isn't real until it's independently re-read from disk and
  committed.** A one-line header fix (`bg-transparent` → `bg-base-100`) was
  applied, verified in one turn, then found reverted in a later turn — the
  working tree had silently gone back to the old value, and because it was
  never committed there was no history to recover it from. Root cause was
  never conclusively identified (possibly an IDE-side revert). The
  takeaway: after any fix, re-`grep`/`Read` the file to confirm it's really
  there, and commit meaningful fixes promptly rather than leaving them
  sitting uncommitted across turns.

## Testing

- `tests/Feature/PagesTest.php` — every route returns 200 (or the correct
  301) and has exactly one `<h1>`; the `pages` dataset lists every GET
  route. Covers the Services dropdown listing all three lines, each service
  page showing all four tier names in order with no `₱` anywhere, the
  `/services#approach` anchor existing, tier query-param whitelisting on
  Contact, the Why us founder quote, and that the inline theme script
  defaults to `robanis-light` without reading `prefers-color-scheme`.
- `tests/Feature/LeadTest.php` — valid submit, invalid email, over-length
  message, honeypot (silently drops, still shows success), unknown
  `tier_interest` rejected, and throttling (6th request in a minute → 429).
- `tests/Pest.php` binds `Illuminate\Foundation\Testing\RefreshDatabase` to
  every test in `Feature/`. Each test gets a fresh app instance (and so a
  fresh in-memory rate limiter), which is why the throttle test doesn't
  need manual cleanup between tests.
- `vendor/bin/pint --test` passes on everything except a pre-existing
  `tests/Pest.php` style nit that predates this project's changes
  (`fully_qualified_strict_types`, `ordered_imports`) — left alone as
  out-of-scope framework-scaffold code, not something introduced here.

## Deployment

See README's **"Deploying to cPanel"** section for the full checklist
(document-root options, what never gets uploaded, the `.env` setup, which
`artisan` commands need real server/SSH access). Short version: build
`vendor/` and `public/build/` locally with `--no-dev`/`npm run build`
respectively (both are gitignored, so they don't travel via git), never
upload the local `.env`, and generate a fresh `APP_KEY` per environment.

## Known open items

- Every `<x-placeholder-image>` on `/why-us` needs a real photo before
  launch (team shot, 3 strength photos, founder portrait).
- Tier feature copy across all three service lines should get a business
  review — it was written to spec but not yet checked against what's
  actually sellable at each level.
- The `.btn` class transitions `background-color` in addition to
  `opacity`/`border-color`, technically outside DESIGN.md's stated 150ms
  interaction rule — kept deliberately for the `.btn-cta` hover effect, but
  flagged here in case it should be tightened later.
- As of this writing, `README.md`, `.gitignore` and
  `resources/views/partials/header.blade.php` have local changes not yet
  committed (`git status` will show them) — see the last Gotchas entry.
