<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    
    protected $table = 'obat';
    protected $primaryKey = 'obat_id';
    protected $guarded = ['obat_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    // public function brand() {
    //     return $this->belongsTo(Brand::class, 'merek_id');
    // }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'id', 'obat_id');
    }
}
