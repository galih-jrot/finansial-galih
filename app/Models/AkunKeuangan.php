<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunKeuangan extends Model
{
    use HasFactory;

    protected $table = 'akun_keuangan';

    protected $fillable = [
        'nama_akun',
        'jenis',
        'saldo_awal',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'akun_id');
    }
}
