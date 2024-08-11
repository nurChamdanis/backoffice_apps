<?php

namespace Modules\PPOB\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\TrxNotif;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Modules\Admin\App\Models\Margin;
use Modules\Produk\App\Models\Produk;
use Modules\Setting\App\Models\Setting;
use Modules\Transaksi\App\Models\Transaksi;
use Modules\Users\App\Models\HistoriKoin;
use Modules\Users\App\Models\HistoriPoin;
use Modules\Users\App\Models\Notifikasi;

class PPOBController extends Controller
{
    public function transaksiPrabayar(Request $request)
    {
        $request->validate([
            'code'          => ['required'],
            'id_pelanggan'  => ['required'],
            'pin'           => ['required'],
            'prabayar'      => ['boolean', 'required'],
            'use_poin'      => ['boolean', 'required'],
            'use_koin'      => ['boolean', 'required'],
            'ref_id'        => ['nullable'],
        ]);
        try {
            $code   = $request->code;
            $idPel  = $request->id_pelanggan;
            $pin    = $request->pin;
            $type   = $request->prabayar;
            $usPoin = $request->use_poin;
            $usKoin = $request->use_koin;

            $tj = Str::replace('(', '', $idPel);
            $tujuan = Str::replace(')', '', $tj);
            $ref_id = Str::upper(Str::random(12));

            $val = Setting::where('key', 'maintnance_mode')->first();
            $mode = json_decode($val->value);


            if(isset($mode)){

                if ($mode->mode == 'on') {
                    return errorResponApi('Sedang dalam pemeliharaan', 422);

                }else {

                    $us = User::find(userId());
                    $pr = Produk::where('code', $code)->first();
                    $kode = $pr->code;
        
                    $cekPin = Hash::check($pin, $us->pin);
                    if($cekPin){

                        if($usPoin == true){
                            $nom = intval($us->saldo) + intval($us->poin); 
                        }else {
                            $nom = $us->saldo;
                        }

                        if($usKoin == true){
                            
                            if(intval($us->koin) <= $pr->sale_price){
                                return errorResponApi('Koin tidak mencukupi', 422);
                            }else {
                                $nom = intval($us->koin);
                            }
                        }

                        if($nom >= limitTransaksi()){
                            return errorResponApi('Limit transaksi telah mencapai batas', 422);
                        }

                        $price = $type == true ? $pr->sale_price : ''; 
                        if($nom >= $pr->sale_price){

                            $tk = new HistoriPoin();

                            if($usKoin == true && $us->koin >= $pr->sale_price){
                                $us->koin -= $pr->sale_price;
                                $judul = 'Pembelian Dengan Koin';
                                $isi = 'Koin sebesar ' . number_format($pr->sale_price, 0, ',', '.') . ' berhasil di tukar untuk pembelian '.$pr->name;
                                Notifikasi::create([
                                    'user_id'   => userId(),
                                    'title'     => $judul,
                                    'content'   => $isi,
                                    'type'      => 'Tukar Poin',
                                    'ref_id'    => $ref_id
                                ]);
                            }else {
                                $myPoin = intval($us->poin);
                                if($myPoin >= $pr->sale_price){
                                    $payerPoin = intval($myPoin) - intval($pr->sale_price);
                                    $us->poin -= intval($pr->sale_price);
                                    $isi = 'Poin sebesar ' . number_format($pr->sale_price, 0, ',', '.') . ' berhasil di tukar untuk pembelian '.$pr->name;
                                    
                                }else if($myPoin <= $pr->sale_price){
                                    $payerPoin = intval($us->poin);

                                    $payWtPoin = intval($pr->sale_price) - $payerPoin;
                                    $us->saldo -= $usPoin == true ? $payWtPoin : $pr->sale_price;
                                    $us->poin  -= $usPoin == true ? $payerPoin : 0;
                                    $isi = 'Poin sebesar ' . number_format($payerPoin, 0, ',', '.') . ' berhasil di tukar untuk pembelian '.$pr->name;
                                }


                                $judul = 'Pembelian Dengan Poin';
                                Notifikasi::create([
                                    'user_id'   => userId(),
                                    'title'     => $judul,
                                    'content'   => $isi,
                                    'type'      => 'Tukar Poin',
                                    'ref_id'    => $ref_id
                                ]);
                            }

                            if($usPoin == true){
                                $nomPoin = $myPoin >= $pr->sale_price ? $pr->sale_price :  $payerPoin;
                                $tk->user_id    = $us->id;
                                $tk->ref_id     = $ref_id;
                                $tk->jenis      = 'DEBIT';
                                $tk->nominal    = $nomPoin;
                                $tk->keterangan = 'Pembayaran dengan poin sebesar '.rupiah($nomPoin);
                                $tk->poin_awal  = intval($us->poin) + $nomPoin;
                                $tk->poin_akhir = intval($us->poin);
                                $tk->save();
                            }
            
                            if($type == true){
                                $us->save();
                                $d = urlTrxNukar($code, $tujuan);
                            }else {
                                $d = urlTrxPascaNukar($request->ref_id); 
                            }

                            if(isset($d[0]->data)){

                                if($type == true){
                                    $status = $d[0]->status;
                                }else {
                                    $status = $d[0]->error == false ? true : false;

                                    $us->saldo += $d[0]->data[0]->harga;
                                    $us->save();
                                }

                                if($status){
                    
                                    $resp = $type == true ?  $d[0]->data : $d[0]->data[0];
    
                                    $cekPromo = cekPromo($kode);
                                    if($cekPromo){

                                        $disc = intval($pr->sale_price) * $pr->discount / 100;
                                        if($pr->margin >= $disc){
                                            $margin = intval($pr->margin) - $disc;
                                        }else {
                                            $margin = $pr->margin;
                                        }
                                    }else {
                                        $margin = $pr->margin;
                                    }

                                    $tr = new Transaksi();
                                    $tr->user_id    = $us->id;
                                    $tr->produk_id  = $pr->code;
                                    $tr->ref_id     = $ref_id;
                                    $tr->seller_ref = $resp->ref_id;
                                    $tr->invoice    = invoice();
                                    $tr->tujuan     = $tujuan;
                                    $tr->status     = Str::upper($resp->status);
                                    $tr->sn         = $resp->sn;
                                    $tr->harga      = $type == true ? $pr->sale_price : $resp->harga;
                                    $tr->margin     = $margin;
                                    $tr->desc       = '';
                                    $tr->flag       = '';
                                    $tr->tipe       = $type == 1 ? 'Prabayar' : 'Pascabayar';
                                    $tr->save();

                                    $mr = new Margin();
                                    $mr->ref_id     = $ref_id;
                                    $mr->produk_id  = $pr->code;
                                    $mr->value      = $margin;
                                    $mr->type       = 'PEMBELIAN_PEMBAYARAN';
                                    $mr->posted     = false;
                                    $mr->save();

                                    $judul = 'Pembelian '.$pr->name;
                                    $isi = 'Pembelian '.$pr->name.' sebesar Rp. ' . number_format($pr->sale_price, 0, ',', '.') . ' sedang di proses.';
                                    Notifikasi::create([
                                        'user_id'   => userId(),
                                        'title'     => $judul,
                                        'content'   => $isi,
                                        'type'      => 'Transaksi',
                                        'ref_id'    => $ref_id
                                    ]);
    
                                    $data = array(
                                        'produk_id'      => $pr->code, 
                                        'produk_name'    => $pr->name, 
                                        'username'       => $us->name, 
                                        'user_id'        => $us->id, 
                                        'ref_id'         => $tr->ref_id, 
                                        'invoice'        => $tr->invoice, 
                                        'tujuan'         => $tr->tujuan, 
                                        'harga'          => $tr->harga, 
                                        'status'         => $tr->status, 
                                        'serial_number'  => $tr->sn, 
                                        'description'    => $tr->desc, 
                                        'type_trx'       => $tr->tipe, 
                                        'date_trx'       => $tr->created_at, 
                                    );

                                    $title = 'Transaksi '.$pr->name;
                                    $message = $us->first_name.' transaksi produk '.$pr->name.' sebesar '.$tr->harga;
                                    $admin = Admin::where('id', 1)->first();
                                    if(isset($admin->fcm)){
                                        $fcmTokens = $admin->fcm;
                                        Notification::send($admin, new TrxNotif($title, $message, null, $fcmTokens, 'TRX-PREPAID'));
                                    }
    
                                    return successResponse('Transaksi Berhasil', $data);
                                }else {
                                    return errorResponApi($d->message, 422);
                                }
                            }else {

                                return errorResponApi($d[0]->message, 422);
                            }
                        }else {
                            return errorResponApi('Saldo tidak mencukupi', 422);
                        }
                    }else {
                        return errorResponApi('PIN Anda Salah!!', 422);
                    }
                }
            }else {

                return errorResponApi('Sedang dalam pemeliharaan', 422);
            }

        } catch (BadResponseException $ex) {

            $response = $ex->getResponse();
            $jsonBody = (string) $response->getBody();
            return json_decode($jsonBody);
        }
    }

