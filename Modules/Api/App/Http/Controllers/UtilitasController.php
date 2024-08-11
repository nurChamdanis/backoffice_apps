<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\TrxNotif;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\Setting\App\Models\Pengaturan;
use Modules\Setting\App\Models\Setting;
use Modules\Users\App\Models\Banner;
use Modules\Users\App\Models\HistoriKoin;
use Modules\Users\App\Models\HistoriPoin;
use Modules\Users\App\Models\Notifikasi;

class UtilitasController extends Controller
{
    public function maintenancemode()
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $mode = json_decode($val->value);

        return successResponse('Berhasil', $mode);
    }

    public function tukarKoin(Request $request)
    {
        $ref_id = Str::upper(Str::random(8));
        $us = User::where('id', userId())->first();
        $koin = intval($us->koin);
        
        $setKoin = Setting::where('key', 'min_koin')->first();
        if(isset($setKoin)){
            $kn = json_decode($setKoin->value);
            $min = intval($kn->nominal);
        }else {
            $min = 0;
        }

        if($koin <= $min){
            return errorResponApi('Minimal penukaran Koin adalah '.rupiah($min));
        }else {
            
            $pembagi = $koin / $min;
            $penukaran = round($pembagi) * $min;
            $hasil = intval($penukaran);
    
            $us->koin -= $hasil;
            $us->saldo += $hasil;
            $us->save();
    
            $float = $koin - $hasil;
            $data = array(
                'float_balance' => $float,
                'converted'     => $hasil,
                'last_balance'  => $us->saldo
            );

            $tk = new HistoriKoin();
            $tk->user_id    = userId();
            $tk->ref_id     = Str::upper(Str::random(16));
            $tk->jenis      = 'CREDIT';
            $tk->nominal    = $hasil;
            $tk->keterangan = 'Penukaran Koin sebesar '.rupiah($hasil);
            $tk->koin_awal  = intval($hasil) + $float;
            $tk->koin_akhir = $us->koin;
            $tk->save();
    
            $judul = 'Tukar Koin';
            $isi = 'Penukaran koin sebesar ' . rupiah($hasil) . ' berhasil';
            Notifikasi::create([
                'user_id'   => userId(),
                'title'     => $judul,
                'content'   => $isi,
                'type'      => 'Tukar Koin',
                'ref_id'    => $ref_id
            ]);
    
            $admin = Admin::where('id', 1)->first();
            if(isset($admin->fcm)){
                $fcmTokens = $admin->fcm;
                Notification::send($admin, new TrxNotif($judul, $isi, null, $fcmTokens, 'ADM-TUKAR-KOIN'));
            }
    
            if(isset($us->fcm)){
                $fcm = $us->fcm;
                Notification::send($us, new TrxNotif($judul, $isi, null, $fcm, 'TUKAR-KOIN'));
            }
    
            return successResponse('Berhasil', $data);
        }

    }

    public function historiKoin()
    {
        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        $dateE = Carbon::now()->endOfMonth();
        
        $dt = HistoriKoin::where('user_id', userId())->whereBetween('created_at',[$dateS, $dateE])->orderBy('id', 'desc')->get();
        return successResponse('Berhasil', $dt);
    }

    public function historiPoin()
    {
        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        $dateE = Carbon::now()->endOfMonth();

        $dt = HistoriPoin::where('user_id', userId())->whereBetween('created_at',[$dateS, $dateE])->orderBy('id', 'desc')->get();
        return successResponse('Berhasil', $dt);
    }

    public function listBanner(Request $request)
    {
        $dt = Banner::orderBy('id', 'desc')->get();
        return successResponse('Berhasil', $dt);
    }

    public function inboxNotif(Request $request)
    {
        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        $dateE = Carbon::now()->endOfMonth();

        $dt = Notifikasi::where('user_id', userId())->whereBetween('created_at',[$dateS, $dateE])->orderBy('id', 'desc')->get();
        return successResponse('Berhasil', $dt);
    }

    public function tnc(Request $request)
    {
        $dt = Setting::where('key', 'term')->first();
        if(!isset($dt)){
            $data = null;
        }else {
            $data = $dt->value;
        }

        return successResponse('Berhasil', $data);
    }

    public function policy(Request $request)
    {
        $dt = Setting::where('key', 'policy')->first();
        if(!isset($dt)){
            $data = null;
        }else {
            $data = $dt->value;
        }

        return successResponse('Berhasil', $data);
    }

    public function contact(Request $request)
    {
        $dt = Setting::where('key', 'contact')->first();
        if(!isset($dt)){
            $data = null;
        }else {
            $data = json_decode($dt->value);
        }

        return successResponse('Berhasil', $data);
    }

    public function allSetting(Request $request)
    {
        $dt = Pengaturan::whereNotIn('key', ['term', 'policy'])->get();
        $data = collect($dt);
        return successResponse('Berhasil', $data);
    }
}
