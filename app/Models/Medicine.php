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
        return $this->hasMany(Stock::class, 'obat_id');
    }

    public function purchases($startDate, $endDate)
    {
        return OrderList::where('flow_type', Purchase::class)
            ->where('medicine_type', Medicine::class)
            ->where('medicine_id', $this->obat_id)
            ->whereBetween('created_at', array($startDate, $endDate))
            ->get();
    }

    public function sales($startDate, $endDate)
    {
        return OrderList::where('flow_type', Sell::class)
            ->where('medicine_type', Stock::class)
            ->where('medicine_id', $this->obat_id)
            ->whereBetween('created_at', array($startDate, $endDate))
            ->get();
    }
}
