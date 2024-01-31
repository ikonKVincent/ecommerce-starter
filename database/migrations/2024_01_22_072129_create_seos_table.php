<?php

use App\Base\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->prefix . 'seos', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('element');
            $table->boolean('robot')->default(true);
            $table->json('title');
            $table->json('description');
            $table->string('type')->default('website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'seos');
    }
};
