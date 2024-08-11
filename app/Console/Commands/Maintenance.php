<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\InstTransfer\App\Models\Disbursement;
use Modules\Setting\App\Models\Setting;
use Modules\Users\App\Models\Deposit;

class Maintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintnance:on';

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
        $val = Setting::where('key', 'maintnance_mode')->first();
        $data = array(
            'mode'  => 'on',
            'title' => 'Cutt Off Harian dr jam 23:55 s/d 00:15'
        );
        $val->update([
            'value' => json_encode($data)
        ]);


        $dataTopup = Deposit::where('status', 'PENDING')->get();
        foreach ($dataTopup as $data) {

            $data->update([
                'status' => 'FAILED',
            ]);
        }

        $disb = Disbursement::where('status','INQUIRY')->get();
        foreach ($disb as $key => $item) {
            $item->status = 'FAILED';
            $item->save();
        }

        return true;
    }
}
