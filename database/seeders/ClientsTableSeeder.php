<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = ['rebin', 'tarza'];

        foreach ($clients as $client) {

            Client::create([
                'name' => $client,
                'phone' => ['011111111', '011111112'], // Pass as an array                
                'address' => 'slemani',
            ]);
        } //end of foreach
    }
}
