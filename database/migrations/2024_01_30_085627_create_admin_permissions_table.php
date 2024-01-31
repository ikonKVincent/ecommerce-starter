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
        Schema::create($this->prefix . 'admin_permissions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('role_id')->constrained(table: $this->prefix . 'admin_roles', column: 'id')->cascadeOnDelete();
            $table->string('name');
            $table->string('action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'admin_permissions');
    }
};
