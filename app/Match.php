<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class match extends Model
{
    //  config
    //nom de la base
    protected $connection = 'mysql';
    //table name
    protected $table = 'matchs';
    //primary ley
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;
}
