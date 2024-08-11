<?php

namespace Modules\Transaksi\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Str;
use Modules\Users\App\Models\Deposit;
use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;


class TopupHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi::topup.index');
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

    public function getData(Request $request)
    {
        $payload = $request->all();
        $data = Deposit::orderBy('deposits.id', 'desc')
            ->with('user', 'metod')
            ->where('payment_id', '!=', 0)
            ->where(function (Builder $query) use ($payload) {
                if (array_key_exists("status",$payload) && count($payload["status"]) > 0) {
                    $query->whereIn("status", $payload["status"]);
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->orWhere("deposits.va_number",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("deposits.ref_id",'like','%' . $payload["keyword"] . '%');

                    $query->orWhereHas('user', function($q) use($payload){
                        $q->where('first_name', 'like','%' . $payload["keyword"] . '%');
                    });

                    $query->orWhereHas('user', function($q) use($payload){
                        $q->where('phone', 'like','%' . $payload["keyword"] . '%');
                    });

                    $query->orWhereHas('metod', function($q) use($payload){
                        $q->where('description', 'like','%' . $payload["keyword"] . '%');
                    });

                    $query->orWhereHas('metod', function($q) use($payload){
                        $q->where('code', 'like','%' . $payload["keyword"] . '%');
                    });
                }
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("ref_id",$payload["reference_code"]);
                }
                if (array_key_exists("name",$payload) && $payload["name"] != null) {
                    $query->whereHas('user', function($q) use($payload){
                        $q->where('first_name', 'like','%' . $payload["keyword"] . '%');
                    });
                }
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("deposits.updated_at", $payload["date_range"]);
                }
            })
            ->limit(1000)
            ->get();

        $dt =  DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="btn btn-warning btn-sm btn-cek">Cek Status</a>';
                return $actionBtn;
            })
            ->addColumn('username', function($row){
                $t = '<span>'.$row->user->first_name.'</span>';
                return $t;
            })
            ->addColumn('order_id', function($row){
                $t = '<span>'.$row->order_id.'</span>';
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
            ->addColumn('fee', function($row){
                $t = '<span>'.rupiah($row->fee).'</span>';
                return $t;
            })
            ->addColumn('total_payment', function($row){
                $t = '<span>'.rupiah($row->total_payment).'</span>';
                return $t;
            })
            ->addColumn('va_number', function($row){
                $t = '<span>'.$row->va_number.'</span>';
                return $t;
            })
            ->addColumn('status', function($row){
                if($row->status == 'INQUIRY'){
                    $t = '<span class="text-warning">'.Str::upper($row->status).'</span>';
                }else if($row->status == 'PENDING'){
                    $t = '<span class="text-grey">'.Str::upper($row->status).'</span>';
                }else if($row->status == 'FAILED'){
                    $t = '<span class="text-danger">'.Str::upper($row->status).'</span>';
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
                'action',
                'username',
                'order_id',
                'ref_id',
                'nominal',
                'fee',
                'total_payment',
                'status',
                'trx_date'
            ])
            ->make();

        return $dt;

    }


}
