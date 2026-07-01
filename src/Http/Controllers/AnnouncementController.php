<?php

declare(strict_types=1);

namespace CmsOrbit\Announcement\Http\Controllers;

use CmsOrbit\Announcement\Models\Announcement;
use CmsOrbit\Core\Document\Models\Document;
use CmsOrbit\Core\Document\Models\DocumentContent;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

/**
 * Public (front-facing) controller for announcements.
 */
class AnnouncementController extends Controller
{
    /**
     * Paginated public listing of published announcements.
     */
    public function index(): InertiaResponse
    {
        $announcements = Announcement::query()
            ->published()
            ->orderByDesc('documents.is_notice')
            ->orderByDesc('documents.public_at')
            ->paginate(15)
            ->through(fn (Announcement $announcement): array => [
                'id' => $announcement->getKey(),
                'title' => $announcement->getAttribute('title'),
                'slug' => $announcement->getAttribute('slug'),
                'description' => $announcement->getAttribute('description'),
                'is_notice' => (bool) $announcement->getAttribute('is_notice'),
                'read_count' => (int) $announcement->getAttribute('read_count'),
                'public_at' => optional($announcement->getAttribute('public_at'))->toDateTimeString(),
            ]);

        return Inertia::render('announcement/index', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Public detail page resolved by localized slug.
     */
    public function show(string $slug): InertiaResponse
    {
        $content = DocumentContent::query()->where('slug', $slug)->firstOrFail();
        $document = Document::query()->findOrFail($content->document_id);

        /** @var Announcement $announcement */
        $announcement = Announcement::query()->findOrFail($document->documentable_id);

        $announcement->recordView();

        return Inertia::render('announcement/show', [
            'announcement' => [
                'id' => $announcement->getKey(),
                'title' => $announcement->getAttribute('title'),
                'slug' => $announcement->getAttribute('slug'),
                'description' => $announcement->getAttribute('description'),
                'content' => $announcement->getAttribute('content'),
                'gallery' => $announcement->getAttribute('gallery') ?? [],
                'read_count' => (int) $announcement->getAttribute('read_count'),
                'public_at' => optional($announcement->getAttribute('public_at'))->toDateTimeString(),
            ],
        ]);
    }
}
