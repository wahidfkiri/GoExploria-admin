<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::connection('cms')->hasTable('cms_contact_messages')) {
            return;
        }

        Schema::connection('cms')->table('cms_contact_messages', function (Blueprint $table) {
            if (!Schema::connection('cms')->hasColumn('cms_contact_messages', 'attachment_path')) {
                $table->string('attachment_path')->nullable()->after('message');
            }
            if (!Schema::connection('cms')->hasColumn('cms_contact_messages', 'attachment_name')) {
                $table->string('attachment_name')->nullable()->after('attachment_path');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::connection('cms')->hasTable('cms_contact_messages')) {
            return;
        }

        Schema::connection('cms')->table('cms_contact_messages', function (Blueprint $table) {
            foreach (['attachment_path', 'attachment_name'] as $column) {
                if (Schema::connection('cms')->hasColumn('cms_contact_messages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
