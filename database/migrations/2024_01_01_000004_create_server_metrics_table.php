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
        Schema::create('server_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id')->constrained()->onDelete('cascade');
            $table->decimal('cpu_usage', 5, 2);
            $table->decimal('memory_usage', 5, 2);
            $table->decimal('disk_usage', 5, 2);
            $table->integer('running_processes');
            $table->bigInteger('disk_total_gb');
            $table->bigInteger('memory_total_mb');
            $table->decimal('load_average', 5, 2);
            $table->timestamps();
            
            $table->index(['server_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_metrics');
    }
};