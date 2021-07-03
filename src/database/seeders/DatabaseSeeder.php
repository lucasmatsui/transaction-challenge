<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
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
                'id' => '93c1bc56-b6ac-489a-aa7f-97c014ae8e3b',
                'name' => 'Lucas',
                'cpf' => '363.154.540-11',
                'cnpj' => '82.456.062/0001-77',
                'email' => Str::random(10).'@gmail.com',
                'balance' => 2500,
                'password' => Hash::make('password'),
                'id_type' => 2,
                'created_at' => Carbon::now('America/Sao_Paulo')
            ],
            [
                'id' => 'ad2b411f-685e-4676-82bf-d0003cc43d19',
                'name' => 'Fernando',
                'cpf' => '164.332.880-81',
                'cnpj' => '',
                'email' => Str::random(10).'@gmail.com',
                'balance' => 3450.10,
                'password' => Hash::make('password'),
                'id_type' => 1,
                'created_at' => Carbon::now('America/Sao_Paulo')
            ],
            [
                'id' => '49585f0b-ffdf-4cdc-aebe-a1bb2eed771b',
                'name' => 'Roberto',
                'cpf' => '363.154.540-11',
                'cnpj' => '670.222.45-23',
                'email' => Str::random(10).'@gmail.com',
                'balance' => 4000,
                'password' => Hash::make('password'),
                'id_type' => 1,
                'created_at' => Carbon::now('America/Sao_Paulo')
            ]
        ];

        $types = [
            [
                'id' => 1,
                'name' => 'customer'
            ],
            [
                'id' => 2,
                'name' => 'shopkeeper'
            ]
        ];

        DB::table('users')->delete();
        DB::table('types')->delete();

        DB::table('types')->insert($types);
        DB::table('users')->insert($users);
    }
}
