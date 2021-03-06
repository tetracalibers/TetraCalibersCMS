<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\Reference;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function references()
    {
        return $this->belongsToMany(Reference::class);
    }
}
