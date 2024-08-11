<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Produk\App\Models\Kategori;
use Modules\Produk\App\Models\Produk;

class CekHarga extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:harga';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Harga produk PPOB Nukar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('PRODUK UPDATED');
        $data = getPrabayar();

        foreach ($data->data as $item) {
            $cek = Produk::where('code', $item->sku_code)->first();
            if(isset($cek)){

                $cek->code = $item->sku_code;
                $cek->name = $item->product_name;
                $cek->description = $item->desc;
                $cek->category = $item->brand;
                $cek->type = $item->type;
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

        return true;
    }
}
