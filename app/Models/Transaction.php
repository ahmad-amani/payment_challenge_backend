<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'package_id', 'card', 'ref', 'price', 'paid_at', 'status', 'message'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
