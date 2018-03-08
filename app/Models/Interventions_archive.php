<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interventions_archive extends Model
{
    protected $table = 'interventions';

	protected $fillable = ['id_intervention','id_type_intervention','id_user','id_equipement', 'description', 'date', 'duree', 'date_delete','created_at','updated_at',];
}
