# Robanis marketing site

Marketing site for Robanis, an IT solutions consultancy running two agentic
service lines: agentic system integration and agentic SEO optimization.
Laravel + Blade, Tailwind CSS 4 + daisyUI 5, MySQL.

## Requirements

- PHP 8.2+
- Composer
- Node 20+ / npm
- MySQL 8 (or compatible)

## Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create the database, then point `.env` at it (see **`.env` notes** below):

```sql
CREATE DATABASE robanis;
```

```bash
php artisan migrate
```

Run the app:

```bash
composer dev   # php artisan serve + vite dev, concurrently
```

or in two terminals:

```bash
php artisan serve
npm run dev
```

For production assets: `npm run build`.

## `.env` notes

- `DB_CONNECTION=mysql`, `DB_DATABASE=robanis` — set `DB_USERNAME` /
  `DB_PASSWORD` to match your local MySQL user.
- `SESSION_DRIVER=database` and `CACHE_STORE=database` are the Laravel
  defaults and work out of the box — `php artisan migrate` creates the
  `sessions`/`cache` tables along with everything else.
- No mail or queue configuration is needed. The lead form stores a database
  row and nothing else; there is no queue worker to run.
- Tests run against an in-memory SQLite database (see `phpunit.xml`), so
  `php artisan test` does not touch the MySQL database above.

## Lead capture

Contact-form submissions are stored in the `leads` table
(`app/Models/Lead.php`) — no email is sent. To look at what's come in:

```bash
php artisan tinker
>>> App\Models\Lead::latest()->get();
```

The form has a honeypot field (`website`) and is rate-limited to 5
submissions per minute per IP (`throttle:5,1` on `POST /leads` in
`routes/web.php`) instead of a CAPTCHA.

## Theme

Two daisyUI 5 themes, `robanis-light` (default) and `robanis-dark`, are
defined entirely in `resources/css/app.css` via `@plugin "daisyui/theme"`
(Tailwind 4 + daisyUI 5 — no `tailwind.config.js`). The comment block above
the `robanis-dark` theme explains why it can't reuse the light theme's
greens: base Moss on base Ink measures 2.23:1 and fails WCAG, so the dark
theme substitutes lightened primary/secondary/accent/error colors instead,
each with its measured contrast ratio noted inline. Every text/background
pairing actually used on the site clears 4.5:1 in both themes.

Radii are flattened to 2px (`--radius-*`) and depth/noise are switched off
globally, so daisyUI's default soft/rounded look is overridden at the token
level rather than per component.

The theme is set on `<html data-theme>` by a blocking inline script in
`resources/views/layouts/app.blade.php` (before Tailwind loads), so there's
no flash of the wrong theme. It respects `prefers-color-scheme` on first
visit and then persists the user's choice (via the header toggle) to
`localStorage`.

The base font size is bumped to 18px (`html { font-size: 112.5% }` in
`app.css`) so mono labels and body copy stay legible at 400/500 weight.

## Placeholder images

`/why-us` uses `<x-placeholder-image>` (`resources/views/components/
placeholder-image.blade.php`) for the team photo, the three strength photos,
and the founder portrait. It renders on-brand frames from **placehold.co**
(an external service — each is an outbound request) with light/dark variants
swapped the same way as the theme-toggle icon. **Replace every one of these
with a real photo before launch.**

## Services and tiers

Three service lines, each with its own page at `/services/{service}`, all
defined in `config/offerings.php` (read through `App\Support\Offerings`).
That one file drives the header's Services dropdown, the `/services`
overview, each service page, and the whitelist for `tier_interest` on the
lead form.

Every service line shares the same four tiers, so the pricing conversation
stays consistent no matter which line a client starts with:

| Tier | For |
|---|---|
| **Advice** | An independent assessment — market research, an audit, and a written roadmap — before committing budget. |
| **Starter** | A first, scoped engagement (one site, one system, or one application, depending on the line). |
| **Business** | The "most popular" tier — broader scope, priority support, a monthly call. |
| **Enterprise** | Dedicated engineering, SSO/audit logging, a written SLA. |

There are no prices shown — each tier lists what's included and links to
`/contact?tier=<slug>`, which pre-fills `tier_interest`. Tier slugs are
prefixed with their service line (e.g. `agentic-ai-enterprise`) and must fit
the `leads.tier_interest` column, widened to `varchar(40)` by the
`widen_leads_tier_interest_column` migration.

**Approach** (the four-step audit/design/build/operate process) lives as a
section on `/services#approach` rather than its own page. `/approach` and
`/about` both 301-redirect to their new locations (`/services#approach` and
`/why-us`) for anyone with the old links.

To add or rename a service line or a tier, edit `config/offerings.php`. The
route constraint, dropdown, overview and validation all pick it up from
there — the moss top-bar brightness on each tier card is driven by that
tier's `level` (1–4), styled via the `--tier-1`..`--tier-4` tokens in
`resources/css/app.css`.

## Tests

```bash
php artisan test
```

Covers page rendering (one `<h1>` per page, tier query-param handling) and
lead submission (validation, honeypot, throttling) — see
`tests/Feature/PagesTest.php` and `tests/Feature/LeadTest.php`.
