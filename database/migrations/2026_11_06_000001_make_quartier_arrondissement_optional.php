<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('quartiers') || !Schema::hasColumn('quartiers', 'arrondissement_id')) {
            return;
        }

        Schema::table('quartiers', function (Blueprint $table): void {
            $table->foreignId('arrondissement_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('quartiers') || !Schema::hasColumn('quartiers', 'arrondissement_id')) {
            return;
        }

        if (DB::table('quartiers')->whereNull('arrondissement_id')->exists()) {
            throw new RuntimeException('Cannot make quartiers.arrondissement_id required while unassigned quartiers exist.');
        }

        Schema::table('quartiers', function (Blueprint $table): void {
            $table->foreignId('arrondissement_id')->nullable(false)->change();
        });
    }
};
