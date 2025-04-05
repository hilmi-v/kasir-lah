<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use SoftDeletes;

    /** @use HasFactory<\Database\Factories\SaleFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
