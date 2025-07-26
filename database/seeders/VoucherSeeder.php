<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::create([
            'name' => 'Voucher 1',
            'voucher_code' => 'VOUCHER123',
        ]);

        Voucher::create([
            'name' => 'Voucher 2',
            'voucher_code' => 'VOUCHER456',
        ]);

        Voucher::create([
            'name' => 'Voucher 3',
            'voucher_code' => 'VOUCHER789',
        ]);
    }
}
