<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BalanceImport implements ToModel, WithHeadingRow
{
    public $rowCount = 0;
    public function __construct($rowCount)
    {
        $this->rowCount = $rowCount;
    }


    public function model(array $row)
    {
        $cek = User::where('phone', $row['phone'])->first();
        if(isset($cek)){
            
            $user = User::where('phone', $row['phone'])->first();
            $user->saldo = $row['saldo'];
            $user->save();

            Log::info('IMPORT '.$user->first_name.' - SISA SALDO '.rupiah($user->saldo));
            return $user;

        }else {
            return $cek;
        }
        
    }

    public function getRowCount(): int
    {
        return count($this->rowCount);
    }
}
