<?php

namespace Modules\Transaksi\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Users\App\Models\Deposit;
use Yajra\DataTables\Facades\DataTables;

class RiwayatTrfSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi::transfer_saldo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi::topup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('transaksi::topup.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('transaksi::topup.edit');
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


    public function getData()
    {
        $data = DB::table("disbursement")
            ->join('users', 'users.id', '=', 'disbursement.user_id')
            ->selectRaw("
                disbursement.ref_id,
                disbursement.user_id,
                users.first_name as `username`,
                users.phone as `phone`,
                users.saldo,
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
            ->where('disbursement.status', 'SUCCESS')
            ->where('disbursement.bank_code', 'BILPAY')
            ->orderBy('disbursement.updated_at', 'desc')
            ->limit(5000)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $dt =  DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('username', function($row){
                $t = '<span>'.$row->username.' - '.$row->phone.'</span>';
                return $t;
            })
            ->addColumn('ref_id', function($row){
                $t = '<span>'.Str::upper($row->ref_id).'</span>';
                return $t;
            })
            ->addColumn('nominal', function($row){
                $t = '<span>'.rupiah($row->nominal).'</span>';
                return $t;
            })
            ->addColumn('tujuan', function($row){
                $t = '<span>'.$row->tujuan.'</span>';
                return $t;
            })
            ->addColumn('current_balance', function($row){
                $t = '<span>'.$row->saldo.'</span>';
                return $t;
            })
            ->addColumn('status', function($row){
                if($row->status == 'INQUIRY'){
                    $t = '<span class="text-warning">'.Str::upper($row->status).'</span>';
                }else if($row->status == 'PENDING'){
                    $t = '<span class="text-grey">'.Str::upper($row->status).'</span>';
                }else {
                    $t = '<span class="text-success">'.Str::upper($row->status).'</span>';
                }

                return $t;
            })
            ->addColumn('trx_date', function($row){
                $t = '<span>'.$row->created_at.'</span>';
                return $t;
            })
            ->rawColumns([
                'username',
                'ref_id',
                'nominal',
                'status',
                'trx_date',
                'current_balance'
            ])
            ->make();

        return $dt;

    }
}
