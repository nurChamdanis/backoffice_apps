<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Users\App\Models\HistoriKoin;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Query\Builder;

class HistoriKoinController extends Controller
{
    public function getData(Request $request)
    {
        $payload = $request->all();
        // $data = DB::table("histori_koins")
        //     ->orderBy('id', 'desc')
        $data = HistoriKoin::orderBy('histori_koins.id', 'desc')
            ->join('users', 'users.id', '=', 'histori_koins.user_id')
            ->where(function (Builder $query) use ($payload) {
                if (array_key_exists("status",$payload) && count($payload["status"]) > 0) {
                    $query->whereIn("status", $payload["status"]);
                }
                if (array_key_exists("keyword",$payload) && $payload["keyword"] != null) {
                    $query->where("users.first_name",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("histori_koins.jenis",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("histori_koins.ref_id",'like','%' . $payload["keyword"] . '%');
                    $query->orWhere("histori_koins.keterangan",'like','%' . $payload["keyword"] . '%');
                }
                if (array_key_exists("reference_code",$payload) && $payload["reference_code"] != null) {
                    $query->where("ref_id",$payload["reference_code"]);
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
            ->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('name', function($row){
            $t = '<span>'.$row->user->first_name.'</span>';
            return $t;
        })
        ->addColumn('ref_id', function($row){
            $t = '<span>'.Str::upper($row->ref_id).'</span>';
            return $t;
        })
        ->addColumn('jenis', function($row){
            if($row->jenis == 'CREDIT'){
                $t = '<span class="text-success">'.$row->jenis.'</span>';
            }else {
                $t = '<span class="text-danger">'.$row->jenis.'</span>';
            }
            return $t;
        })
        ->addColumn('date', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->addColumn('nominal', function($row){
            $t = '<span><b>'.rupiah($row->nominal).'</b></span>';
            return $t;
        })
        ->addColumn('awal', function($row){
            $t = '<span>'.rupiah(intval($row->koin_awal)).'</span>';
            return $t;
        })
        ->addColumn('akhir', function($row){
            $t = '<span>'.rupiah(intval($row->koin_akhir)).'</span>';
            return $t;
        })
        ->addColumn('keterangan', function($row){
            $t = '<span>'.$row->keterangan.'</span>';
            return $t;
        })
        ->rawColumns(['name', 'ref_id', 'jenis', 'date', 'nominal', 'awal', 'akhir', 'keterangan'])
        ->make();

        return $dt;
    }

    public function index()
    {
        return view('admin::histori.koin');
    }
}
