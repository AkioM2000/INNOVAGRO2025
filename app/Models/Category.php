<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'afdeling_id',
        'code',
    ];

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function afdeling()
    {
        return $this->belongsTo(Afdeling::class);
    }
}
