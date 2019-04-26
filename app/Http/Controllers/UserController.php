<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        return view('user.show', compact('user'));
    }

    protected function update_email_validator(array $data)
    {
        return Validator::make($data, [
            'current_password' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
    }

    protected function update_password_validator(array $data)
    {
        return Validator::make($data, [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    protected function update_info_validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $session = $request->session();
        $simple_changes = false;

        // Update email
        if ($request->filled('email') && $request->email != $user->email) {
            if ($user->check_password($request->current_password)) {
                $this->update_email_validator($request->all())->validate();

                $user->email = $request->email;
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
                $user->save();

                $session->flash('success', 'Din kontos e-post adresse ble oppdatert.');
                $session->flash('info', 'Du må bekrefte din nye e-post. En lenke har blitt sendt til deg.');
            } else {
                $session->flash('error', 'Feil passord');
            }
        }

        // Update password
        if ($request->filled('new_password')) {
            if ($user->check_password($request->current_password)) {
                $this->update_password_validator($request->all())->validate();

                $user->password = Hash::make($request->new_password);
                $user->save();
    
                $session->flash('success', 'Din kontos passord ble oppdatert.');
            } else {
                $session->flash('error', 'Feil passord');
            }
        }

        // Update name
        if ($request->filled('name') && $request->name != $user->name) {
            $this->update_info_validator($request->all())->validate();

            $user->name = $request->name;
            $user->save();

            $simple_changes = true;
        }

            }

        if ($simple_changes) {
            $session->flash('success', 'Din konto ble oppdatert.');
        }

        return redirect()->route('user.show');
    }
}
