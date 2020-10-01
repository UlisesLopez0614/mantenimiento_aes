<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    //Nombre de la table
    protected $table = 'tb_mtto_history';

    //Llave primaria
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'FK_idVehicle', 'FK_tipoMtto', 'FK_taller', 'kms_ini', 'kms_goal', 'date', 'time', 'alerta_naranja', 'alerta_prox_vencer', 'alerta_roja', 'recordatorio_diario_vencido', 'recordatorio_diario_por_vencerse', 'porcentaje_alerta_por_vencerse', 'correo', 'costo'
    ];

    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'FK_idVehicle');
    }


    public function tipomanto()
    {
        return $this->belongsTo(Tipomanto::class, 'FK_tipoMtto');
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'FK_taller');
    }

    public function principal()
    {
        return $this->hasOne(Principal::class, 'FK_idMtto');
    }

}
