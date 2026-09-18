# Robanis design system

This is the reference for anyone changing how the site looks, reads or
moves — designers, developers, or an AI agent extending a page. It records
the rules and the reasoning behind them, so the "futuristic minimalist"
direction stays consistent as the site grows.

For routes, controllers, config and JS architecture, see [AGENTS.md](AGENTS.md).

## Principles

- **Negative space is the primary design element.** When unsure, remove
  something and add more space. Sections breathe — `py-32` on desktop, not
  `py-12`.
- **Structure comes from hairline rules and alignment**, not cards, shadows
  or filled boxes. A 1px divider at low opacity does the work a bordered
  card used to.
- **Colour is scarce.** Most of every screen is Bone or Ink. Moss appears a
  handful of times per page. Amber appears once or twice, always as a solid
  CTA fill.
- **Sharp over soft.** Global radius is 2px. No pill buttons anywhere.
- **Flat.** No gradients, drop shadows, glassmorphism, blur or glow — those
  read as 2021 AI-startup, not futuristic. The one exception is the
  radial-gradient dot grid, which is a texture, not a decorative gradient.

## Palette

| Name  | Hex       | Role                              |
|-------|-----------|------------------------------------|
| Bone  | `#F6F3ED` | Light surface. Never pure white.  |
| Ink   | `#16211D` | Dark surface / light-mode text.   |
| Moss  | `#2E5E4E` | Primary accent (light theme).     |
| Oak   | `#8F5626` | Secondary accent.                 |
| Amber | `#D89A4A` | Single CTA fill colour, both themes. |
| Slate | `#5A6763` | Secondary text.                   |

## Themes

Two daisyUI 5 themes, defined in `resources/css/app.css` via
`@plugin "daisyui/theme"` (Tailwind 4 CSS-first syntax — there is no
`tailwind.config.js`). `robanis-light` is the default; `robanis-dark` sets
`prefersdark: true` so it also matches `prefers-color-scheme: dark`.

### robanis-light

| Token | Value | Contrast |
|---|---|---|
| `base-100` | Bone `#F6F3ED` | — |
| `base-200` | `#EDE9E1` | — |
| `base-300` | `#DFDAD0` | — |
| `base-content` | Ink `#16211D` | 14.94:1 on base-100 |
| `primary` | Moss `#2E5E4E` | 6.71:1 on base-100 |
| `secondary` | Slate `#5A6763` | 5.33:1 on base-100/200 |
| `accent` | Oak `#8F5626` | 5.38:1 on base-100 |
| `error` | `#B42318` | 5.94:1 on base-100 |
| CTA fill | Amber `#D89A4A` + Ink text | 6.81:1 |
| Dividers (`--rule`) | Ink at 10% opacity | decorative only |
| Input underline (`--field-line`) | Ink at 55% opacity | ≥3:1, UI-boundary contrast |

### robanis-dark

Base Moss on base Ink measures **2.23:1** and fails WCAG — two dark,
low-chroma colours can't separate from each other. The dark theme therefore
substitutes lightened variants instead of reusing the light theme's greens:

| Token | Substitution | Contrast on Ink |
|---|---|---|
| `primary` (text/links/borders) | `#2E5E4E` → `#5FB094` | 6.40:1 |
| `primary` button fill | `#2E5E4E` → `#4E9B80` (with Ink text) | 4.98:1 |
| `secondary` | `#5A6763` → `#9AA8A3` | 6.70:1 |
| `accent` | `#8F5626` → `#C98A4B` | 5.69:1 |
| `error` | `#B42318` → `#E5877D` | 6.38:1 |
| Dividers (`--rule`) | Bone at 12% opacity | decorative only |
| Input underline (`--field-line`) | Bone at 45% opacity | ≥3:1 |

Amber is unchanged in both themes — it's never text or a border on its own
(2.19:1 on Bone, worse on Ink), only a solid CTA fill with Ink text on top.

**Restriction that applies in both themes:** Slate/`#9AA8A3` as *secondary
text* never sits on `base-300` — it drops under 4.5:1 there (4.24:1 in
light). Long-form secondary copy stays on `base-100`/`base-200`.

Every text/background pair actually used on the site clears 4.5:1 in both
themes. Verify any new pair with a contrast calculator before shipping it —
don't estimate from the swatch.

Radii, depth and noise are flattened identically in both theme blocks:
`--radius-selector/field/box: 2px`, `--border: 1px`, `--depth: 0`,
`--noise: 0`. This overrides daisyUI's default soft/rounded look at the
token level, so components don't need per-class overrides.

## Tier ramp

