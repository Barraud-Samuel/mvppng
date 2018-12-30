<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    //  config
    //nom de la base
    protected $connection = 'mysql';
    //table name
    protected $table = 'results';
    //primary ley
    public $primaryKey = 'pronostic_id';
    //Timestamps
    public $timestamps = true;
}
