<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Base\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->prefix . 'admins', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->boolean('enabled')->default(false)->index();
            $table->foreignUlid('role_id')->constrained(table: 'admin_roles', column: 'id');
            $table->string('firstname')->index();
            $table->string('lastname')->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->prefix . 'admins');
    }
};
