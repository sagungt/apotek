<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function flow()
    {
        return $this->morphTo();
    }

    public function medicine()
    {
        return $this->morphTo();
    }

    public function grossProfit()
    {
        return $this->kuantitas * $this->medicine->finalPrice();
    }

    public function netProfit()
    {
        return $this->grossProfit() - ($this->kuantitas * $this->medicine->harga_jual);
    }
}
