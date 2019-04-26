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

        if ($user->check_password($request->current_password)) {

            if ($request->filled('email') && $request->email != $user->email) {
                $this->update_email_validator($request->all())->validate();

                $user->email = $request->email;
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
                $user->save();

                $session->flash('success', 'Din kontos e-post adresse ble oppdatert.');
                $session->flash('info', 'Du må bekrefte din nye e-post. En lenke har blitt sendt til deg.');
            }

            if ($request->filled('new_password')) {
                $this->update_password_validator($request->all())->validate();

                $user->password = Hash::make($request->new_password);
                $user->save();

                $session->flash('success', 'Din kontos passord ble oppdatert.');
            }

            if ($request->filled('name') && $request->name != $user->name) {
                $this->update_info_validator($request->all())->validate();

                $user->name = $request->name;
                $user->save();

                $session->flash('success', 'Din konto ble oppdatert.');
            }

        } else {
            $session->flash('error', 'Feil passord');
        }

        return redirect()->route('user.show');
    }
}
