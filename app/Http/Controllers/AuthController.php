<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Session, Validator, Hash, Crypt;

class AuthController extends Controller
{
    public function signIn() {
        $sess = Session::get('user_logged_in');

        if(!is_null($sess)) return redirect()->route('backend.dashboard.main');
        
        return view('admin.auth.signin');
    }

    public function signInProcess(Request $req) {

        $validator = Validator::make($req->all(), [
            'user' => 'required',
            'pass' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('admin.auth.signin')
                        ->withErrors($validator)
                        ->withInput();
        } else {

            $user = User::where('userLogin', $req->input('user'))
                            ->first();
            
            if(!is_null($user)) {
                if(Hash::check($req->input('pass'), $user->userPass)) {
                    
                    setSession(config('shiza.session.signin'),[
                        'id' => $user->id,
                        'email' => $user->userEmail,
                        'username' => $user->userLogin,
                        'level' => $user->levelId,
                        'loggedIn' => TRUE,
                        'loggedDateTime' => date('Y-m-d H:i:s')
                    ]);
                    
                    return redirect()->route('admin.dashboard.index');
                } else {
                    Session::flash('failed', 'Wrong password');
                    return redirect()->route('admin.auth.signin');
                }
            } else {
                Session::flash('failed', 'Wrong username');
                return redirect()->route('admin.auth.signin');
            }
        }

    }

    public function signOut() {
        Session::forget(config('shiza.session.signin'));

        return redirect()->route('admin.auth.signin');
    }
}
