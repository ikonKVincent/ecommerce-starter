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
        Schema::create($this->prefix . 'urls', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->boolean('default')->default(false)->index();
            $table->foreignUlid('language_id')->constrained(table: $this->prefix . 'languages', column: 'id')->onDelete('cascade');
            $table->ulidMorphs('element');
            $table->string('slug')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'urls');
    }
};
