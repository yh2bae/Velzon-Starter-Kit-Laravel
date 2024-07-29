<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\DataTables;

class RolesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:role_view', only: ['index']),
            new Middleware('permission:role_create', only: ['store']),
            new Middleware('permission:role_update', only: ['update', 'rolePermission']),
            new Middleware('permission:role_show', only: ['show']),
            new Middleware('permission:role_delete', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->path = 'pages.master.roles.';
    }

    public function index(Request $request, DataTables $dataTables)
    {
        if ($request->ajax()) {
            return $this->datatables($dataTables);
        }

        $data = [
            'page_title' => 'Roles',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'roles' => ['title' => 'Roles', 'url' => route('roles')],
            ],
        ];

        return view($this->path . 'index', $data);
    }

    public function store(RoleRequest $request)
    {
        try {
            $request->validated();

            Role::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Role berhasil ditambahkan',
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
            $role = Role::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $role,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $request->validated();

            $role = Role::findOrFail($id);
            $role->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Role berhasil diperbarui',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diperbarui',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Role berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }

    public function rolePermission($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        $modulePermissions = $this->getModulePermissions();

        $data = [
            'page_title' => 'Role Permission',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'roles' => ['title' => 'Roles', 'url' => route('roles')],
                'role_permission' => ['title' => 'Role Permission', 'url' => route('roles.permissions', $id)],
            ],
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
            'modulePermissions' => $modulePermissions,
        ];

        return view($this->path . 'role-permission', $data);
    }

    public function rolePermissionUpdate(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            $role->syncPermissions($request->permissions);

            return redirect()->route('roles.permissions', $id)->with('success', 'Role permission berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('roles.permissions', $id)->with('error', 'Role permission gagal diperbarui');
        }
    }

    protected function datatables(DataTables $dataTables)
    {
        $query = Role::query();

        return $dataTables->eloquent($query)
            ->addIndexColumn()
            ->addColumn('no', function ($item) {
                static $no = 1;
                return $no++ . '.';
            })
            ->editColumn('permissions', function ($item) {
                $permissionCount = $item->permissions->count();
                return view($this->path . 'components.row.permission', compact('permissionCount'));
            })
            ->addColumn('action', function ($item) {
                return view($this->path . 'components.row.action', compact('item'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    private function getModulePermissions()
    {
        $permissions = Permission::get();
        $modules = Permission::select('module_name')->distinct()->get();
        $modulePermissions = [];

        foreach ($modules as $module) {
            $modulePermissions[$module->module_name] = $permissions
                ->where('module_name', $module->module_name)
                ->map(function ($perm) {
                    return ['id' => $perm->id, 'name' => $perm->name];
                })
                ->toArray();
        }

        return $modulePermissions;
    }
}
