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
        Schema::table('sites', function (Blueprint $table) {
            $table->boolean('easypanel_enabled')->default(false)->after('maintenance_mode');
            $table->string('easypanel_project_name')->nullable()->after('easypanel_enabled');
            $table->string('easypanel_service_name')->nullable()->after('easypanel_project_name');
            $table->enum('easypanel_deploy_method', ['git', 'docker_image', 'docker_compose'])->nullable()->after('easypanel_service_name');
            $table->string('easypanel_repository_url')->nullable()->after('easypanel_deploy_method');
            $table->string('easypanel_branch')->default('main')->after('easypanel_repository_url');
            $table->string('easypanel_docker_image')->nullable()->after('easypanel_branch');
            $table->integer('easypanel_port')->nullable()->after('easypanel_docker_image');
            $table->json('easypanel_env_vars')->nullable()->after('easypanel_port');
            $table->string('easypanel_cpu_limit')->nullable()->after('easypanel_env_vars');
            $table->string('easypanel_memory_limit')->nullable()->after('easypanel_cpu_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn([
                'easypanel_enabled',
                'easypanel_project_name',
                'easypanel_service_name',
                'easypanel_deploy_method',
                'easypanel_repository_url',
                'easypanel_branch',
                'easypanel_docker_image',
                'easypanel_port',
                'easypanel_env_vars',
                'easypanel_cpu_limit',
                'easypanel_memory_limit',
            ]);
        });
    }
};
