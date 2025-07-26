<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Voucher;

class VoucherTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateVoucher(): void
    {
        $voucher = new Voucher();
        $voucher->name = 'Voucher 1';
        $voucher->voucher_code = 'VOUCHER123';
        $voucher->save();

        $this->assertDatabaseHas('vouchers', [
            'name' => 'Voucher 1',
            'voucher_code' => 'VOUCHER123',
        ]);

        $this->assertNotNull($voucher->id, 'Voucher ID should not be null after saving.');
    }

    public function testCreateVoucherUUID(): void
    {
        $voucher = new Voucher();
        $voucher->name = 'Voucher 1';
        $voucher->save();

        $this->assertDatabaseHas('vouchers', [
            'name' => 'Voucher 1',
        ]);

        $this->assertNotNull($voucher->id, 'Voucher ID should not be null after saving.');
        $this->assertNotNull($voucher->voucher_code, 'Voucher code should not be null after saving.');
    }
}
