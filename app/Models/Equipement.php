<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
	protected $table = 'equipements';

	protected $primaryKey = 'id_equipement';

	protected $fillable = ['id_equipement', 'id_famille', 'description', 'created_at', 'updated_at'];
}
