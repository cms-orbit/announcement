---
name: announcement-development
description: Build or modify CMS Orbit announcement features — DocumentEntity CRUD, public list/detail pages, routes, and translations. Activate when working on cms-orbit/announcement entities, controllers, Inertia pages, or announcement-specific migrations.
---

# Announcement package development

## When to use

- Changing `AnnouncementEntity`, models, migrations, or public controllers
- Updating announcement Inertia pages or Korean translations
- Adding fields to announcement documents (gallery, notice flag, publish time)

## Workflow

1. Extend document fields in `AnnouncementEntity::fields()` using `__()` labels.
2. Keep slug resolution locale-aware via `DocumentContent` (existing show action pattern).
3. Update `resources/lang/ko.json` for every new label or React key.
4. If Inertia component names change, update `resources/orbit/frontend.json` and note
   `orbit:frontend-sync` in CHANGELOG/README.
5. Add Pest tests in the host app or package test suite for public routes and published scope.

## Host setup (document in README)

| Step | Required |
| --- | --- |
| `composer require cms-orbit/core` + `cms-orbit/announcement` | Yes |
| `php artisan migrate` | Yes |
| `php artisan orbit:frontend-sync` | Yes (once per package set) |
| Manual Vite alias | No (sync command) |
| Manual bridge TSX files | No (sync command) |

## Example frontend manifest

```json
{
    "alias": "@cms-orbit/announcement",
    "jsPath": "resources/js",
    "pages": [
        { "component": "announcement/index", "export": "pages/announcement/index" },
        { "component": "announcement/show", "export": "pages/announcement/show" }
    ]
}
```
