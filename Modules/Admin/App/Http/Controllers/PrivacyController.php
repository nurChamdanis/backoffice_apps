<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class PrivacyController extends Controller
{
    public function index()
    {
        $dt = Setting::where('key', 'policy')->first();
        if(!isset($dt)){
            $data = null;
        }else {
            $data = $dt->value;
        }
        return view('admin::utilitas.policy.index', compact('data'));
    }

    public function create()
    {
        return view('admin::create');
    }

    public function store(Request $request)
    {
        $detail = $request->konten;

        $dom = new \domdocument();
        $dom->loadHtml($detail);
        $images = $dom->getelementsbytagname('img');

        foreach($images as $k => $img){
            $data = $img->getattribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name= time().$k.'.png';
            $path = public_path() .'/'. $image_name;

            file_put_contents($path, $data);

            $img->removeattribute('src');
            $img->setattribute('src', $image_name);

            publicUpload('source/' . $image_name, $data);
        }

        $detail = $dom->savehtml();
        
        $data = Setting::where('key', 'policy')->first();
        if(!isset($data)){
            
            $summernote = new Setting;
            $summernote->key = 'policy';
            $summernote->value = $detail;
            $summernote->save();

        }else {

            $data->value = $detail;
            $data->save();
        }

        return successResponse('Data berhasil disimpan', null);

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
