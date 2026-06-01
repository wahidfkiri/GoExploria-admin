<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::connection('cms')->hasTable('cms_contact_messages')) {
            return;
        }

        Schema::connection('cms')->create('cms_contact_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->nullable()->index();
            $table->foreignId('page_id')->nullable()->index();
            $table->foreignId('assigned_to')->nullable()->index();
            $table->string('form_name')->nullable();
            $table->string('source')->nullable()->index();
            $table->text('source_url')->nullable();
            $table->text('referrer')->nullable();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->index();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('preferred_contact_method')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->string('status')->default('new')->index();
            $table->string('priority')->default('normal')->index();
            $table->boolean('consent')->default(true);
            $table->boolean('newsletter_opt_in')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::connection('cms')->dropIfExists('cms_contact_messages');
    }
};
