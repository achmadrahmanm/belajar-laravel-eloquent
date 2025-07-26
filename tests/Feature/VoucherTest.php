<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Voucher;

use Database\Seeders\VoucherSeeder;

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

    public function testSoftDeleteVoucher(): void
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where('name', 'Voucher 1')->first();
        $this->assertNotNull($voucher, 'Voucher with name Voucher 1 should exist.');

        $voucher->delete();

        $this->assertSoftDeleted('vouchers', [
            'id' => $voucher->id,
            'name' => 'Voucher 1',
        ]);

        $this->assertDatabaseMissing('vouchers', [
            'id' => $voucher->id,
            'deleted_at' => null,
        ]);

        $all_vouchers_include_deleted = Voucher::withTrashed()->get();
        $this->assertTrue($all_vouchers_include_deleted->contains($voucher), 'Voucher should be found in the trashed records.');
    }

    // public function testForceDeletedVoucher(): void
    // {
    //     $this->seed(VoucherSeeder::class);

    //     $voucher = Voucher::where('name', 'Voucher 1')->first();
    //     $this->assertNotNull($voucher, 'Voucher with name Voucher 1 should exist.');

    //     $voucher->delete();
    //     $voucher->forceDelete();

    //     $this->assertDatabaseMissing('vouchers', [
    //         'id' => $voucher->id,
    //         'name' => 'Voucher 1',
    //     ]);
    // }
}
