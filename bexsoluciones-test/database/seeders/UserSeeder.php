<?php

namespace Database\Seeders;

use App\Domain\Shared\ValueObjects\UlidValueObject;
use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 3; $i++) { 
            User::insert($this->data($i));
        }
    }

    public function data(int $count)
    {
        return [
            [
                'id' => UlidValueObject::random(),
                'name' => 'Jonathan',
                'last_name' => 'Garzon',
                'email' => "jonatangarzon+$count@gmail.com",
                'identification' => '1121940890',
                'is_verified' => 'id_banlinea',
                'password' => Hash::make('Lol123Lol@'),
            ]
        ];
    }
}
