<?php

declare(strict_types=1);

use CmsOrbit\Announcement\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Announcement public routes
|--------------------------------------------------------------------------
|
| Front-facing announcement listing and detail pages. Loaded by the
| AnnouncementServiceProvider inside the "web" middleware group.
*/
Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('announcements/{slug}', [AnnouncementController::class, 'show'])->name('announcements.show');
