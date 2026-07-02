<?php

declare(strict_types=1);

namespace CmsOrbit\Announcement\Entities;

use CmsOrbit\Announcement\Models\Announcement;
use CmsOrbit\Core\Foundation\Entity\DocumentEntity;
use CmsOrbit\Core\Screen\Field;
use CmsOrbit\Core\Screen\Fields\Attach;
use CmsOrbit\Core\Screen\Fields\CheckBox;
use CmsOrbit\Core\Screen\Fields\DateTimer;
use CmsOrbit\Core\Screen\Fields\Input;
use CmsOrbit\Core\Screen\Fields\Quill;
use CmsOrbit\Core\Screen\Fields\Select;
use CmsOrbit\Core\Screen\Fields\TextArea;
use CmsOrbit\Core\Screen\Sight;
use CmsOrbit\Core\Screen\TD;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

/**
 * Admin descriptor for the Announcement document type.
 */
class AnnouncementEntity extends DocumentEntity
{
    public function model(): string
    {
        return Announcement::class;
    }

    public function icon(): string
    {
        return 'bs.megaphone';
    }

    public function sort(): int
    {
        return 5100;
    }

    /**
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('title')->title(__('Title'))->required(),
            Input::make('slug')->title(__('Slug'))->help(__('Leave blank to auto-generate.')),
            Quill::make('content')->title(__('Content')),
            TextArea::make('description')->title(__('Description'))->rows(2),
            Attach::make('gallery')
                ->multiple()
                ->title(__('Gallery'))
                ->group('announcement')
                ->help(__('Attach images shown alongside the announcement.')),
            DateTimer::make('public_at')
                ->title(__('Publish at'))
                ->enableTime()
                ->format('Y-m-d H:i:S'),
            Select::make('approved')
                ->title(__('Approval'))
                ->options([0 => __('Rejected'), 10 => __('Waiting'), 30 => __('Approved')]),
            CheckBox::make('is_notice')->title(__('Notice'))->sendTrueOrFalse(),
            CheckBox::make('is_secret')->title(__('Secret'))->sendTrueOrFalse(),
        ];
    }

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('document_id', __('ID'))->sort(),
            TD::make('title', __('Title')),
            TD::make('is_notice', __('Notice')),
            TD::make('read_count', __('Views'))->sort(),
            TD::make('approved', __('Approval')),
            TD::make('public_at', __('Published'))->sort(),
        ];
    }

    /**
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('document_id', __('ID')),
            Sight::make('title', __('Title')),
            Sight::make('read_count', __('Views')),
            Sight::make('assent_count', __('Likes')),
            Sight::make('approved', __('Approval')),
            Sight::make('public_at', __('Published')),
        ];
    }

    public function showUrl(Model $model): ?string
    {
        $slug = $model->getAttribute('slug');

        if ($slug === null || ! Route::has('announcements.show')) {
            return parent::showUrl($model);
        }

        return route('announcements.show', ['slug' => $slug]);
    }

    /**
     * Public show URLs contributed to the sitemap.
     *
     * @return iterable<int, array<string, mixed>>
     */
    public function sitemapUrls(): iterable
    {
        if (! Route::has('announcements.show')) {
            return [];
        }

        return Announcement::query()
            ->published()
            ->get()
            ->map(fn (Announcement $announcement): array => [
                'loc' => route('announcements.show', ['slug' => $announcement->getAttribute('slug')]),
                'lastmod' => optional($announcement->getAttribute('updated_at'))->toAtomString(),
            ])
            ->all();
    }
}
