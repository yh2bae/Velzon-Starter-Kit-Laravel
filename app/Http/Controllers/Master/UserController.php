<?php

namespace App\Http\Controllers\Master;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Master\UserStoreRequest;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Master\UserUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:user_view', only: ['index']),
            new Middleware('permission:user_create', only: ['store']),
            new Middleware('permission:user_update', only: ['update']),
            new Middleware('permission:user_show', only: ['show']),
            new Middleware('permission:user_delete', only: ['destroy']),
        ];
    }

    public function __construct()
    {
        $this->path = 'pages.master.user.';

    }

    public function index(Request $request, DataTables $dataTables)
    {

        if ($request->ajax()) {
            return $this->datatables($dataTables);
        }

        $role = Role::where('name', '!=', 'superadmin')->get();

        $data = [
            'page_title' => 'User',
            'breadcrumbs' => [
                'home' => ['title' => 'Beranda', 'url' => route('home')],
                'users' => ['title' => 'Users', 'url' => route('users')],
            ],
            'role' => $role,
        ];

        return view($this->path . 'index', $data);
    }

    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validated();

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->assignRole($request->role);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::with(['roles', 'profile'])->findOrFail($id);
            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles->first()->name,
                'avatar' => $user->profile->avatar ?? asset('assets/images/users/user-dummy-img.jpg'),
                'phone' => $user->profile->phone ?? null,
                'address' => $user->profile->address ?? null,
                'created_at' => $user->created_at->format('d F Y H:i:s'),
                'updated_at' => $user->updated_at->format('d F Y H:i:s'),
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validated();

            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->save();

            $user->syncRoles([$request->role]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal diupdate',
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            if ($user->profile && $user->profile->avatar) {
                Storage::delete('public/avatars/' . basename($user->profile->avatar));
            }

            $user->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
            ], 500);
        }
    }

    public function loginAs($id)
    {
        $user = User::find($id);

        auth()->login($user);

        return redirect()->route('home')->with('success', 'Berhasil login sebagai ' . $user->name);
    }

    protected function datatables(DataTables $dataTables)
    {
        $query = User::with(['roles', 'profile'])
            ->whereHas('roles', function ($query) {
                $query->where('name', '!=', 'superadmin');
            })
            ->select('users.*', 'roles.name as role_name')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('users.id', '=', 'model_has_roles.model_uuid')
                    ->where('model_has_roles.model_type', '=', User::class);
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id');

        return $dataTables->eloquent($query)
            ->addIndexColumn()
            ->addColumn('no', function ($item) {
                static $no = 1;
                return $no++ . '.';
            })
            ->editColumn('name', function ($item) {
                $item->avatar = $item->profile->avatar ?? asset('assets/images/users/user-dummy-img.jpg');
                return view($this->path . 'components.row.name', compact('item'));
            })
            ->editColumn('email', function ($item) {
                return $item->email;
            })
            ->addColumn('role', function ($item) {
                return $item->role_name;
            })
            ->addColumn('action', function ($item) {
                return view($this->path . 'components.row.action', compact('item'));
            })
            ->orderColumn('role', 'role_name $1')
            ->rawColumns(['action'])
            ->make(true);
    }

}
