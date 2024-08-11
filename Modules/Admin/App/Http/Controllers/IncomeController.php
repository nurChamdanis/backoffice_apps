<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Admin\App\Models\Margin;
use Modules\Klick\App\Http\Controllers\KlickController;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    public function index()
    {
        $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        $dateE = Carbon::now()->endOfMonth();

        $kl = new KlickController();
        $klk = $kl->cekSaldo();

        $nk = detailNukar();
        if($nk->error == false){
            $nukar = $nk->data->saldo->value;
        }else {
            $nukar = 0;
        }

        if(isset($klk[0]->message)){
            if($klk[0]->message == 'Success'){
                $klik = $klk[0]->data->balance;
            }else {
                $klik = 0;
            }
        }else {
            $klik = 0;
        }

        $income = Margin::where(['posted' => 1])->whereBetween('created_at',[$dateS, $dateE])->sum('value');
        return view('admin::income.index', compact('income', 'dateS', 'dateE', 'nukar', 'klik'));
    }

    public function getData(Request $request)
    {

        $payload = $request->all();
        $data = Margin::with('produk')
            ->where(function (Builder $query) use ($payload) {

                if (array_key_exists("name", $payload) && $payload["name"] != null) {
                    $query->orWhereHas("produk", function($q) use($payload){
                        $q->where('name', 'like','%' . $payload["name"] . '%');
                    });
                }

                if (array_key_exists("typeTrx",$payload) && $payload["typeTrx"] != null) {
                    $query->where("type", 'like', '%'. $payload["typeTrx"].'%');
                }
                
                if (array_key_exists("date_range",$payload)
                    && count($payload["date_range"]) == 2
                    && $payload["date_range"][0] != null
                    && $payload["date_range"][1] != null ) {
                    $query->whereBetween("created_at", $payload["date_range"]);
                }
            })
            ->orderBy('id', 'desc')
            ->get();


        // dd($data);
        $dt =  DataTables::of($data)
        ->addIndexColumn()

        ->addColumn('ref_id', function($row){
            $t = '<span>'.Str::upper($row->ref_id).'</span>';
            return $t;
        })
        ->addColumn('produk_id', function($row){
            if(isset($row->produk_id) && isset($row->produk->name) && $row->produk != null){
                $t = '<span>'.$row->produk_id.' <span> - '.$row->produk->name.'</span> </span>';
            }else {
                $t = '<span>'.$row->produk_id.'</span>';
            }
            return $t;
        })
        ->addColumn('value', function($row){
            $t = '<span>'.rupiah($row->value).'</span>';
            return $t;
        })
        ->addColumn('posted', function($row){
            if($row->posted == true){
                $t = '<span class="text-info">TRUE</span>';
            }else {
                $t = '<span class="text-danger">FALSE</span>';
            }
            return $t;
        })
        ->addColumn('type', function($row){
            $t = '<span>'.$row->type.'</span>';
            return $t;
        })
        ->addColumn('date', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->rawColumns(['ref_id', 'produk_id', 'value', 'posted', 'type', 'date'])
        ->make();

        return $dt;
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('admin::show');
    }

    public function edit($id)
    {
        return view('admin::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
