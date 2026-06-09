<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndexAuditLogRequest;
use App\Http\Resources\AuditLogResource;
use App\Services\AuditLogService;

class AuditLogController extends Controller
{
    public function __construct(private AuditLogService $auditLogService)
    {
    }

    public function index(IndexAuditLogRequest $request)
    {
        $paginator = $this->auditLogService->list(
            $request->validated('action'),
            $request->validated('search'),
            (int) $request->validated('per_page', 20)
        );

        $paginator->getCollection()->transform(
            fn ($row) => (new AuditLogResource($row))->resolve()
        );

        return ApiResponse::paginated($paginator, 'Berhasil mengambil audit log');
    }
}
