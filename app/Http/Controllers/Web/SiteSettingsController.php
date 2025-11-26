<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingsController extends Controller
{
    public function index(Site $site): View
    {
        $site->load(['database', 'sslCertificate', 'dnsRecords']);
        
        return view('sites.settings', [
            'site' => $site,
        ]);
    }

    public function update(Request $request, Site $site): RedirectResponse
    {
        $validated = $request->validate([
            'php_version' => ['nullable', 'string'],
            'maintenance_mode' => ['nullable', 'boolean'],
            'easypanel_enabled' => ['nullable', 'boolean'],
            'easypanel_project_name' => ['nullable', 'string', 'max:255'],
            'easypanel_service_name' => ['nullable', 'string', 'max:255'],
            'easypanel_deploy_method' => ['nullable', 'in:git,docker_image,docker_compose'],
            'easypanel_repository_url' => ['nullable', 'url'],
            'easypanel_branch' => ['nullable', 'string', 'max:255'],
            'easypanel_docker_image' => ['nullable', 'string', 'max:255'],
            'easypanel_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'easypanel_env_vars' => ['nullable', 'array'],
            'easypanel_cpu_limit' => ['nullable', 'string', 'max:50'],
            'easypanel_memory_limit' => ['nullable', 'string', 'max:50'],
        ]);

        // Handle environment variables
        if (isset($validated['easypanel_env_vars'])) {
            $envVars = [];
            foreach ($validated['easypanel_env_vars'] as $item) {
                if (isset($item['key']) && isset($item['value']) && !empty($item['key']) && !empty($item['value'])) {
                    $envVars[$item['key']] = $item['value'];
                }
            }
            $validated['easypanel_env_vars'] = !empty($envVars) ? $envVars : null;
        }

        $site->update($validated);

        return redirect()->route('sites.settings', $site)
            ->with('success', 'Site settings updated successfully.');
    }
}
