<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dns_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id');
            $table->string('type')->default('A'); // A, AAAA, CNAME, MX, TXT, etc.
            $table->string('name'); // subdomain or @ for root
            $table->string('value'); // IP address or target
            $table->integer('ttl')->default(3600);
            $table->integer('priority')->nullable(); // For MX records
            $table->boolean('active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->index(['site_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dns_records');
    }
};
