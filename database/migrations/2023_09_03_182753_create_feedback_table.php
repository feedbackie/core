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
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid("site_id")
                ->nullable()
                ->references("id")
                ->on("sites")
                ->cascadeOnDelete();
            $table->foreignId("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete();
            $table->string('answer');
            $table->longText('comment')->nullable();
            $table->jsonb('options')->nullable();
            $table->string('url');
            $table->string('url_hash')->nullable();
            $table->string('hash')->nullable();
            $table->string('email')->nullable();
            $table->integer('language_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
