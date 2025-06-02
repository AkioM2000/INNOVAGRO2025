<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afdeling extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'division_id', 'code'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
