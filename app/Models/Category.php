<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama',
        'barang_id'
    ];

    public function barang() : BelongsTo{
        return $this->belongsTo(Barang::class);
    }
}
