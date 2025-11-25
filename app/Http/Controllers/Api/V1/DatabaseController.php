<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Database;
use Illuminate\Http\JsonResponse;

class DatabaseController extends Controller
{
    public function index(): JsonResponse
    {
        $databases = Database::with('site')
            ->get()
            ->map(function ($database) {
                return [
                    'id' => $database->id,
                    'name' => $database->name,
                    'username' => $database->username,
                    'host' => $database->host,
                    'port' => $database->port,
                    'size_mb' => $database->size_mb,
                    'status' => $database->status,
                    'site_domain' => $database->site?->domain,
                    'created_at' => $database->created_at,
                ];
            });

        return response()->json($databases);
    }

    public function show(Database $database): JsonResponse
    {
        $database->load('site');

        return response()->json([
            'id' => $database->id,
            'name' => $database->name,
            'username' => $database->username,
            'host' => $database->host,
            'port' => $database->port,
            'size_mb' => $database->size_mb,
            'status' => $database->status,
            'site' => $database->site ? [
                'id' => $database->site->id,
                'domain' => $database->site->domain,
            ] : null,
            'created_at' => $database->created_at,
            'updated_at' => $database->updated_at,
        ]);
    }
}

