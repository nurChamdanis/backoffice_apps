<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class KontakController extends Controller
{
    public function index()
    {
        $dt = Setting::where('key', 'contact')->first();
        if(!isset($dt)){
            $value = null;
        }else {
            $value = json_decode($dt->value);
        }
        return view('admin::utilitas.contact.index', compact('value'));
    }

    public function create()
    {
        return view('admin::create');
    }

    public function store(Request $request)
    {
        $detail = array(
            'whatsapp'  => $request->whatsapp,
            'telegram'  => $request->telegram,
            'facebook'  => $request->facebook,
            'instagram' => $request->instagram,
            'tweeter'   => $request->tweeter,
            'tiktok'    => $request->tiktok,
            'email'     => $request->email,
            'alamat'    => $request->alamat,
            'telepon'   => $request->telepon,
        );
        
        $data = Setting::where('key', 'contact')->first();
        if(!isset($data)){
            
            $contact = new Setting;
            $contact->key = 'contact';
            $contact->value = json_encode($detail);
            $contact->save();

        }else {

            $data->value = json_encode($detail);
            $data->save();
        }

        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
