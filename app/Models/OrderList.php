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
}
