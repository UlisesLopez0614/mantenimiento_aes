<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    //Nombre de la table
    protected $table = 'tb_vehicles';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idAVL', 'Name', 'Plate', 'Fleet', 'kms_inicial'
    ];

    public function setNameAttribute($value) 
    {
        $this->attributes['Name'] = strtoupper($value);
    }

    public function setPlateAttribute($value) 
    {
        $this->attributes['Plate'] = strtoupper($value);
    }

    public function setFleetAttribute($value) 
    {
        $this->attributes['Fleet'] = strtoupper($value);
    }

    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'FK_idVehicle');
    }

    public function principal()
    {
        return $this->hasOne(Principal::class, 'FK_idVehicle');
    }
}
