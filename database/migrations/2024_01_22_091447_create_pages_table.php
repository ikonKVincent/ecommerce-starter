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
        Schema::create($this->prefix . 'pages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->publishedFields();
            $table->foreignUlid('page_type_id')->constrained(table: $this->prefix . 'page_types', column: 'id')->cascadeOnDelete();
            $table->string('name');
            $table->json('attribute_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'pages');
    }
};
