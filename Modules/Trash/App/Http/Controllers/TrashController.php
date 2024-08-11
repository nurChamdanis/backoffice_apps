<?php

namespace Modules\Trash\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Transaksi\App\Models\Transaksi;
use Modules\Users\App\Models\Card;
use Modules\Users\App\Models\Deposit;
use Modules\Users\App\Models\HistoriKoin;
use Modules\Users\App\Models\HistoriPoin;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TrashController extends Controller
{
    public function getData()
    {
        $data = User::withTrashed()->whereNotNull('deleted_at')->get();
        $dt =  DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $actionBtn = view('trash::components.right-action', [
                'restore' => route('restore.user', [$row->id]),
                'delete' => route('user.trash.destroy', [$row->id]),
            ]);
            return $actionBtn;
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
        ->rawColumns(['action', 'name', 'phone', 'email', 'kyc', 'type', 'join'])
        ->make();

        return $dt;
    }
    
    public function index()
    {
        return view('trash::index');
    }

    public function destroy($id)
    {
        $u = User::onlyTrashed()->where('id', $id)->first();
        if($u){
            Profile::where('user_id', $u->id)->delete();
            Transaksi::where('user_id', $u->id)->delete();
            HistoriKoin::where('user_id', $u->id)->delete();
            HistoriPoin::where('user_id', $u->id)->delete();
            Disbursement::where('user_id', $u->id)->delete();
            Deposit::where('user_id', $u->id)->delete();
            Card::where('user_id', $u->id)->delete();

            $u->forceDelete();
        }
        return redirect()->back()->with('success', 'Data sudah di delete permanen');
    }

    public function restore($id)
    {
        $u = User::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('success', 'Data berhasil di kembalikan');
    }
}
