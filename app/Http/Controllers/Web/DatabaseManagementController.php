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

    public function phpmyadmin(Site $site): RedirectResponse
    {
        if (!$site->database) {
            abort(404, 'No database associated with this site.');
        }

        $phpmyadminUrl = config('wphcp.phpmyadmin_url', 'http://localhost/phpmyadmin');
        $database = $site->database;
        
        // Generate phpMyAdmin URL with auto-login parameters
        // Note: This requires phpMyAdmin to be configured to accept these parameters
        $params = http_build_query([
            'server' => $database->host . ':' . $database->port,
            'username' => $database->username,
            'db' => $database->name,
        ]);

        // For security, we'll redirect to phpMyAdmin with a token-based approach
        // Store credentials in session temporarily for secure access
        session([
            'phpmyadmin_db_host' => $database->host,
            'phpmyadmin_db_port' => $database->port,
            'phpmyadmin_db_name' => $database->name,
            'phpmyadmin_db_user' => $database->username,
            'phpmyadmin_db_pass' => $database->decrypted_password,
            'phpmyadmin_site_id' => $site->id,
        ]);

        return redirect()->route('sites.database.phpmyadmin.proxy', $site);
    }

    public function phpmyadminProxy(Site $site): View
    {
        if (!$site->database) {
            abort(404, 'No database associated with this site.');
        }

        $database = $site->database;
        $phpmyadminUrl = config('wphcp.phpmyadmin_url', 'http://localhost/phpmyadmin');

        return view('sites.database-phpmyadmin', [
            'site' => $site,
            'database' => $database,
            'phpmyadminUrl' => $phpmyadminUrl,
        ]);
    }
}
