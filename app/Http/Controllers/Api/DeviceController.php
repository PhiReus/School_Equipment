<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function getDevices(){
        $devices = Device::all();
        return response()->json($devices, 200);
    }
}
