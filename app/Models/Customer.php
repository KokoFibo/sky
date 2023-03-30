<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function invoice () {
        return $this->hasMany(Invoice::class);
    }
    public function contract () {
        return $this->hasMany(Contract::class);
    }
}
