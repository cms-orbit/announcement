<?php

declare(strict_types=1);

namespace CmsOrbit\Announcement\Database\Factories;

use CmsOrbit\Announcement\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'description' => $this->faker->sentence(),
            'gallery' => [],
            'is_notice' => false,
            'is_secret' => false,
            'approved' => 30,
            'public_at' => now(),
        ];
    }

    /**
     * A pinned notice announcement.
     */
    public function notice(): static
    {
        return $this->state(fn (): array => ['is_notice' => true]);
    }

    /**
     * An announcement awaiting approval (hidden from the public listing).
     */
    public function waiting(): static
    {
        return $this->state(fn (): array => ['approved' => 10]);
    }
}
