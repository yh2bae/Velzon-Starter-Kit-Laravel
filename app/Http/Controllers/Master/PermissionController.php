<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:permission_view', only: ['index']),
            new Middleware('permission:permission_create', only: ['store']),
            new Middleware('permission:permission_update', only: ['update']),
            new Middleware('permission:permission_show', only: ['show']),
            new Middleware('permission:permission_delete', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->path = 'pages.master.permissions.';
    }

    public function index(Request $request, DataTables $dataTables)
    {
        if ($request->ajax()) {
            return $this->datatables($dataTables);
        }

        $data = [
            'page_title' => 'Permissions',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'permissions' => ['title' => 'Permissions', 'url' => route('permissions')],
            ],
        ];

        return view($this->path . 'index', $data);
    }

    public function store(PermissionRequest $request)
    {
        try {
            $request->validated();

            Permission::create([
                'name' => $request->name,
                'module_name' => $request->module_name,
                'guard_name' => 'web',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $permission = Permission::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $permission,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function update(PermissionRequest $request, $id)
    {
        try {
            $request->validated();

            $permission = Permission::findOrFail($id);
            $permission->update([
                'name' => $request->name,
                'module_name' => $request->module_name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diubah',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diubah',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }

    protected function datatables(DataTables $dataTables)
    {
        $query = Permission::query();

        return $dataTables->eloquent($query)
            ->addIndexColumn()
            ->addColumn('no', function ($item) {
                static $no = 1;
                return $no++ . '.';
            })
            ->addColumn('action', function ($item) {
                return view($this->path . 'components.row.action', compact('item'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
