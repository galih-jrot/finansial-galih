<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KategoriKeuangan extends Model
{
    use HasFactory;

    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'nama_kategori',
        'jenis', // 'pemasukan' atau 'pengeluaran'
        'deskripsi',
        'user_id',
    ];

    /**
     * Relasi: Satu kategori bisa digunakan oleh banyak transaksi.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }
}
