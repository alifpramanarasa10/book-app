<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    // Mendefine bahwa model Book, memiliki kolom yang dapat diisi dengan kolom dibawah
    protected $fillable = [
        'author_id',
        'title',
        'description'
    ];

    public function author()
    {
        // ( MODEL RELASI, PRIMARY KEY RELASI, FOREIGN KEY LOCAL)
        return $this->hasOne(Author::class, 'id', 'author_id');
    }
}
