<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->string('full_name')->nullable();
            $table->string('photo')->nullable();
            $table->string('city')->nullable();
            $table->tinyInteger('general_level')->unsigned()->default(1); // nivel 1-5
            $table->text('bio')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('has_band')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'full_name',
                'photo',
                'city',
                'general_level',
                'bio',
                'age',
                'has_band'
            ]);
        });
    }
};
