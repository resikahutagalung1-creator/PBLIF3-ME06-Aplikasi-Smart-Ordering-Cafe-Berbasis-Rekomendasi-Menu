
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->id('meja_id');
            $table->string('nomor_meja', 10)->unique();
            $table->string('status', 20)->default('tersedia');
            $table->timestamps();
        });

        // Membuat 25 meja secara otomatis
        $dataMeja = [];

        for ($i = 1; $i <= 25; $i++) {
            $dataMeja[] = [
                'nomor_meja' => 'A' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('meja')->insert($dataMeja);
    }

    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};