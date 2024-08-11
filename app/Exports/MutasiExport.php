<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MutasiExport implements FromView
{
    protected $start;
    protected $end;

    function __construct( $start, $end) {
        $this->start    = $start;
        $this->end      = $end;
    }

    public function view(): View
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
            ->orderBy('deposits.created_at', 'desc')
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
            ->orderBy('disbursement.created_at', 'desc')
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
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('transaksi::export.mutasi',compact('data'));
    }
}
