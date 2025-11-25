<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DatabaseManagementController extends Controller
{
    public function index(Site $site): View
    {
        if (!$site->database) {
            abort(404, 'No database associated with this site.');
        }

        try {
            $tables = DB::select("SHOW TABLES FROM `{$site->database->name}`");
            $tableNames = array_map(function ($table) {
                return array_values((array) $table)[0];
            }, $tables);

            return view('sites.database', [
                'site' => $site,
                'database' => $site->database,
                'tables' => $tableNames,
            ]);
        } catch (\Exception $e) {
            return view('sites.database', [
                'site' => $site,
                'database' => $site->database,
                'error' => 'Failed to fetch tables: ' . $e->getMessage(),
            ]);
        }
    }

    public function executeQuery(Request $request, Site $site): RedirectResponse
    {
        $request->validate([
            'query' => ['required', 'string', 'max:10000'],
        ]);

        if (!$site->database) {
            return redirect()->back()->with('error', 'No database associated with this site.');
        }

        try {
            $query = $request->input('query');
            
            // Security: Only allow SELECT queries for safety
            $trimmedQuery = trim($query);
            if (!preg_match('/^\s*SELECT/i', $trimmedQuery)) {
                return redirect()->back()->with('error', 'Only SELECT queries are allowed for security reasons.');
            }

            $results = DB::connection('mysql')->select($query);
            
            return redirect()->back()
                ->with('query_results', $results)
                ->with('query_executed', $query)
                ->with('success', 'Query executed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Query failed: ' . $e->getMessage())
                ->with('query_executed', $query);
        }
    }

    public function showTables(Site $site): RedirectResponse
    {
        return redirect()->route('sites.database', $site);
    }

    public function showTableStructure(Site $site, string $tableName): View
    {
        if (!$site->database) {
            abort(404, 'No database associated with this site.');
        }

        try {
            $structure = DB::select("DESCRIBE `{$site->database->name}`.`{$tableName}`");
            $rows = DB::select("SELECT * FROM `{$site->database->name}`.`{$tableName}` LIMIT 100");

            return view('sites.database-table', [
                'site' => $site,
                'database' => $site->database,
                'tableName' => $tableName,
                'structure' => $structure,
                'rows' => $rows,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('sites.database', $site)
                ->with('error', 'Failed to fetch table structure: ' . $e->getMessage());
        }
    }

    public function phpmyadmin(Site $site): View|RedirectResponse
    {
        if (!$site->database) {
            abort(404, 'No database associated with this site.');
        }

        $database = $site->database;
        $phpmyadminUrl = config('wphcp.phpmyadmin_url', 'http://localhost/phpmyadmin');
        
        // If direct redirect is enabled, redirect to phpMyAdmin
        if (config('wphcp.phpmyadmin_direct_redirect', false)) {
            return redirect($phpmyadminUrl);
        }

        // Otherwise show phpMyAdmin access page with credentials
        return view('sites.database-phpmyadmin', [
            'site' => $site,
            'database' => $database,
            'phpmyadminUrl' => $phpmyadminUrl,
        ]);
    }
}
