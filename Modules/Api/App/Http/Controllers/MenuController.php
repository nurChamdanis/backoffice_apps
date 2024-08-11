<?php

namespace Modules\Api\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\PPOB\App\Http\Controllers\PPOBController;
use Modules\Produk\App\Models\Kategori;
use Modules\Produk\App\Models\Menu;
use Modules\Produk\App\Models\Prefix;
use Modules\Produk\App\Models\Produk;

class MenuController extends Controller
{
    public function menuPpob()
    {
        $d = Menu::orderBy('position', 'asc')->limit(10)->get();
        return successResponse('Sukses', $d);
    }

    public function listKategori(Request $request)
    {
        $d = Kategori::where('type', $request->type)->get();
        return successResponse('Sukses', $d);
    }

    public function inquiryIdPLN(Request $request, PPOBController $ppob)
    {
        $d = $ppob->cekIdPelangganPLN($request);
        return successResponse('Sukses', $d);
    }

    public function getPulsa(Request $request)
    {
        try {
            $req    = $request->tujuan;
            $nom    = substr($req, 0, 4);
            $rplc   = Str::replace('62', '0', $nom);
            $prefix = Prefix::where('prefix', $rplc)->with('operator')->first();

            if(isset($prefix)){

                $produk = Produk::where([
                    'type'      => $request->type,
                ])
                ->where('category', 'like', '%' . $prefix->operator->name . '%')
                ->orderBy('price', 'ASC')->get();
                
                $data = array();
                foreach ($produk as $item) {
    
                    $col["product_name"]          = $item->name;
                    $col["category"]              = $item->category;
                    $col["type"]                  = $item->type;
                    $col["diskon_price"]          = $item->diskon_price;
                    $col["diskon_persen"]         = $item->discount;
                    $col["sale_price"]            = intval($item->sale_price);
                    $col["sku_code"]              = $item->code;
                    $col["product_status"]        = $item->status == 1 ? 'AKTIF' : 'GANGGUAN';
                    $col["desc"]                  = $item->description;
                    $col["is_promo"]              = $item->is_promo;
                    $col["created_at"]            = $item->created_at;
    
                    $data[] = $col;
                }

                $icon = $prefix->operator->icon;
                $dt = array('icon' => $icon, 'data' => $data);
                return successResponse('Sukses', $dt);

            }else {
                return errorResponApi('Prefix nomor tujuan tidak tersedia', 422);
            }

        } catch (\Throwable $th) {
            return array(
                'error' => true,
                'message' => $th->getMessage()
            );
        }
    }

    public function getPrabayar(Request $request)
    {
        try {
            $pra = $request->prabayar;
            $produk = Produk::where([
                'type'      => $request->type,
            ])
            ->where('prabayar', $pra)
            ->where('category', $request->category)
            ->orderBy('price', 'ASC')->get();
            
            $data = array();
            foreach ($produk as $item) {

                $col["product_name"]          = $item->name;
                $col["category"]              = $item->category;
                $col["type"]                  = $item->type;
                $col["diskon_price"]          = $item->diskon_price;
                if($pra == 1){
                    $col["sale_price"]            = intval($item->sale_price);
                }else {
                    $col["admin_fee"]            = intval($item->sale_price);
                }
                $col["sku_code"]              = $item->code;
                $col["product_status"]        = $item->status == 1 ? 'AKTIF' : 'GANGGUAN';
                $col["desc"]                  = $item->description;
                $col["is_promo"]              = $item->is_promo;
                $col["created_at"]            = $item->created_at;

                $data[] = $col;
            }

            return successResponse('Sukses', $data);
            

        } catch (\Throwable $th) {
            return array(
                'error' => true,
                'message' => $th->getMessage()
            );
        }
    }
}
