<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Backup::with('site');

        if ($request->has('site_id')) {
            $query->where('site_id', $request->integer('site_id'));
        }

        $backups = $query->orderBy('created_at', 'desc')->get();

        return response()->json($backups);
    }

    public function show(Backup $backup): JsonResponse
    {
        $backup->load('site');

        return response()->json($backup);
    }

    public function download(Backup $backup): JsonResponse
    {
        // For MVP, return JSON with backup path
        // TODO: Implement file streaming/download in future
        return response()->json([
            'message' => 'Backup download not yet implemented',
            'backup_id' => $backup->id,
            'path' => $backup->path,
            'size_mb' => $backup->size_mb,
        ], 501);
    }
}


