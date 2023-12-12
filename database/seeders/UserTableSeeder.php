<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\PrayerRequest;
use App\Models\Testimony;
use App\Models\User;
use App\Services\Helper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'phone' => '08035153348',
                'name' => 'Super',
                'password' => Hash::make("password"),
            ],
            [
                'phone' => '08188531726',
                'name' => 'Collins',
                'password' => Hash::make("password"),
            ],
            [
                'phone' => '08165940838',
                'name' => 'Alabo',
                'password' => Hash::make("password"),
            ],
        ];

        foreach ($users as $user)
        {
            Helper::saveModelRecord((new User()), $user);
        }
    }
}
