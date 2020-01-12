<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * Delete selected items
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $user_ids = explode(',', $request->bulk_ids);
        foreach ($user_ids as $user_id) {
            User::find($user_id)->delete();
        }
        
        return back()->with('success', "Items successfully deleted.");
    }
}