Each tier card (`resources/views/components/tier-card.blade.php`) gets a 4px
top bar in `--tier-1` through `--tier-4`, brighter from Advice → Enterprise:

| Level | Light | Dark |
|---|---|---|
| 1 (Advice) | `#2E5E4E` | `#3E7F68` |
| 2 (Starter) | `#3B7A64` | `#4E9B80` |
| 3 (Business) | `#4E9B80` | `#5FB094` |
| 4 (Enterprise) | `#6DB89A` | `#7FC8AC` |

**These tokens are decorative only** — the bar is a non-text 4px border. The
"Tier 0N" label next to it always stays `text-primary`, because the
brighter ramp steps don't all clear 4.5:1 as text.

## Typography

- **Sans**: Inter Variable, self-hosted via `@fontsource-variable/inter`.
  Weights 400 and 500 only — never 600 or 700.
- **Mono**: JetBrains Mono Variable, self-hosted via
  `@fontsource-variable/jetbrains-mono`. Used only for eyebrows, section
  numbers, tier labels and metrics — uppercase, wide tracking. This one
  choice does most of the "futuristic" work; keep it rare and consistent.
- **Root size is 18px**, not Tailwind's 16px default
  (`html { font-size: 112.5% }` in `app.css`). Every rem-based size scales
  from this — the display clamp, `.eyebrow`, spacing. It was raised because
  thin 400-weight text read as too small below 16px.
- **`.display`**: `clamp(2.5rem, 5vw, 4.5rem)`, `-0.03em` tracking, `1.05`
  line-height. Used for every section opener and page `<h1>`.
- **`.eyebrow` / `.section-number`**: `0.8125rem`, mono, uppercase, `0.15em`
  tracking, `text-secondary`.
- **Body copy** maxes out around `65ch` (`max-w-[65ch]` / `max-w-[50ch]` /
  `max-w-[55ch]` depending on context). Never full-width paragraphs.
- Use `text-base` for real body copy (feature lists, footer text, dropdown
  descriptions). Reserve `text-sm` for short, secondary UI labels only —
  not for anything meant to be read as a sentence.
- `antialiased` is deliberately **not** applied to `<body>` — it was making
  Inter look thinner than intended on some displays.

## Layout and spacing

- Containers: `mx-auto max-w-6xl px-6` (the four-tier grid on service pages
  widens to `max-w-7xl` to fit four columns comfortably).
- Section rhythm: `py-32`, separated by `border-t border-rule`.
- The home page numbers its narrative sections `01 / 02` in mono
  (`x-section-heading :number="..."`). Other pages (services index, service
  pages, Why us, Contact) use an eyebrow without a number, because they
  aren't "section N of the homepage."
- Verify every page at 375px, 768px, 1280px and 1920px. The services grid
  goes 1 → 2 → 4 columns; the tier comparison was removed entirely rather
  than made to scroll (see AGENTS.md gotchas for why a table was dropped).

## Motion

One pattern, applied via `[data-reveal]` + `IntersectionObserver`
(`resources/js/app.js`, `initReveal`):

- 8px upward translate, 400ms, ease-out, triggered once on scroll into view.
- Staggered ~60ms per item via an inline `style="--i:N"`.
- Scoped inside `@media (prefers-reduced-motion: no-preference)` **and**
  gated on `html.js` (added by app.js on load), so content is fully visible
  with JS disabled or reduced motion on.
- Interactive-element transitions are 150ms, `border-color`/`opacity` only
  — except `.btn`, which also transitions `background-color` for the
  hover-opacity effect on `.btn-cta`. That's a deliberate, narrow exception,
  not a precedent for adding more properties elsewhere.

No parallax, no counters, no typewriter effects, no animated backgrounds.

## Texture and imagery

- **One permitted texture**: `.dot-grid`, a radial-gradient dot pattern at
  3% opacity, used once, in the home hero only.
- **Line art**: the "why agentic" SVG on the home page uses 1px
  `currentColor` strokes, no fills, `aria-hidden="true"`.
- **Placeholder images**: `<x-placeholder-image>` renders light/dark pairs
  from placehold.co (an external service — every render is an outbound
  request). Used on `/why-us` for the team photo, three strength photos and
  the founder portrait. **Every one of these must be replaced with a real
  photo before launch** — they exist so the page doesn't ship with empty
  boxes, not as a long-term choice.

## Component catalogue

### Blade components (`resources/views/components/`)

