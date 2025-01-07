<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class status extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            'Unverified',
            'Verified',
            'Active',
            'Not-active',
            'Pending',
        ];
        foreach ($status as $stat) {

            \App\Models\Admin\Status::create(['status' => $stat]);

       }
    }
}
