<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('arrondissements')) {
            Schema::create('arrondissements', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code', 10)->nullable();
                $table->string('classification')->nullable();
                $table->integer('population')->nullable();
                $table->decimal('area', 15, 2)->nullable();
                $table->integer('households')->nullable();
                $table->decimal('density', 10, 2)->nullable();
                $table->string('mayor')->nullable();
                $table->string('website')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->text('history')->nullable();
                $table->text('attractions')->nullable();
                $table->text('transport')->nullable();
                $table->text('education')->nullable();
                $table->text('parks')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->boolean('is_active')->default(false);
                $table->foreignId('ville_id')->nullable()->constrained('villes')->nullOnDelete();
                $table->foreignId('secteur_id')->nullable()->constrained('secteurs')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('quartiers')) {
            Schema::create('quartiers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code', 10)->nullable();
                $table->string('classification')->nullable();
                $table->integer('population')->nullable();
                $table->decimal('area', 15, 2)->nullable();
                $table->integer('households')->nullable();
                $table->decimal('density', 10, 2)->nullable();
                $table->string('mayor')->nullable();
                $table->string('website')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->text('history')->nullable();
                $table->text('attractions')->nullable();
                $table->text('transport')->nullable();
                $table->text('education')->nullable();
                $table->text('parks')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->boolean('is_active')->default(false);
                $table->foreignId('arrondissement_id')->nullable()->constrained('arrondissements')->nullOnDelete();
                $table->foreignId('ville_id')->nullable()->constrained('villes')->nullOnDelete();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('quartiers');
        Schema::dropIfExists('arrondissements');
    }
};
