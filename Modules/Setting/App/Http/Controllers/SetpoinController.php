<?php

namespace Modules\Setting\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\App\Models\Setting;

class SetpoinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dep = Setting::where('key', 'poin_deposit')->first();
        $ref = Setting::where('key', 'poin_referral')->first();
        $nomDev = Setting::where('key', 'nom_poin_deposit')->first();
        $nomRef = Setting::where('key', 'nom_poin_referral')->first();

        if(isset($dep)){
            $depo = json_decode($dep->value);
            $valdev = $depo->poin_depo;
        }else {
            $valdev = 'off';
        }

        if(isset($ref)){
            $reff = json_decode($ref->value);
            $valref = $reff->poin_ref;
        }else {
            $valref = 'off';
        }

        if(isset($nomDev)){
            $nomDeposit = json_decode($nomDev->value);
        }else {
            $nomDeposit = null;
        }

        if(isset($nomRef)){
            $nomReferral = json_decode($nomRef->value);
        }else {
            $nomReferral = null;
        }
        
        return view('setting::poin.index', compact('valdev', 'valref', 'nomDeposit', 'nomReferral'));
    }

    public function setPoinDeposit(Request $request)
    {
        $val = Setting::where('key', 'poin_deposit')->first();
        $data = array(
            'poin_depo'  => $request->poin_depo,
        );

        if(isset($val)){
            $val->value = json_encode($data);
            $val->save();
        }else {

            $val = new Setting();
            $val->key = 'poin_deposit';
            $val->value = json_encode($data);
            $val->save();
        }

        if($request->poin_depo == 'on'){
            return successResponse('Modul poin deposit aktif');
        }else{
            return successResponse('Modul poin deposit tidak aktif');
        }
    }

    public function setDep(Request $request)
    {
        $val = Setting::where('key', 'nom_poin_deposit')->first();
        $data = array(
            'minimal'  => $request->minimal == null ? 0 : $request->minimal,
            'nominal'  => $request->nominal == null ? 0 : $request->nominal,
        );

        if(isset($val)){
            $val->value = json_encode($data);
            $val->save();
        }else {

            $val = new Setting();
            $val->key = 'nom_poin_deposit';
            $val->value = json_encode($data);
            $val->save();
        }

        return successResponse('Nominal poin berhasil disimpan');
    }

    public function setPoinReferral(Request $request)
    {
        $val = Setting::where('key', 'poin_referral')->first();

        $data = array(
            'poin_ref'  => $request->poin_ref,
        );


        if(isset($val)){
            $val->value = json_encode($data);
            $val->save();

        }else {

            $val = new Setting();
            $val->key = 'poin_referral';
            $val->value = json_encode($data);
            $val->save();
        }

        if($request->poin_depo == 'on'){
            return successResponse('Modul poin referral aktif');
        }else{
            return successResponse('Modul poin referral tidak aktif');
        }
    }

    public function setRef(Request $request)
    {
        $val = Setting::where('key', 'nom_poin_referral')->first();
        $data = array(
            'nominal'  => $request->nominal == null ? 0 : $request->nominal,
            'nominal_share'  => $request->nominal_share == null ? 0 : $request->nominal_share,
            'minimal'   => $request->minimalShare,
        );

        if(isset($val)){
            $val->value = json_encode($data);
            $val->save();
        }else {

            $val = new Setting();
            $val->key = 'nom_poin_referral';
            $val->value = json_encode($data);
            $val->save();
        }

        return successResponse('Nominal poin referral berhasil disimpan');
    }
}
