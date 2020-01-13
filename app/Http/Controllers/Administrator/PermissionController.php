<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Show the administrator permissions
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Permission::with('permissions');
        if ($request->search)
        {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->role_name)
        {
            $query->role($request->role_name);
        }
        $permissions = $query->paginate();
        $roles = Role::pluck('name', 'id');
        return view('administrator/permissions/index', ['permissions' => $permissions, 'roles' => $roles]);
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
        $roles = Role::get();
        return view('administrator/permissions/create', ['roles' => $roles]);
    }
    
    /**
     * Edit item
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Permission $permission
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Permission $permission)
    {
        $roles = Role::get();
        return view('administrator/permissions/edit', ['permission' => $permission, 'roles' => $roles]);
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
            'name' => 'required|max:255|unique:permissions',
            'guard_name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $data = $request->only(['name', 'guard_name']);
        $permission = Permission::create($data);
        
        //assign new roles
        $roles = Role::get();
        foreach ($roles as $role) {
            $roleId = 'role_' . $role->id;
            if ($request->{$roleId})
            {
                $role->givePermissionTo($permission);
            }
        }
        
        if ($request->save_close)
        {
            return redirect()->route('administrator.permissions')->withSuccess("Item successfully saved.");
        }
        return redirect()->route('administrator.permissions.edit', $permission)->withSuccess("Item successfully saved.");
    }
    
    /**
     * Update item
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Request $request
     * @param Permission $permission
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, Permission $permission)
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
        
        $permission->name = $request->name;
        $permission->guard_name = $request->guard_name;
        $permission->save();
        
        //assign new roles
        $roles = Permission::get();
        foreach ($roles as $role) {
            $roleId = 'role_' . $role->id;
            if ($request->{$roleId})
            {
                $role->givePermissionTo($permission);
            }
        }
        
        //remove obsolete roles
        $roles = $role->roles;
        foreach ($roles as $role) {
            $roleId = 'role_' . $role->id;
            if (!$request->{$roleId})
            {
                $role->revokePermissionTo($permission);
            }
        }
        
        if ($request->save_close)
        {
            return redirect()->route('administrator.permissions')->withSuccess("Item successfully saved.");
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
        $permission_ids = explode(',', $request->bulk_ids);
        foreach ($permission_ids as $permission_id) {
            Permission::find($permission_id)->delete();
        }
        
        return back()->withSuccess("Items successfully deleted.");
    }
    
}
