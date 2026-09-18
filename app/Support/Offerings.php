<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Read-only access to config/offerings.php — the three service lines and
 * their tiers.
 */
class Offerings
{
    /**
     * @return Collection<string, array<string, mixed>> keyed by service slug
     */
    public static function all(): Collection
    {
        return collect(config('offerings'))->map(
            fn (array $service, string $slug) => ['slug' => $slug, ...$service]
        );
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(string $slug): ?array
    {
        return static::all()->get($slug);
    }

    /**
     * Every tier slug across all service lines, for validating tier_interest.
     *
     * @return list<string>
     */
    public static function tierSlugs(): array
    {
        return static::all()
            ->flatMap(fn (array $service) => array_column($service['tiers'], 'slug'))
            ->values()
            ->all();
    }

    /**
     * Human label for a tier slug, e.g. "Agentic AI — Operator".
     */
    public static function tierLabel(string $tierSlug): ?string
    {
        foreach (static::all() as $service) {
            foreach ($service['tiers'] as $tier) {
                if ($tier['slug'] === $tierSlug) {
                    return "{$service['name']} — {$tier['name']}";
                }
            }
        }

        return null;
    }
}
