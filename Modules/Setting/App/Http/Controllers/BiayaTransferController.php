<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class BiayaTransferController extends Controller
{
    public function index()
    {
        $setBiaya = Setting::where('key', 'Biaya Transfer')->first();

        if(isset($setBiaya)){
            $kn = json_decode($setBiaya->value);
            $biaya = intval($kn->biaya);
        }else {
            $biaya = 0;
        }
        
        return view('setting::biaya.index', compact('biaya'));
    }

    public function setBiaya(Request $request)
    {
        $val = Setting::where('key', 'Biaya Transfer')->first();
        $data = array(
            'biaya'  => $request->nominal == null ? 0 : $request->nominal,
        );

        if(isset($val)){
            $val->value = json_encode($data);
            $val->save();
        }else {

            $val = new Setting();
            $val->key = 'Biaya Transfer';
            $val->value = json_encode($data);
            $val->save();
        }

        return successResponse('Pengaturan berhasil disimpan');
    }
}
