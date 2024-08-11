<?php

namespace Modules\Users\App\Http\Controllers;

use App\Exports\UsersListExport;
use App\Exports\UsersViewExport;
use App\Http\Controllers\Controller;
use App\Imports\BalanceImport;
use App\Imports\UserImport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Users\App\Models\Deposit;
use Modules\Users\App\Models\HistoriKoin;
use Modules\Users\App\Models\HistoriPoin;
use Modules\Users\App\Models\Notifikasi;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function getData()
    {
        $data = User::where('plan_id', '!=', 2)->orderBy('id', 'desc')->with('card')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = view('users::components.right-action', [
                'delete' => route('members.destroy', [$row->id]),
                'class' => 'btn-edit-tooltip',
                'editAdj' => route('layouts.adjustSaldo', [$row->id]),
                'resetLink' => '',
            ]);
            return $actionBtn;
        })
        ->addColumn('code', function($row){
            $t = '<span>'.$row->code.'</span>';
            return $t;
        })
        ->addColumn('name', function($row){
            $t = '<span>'.$row->first_name.'</span>';
            return $t;
        })
        ->addColumn('phone', function($row){
            $t = '<span>'.$row->phone.'</span>';
            return $t;
        })
        ->addColumn('email', function($row){
            $t = '<span>'.$row->email.'</span>';
            return $t;
        })
        ->addColumn('balance', function($row){
            $t = '<span>'.rupiah($row->saldo).'</span>';
            return $t;
        })
        ->addColumn('poin', function($row){
            $t = '<span>'.rupiah($row->poin).'</span>';
            return $t;
        })
        ->addColumn('koin', function($row){
            $t = '<span>'.rupiah($row->koin).'</span>';
            return $t;
        })
        ->addColumn('kyc', function($row){
            if($row->is_kyc == 0){
                $t = '<span class="text-danger">TDK</span>';
            }else {
                $t = '<span class="text-success">YA</span>';
            }
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->status == 'ACTIVE'){
                $t = '<span class="text-success">ACTIVE</span>';
            }else {
                $t = '<span class="text-danger">INACTIVE</span>';
            }
            return $t;
        })
        ->addColumn('type', function($row){
            switch ($row->plan_id) {
                case '0':
                    $t = '<span class="text-warning">Basic</span>';
                    break;
                case '1':
                    $t = '<span class="text-success">Platinum</span>';
                    break;
                case '2':
                    $t = '<span class="text-primary">Enterprise</span>';
                    break;
            }
            return $t;
        })
        ->addColumn('join', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->addColumn('last_login', function($row){
            $t = '<span>'.$row->updated_at.'</span>';
            return $t;
        })
        ->addColumn('card', function($row){
            $t = '<span>'.$row->card->card_number.'</span>';
            return $t;
        })
        ->rawColumns(['action', 'code', 'name', 'phone', 'email', 'balance', 'poin', 'koin', 'kyc', 'status', 'type', 'join', 'last_login', 'card'])
        ->make();

        return $dt;
    }

    public function getBata()
    {
        $data = User::orderBy('id', 'asc')->with('card')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = view('users::components.right-action', [
                'delete' => route('members.destroy', [$row->id]),
                'class' => 'btn-edit-tooltip',
                'editAdj' => route('layouts.adjustSaldo', [$row->id]),
                'resetLink' => '#',
            ]);
            return $actionBtn;
        })
        ->addColumn('code', function($row){
            $t = '<span>'.$row->code.'</span>';
            return $t;
        })
        ->addColumn('name', function($row){
            $t = '<span>'.$row->first_name.'</span>';
            return $t;
        })
        ->addColumn('phone', function($row){
            $t = '<span>'.$row->phone.'</span>';
            return $t;
        })
        ->addColumn('email', function($row){
            $t = '<span>'.$row->email.'</span>';
            return $t;
        })
        ->addColumn('balance', function($row){
            $t = '<span>'.rupiah($row->saldo).'</span>';
            return $t;
        })
        ->addColumn('poin', function($row){
            $t = '<span>'.rupiah($row->poin).'</span>';
            return $t;
        })
        ->addColumn('koin', function($row){
            $t = '<span>'.rupiah($row->koin).'</span>';
            return $t;
        })
        ->addColumn('kyc', function($row){
            if($row->is_kyc == 0){
                $t = '<span class="text-danger">TDK</span>';
            }else {
                $t = '<span class="text-success">YA</span>';
            }
            return $t;
        })
        ->addColumn('status', function($row){
            if($row->status == 'ACTIVE'){
                $t = '<span class="text-success">ACTIVE</span>';
            }else {
                $t = '<span class="text-danger">INACTIVE</span>';
            }
            return $t;
        })
        ->addColumn('type', function($row){
            switch ($row->plan_id) {
                case '0':
                    $t = '<span class="text-warning">Basic</span>';
                    break;
                case '1':
                    $t = '<span class="text-success">Platinum</span>';
                    break;
                case '2':
                    $t = '<span class="text-primary">Enterprise</span>';
                    break;
            }
            return $t;
        })
        ->addColumn('join', function($row){
            $t = '<span>'.$row->created_at.'</span>';
            return $t;
        })
        ->addColumn('last_login', function($row){
            $t = '<span>'.$row->updated_at.'</span>';
            return $t;
        })
        ->addColumn('card', function($row){
            $t = '<span>'.$row->card->card_number.'</span>';
            return $t;
        })
        ->rawColumns(['action', 'code', 'name', 'phone', 'email', 'balance', 'poin', 'koin', 'kyc', 'status', 'type', 'join', 'last_login', 'card'])
        ->make();

        return $dt;
    }

    public function index()
    {
        
        return view('users::index');
    }
        
    public function user()
    {
        $saldo = User::sum('saldo');
        $poin = User::sum('poin');
        $koin = User::sum('koin');
        
        return view('users::user', compact('saldo', 'poin', 'koin'));
    }

    public function create()
    {
        return view('users::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('users::show');
    }

    public function edit($id)
    {
        return view('users::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $d = User::find($id);
        $d->delete();
        return redirect()->back()->with('Sukses', 'Data berhasil di hapus');

    }

    //adjustSaldo
    public function adjustSaldo(string $id)
    {
        //
        $mber=User::findorfail($id);
        return view('users::layouts.adjustSaldo', compact('mber'));
    }

    public function updateSaldo(Request $request, string $id)
    {
        $request->validate([
            'saldo' => ['required', 'integer'],
            'jenis' => ['required'],
            'type'  => ['required'],
        ]);

        $mber = User::findorfail($id);
        $ref_id = Str::upper(Str::random(12));

        switch ($request->jenis) {
            case 'saldo':
                if($request->type == 'plus'){
                    $mber->saldo += $request->saldo;
                    $lbl = 'Penambahan saldo sebesar '.rupiah($request->saldo);
                }else {
                    $mber->saldo -= $request->saldo;
                    $lbl = 'Pengurangan saldo sebesar '.rupiah($request->saldo);
                }
                $mber->save();

                $disb = new Disbursement();
                $disb->user_id                  = $mber->id;
                $disb->ref_id                   = $ref_id;
                $disb->nominal                  = intval($request->saldo);
                $disb->bank_code                = 'BILPAY';
                $disb->account_number           = $mber->card->card_number;
                $disb->account_holder_name      = $mber->first_name;
                $disb->disbursement_description = $lbl;
                $disb->status                   = 'SUCCESS';
                $disb->save();
                
                $content = 'Penyesuaian saldo sebesar '.rupiah($request->saldo).' berhasil pada '. $mber->updated_at;
                Notifikasi::create([
                    'user_id'   => $mber->id,
                    'title'     => $lbl,
                    'content'   => $content,
                    'type'      => 'Transaksi',
                    'ref_id'    => $ref_id
                ]);
                break;
            
            case 'poin':
                if($request->type == 'plus'){
                    $mber->poin += $request->saldo;
                    $lbl = 'Penambahan poin sebesar '.rupiah($request->saldo);

                    $valK = intval($mber->poin) - intval($request->saldo);
                    $valKo = intval($mber->poin);
                }else {
                    $mber->poin -= $request->saldo;
                    $lbl = 'Pengurangan poin sebesar '.rupiah($request->saldo);

                    $valP = intval($mber->poin) + intval($request->saldo);
                    $valPo = intval($mber->poin);
                }
                $mber->save();

                $hp = new HistoriPoin();
                $hp->user_id    = $mber->id;
                $hp->ref_id     = $ref_id;
                $hp->jenis      = 'CREDIT';
                $hp->nominal    = $request->saldo;
                $hp->keterangan = $lbl;
                $hp->poin_awal  = $valP;
                $hp->poin_akhir = $valPo;
                $hp->save();

                $content = 'Penyesuaian poin sebesar '.rupiah($request->saldo).' berhasil pada '. $hp->created_at;
                Notifikasi::create([
                    'user_id'   => $mber->id,
                    'title'     => $lbl,
                    'content'   => $content,
                    'type'      => 'Transaksi',
                    'ref_id'    => $ref_id
                ]);
                
                break;

            case 'koin':
                if($request->type == 'plus'){
                    $mber->koin += $request->saldo;
                    $lbl = 'Penambahan koin sebesar '.rupiah($request->saldo);

                    $valK = intval($mber->koin) - intval($request->saldo);
                    $valKo = intval($mber->koin);
                }else {
                    $mber->koin -= $request->saldo;
                    $lbl = 'Pengurangan koin sebesar '.rupiah($request->saldo);

                    $valK = intval($mber->koin) + intval($request->saldo);
                    $valKo = intval($mber->koin);
                }
                $mber->save();

                $hk = new HistoriKoin();
                $hk->user_id    = $mber->id;
                $hk->ref_id     = $ref_id;
                $hk->jenis      = 'CREDIT';
                $hk->nominal    = $request->saldo;
                $hk->keterangan = $lbl;
                $hk->koin_awal  = $valK;
                $hk->koin_akhir = $valKo;
                $hk->save();

                $content = 'Penyesuaian koin sebesar '.rupiah($request->saldo).' berhasil pada '. $hk->created_at;
                Notifikasi::create([
                    'user_id'   => $mber->id,
                    'title'     => $lbl,
                    'content'   => $content,
                    'type'      => 'Transaksi',
                    'ref_id'    => $ref_id
                ]);

                break;
        }
        // return redirect()->to('backoffice/v2/members')->with('success', 'Saldo Adjusted');
        return redirect()->back()->with('success', 'Saldo Adjusted');
    }

    public function import(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            
            $file = $request->file('file');
            $nama_file = rand().$file->getClientOriginalName();
            $file->storeAs('data_users', $nama_file);
    
            $import = new UserImport(0);
            Excel::import($import, storage_path('/app/data_users/'.$nama_file));
            return redirect()->back()->withSuccess('Data Member Berhasil Di Import!');

        } catch (\Throwable $th) {

            Log::info('IMPORT EXCEL ERR '.$th->getMessage());
            return redirect()->back()->withErrors('Terjadi kesalahan pada file');;
        }
    }

    public function importBalance(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);
            
            $file = $request->file('file');
            $nama_file = rand().$file->getClientOriginalName();
            $file->storeAs('balance_users', $nama_file);
    
            $import = new BalanceImport(0);
            Excel::import($import, storage_path('/app/balance_users/'.$nama_file));
            return redirect()->back()->withSuccess('Current Balance Berhasil Di Import!');

        } catch (\Throwable $th) {

            Log::info('IMPORT EXCEL ERR '.$th->getMessage());
            return redirect()->back()->withErrors('Terjadi kesalahan pada file');;
        }
    }

    public function export(Request $request)
    {

        $start = Carbon::parse($request->start)->format('Y-m-d'); 
        $end = Carbon::parse($request->end)->format('Y-m-d');
        
        $query = new User();
        return Excel::download(new UsersViewExport($query), now() . '-data-member.xlsx');
    }

}
