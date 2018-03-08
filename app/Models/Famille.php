<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    protected $table = 'familles';

	protected $fillable = ['id_famille', 'description', 'created_at', 'updated_at'];
}
