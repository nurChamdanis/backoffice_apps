<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\TrxNotif;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\Klick\App\Http\Controllers\KlickController;
use Modules\Setting\App\Models\Setting;
use Modules\Transaksi\App\Http\Controllers\TopupHistoryController;
use Modules\Transaksi\App\Http\Controllers\TransaksiController;
use Modules\Users\App\Models\Deposit;
use Modules\Users\App\Models\Notifikasi;
use Modules\Users\App\Models\PaymentMethod;

class TopupController extends Controller
{
    public function listBank(Request $request)
    {
        $d = PaymentMethod::orderBy('id', 'desc')->get();
        $bank = array();
        foreach ($d as $item) {

            $col["id"]            = $item->id;
            $col["code"]          = $item->code;
            $col["swift"]         = $item->swift_code;
            $col["description"]   = $item->description;
            $col["type"]          = $item->type;
            $col["status"]        = $item->status;
            $col["logo"]          = getOss('source/' . $item->icon);

            $bank[] = $col;
        }

        $collection = collect($bank);
        $grouped = $collection->groupBy('type');

        return successResponse('Sukses', $grouped);
    }

    public function create(Request $request, KlickController $klik)
    {
        $ref_id         = 'BLPTP'.Str::upper(Str::random(12));
        $code           = $request->kode_bank;
        $bank           = PaymentMethod::where('code', $code)->first();
        if (!$bank) {
            return response()->json([
                'error' => true,
                'data' => 'Kode pembayaran tidak tersedia (rc:0028)',
            ]);
        }

        $nominal        = intval($request->nominal);
        $cekDep = Deposit::where(['user_id' => userId(), 'status' => 'PROCCESS'])->get()->count('id');
        if ($cekDep > 10) {
            return response()->json([
                'error' => true,
                'data' => 'Request top up Anda telah mencapai limit harian (rc:0027)',
            ]);
        } else {

            if ($nominal > minimalTopup()) {

                if ($nominal > limitTransaksi()) {

                    return errorResponApi('Limit deposit Anda telah mencapai batas (rc:0029)', 422);
                }

                $user = Auth::user();
                if($user->status == 'ACTIVE'){

                    $k = $klik->createVa($nominal, $code);
                    // return $k;
                    if($k->data->rc != "00"){
                        return errorResponApi($k->data->message, 422);
                    }else {

                        $kRespon = $k->data->data;

                        $tp = new Deposit();
                        $tp->user_id        = userId();
                        $tp->payment_id     = $bank->id;
                        $tp->order_id       = rand(1111111111, 9999999999);
                        $tp->ref_id         = $ref_id;
                        $tp->nominal        = $nominal;
                        $tp->fee            = 0;
                        $tp->total_payment  = $kRespon->amount;
                        $tp->va_number      = $kRespon->va_number;
                        $tp->expired        = $kRespon->expired_at;
                        $tp->status         = 'PENDING';
                        $tp->save();

                        $judul = 'Top up saldo';
                        $isi = 'Top up saldo sebesar Rp. ' . number_format($nominal, 2, ',', '.') . ' sedang di proses.';
                        Notifikasi::create([
                            'user_id'   => userId(),
                            'title'     => $judul,
                            'content'   => $isi,
                            'type'      => 'Topup',
                            'ref_id'    => $ref_id
                        ]);

                        $title = 'Deposit Saldo';
                        $admin = Admin::where('id', 1)->first();
                        if(isset($admin->fcm)){
                            $fcmTokens = $admin->fcm;
                            Notification::send($admin, new TrxNotif($title, $isi, null, $fcmTokens, 'DEPOSIT'));
                        }

                        $data[] = array(
                            'status'        => true,
                            'message'       => $k->data->message,
                            'data'          => $tp,
                            'payment_url'   => '-',
                            'desc'          => $kRespon->status,
                        );

                        return $data;
                    }
                }else {
                    return errorResponApi('Maaf, Akun Anda Belum Aktif', 422);
                }

            }else {

                return errorResponApi('Nominal kurang dari ' . intval(minimalTopup() + 1), 422);
            }
        }
    }

    public function cekStatusDeposit(Request $request)
    {
        $dt = Deposit::where('ref_id', $request->ref_id)->with('metod')->first();
        $data = array(
            "order_id"      => $dt->order_id,
            "ref_id"        => $dt->ref_id,
            "nominal"       => $dt->nominal,
            "fee"           => $dt->fee,
            "total_payment" => $dt->total_payment,
            "va_number"     => $dt->va_number,
            "expired"       => $dt->expired,
            "status"        => $dt->status,
            "updated_at"    => $dt->updated_at,
            "created_at"    => $dt->created_at,
            "payment_name"  => $dt->metod->description,
            "payment_code"  => $dt->metod->code,
            "payment_type"  => $dt->metod->type,
            "icon"          => $dt->metod->icon
        );
        return successResponse('Berhasil', $data);
    }

    public function historiDeposit(Request $request, TopupHistoryController $trx)
    {
        $d = Deposit::where('user_id', userId())
            ->where('payment_id', '!=', 0)
            ->orderBy('id', 'desc')
            ->with('payment')->limit(5000)->get();
            
        $data = [];
        foreach ($d as $key => $item) {
            $col['id'] = $item->id;
            $col['ref_id'] = $item->ref_id;
            $col['order_id'] = $item->order_id;
            $col['payment_id'] = $item->payment_id;
            $col['payment_name'] = $item->payment->description;
            $col['payment_code'] = $item->payment->code;
            $col['payment_type'] = $item->payment->type;
            $col['payment_icon'] = $item->payment->icon;
            $col['nominal'] = $item->nominal;
            $col['fee'] = $item->fee;
            $col['total'] = $item->total;
            $col['expired'] = $item->expired;
            $col['status'] = $item->status;
            $col['created_at'] = $item->created_at;
            $col['va_number'] = $item->va_number;

            $data[] = $col;
        }
        return successResponse('Berhasil', $data);
    }
}
