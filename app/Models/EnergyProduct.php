<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Energy;
use App\Models\User;

class EnergyProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function energy()
    {
        return $this->belongsTo(Energy::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
