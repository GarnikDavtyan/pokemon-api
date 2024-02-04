<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'name',
        'serial_number',
        'shape_id',
        'location_id',
        'region'
    ];

    public function shape(): BelongsTo
    {
        return $this->belongsTo(Shape::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function abilities()
    {
        return $this->belongsToMany(Ability::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('serial_number');
        });
    }
}
