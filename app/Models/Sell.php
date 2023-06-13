<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $guarded = ['prnjual_id'];

    public function orderList()
    {
        return $this->morphMany(OrderList::class, 'flow');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
