<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Show the administrator roles
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Role::with('permissions');
        if ($request->search)
        {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $roles = $query->paginate();
        $permissions = Permission::pluck('name', 'id');
        return view('administrator/roles/index', ['roles' => $roles, 'permissions' => $permissions]);
    }
    
    /**
     * Create new item
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $permissions = Permission::pluck('name', 'id');
        return view('administrator/roles/create', ['permissions' => $permissions]);
    }
    
    /**
     * Edit item
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Role $role
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Role $role)
    {
        $permissions = Permission::pluck('name', 'id');
        return view('administrator/roles/edit', ['role' => $role, 'permissions' => $permissions]);
    }
    
    /**
     * Save new item
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save(Request $request)
    {                
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:roles',
            'guard_name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $data = $request->only(['name', 'guard_name']);
        $role = Role::create($data);
        
        //assign new permissions
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $permissionId = 'permission_' . $permission->id;
            if ($request->{$permissionId})
            {
                $permission->assignRole($role->name);
            }
        }
        
        if ($request->save_close)
        {
            return redirect()->route('administrator.roles')->withSuccess("Item successfully saved.");
        }
        return redirect()->route('administrator.roles.edit', $role)->withSuccess("Item successfully saved.");
    }
    
    /**
     * Update item
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, Role $role)
    {                
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'guard_name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
        $role->save();
        
        //assign new permissions
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            $permissionId = 'permission_' . $permission->id;
            if ($request->{$permissionId})
            {
                $permission->assignRole($role->name);
            }
        }
        
        //remove obsolete permissions
        $permissions = $permission->permissions;
        foreach ($permissions as $permission) {
            $permissionId = 'permission_' . $permission->id;
            if (!$request->{$permissionId})
            {
                $permission->removeRole($role->name);
            }
        }
        
        if ($request->save_close)
        {
            return redirect()->route('administrator.roles')->withSuccess("Item successfully saved.");
        }
        return back()->withSuccess("Item successfully saved.");
    }
    
    /**
     * Delete selected items
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request)
    {
        $role_ids = explode(',', $request->bulk_ids);
        foreach ($role_ids as $role_id) {
            Role::find($role_id)->delete();
        }
        
        return back()->withSuccess("Items successfully deleted.");
    }
    
}
