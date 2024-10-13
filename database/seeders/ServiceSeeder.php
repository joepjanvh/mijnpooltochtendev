<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $services = [
            'Kampstaf',
            'Hikestaf A',
            'Hikestaf B',
            'Hikestaf C',
            'Hikestaf D',
            'Hikestaf E',
            'Hikestaf F',
            'Kookploeg',
            'Bouwploeg',
            'Vliegende Keep',
            'Werkploeg',
        ];

        foreach ($services as $service) {
            Service::create(['name' => $service]);
    }
}
}