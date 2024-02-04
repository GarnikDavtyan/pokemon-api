<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_in_english',
        'name_in_russian'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
