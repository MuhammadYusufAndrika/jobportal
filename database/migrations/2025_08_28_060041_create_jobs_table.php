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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('company');
            $table->enum('location', [
                'Martapura',
                'Belitang',
                'Belitang Hilir',
                'Belitang Hulu',
                'Belitang Jaya',
                'Cit',
                'Pedamaran',
                'Semendawai Suku III',
                'Semendawai Timur',
                'Sirah Pulau Padang',
                'Sosok'
            ]);
            $table->text('description');
            $table->decimal('salary', 12, 2);
            $table->date('deadline');
            $table->json('application_form')->nullable(); // Custom form fields
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Company user who posted the job
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
