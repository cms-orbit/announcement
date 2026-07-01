<?php

declare(strict_types=1);

namespace CmsOrbit\Announcement\Models;

use CmsOrbit\Announcement\Database\Factories\AnnouncementFactory;
use CmsOrbit\Core\Document\DocumentModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Announcement document type.
 *
 * Document meta (title, slug, content, approval, public_at, counters) lives on
 * the central documents / document_contents tables managed by DocumentModel.
 * Only the domain-specific gallery column lives on the announcements table.
 *
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $content
 * @property int $read_count
 * @property array<int, mixed>|null $gallery
 * @property Carbon|null $public_at
 */
class Announcement extends DocumentModel
{
    use SoftDeletes;

    protected $table = 'announcements';

    protected $guarded = [];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'read_count' => 'integer',
        'comment_count' => 'integer',
        'assent_count' => 'integer',
        'dissent_count' => 'integer',
        'gallery' => 'array',
        'is_notice' => 'boolean',
        'is_secret' => 'boolean',
        'approved' => 'integer',
        'public_at' => 'datetime',
    ];

    public function documentType(): string
    {
        return 'announcement';
    }

    protected static function newFactory(): AnnouncementFactory
    {
        return AnnouncementFactory::new();
    }

    protected static function booted(): void
    {
        // Register before parent::booted() so the default is applied before the
        // DocumentModel split moves public_at onto the central documents table.
        static::saving(function (self $announcement): void {
            if ($announcement->getAttribute('public_at') === null) {
                $announcement->setAttribute('public_at', now());
            }
        });

        parent::booted();
    }

    /**
     * Approved announcements whose publish time has passed.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('documents.approved', 30)
            ->where(function (Builder $q): void {
                $q->whereNull('documents.public_at')
                    ->orWhere('documents.public_at', '<=', now());
            });
    }
}
