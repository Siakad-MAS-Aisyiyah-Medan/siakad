<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('key', 50)->unique();
            $table->string('name');
            $table->string('redirect_path', 120)->default('/');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id('id_permission');
            $table->string('key', 80)->unique();
            $table->string('name');
            $table->string('group', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('id_role')->constrained('roles', 'id_role')->cascadeOnDelete();
            $table->foreignId('id_permission')->constrained('permissions', 'id_permission')->cascadeOnDelete();
            $table->primary(['id_role', 'id_permission']);
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('permission_key', 80);
            $table->string('icon_key', 50);
            $table->string('label');
            $table->string('path', 120);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('permission_key');
            $table->unique('path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
