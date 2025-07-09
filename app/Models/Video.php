<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Video extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'judul',
        'slug',
        'deskripsi',
        'video',
        'user_id',
        'type',
        'thumbnail',
        'nama',
        'umur',
        'perkerjaan'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
