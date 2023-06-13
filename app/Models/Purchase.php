<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
