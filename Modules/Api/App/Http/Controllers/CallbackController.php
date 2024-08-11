<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TransactionMail;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\TrxNotif;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\App\Models\Margin;
use Modules\Klick\App\Http\Controllers\KlickController;
use Modules\Produk\App\Models\Produk;
use Modules\Transaksi\App\Models\Transaksi;
use Modules\Users\App\Models\HistoriKoin;
use Modules\Users\App\Models\HistoriPoin;
use Modules\Users\App\Models\Notifikasi;

class CallbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function callbackNukar(Request $request)
    {
        Log::info('CALLBACK NUKAR: '.$request->ref_id);
        $t = Transaksi::where('seller_ref', $request->ref_id)->first();
        if(isset($t)){
            $t->status = Str::upper($request->status);
            $t->sn = $request->sn;
            $t->save();

            $us = User::where('id', $t->user_id)->first();
            $mr = Margin::where('ref_id', $t->ref_id)->first();
            if($request->status == 'Gagal'){

                //only refund koin?
                $tk = new HistoriKoin();
                $tk->user_id    = $us->id;
                $tk->ref_id     = $t->ref_id;
                $tk->jenis      = 'CREDIT';
                $tk->nominal    = $t->harga;
                $tk->keterangan = 'Refund transaksi sebesar '.rupiah($t->harga);
                $tk->koin_awal  = intval($us->koin);
                $tk->koin_akhir = intval($us->koin) + $t->harga;
                $tk->save();

                $us->koin += $t->harga;
                $us->save();

                //where is refund poin / saldo

                $t->margin = 0;
                $t->save();
            }

            $pr = Produk::where('code', $t->produk_id)->first();
            $mr->posted = $request->status == 'Gagal' ? false : true;
            $mr->save();

            if($request->status !== 'Gagal'){
                $kode = $pr->code;
                $cekPromo = cekPromo($kode);
                if($cekPromo){

                    $disc = intval($pr->sale_price) * $pr->discount / 100;
                    if($pr->margin >= $disc){

                        $hp = new HistoriPoin();
                        $hp->user_id    = $us->id;
                        $hp->ref_id     = $t->ref_id;
                        $hp->jenis      = 'CREDIT';
                        $hp->nominal    = $disc;
                        $hp->keterangan = 'Cashback transaksi sebesar '.rupiah($disc);
                        $hp->poin_awal  = intval($us->poin);
                        $hp->poin_akhir = intval($us->poin) + $disc;
                        $hp->save();

                        $us->poin += $disc;
                        $us->save();

                        $judul = 'Cashback transaksi '.$pr->name;
                        $isi = 'Cashback pembelian produk '.$pr->name.' sebesar Rp. ' . number_format($disc, 0, ',', '.');
                        Notifikasi::create([
                            'user_id'   => $us->id,
                            'title'     => $judul,
                            'content'   => $isi,
                            'type'      => 'Transaksi',
                            'ref_id'    => $t->ref_id
                        ]);
                    }
                }

                $cekPoin = cekPoinProduk($kode);
                if($cekPoin > 0){
                    $hp = new HistoriPoin();
                    $hp->user_id    = $us->id;
                    $hp->ref_id     = $t->ref_id;
                    $hp->jenis      = 'CREDIT';
                    $hp->nominal    = $cekPoin;
                    $hp->keterangan = 'Bonus poin transaksi sebesar '.rupiah($cekPoin);
                    $hp->poin_awal  = intval($us->poin);
                    $hp->poin_akhir = intval($us->poin) + $cekPoin;
                    $hp->save();

                    $us->poin += $cekPoin;
                    $us->save();

                    $judul = 'Bonus poin transaksi '.$pr->name;
                    $isi = 'Bonus poin '.$pr->name.' sebesar Rp. ' . number_format($cekPoin, 0, ',', '.');
                    Notifikasi::create([
                        'user_id'   => $us->id,
                        'title'     => $judul,
                        'content'   => $isi,
                        'type'      => 'Transaksi',
                        'ref_id'    => $t->ref_id
                    ]);
                }
            }

            $title = 'Transaksi '.$pr->name.' '.ucwords($request->status);
            $message = $us->first_name.' transaksi produk '.$pr->name.' '.ucwords($request->status);
            $admin = Admin::where('id', 1)->first();
            if(isset($admin->fcm)){
                $fcmTokens = $admin->fcm;
                Notification::send($admin, new TrxNotif($title, $message, null, $fcmTokens, 'ADM-TRX-PPOB'));
            }

            if(isset($us->fcm)){
                $fcm = $us->fcm;
                Notification::send($us, new TrxNotif($title, $message, null, $fcm, 'TRX-PPOB'));
            }

            Mail::to($us->email)->send(new TransactionMail($us, $pr, $t));
            return true;
        }else {
            Log::info('CALLBACK IGNORED');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function callbackKlik(KlickController $klik, Request $request)
    {
        $c = $klik->callback($request);
        return $c;
    }
}
