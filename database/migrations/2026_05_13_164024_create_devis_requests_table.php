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
        Schema::create('devis_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name', 120);
            $table->string('last_name', 120);
            $table->string('email', 180);
            $table->string('phone', 60);
            $table->string('company', 180)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('country', 120)->nullable();
            $table->string('preferred_contact', 40);
            $table->string('service_subject', 160);
            $table->json('selected_services');
            $table->string('plan_interest', 180)->nullable();
            $table->string('budget', 120)->nullable();
            $table->date('project_deadline')->nullable();
            $table->text('project_details');
            $table->json('media_files')->nullable();
            $table->boolean('email_sent')->default(false);
            $table->text('email_error')->nullable();
            $table->string('client_ip', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('source_url')->nullable();
            $table->timestamps();

            $table->index(['email_sent', 'created_at']);
            $table->index(['email', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis_requests');
    }
};
