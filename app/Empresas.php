<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    //Nombre de la table
    protected $table = 'tb_company';

    //Llave primaria
    protected $primaryKey = 'company_id';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
