<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialVehiculo extends Model
{
    //
    //Nombre de la table
    protected $table = 'tb_history';

    //Llave primaria
    protected $primaryKey = 'registro_id';

}
