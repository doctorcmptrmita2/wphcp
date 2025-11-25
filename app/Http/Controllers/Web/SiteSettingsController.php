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
        ]);

        $site->update($validated);

        return redirect()->route('sites.settings', $site)
            ->with('success', 'Site settings updated successfully.');
    }
}
