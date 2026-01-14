<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

protected function credentials(Request $request)
{
    if ($request->type === 'admin') {
        return [
            'email' => $request->email,
            'password' => $request->password,
        ];
    }

    return [
        'email' => $request->email,
        'password' => $request->password,
        'type' => $request->type,
    ];
}



protected function authenticated(Request $request, $user)
{
    // Jika user pilih ADMIN
    if ($request->type === 'admin') {

        if ($user->type === 'kafa_admin') {
            return redirect()->route('home.admin');
        }

        if ($user->type === 'muip_admin') {
            return redirect()->route('home.muip');
        }

        // Kalau bukan admin sebenar
        auth()->logout();
        return redirect()->back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // Jika bukan admin, mesti exact match
    if ($request->type !== $user->type) {
        auth()->logout();
        return redirect()->back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    // Normal redirect ikut role
    switch ($user->type) {
        case 'teacher':
            return redirect()->route('home.teacher');
        case 'parent':
            return redirect()->route('home.parent');
        case 'student':
            return redirect()->route('home.student');
        default:
            auth()->logout();
            abort(403);
    }
}




    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


}
