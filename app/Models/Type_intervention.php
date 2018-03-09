<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_intervention extends Model
{
	protected $table = 'type_interventions';

	protected $primaryKey = 'id_type_intervention';

	protected $fillable = ['id_type_intervention', 'description', 'created_at', 'updated_at'];
}
