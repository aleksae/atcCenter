<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $fillable = [
        'cid',
        'isCurrent',
        'approvedAirports',
        'hasSolo',
        'letter',
        'full_name',
        'type'
    ];
}
