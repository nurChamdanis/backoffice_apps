<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class SertProdukController extends Controller
{
    public function index()
    {
        $setproduk = Setting::where('key', 'set_produk')->first();

        if(isset($setproduk)){
            $val = $setproduk->value;
        }else {
            $val = "off";
        }
        
        return view('setting::produk.index', compact('val'));
    }

    public function create()
    {
        return view('setting::create');
    }

    public function store(Request $request)
    {
        try {
            $val = Setting::where('key', 'set_produk')->first();
            if(isset($val)){
                $val->key = 'set_produk';
                $val->value = $request->auto_rename == 'on' ? 'on' : 'off';
                $val->save();
            }else {
    
                $val = new Setting();
                $val->key = 'set_produk';
                $val->value = $request->auto_rename == 'on' ? 'on' : 'off';
                $val->save();
            }
            
            return successResponse('Seting produk berhasil');
        } catch (\Throwable $th) {
            return successResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        return view('setting::show');
    }

    public function edit($id)
    {
        return view('setting::edit');
    }

    public function update(Request $request)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
