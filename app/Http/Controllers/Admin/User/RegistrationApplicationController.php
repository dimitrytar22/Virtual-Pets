<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RegistrationApplication\UpdateRequest;
use App\Models\RegistrationApplication;
use Illuminate\Http\Request;

class RegistrationApplicationController extends Controller
{
    public function index(){
        return view('admin.users.registration_application.index', ['registration_applications'=>RegistrationApplication::all()]);
    }




    public function update(UpdateRequest $request, $id){
        $registrationApplication = RegistrationApplication::find($id);
        $data = $request->validated();
        $user = $registrationApplication->user;
        $user->password = md5($data['password']);
        $user->role_id = $data['role_id'];
        $user->save();
        $registrationApplication->delete();
        return redirect()->route('admin.users.registration_applications.index');
    }

    public function destroy($id){
        $registrationApplication = RegistrationApplication::find($id);
        $registrationApplication->delete();
        return redirect()->route('admin.users.registration_applications.index');
    }
}