    public function inquiryTagihan(Request $request)
    {
        $code   = $request->code;
        $idPel  = $request->id_pelanggan;
        $tj = Str::replace('(', '', $idPel);
        $tujuan = Str::replace(')', '', $tj);
        $p = Produk::where('code', $code)->first();

        if(isset($p)){

            $d = urlInquiryNukar($code, $tujuan);
            $resp = $d->data;
            if(isset($resp->status)){

                $data = array(
                    "ref_id"        => $resp->ref_id,
                    "no_tujuan"     => $tujuan,
                    "customer_name" => $resp->customer_name,
                    "kode_produk"   => $resp->kode_produk,
                    "admin"         => $p->sale_price,
                    "tagihan"       => $resp->harga_jual,
                    "total"         => intval($resp->harga_jual) + intval($p->sale_price),
                    "status"        => Str::upper($resp->status),
                    "detail"        => $resp->detail
                );

                return $data;
            }else {

                return errorResponApi('Tagihan tidak ditemukan', 422);

            }
        }else {
            return errorResponApi('Produk belum tersedia', 422);
        }
    }

    public function cekIdPelangganPLN(Request $request)
    {
        $idPel  = $request->id_pel;
        $tj = Str::replace('(', '', $idPel);
        $tujuan = Str::replace(')', '', $tj);

        $d = cekIdPln($tujuan);
        if($d->data->subscriber_id != ""){
            return $d->data;
        }else {

            return errorResponApi('ID Pelanggan tidak ditemukan', 422);

        }
    }
}
