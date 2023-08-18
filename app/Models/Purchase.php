<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';
    protected $guarded = ['pembelian_id'];

    public function orderList()
    {
        return $this->morphMany(OrderList::class, 'flow');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function generateID()
    {
        return 'RQ' . $this->pembelian_id . '-' . Carbon::parse($this->created_at)->format('dmy');
    }
}
