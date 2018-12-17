<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pronostic extends Model
{
    //  config
    //nom de la base
    protected $connection = 'mysql';
    //table name
    protected $table = 'pronostics';
    //primary ley
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
}
