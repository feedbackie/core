<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid("site_id")
                ->nullable()
                ->references("id")
                ->on("sites")
                ->cascadeOnDelete();
            $table->foreignId("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete();
            $table->text('selected_text')->nullable();
            $table->text('full_text')->nullable();
            $table->text('fixed_text')->nullable();
            $table->text('diff_text')->nullable();
            $table->text('url')->nullable();
            $table->text('comment')->nullable();
            $table->integer('offset')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
