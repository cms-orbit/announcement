# CMS Orbit Announcement Guidelines

`cms-orbit/announcement` adds a document-based **Announcement** content type on top of
`cms-orbit/core`. It registers admin CRUD automatically and exposes public list/detail Inertia
pages.

## Package independence

- All announcement code lives under `CmsOrbit\Announcement\` — never import host `App\` classes.
- Public routes ship in the package (`routes/web.php`); no host route edits required.
- Inertia pages live in `resources/js/pages/announcement/` inside the package.
- Declare pages in `resources/orbit/frontend.json`; hosts run `php artisan orbit:frontend-sync`
  instead of hand-writing bridge files.

## Internationalization (required)

- PHP: `__()` for entity labels, sections, and controller-visible strings.
- React (`index.tsx`, `show.tsx`): `useT()` for titles, empty states, badges, view counts.
- Add keys to `resources/lang/ko.json` in this package.
- Never hardcode Korean in TSX even when `ko` is the default locale.

## Admin integration

- `AnnouncementEntity` extends `DocumentEntity` — use document fields (title, slug, content,
  gallery, `public_at`, `is_notice`).
- Entity registers via `AnnouncementServiceProvider` + `EntityRegistry::registerClass()`.
- Section key: `documents` (shared with other document types).

## Public pages

- Routes: `announcements.index`, `announcements.show` (`/announcements`, `/announcements/{slug}`).
- Controllers render `announcement/index` and `announcement/show` Inertia components.
- Host requirement after install: `composer require cms-orbit/announcement` + `php artisan migrate`
  + `php artisan orbit:frontend-sync` (if not already run by `orbit:install`).

## Contributing

Follow `orbit-package-contribution` and `orbit-i18n` skills from `cms-orbit/core`. Do not commit
host bridge pages into this repository.
