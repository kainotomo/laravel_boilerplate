<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Stop impersonating
     * 
     * @author Panayiotis Halouvas <phalouvas@kainotomo.com>
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function stopImpersonate()
    {
        if (! session()->has('impersonate')) {
            abort(404);
        }

        $orig_user = User::findOrFail(session()->pull('impersonate'));
        session()->forget('impersonate');
        auth()->login($orig_user);
        return redirect()->route('administrator');
    }
}