| Component | Props | Purpose |
|---|---|---|
| `section-heading` | `number?`, `eyebrow?`, `title`, `level='h2'`, slot = intro paragraph | Reusable eyebrow + display heading + optional intro, used across every page |
| `service-line` | `service` (array from `config/offerings.php`) | One column on the home/services overview — name, intro, highlights, "See pricing" link |
| `tier-card` | `tier` (array; needs `level`, `featured`, `slug`, `name`, `for`, `features`) | One tier column — moss-ramp bar, features list, "Enquire about {name}" CTA |
| `faq-item` | `question`, slot = answer | Native `<details>`/`<summary>` accordion, `+`/`−` marker via `group-open:` |
| `field` | `name`, `label`, `type='text'`, `as='input'|'textarea'`, `required=false` | Underlined form field with inline `@error` handling |
| `placeholder-image` | `label`, `width=800`, `height=600`, `alt?` | Light/dark placehold.co frame pair, swapped by `[data-theme]` |

### Partials (`resources/views/partials/`)

- `header` — sticky nav, Services dropdown (built from `Offerings::all()`),
  theme toggle, "Book a call" CTA, full-screen mobile overlay.
- `footer` — one hairline rule, a link row, copyright, the robur/oak line.
- `theme-toggle` — icon-only button, sun/moon SVGs swapped via
  `[data-icon]` + `[data-theme]`.

### Key CSS classes (`resources/css/app.css`, `@layer components`)

`.eyebrow`, `.section-number`, `.display`, `.btn` (weight override),
`.btn-cta`, `.link-plain`, `.field-underline`, `.dot-grid`.

## Page anatomy

- **`/` (home)** — hero (full `min-h-svh`) → `01` Services (three columns,
  hairline dividers) → `02` Why agentic (three points + line-art SVG) →
  unnumbered closing CTA band.
- **`/services`** — hero → three `service-line` columns → `#approach` (the
  four-step audit/design/build/operate row, folded in from the old
  standalone Approach page) → `#faq`.
- **`/services/{service}`** — hero (breadcrumb-style eyebrow) → four
  `tier-card` columns (`max-w-7xl`, `md:grid-cols-2 lg:grid-cols-4`) → "not
  sure which tier" CTA + links to the other two service lines. No pricing
  table — each tier just lists what's included.
- **`/why-us`** — hero → team photo placeholder → three strengths (each
  with a placeholder image) → founder quote with portrait placeholder →
  four operating principles (mono-numbered, same pattern as the approach
  steps) → closing CTA.
- **`/contact`** — hero + form. Shows "Enquiring about: {tier label}" above
  the form when arriving via `?tier=<slug>`.

### Header behaviour

The header is `sticky top-0 z-40 bg-base-100` — **always** opaque, not
`bg-transparent`. On scroll (`initHeaderScroll` in `app.js`), it gains a
`.is-scrolled` class that adds a `border-bottom-color` hairline; the
background was already solid, so nothing else changes. See AGENTS.md's
gotchas for why it must never go back to `bg-transparent`.

The Services dropdown (`initSubmenus`) opens on hover or click, closes on
Escape/outside-click/focus-out, and lists all three service lines plus an
"Overview, approach and FAQ" link to `/services`.

The mobile menu (`initMobileMenu`) is a full-screen overlay (not a slide-in
drawer), toggles `hidden`/`flex` classes (never mixed with the native
`hidden` attribute — see AGENTS.md), locks body scroll, and marks the rest
of the page `inert` while open.

## Voice and copy

- Grounded, technical, understated. We sell reliability, not hype.
- **Banned words**: revolutionary, unlock, supercharge, seamless,
  game-changing, empower, leverage.
- Sentence case for all headings and buttons. No exclamation marks.
- No testimonials, logo strips or invented company stats (headcount, years
  in business) until they're real — an empty placeholder undermines the
  page more than omitting the section.
- The founder quote is fixed copy, used verbatim on `/why-us`:
  > "We want you to blossom as a flower and be as resilient as a mighty
  > tree." — Heal Joshua C. Pardo, CEO & Founder

## Accessibility

- One `<h1>` per page, headings in document order (`PagesTest` asserts this
  for every route).
- `:focus-visible` gets a 2px `primary`-coloured outline with 2px offset,
  in both themes.
- `aria-label` on every icon-only control (theme toggle, menu toggle).
- A "Skip to content" link is the first focusable element on every page.
- The mobile menu and Services dropdown: Escape closes, focus returns to
  the opener, and `inert` is applied to the rest of the page while open.
- The (now-removed) comparison tables used `<caption class="sr-only">`,
  `scope="col"/"row"`, and `sr-only` "Included"/"Not included" text next to
  `aria-hidden` check/dash marks — keep that pattern if a table returns.
