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
        Schema::create($this->prefix . 'attribute_groups', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('attributable_type')->index();
            $table->json('name');
            $table->string('handle')->unique();
            $table->integer('position')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'attribute_groups');
    }
};
