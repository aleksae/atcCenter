<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRequest extends Model
{
    use HasFactory;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $fillable = [
		'created_at', 'updated_at', 'name','cid', 'date','start_time','end_time','position','status','mentor_name','mentor_id','notes','type'
	];
}

