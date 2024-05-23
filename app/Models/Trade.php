<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EnergyProduct;
use App\Models\User;

class Trade extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function energy_product()
    {
        return $this->belongsTo(EnergyProduct::class, 'energy_product_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
