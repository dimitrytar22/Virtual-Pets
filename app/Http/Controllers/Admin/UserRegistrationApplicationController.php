<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RegistrationApplication\UpdateRequest;
use App\Http\Services\UserRegistrationApplicationService;
use App\Models\RegistrationApplication;

class UserRegistrationApplicationController extends Controller
{

    public function __construct(private UserRegistrationApplicationService $service)
    {
    }

    public function index(){
        return view('admin.users.registration_application.index', ['registration_applications'=>RegistrationApplication::all()]);
    }


    public function update(UpdateRequest $request, $id){
        $this->service->update($request,$id);
        return redirect()->route('admin.users.registration_applications.index');
    }

    public function destroy($id){
        $this->service->destroy($id);
        return redirect()->route('admin.users.registration_applications.index');
    }
}
