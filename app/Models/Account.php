<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    // Izinkan kolom ini diisi data
    protected $fillable = ['user_id', 'title', 'username', 'password'];

    // Relasi: Akun ini milik User siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}