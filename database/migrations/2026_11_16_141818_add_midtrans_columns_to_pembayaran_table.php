
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('midtrans_order_id', 50)
                ->nullable()
                ->unique();

            $table->string('midtrans_transaction_id', 100)
                ->nullable()
                ->unique();

            $table->text('qris_url')->nullable();
            $table->text('qris_string')->nullable();
            $table->dateTime('expired_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropUnique(['midtrans_order_id']);
            $table->dropUnique(['midtrans_transaction_id']);

            $table->dropColumn([
                'midtrans_order_id',
                'midtrans_transaction_id',
                'qris_url',
                'qris_string',
                'expired_at',
            ]);
        });
    }
};