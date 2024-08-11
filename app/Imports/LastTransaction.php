<?php

namespace App\Imports;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Users\App\Models\Card;

class LastTransaction implements ToModel, WithHeadingRow
{
    public $rowCount = 0;
    public function __construct($rowCount)
    {
        $this->rowCount = $rowCount;
    }

    public function model(array $row)
    {
        $sumber = explode('/', $row['sumber']);
        $phone = $sumber[0];
        
        $tujuan = explode('/', $row['sumber']);
        $msisdn = $tujuan[0];
        $user = User::where('phone', $phone)->first();
        if(!isset($user)){
            
            Log::info('IMPORT BERHASIL '.$user->first_name);
            return $user;

        }else {

            return false;
        }
        
    }

    public function getRowCount(): int
    {
        return count($this->rowCount);
    }
}
