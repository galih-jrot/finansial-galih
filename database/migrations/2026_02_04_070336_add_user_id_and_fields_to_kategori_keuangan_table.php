<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kategori_keuangan', function (Blueprint $table) {
            $table->renameColumn('nama', 'nama_kategori');
            $table->renameColumn('tipe', 'jenis');
            $table->text('deskripsi')->nullable()->after('jenis');
            $table->foreignId('user_id')->nullable()->after('id');
        });

        // Assign existing records to the first user if exists
        $firstUser = DB::table('users')->first();
        if ($firstUser) {
            DB::table('kategori_keuangan')->whereNull('user_id')->update(['user_id' => $firstUser->id]);
        }

        Schema::table('kategori_keuangan', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_keuangan', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->renameColumn('nama_kategori', 'nama');
            $table->renameColumn('jenis', 'tipe');
            $table->dropColumn('deskripsi');
        });
    }
};
