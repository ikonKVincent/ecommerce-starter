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
        Schema::create($this->prefix . 'attributables', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulidMorphs('attributable');
            $table->foreignUlid('attribute_id')->constrained(table: $this->prefix . 'attributes', column: 'id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'attributables');
    }
};
