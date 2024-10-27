<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FortuneWheelController extends Controller
{
    public function index(){

        return view('admin.fortune_wheel.index');

    }


}
