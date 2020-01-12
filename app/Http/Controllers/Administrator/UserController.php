<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Show the administrator users
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        if ($request->search)
        {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%');
        }
        $users = $query->paginate();
        return view('administrator/users/index', ['users' => $users]);
    }
    
    /**
     * Edit user
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');
        return view('administrator/users/edit', ['user' => $user, 'roles' => $roles]);
    }
    
    /**
     * 
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, User $user)
    {                
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password && ($request->password == $request->password_confirmation) )
        {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        
        //assign new roles
        $roles = Role::get();
        foreach ($roles as $role) {
            $roleId = 'role_' . $role->id;
            if ($request->{$roleId})
            {
                $user->assignRole($role->name);
            }
        }  
        
        //remove obsolete roles
        $roles = $user->roles;
        foreach ($roles as $role) {
            $roleId = 'role_' . $role->id;
            if (!$request->{$roleId})
            {
                $user->removeRole($role->name);
            }
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
        $user_ids = explode(',', $request->bulk_ids);
        foreach ($user_ids as $user_id) {
            User::find($user_id)->delete();
        }
        
        return back()->withSuccess("Items successfully deleted.");
    }
}