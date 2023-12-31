<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $guarded = ['supplier_id'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
}
