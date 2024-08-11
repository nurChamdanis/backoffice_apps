<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class SetkoinController extends Controller
{
    public function index()
    {
        $setKoin = Setting::where('key', 'min_koin')->first();

        if(isset($setKoin)){
            $kn = json_decode($setKoin->value);
            $koin = intval($kn->nominal);
        }else {
            $koin = 0;
        }
        
        return view('setting::koin.index', compact('koin'));
    }

    public function setKoin(Request $request)
    {
        $val = Setting::where('key', 'min_koin')->first();
        $data = array(
            'nominal'  => $request->nominal == null ? 0 : $request->nominal,
        );

        if(isset($val)){
            $val->value = json_encode($data);
            $val->save();
        }else {

            $val = new Setting();
            $val->key = 'min_koin';
            $val->value = json_encode($data);
            $val->save();
        }

        return successResponse('Minimal koin berhasil disimpan');
    }
}
