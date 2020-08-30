<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal extends Model
{
    //Nombre de la table
    protected $table = 'tb_principal';

    //Llave primaria
    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FK_idVehicle', 'FK_idMtto'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'FK_idVehicle');
    }

    public function mantenimiento()
    {
        return $this->belongsTo(Mantenimiento::class, 'FK_idMtto');
    }

    
}
