<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';
    protected $fillable = [
        'name', 'sprite', 'height', 'weight', 'base_experience',
        'primary_type_id', 'secondary_type_id', 'generation_id',
        'evolution_stage', 'color'
    ];

    public function primaryType()
    {
        return $this->belongsTo(Type::class, 'primary_type_id');
    }

    public function secondaryType()
    {
        return $this->belongsTo(Type::class, 'secondary_type_id');
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }
}
