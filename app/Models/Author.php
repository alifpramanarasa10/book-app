<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    // Mendefine bahwa model Book, memiliki kolom yang dapat diisi dengan kolom dibawah
    protected $fillable = [
        'name',
        'description'
    ];

    public function book()
    {
        // ( MODEL RELASI)
        return $this->hasMany(Book::class);
    }
}
