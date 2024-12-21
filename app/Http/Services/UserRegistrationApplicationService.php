<?php

namespace App\Http\Services;




use App\Http\Requests\Admin\User\RegistrationApplication\UpdateRequest;
use App\Models\RegistrationApplication;

class UserRegistrationApplicationService
{
    public function update(UpdateRequest $request, $id){
        $registrationApplication = RegistrationApplication::find($id);
        $data = $request->validated();
        $user = $registrationApplication->user;
        $user->password = md5($data['password']);
        $user->role_id = $data['role_id'];
        $user->save();
        $registrationApplication->delete();
    }

    public function destroy($id){
        $registrationApplication = RegistrationApplication::find($id);
        $registrationApplication->delete();
    }
}
