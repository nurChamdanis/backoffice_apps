<?php

namespace App\Imports;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Users\App\Models\Card;

class UserImport implements ToModel, WithHeadingRow
{
    public $rowCount = 0;
    public function __construct($rowCount)
    {
        $this->rowCount = $rowCount;
    }


    public function model(array $row)
    {
        $uName = Str::replace(' ', '_', Str::lower($row['name'])); 
        $cek = User::where('phone', $row['phone'])->first();
        if(!isset($cek)){
            
            $user = new User();
            $user->plan_id    = $row['plan'] == 'Nasabah Biasa' ? 0 : 1;
            $user->code       = 'BP-'.Str::upper(Str::random(4)).substr($row['phone'],9);
            
            $nm = strlen($row['name']);
            $cekUsName = User::where('name', $uName)->first();
            if(isset($cekUsName)){
                $username = Str::lower($uName.Str::random(4));
            }else {
                $username = $nm >= 20 ? Str::lower(Str::replace(' ', '_', substr($row['name'], 0, 5))).Str::random(4) :  Str::lower($uName).Str::random(4);
            }

            $user->name       = $username;
            $user->first_name = $nm >= 20 ? ucwords(substr($row['name'], 0, 50)) : ucwords($row['name']);
            $user->saldo      = 0;
            $user->markup     = 0;
            $user->email      = $row['email'];
            $user->phone      = $row['phone'];
            $user->password   = '$2y$10$ifXCZQG7i03S.tVxKkxa8OvAVTGDagPvvPIwiOSDnNBYh9V6L8Qeq'; //password
            $user->verification_code = substr($row['phone'],9).rand(000, 999);
            $user->activated    = true;
            $user->is_kyc       = $row['plan'] == 'Nasabah Biasa' ? false : true;
            $user->is_outlet    = false;
            $user->status       = 'ACTIVE';
            $user->token        = Str::random(64);
            $user->created_at   = Carbon::createFromFormat('d/m/Y H:i:s', $row['date'])->format('Y-m-d H:i:s');
            $user->save();

            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->theme_id = 1;
            $profile->avatar_status = 0;
            $profile->save();

            $card = new Card();
            $card->user_id = $user->id;
            $card->card_number = '2000'.rand(000000, 999999).$user->id;
            $card->valid = '05/29';
            $card->save();

            Log::info('IMPORT BERHASIL '.$user->first_name);
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
