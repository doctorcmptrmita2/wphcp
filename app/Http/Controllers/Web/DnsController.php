<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DnsRecord;
use App\Models\Site;
use App\Services\Wphcp\DnsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DnsController extends Controller
{
    public function __construct(
        private readonly DnsService $dnsService
    ) {
    }

    public function index(Site $site): View
    {
        $site->load('dnsRecords');
        
        return view('sites.dns', [
            'site' => $site,
            'dnsRecords' => $site->dnsRecords,
        ]);
    }

    public function store(Request $request, Site $site): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:A,AAAA,CNAME,MX,TXT,NS,SRV'],
            'name' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'ttl' => ['nullable', 'integer', 'min:60', 'max:86400'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->dnsService->createRecord($site, $validated);

        return redirect()->route('sites.dns', $site)
            ->with('success', 'DNS record created successfully.');
    }

    public function update(Request $request, Site $site, DnsRecord $dnsRecord): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:A,AAAA,CNAME,MX,TXT,NS,SRV'],
            'name' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:255'],
            'ttl' => ['nullable', 'integer', 'min:60', 'max:86400'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'active' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $this->dnsService->updateRecord($dnsRecord, $validated);

        return redirect()->route('sites.dns', $site)
            ->with('success', 'DNS record updated successfully.');
    }

    public function destroy(Site $site, DnsRecord $dnsRecord): RedirectResponse
    {
        $this->dnsService->deleteRecord($dnsRecord);

        return redirect()->route('sites.dns', $site)
            ->with('success', 'DNS record deleted successfully.');
    }
}
