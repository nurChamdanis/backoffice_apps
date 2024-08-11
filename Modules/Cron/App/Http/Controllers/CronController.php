<?php

namespace Modules\Cron\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Modules\Produk\App\Models\Kategori;
use Modules\Produk\App\Models\Produk;
use Modules\Setting\App\Models\Setting;

class CronController extends Controller
{
    public function authKlik()
    {
        $d = createAuthKlik();
        if($d){
            return response()->json([
                'status' => true
            ]);
        }else {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function authNukar()
    {
        $d = createAuthNukar();
        if($d){
            return response()->json([
                'status' => true
            ]);
        }else {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function cekHarga()
    {
        $data = getPrabayar();
        foreach ($data->data as $item) {
            $cek = Produk::where('code', $item->sku_code)->first();
            if(isset($cek)){

                if(autoRenameProduk() == 'on'){
                    $cek->name = $item->product_name;
                    $cek->description = $item->desc;
                }
                $cek->price = $item->sale_price;
                $cek->sale_price = intval($item->sale_price) + intval($cek->margin);
                $cek->status = $item->product_status;
                $cek->prabayar = 1;
                $cek->save();

            }else {

                $p = new Produk();
                $p->code = $item->sku_code;
                $p->name = $item->product_name;
                $p->description = $item->desc;
                $p->category = $item->brand;
                $p->type = $item->type;
                $p->price = $item->sale_price;
                $p->margin = 0;
                $p->discount = 0;
                $p->sale_price = $item->sale_price;
                $p->status = $item->product_status;
                $p->is_promo = $item->is_promo;
                $p->prabayar = 1;
                $p->save();
                
            }
        }
        return response()->json([
            'status' => true
        ]);
    }

    public function cekHargaPasca()
    {
        $data = getPasca();

        foreach ($data->data as $item) {
            $cek = Produk::where('code', $item->sku_code)->first();
            if(isset($cek)){

                if(autoRenameProduk() == 'on'){
                    $cek->name = $item->product_name;
                    $cek->description = $item->desc;
                }
                $cek->price = $item->commission;
                $cek->sale_price = intval($item->commission) + intval($cek->margin);
                $cek->status = $item->product_status;
                $cek->save();

            }else {

                $p = new Produk();
                $p->code = $item->sku_code;
                $p->name = $item->product_name;
                $p->description = $item->desc;
                $p->category = $item->brand;
                $p->type = $item->category;
                $p->price = $item->commission;
                $p->margin = 0;
                $p->discount = 0;
                $p->sale_price = $item->commission;
                $p->status = $item->product_status;
                $p->is_promo = 0;
                $p->prabayar = 0;
                $p->icon = $item->icon;
                $p->save();

            }
        }

        return response()->json([
            'status' => true
        ]);
    }

    public function cekAkunDorman()
    {
        $lastDate = date('Y-m-d', strtotime('-6 months'));
        $us = User::whereDate('updated_at', '=', $lastDate)->get();
        foreach ($us as $key => $item) {
            $item->status = 'INACTIVE';
            $item->save();
        }

        return response()->json([
            'status' => true
        ]);
    }

    public function maintenanceOn()
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $data = array(
            'mode'  => 'on',
            'title' => 'Cutt Off Harian dr jam 23:55 s/d 01:15'
        );
        $val->update([
            'value' => json_encode($data)
        ]);

        return response()->json([
            'status' => true
        ]);
    }

    public function maintenanceOff()
    {
        $val = Setting::where('key', 'maintnance_mode')->first();
        $data = array(
            'mode'  => 'off',
            'title' => ''
        );
        $val->update([
            'value' => json_encode($data)
        ]);
        
        return response()->json([
            'status' => true
        ]);
    }
}
