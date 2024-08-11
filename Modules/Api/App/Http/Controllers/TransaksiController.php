<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\PPOB\App\Http\Controllers\PPOBController;
use Modules\Produk\App\Models\Produk;
use Modules\Transaksi\App\Http\Controllers\MutasiHistoryController;
use Modules\Transaksi\App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function createTransaction(Request $request, PPOBController $ppob)
    {
        $t = $ppob->transaksiPrabayar($request);
        return $t;
    }

    public function inquiry(Request $request, PPOBController $ppob)
    {
        $t = $ppob->inquiryTagihan($request);
        return $t;
    }

    public function cekStatus(Request $request)
    {
        $tr = Transaksi::where('ref_id', $request->ref_id)->first();
        if(isset($tr)){

            $pr = Produk::where('code', $tr->produk_id)->first();
            $us = User::where('id', $tr->user_id)->first();

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

            return successResponse('Transaksi '. ucwords($tr->status), $data);
        }else {
            return errorResponApi('Transaksi tidak ditemukan', 422);
        }
    }

    public function mutasiSaldo(Request $request)
    {
        $deposits = DB::table("deposits")
            ->join('users', 'users.id', '=', 'deposits.user_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'deposits.payment_id')
            ->selectRaw("
                deposits.ref_id,
                deposits.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                deposits.nominal,
                deposits.va_number as `tujuan`,
                deposits.created_at,
                deposits.updated_at,
                deposits.status,
                payment_methods.description as `desc`,
                payment_methods.code as `code`,
                'credit' as `type`,
                'Top Up Saldo' as `jenis`
            ")
            ->where('deposits.user_id', userId())
            ->orderBy('deposits.updated_at', 'desc')
            ->limit(5000);

        $transferBilpay = DB::table("deposits")
            ->join('users', 'users.id', '=', 'deposits.user_id')
            ->selectRaw("
                deposits.ref_id,
                deposits.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                deposits.nominal,
                deposits.va_number as `tujuan`,
                deposits.created_at,
                deposits.updated_at,
                deposits.status,
                'Bilpay Account' as `desc`,
                'Transfer' as `code`,
                'credit' as `type`,
                'Transfer Bilpay' as `jenis`
            ")
            ->where('deposits.payment_id', 0)
            ->where('deposits.status', 'SUCCESS')
            ->where('deposits.user_id', userId())
            ->orderBy('deposits.updated_at', 'desc')
            ->limit(5000);

        $disbursements = DB::table("disbursement")
            ->join('users', 'users.id', '=', 'disbursement.user_id')
            ->selectRaw("
                disbursement.ref_id,
                disbursement.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                disbursement.nominal,
                disbursement.account_number as `tujuan`,
                disbursement.created_at,
                disbursement.updated_at,
                disbursement.status,
                disbursement.account_holder_name as `desc`,
                disbursement.bank_code as `code`,
                'debit' as `type`,
                'Instan Transfer' as `jenis`
            ")
            ->where('disbursement.user_id', userId())
            ->orderBy('disbursement.updated_at', 'desc')
            ->limit(5000);

        $histKoin = DB::table("histori_koins")
            ->join('users', 'users.id', '=', 'histori_koins.user_id')
            ->selectRaw("
                histori_koins.ref_id,
                histori_koins.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                histori_koins.nominal,
                users.phone as `tujuan`,
                histori_koins.created_at,
                histori_koins.updated_at,
                'SUCCESS' as `status`,
                histori_koins.keterangan as `desc`,
                'TUKAR_KOIN' as `code`,
                histori_koins.jenis as `type`,
                'Tukar Koin' as `jenis`
            ")
            ->where('histori_koins.user_id', userId())
            ->orderBy('histori_koins.updated_at', 'desc')
            ->limit(5000);

        $histPoin = DB::table("histori_poins")
            ->join('users', 'users.id', '=', 'histori_poins.user_id')
            ->selectRaw("
                histori_poins.ref_id,
                histori_poins.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                histori_poins.nominal,
                users.phone as `tujuan`,
                histori_poins.created_at,
                histori_poins.updated_at,
                'SUCCESS' as `status`,
                histori_poins.keterangan as `desc`,
                'POIN' as `code`,
                histori_poins.jenis as `type`,
                'POIN' as `jenis`
            ")
            ->where('histori_poins.user_id', userId())
            ->orderBy('histori_poins.updated_at', 'desc')
            ->limit(5000);

        $data = DB::table("transactions")
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->selectRaw("
                transactions.ref_id,
                transactions.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                transactions.harga as `nominal`,
                transactions.tujuan,
                transactions.created_at,
                transactions.updated_at,
                transactions.status,
                transactions.sn as `desc`,
                transactions.produk_id as `code`,
                'debit' as `type`,
                'Pembelian/Pembayaran' as `jenis`
            ")
            ->limit(5000)
            ->union($deposits)
            ->union($disbursements)
            ->union($transferBilpay)
            ->union($histKoin)
            ->union($histPoin)
            ->where('transactions.user_id', userId())
            ->orderBy('updated_at', 'desc')
            ->get();

        return successResponse('Berhasil', $data);
    }
}
