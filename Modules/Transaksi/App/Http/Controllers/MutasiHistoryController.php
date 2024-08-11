<?php

namespace Modules\Transaksi\App\Http\Controllers;

use App\Exports\MutasiExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Query\Builder;

class MutasiHistoryController extends Controller
{
    public function index()
    {
        return view('transaksi::mutasi.index');
    }

    public function getData(Request $request)
    {
        $payload = $request->all();
        $deposits = DB::table("deposits")
            ->join('users', 'users.id', '=', 'deposits.user_id')
            ->join('payment_methods', 'payment_methods.id', '=', 'deposits.payment_id')
            ->selectRaw("
                deposits.id,
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
            ->where(function (Builder $query) use ($payload) {
                if (array_key_exists("status",$payload) && count($payload["status"]) > 0) {
                    $query->whereIn("deposits.status", $payload["status"]);
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("users.phone",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("payment_methods.code",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("deposits.va_number",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("payment_methods.description",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("deposits.ref_id",'like','%' . $payload["keyword"] . '%');
                }
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("deposits.ref_id",$payload["reference_code"]);
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["name"] . '%');
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("deposits.updated_at", $payload["date_range"]);
                }
            })
            ->where('deposits.status', 'SUCCESS')
            ->orderBy('deposits.updated_at', 'desc')
            ->limit(5000);

        $transferBilpay = DB::table("deposits")
            ->join('users', 'users.id', '=', 'deposits.user_id')
            ->selectRaw("
                deposits.id,
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
            ->where(function (Builder $query) use ($payload){
                if (array_key_exists("status",$payload) && count($payload["status"]) > 0) {
                    $query->whereIn("deposits.status", $payload["status"]);
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("users.phone",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("deposits.va_number",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("deposits.ref_id",'like','%' . $payload["keyword"] . '%');
                }
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("deposits.ref_id",$payload["reference_code"] );
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["name"] . '%');
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("deposits.updated_at", $payload["date_range"]);
                }
            })
            ->where('deposits.status', 'SUCCESS')
            ->orderBy('deposits.updated_at', 'desc')
            ->limit(5000);

        $disbursements = DB::table("disbursement")
            ->join('users', 'users.id', '=', 'disbursement.user_id')
            ->selectRaw("
                disbursement.id,
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
            ->where(function (Builder $query) use ($payload){
                if (array_key_exists("status",$payload) && count($payload["status"]) > 0) {
                    $query->whereIn("disbursement.status", $payload["status"]);
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("users.phone",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("disbursement.account_number",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("disbursement.account_holder_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("disbursement.bank_code",'like','%' . $payload["keyword"] . '%');
                }
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("disbursement.ref_id",$payload["reference_code"] );
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["name"] . '%');
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("disbursement.updated_at", $payload["date_range"]);
                }
            })
            ->where('disbursement.status', 'SUCCESS')
            ->orderBy('disbursement.updated_at', 'desc')
            ->limit(5000);

        $histKoin = DB::table("histori_koins")
            ->join('users', 'users.id', '=', 'histori_koins.user_id')
            ->selectRaw("
                histori_koins.id,
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
            ->where(function (Builder $query) use ($payload) {
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("histori_koins.ref_id",$payload["reference_code"] );
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("users.phone",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("histori_koins.keterangan",'like','%' . $payload["keyword"] . '%');
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["name"] . '%');
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("histori_koins.updated_at", $payload["date_range"]);
                }
            })
            ->orderBy('histori_koins.updated_at', 'desc')
            ->limit(5000);

        $histPoin = DB::table("histori_poins")
            ->join('users', 'users.id', '=', 'histori_poins.user_id')
            ->selectRaw("
                histori_poins.id,
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
            ->where(function (Builder $query) use ($payload){
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("histori_poins.ref_id",$payload["reference_code"]);
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("users.phone",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("histori_poins.keterangan",'like','%' . $payload["keyword"] . '%');
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["name"] . '%');
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("histori_poins.updated_at", $payload["date_range"]);
                }
            })
            ->orderBy('histori_poins.updated_at', 'desc')
            ->limit(5000);

        $data = DB::table("transactions")
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->selectRaw("
                transactions.id,
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
            ->where(function (Builder $query) use ($payload) {
                if (array_key_exists("status",$payload) && count($payload["status"]) > 0) {
                    $query->whereIn("transactions.status", $payload["status"]);
                }
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("transactions.ref_id",$payload["reference_code"] );
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["name"] . '%');
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("transactions.updated_at", $payload["date_range"]);
                }
            })
            ->whereIn('transactions.status', ['SUCCESS', 'SUKSES'])
            ->limit(5000)
            ->union($deposits)
            ->union($disbursements)
            ->union($transferBilpay)
            ->union($histKoin)
            ->union($histPoin)
            ->orderBy('id', 'desc')
            ->get();


        $dt =  DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('ref_id', function($row){
                $t = '<div class="user-card">
                    <div class="user-info">
                        <span class="tb-lead"><b>'.Str::upper($row->ref_id).'</b></span> <br/>
                        <span>'.$row->updated_at.'</span>
                    </div>
                </div>';
                return $t;
            })
            ->addColumn('sumber', function($row){
                $t = '<div>
                    <span><b>'.$row->phone.'</b></span><br/>
                    <span>'.Str::limit($row->username, 20, '...').'</span><br/>
                </div>';
                return $t;
            })
            ->addColumn('tujuan', function($row){
                $t = '<div>
                    <span>'.$row->code.' - '.Str::limit($row->tujuan, 20, '...').'</span><br/>
                    <span>'.Str::limit($row->desc, 50, '...').'</span><br/>
                </div>';
                return $t;
            })
            ->addColumn('nominal', function($row){
                $t = '<span>'.rupiah($row->nominal).'</span>';
                return $t;
            })
            ->addColumn('trx_date', function($row){
                $t = '<span>'.$row->updated_at.'</span>';
                return $t;
            })
            ->addColumn('type', function($row){
                if($row->type == 'debit'){
                    $t = '<div>
                        <span>'.$row->jenis.'</span><br/>
                        <span class="text-danger">'.Str::upper($row->type).'</span>
                    </div>';
                }else {
                    $t = '<div>
                        <span>'.$row->jenis.'</span><br/>
                        <span class="text-success">'.Str::upper($row->type).'</span>
                    </div>';
                }
                return $t;
            })
            ->addColumn('jenis', function($row){
                $t = '<span>'.$row->jenis.'</span>';
                return $t;
            })
            ->addColumn('status', function($row){
                switch ($row->status) {
                    case 'INQUIRY':
                        $t = '<span class="text-warning">'.Str::upper($row->status).'</span>';
                        return $t;
                        break;

                    case 'SUCCESS':
                        $t = '<span class="text-success">'.Str::upper($row->status).'</span>';
                        return $t;
                        break;

                    case 'SUKSES':
                        $t = '<span class="text-success">'.Str::upper($row->status).'</span>';
                        return $t;
                        break;

                    case 'GAGAL':
                        $t = '<span class="text-danger">'.Str::upper($row->status).'</span>';
                        return $t;
                        break;

                    case 'FAILED':
                        $t = '<span class="text-danger">'.Str::upper($row->status).'</span>';
                        return $t;
                        break;

                    case 'PENDING':
                        $t = '<span class="text-warning">'.Str::upper($row->status).'</span>';
                        return $t;
                        break;
                }
            })
            ->rawColumns([
                'ref_id',
                'sumber',
                'tujuan',
                'nominal',
                'trx_date',
                'type',
                'jenis',
                'status',
            ])
            ->make();

        return $dt;

    }

    public function export(Request $request)
    {
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

        return Excel::download(new MutasiExport($start, $end), now() . '-data-mutasi.xlsx');
    }
}
