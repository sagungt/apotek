<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'persediaan_obat';
    protected $guarded = ['id'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'obat_id');
    }
}
