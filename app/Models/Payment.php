<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'type',
        'details',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'details' => 'json',
    ];
}
