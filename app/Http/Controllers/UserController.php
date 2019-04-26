<?php

namespace App\Http\Controllers;

use Auth;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            'name_prefix' => ['nullable', 'string', 'max:20'],
            'name_first' => ['required', 'string', 'max:255'],
            'name_last' => ['required', 'string', 'max:255']
        ]);
    }

    protected function update_image_validator(array $data)
    {
        return Validator::make($data, [
            'image' => ['required', 'image', 'max:2000']
        ]);
    }
    protected function remove_image_validator(array $data)
    {
        return Validator::make($data, [
            'image_remove' => ['required', 'accepted']
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
        if ($request->filled('name_first')) {
            $this->update_info_validator($request->all())->validate();

            $user->name_prefix = $request->name_prefix;
            $user->name_first = $request->name_first;
            $user->name_last = $request->name_last;
            
            if ($user->save()) {
                $simple_changes = true;
            }
        }

        // Remove image
        if ($request->has('image_remove')) {
            $this->remove_image_validator($request->all())->validate();

            $user->image_id = null;
            $user->save();

            $simple_changes = true;
        }

        // Update image
        if ($request->has('image')) {
            $this->update_image_validator($request->all())->validate();

            $image = Image::upload($user, $request->file('image'), 'profiles');

            if ($image === null) {
                $session->flash('error', 'Noe gikk galt. Vi kunne ikke laste opp bilde ditt.');
            } else {
                $user->image_id = $image->id;
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
