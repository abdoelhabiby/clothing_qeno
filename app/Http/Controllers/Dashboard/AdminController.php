<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Dashboard\AdminRequest;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{

    public function __construct()
    {
        // $this->middleware('role:super_admin');


    }

    //-------------------index-----------------
    public function index()
    {




        $ids_super_admin =  Admin::role('super_admin')->get()->pluck('id');

        $rows = Admin::with(['roles.permissions'])->whereNotIn('id', $ids_super_admin)->paginate(10);

        return view('dashboard.admins.index', compact('rows'));
    }

    //-----------------show create form------------------

    public function create()
    {


        $roles_permissions = $this->getRolesWithPermissionsCanAdminTake();

        return view('dashboard.admins.create', compact('roles_permissions'));
    }

    //-----------------show create form------------------
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {



        try {

            $validated = $request->validated();


            $validated['password'] = Hash::make($validated['password']);
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password']
            ];

            $admin =  Admin::create($data);

            $validated['permissions'] = $request->permissions && count($request->permissions) > 0 ? $validated['permissions'] : [];
            $permissions = $validated['permissions'];

            if (count($permissions) > 0) {
                $admin->givePermissionTo($permissions);
            }


            return redirect()->route('admins.index')->with(['success' => "success create"]);
        } catch (\Throwable $th) {
            return catchErro('admins.index', $th);
        }
    }



    //------------------------show form edit ---------------

    public function edit(Admin $admin)
    {
        $row =  $admin;
        $admin_permissions = $row->permissions->pluck('name')->toArray();
        $roles_permissions = $this->getRolesWithPermissionsCanAdminTake();


        return view('dashboard.admins.edit', compact(['row', 'admin_permissions', 'roles_permissions']));
    }
    //------------------------show form edit ---------------



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $Admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {



        try {

            $validated = $request->validated();

            if ($request->password && $request->password != '' && !empty(trim($request->password))) {

                $validated["password"] = Hash::make($request->password);
            } else {

                unset($validated['password']);
            }


            $validated['permissions'] = $request->permissions && count($request->permissions) > 0 ? $validated['permissions'] : [];
            $permissions = $validated['permissions'];

            unset($validated['permissions']);

            $admin->update($validated);
            $admin->syncPermissions($permissions);


            return redirect()->route('admins.index')->with(['success' => "success update"]);
        } catch (\Throwable $th) {

            return catchErro('admins.index', $th);
        }
    }


    //-----------------------------delete admin------------------------------

    public function destroy(Admin $admin)
    {
        try {

            $admin->delete();
            return redirect()->route('admins.index')->with(['success' => "success delete"]);
        } catch (\Throwable $th) {

            return catchErro('admins.index', $th);
        }
    }

    //-----------------------------delete admin------------------------------



    protected function getRolesWithPermissionsCanAdminTake()
    {

        $roles_permissions = Role::whereNotIn('name', ['super_admin', 'admin'])
            ->where('guard_name', 'admin')
            ->whereHas('permissions')
            ->with(['permissions' => function ($q) {
                return $q->select('name');
            }])
            ->select(['id', 'name'])
            ->get();

        return $roles_permissions;
    } // end of calss get roles with permissions

} // end of class
