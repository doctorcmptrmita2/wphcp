<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\Site;
use App\Models\SslCertificate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalSites = Site::count();
        $activeSites = Site::where('status', 'active')->count();
        $errorSites = Site::where('status', 'error')->count();
        $disabledSites = Site::where('status', 'disabled')->count();

        $lastBackups = Backup::with('site')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $expiringCertificates = SslCertificate::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now()->addDays(30))
            ->orderBy('expires_at', 'asc')
            ->limit(5)
            ->with('site')
            ->get();

        return view('dashboard', [
            'totalSites' => $totalSites,
            'activeSites' => $activeSites,
            'errorSites' => $errorSites,
            'disabledSites' => $disabledSites,
            'lastBackups' => $lastBackups,
            'expiringCertificates' => $expiringCertificates,
        ]);
    }
}

