<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Concrete child table for the Announcement DocumentModel. Document meta
     * (title, content, approval, public_at, counters) lives on the central
     * documents / document_contents tables; only the domain-specific gallery
     * column and a local read_count mirror (for counter increments) are kept
     * here.
     */
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table): void {
            $table->id();
            $table->json('gallery')->nullable()->comment('gallery image paths');
            $table->unsignedInteger('read_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
