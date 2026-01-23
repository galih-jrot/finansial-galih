<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'jenis',
        'kategori_id',
        'akun_id',
        'user_id',
        'jumlah',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function akun()
    {
        return $this->belongsTo(AkunKeuangan::class, 'akun_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
