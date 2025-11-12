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
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid("site_id")
                ->references("id")
                ->on("sites")
                ->cascadeOnDelete();
            $table->foreignId("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete();
            $table->uuidMorphs("instance");
            $table->string("ip")->nullable();
            $table->string("country")->nullable();
            $table->string("device")->nullable();
            $table->string("os")->nullable();
            $table->string("browser")->nullable();
            $table->string("language")->nullable();
            $table->string("user_agent")->nullable();
            $table->bigInteger("ts")->nullable();
            $table->bigInteger("ls")->nullable();
            $table->string("ss")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
