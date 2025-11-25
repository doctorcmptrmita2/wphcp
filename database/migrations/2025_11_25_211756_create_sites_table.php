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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->string('root_path');
            $table->string('php_version')->default('8.2');
            $table->string('status')->default('creating');
            $table->boolean('maintenance_mode')->default(false);
            $table->unsignedBigInteger('db_id')->nullable();
            $table->timestamp('last_backup_at')->nullable();
            $table->timestamps();

            $table->foreign('db_id')->references('id')->on('databases')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
