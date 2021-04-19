<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalles_Vehiculos extends Model
{
    //Nombre de la table
    protected $table = 'tb_detalles_vehicles';

    //Llave primaria
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'vehicle_id', 'bateria_id','lubricante_id','llantas_id'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehicle_id');
    }

    public function baterias()
    {
        return $this->belongsTo(Baterias_History::class,'bateria_id');
    }


    public function lubricantes()
    {
        return $this->belongsTo(Lubricantes_History::class,'lubricante_id');
    }

    public function llantas()
    {
        return $this->belongsTo(Llantas_History::class, 'llantas_id');
    }

}
