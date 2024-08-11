<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Produk\App\Models\Kategori;
use Modules\Produk\App\Models\Produk;

class CekPasca extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:pasca';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('PRODUK PASCABAYAR UPDATED');
        $data = getPasca();

        foreach ($data->data as $item) {
        
            $cek = Produk::where('code', $item->sku_code)->first();
            if(isset($cek)){

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

        return true;
    }
}
