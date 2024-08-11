<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Setting::where('key', 'maintnance_mode')->first();
        if(isset($data)){
            $val = json_decode($data->value);
        }else {
            $d = array('mode' => 'off', 'title' => '');
            $dt = json_encode($d);
            $val = json_decode($dt);
        }

        return view('setting::maintenance.index', compact('val'));
    }

    public function store(Request $request)
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $data = array(
            'mode'  => $request->mode == 'on' ? 'on' : 'off',
            'title' => $request->title
        );
        $val->update([
            'value' => json_encode($data)
        ]);
        if($request->mode == 'on'){
            return successResponse('Mode Maintnance Berjalan');
        }else{
            return successResponse('Mode Maintnance Ditutup');
        }
    }

}
