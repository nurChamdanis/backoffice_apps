<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Users\App\Models\Card;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Factory::create();
        $this->createUser($faker, 'user_main@bilpay.com');
    }

    private function createUser($faker, $email)
    {
        $user = User::where('email', '=', $email)->first();
        if (null === $user) {
            $user = User::create([
                'plan_id'                        => 0,
                'code'                           => 'BP-0000',
                'ref_code'                       => 'BP-0000',
                'name'                           => $faker->userName,
                'first_name'                     => $faker->firstName,
                'last_name'                      => $faker->lastName,
                'saldo'                          => 0,
                'markup'                         => 0,
                'email'                          => $email,
                'phone'                          => '08123'.rand(0000000, 9999999),
                'password'                       => Hash::make('password'),
                'token'                          => Str::random(64),
                'activated'                      => true,
                'signup_ip_address'              => $faker->ipv4,
                'signup_confirmation_ip_address' => $faker->ipv4,
                'pin'                            => Hash::make('000000'),
            ]);

            $user->profile()->save(new Profile());
            $user->save();

            $c = new Card();
            $c->user_id = $user->id;
            $c->card_number = rand(111111111, 999999999);
            $c->valid = '03/29';
            $c->save();
        }
    }
}
