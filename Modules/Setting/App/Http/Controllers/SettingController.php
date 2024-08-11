<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting::command.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            //code...
            Artisan::call('auth:nukar');
            Artisan::call('auth:klik');
            Artisan::call('cek:harga');
            Artisan::call('cek:pasca');
            Artisan::call('user:cek-dorman');
            Artisan::call('optimize:clear');
    
            return successResponse('Cache Cleared Successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return errorResponApi($th->getMessage(), 422);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
