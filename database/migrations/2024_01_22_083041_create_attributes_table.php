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
        Schema::create($this->prefix . 'attributes', function (Blueprint $table) {
            $table->ulid('id')->primary();

            $table->string('attribute_type')->index();
            $table->foreignUlid('attribute_group_id')->constrained($this->prefix . 'attribute_groups');

            $table->json('name');
            $table->string('handle')->index();
            $table->string('section');
            $table->string('type')->index();

            $table->boolean('required')->default(false);
            $table->string('default_value')->nullable();
            $table->json('configuration')->nullable();
            $table->string('validation_rules')->nullable();

            $table->boolean('system')->default(false);
            $table->boolean('filterable')->default(false)->index();
            $table->boolean('searchable')->default(false)->index();

            $table->integer('position')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'attributes');
    }
};
