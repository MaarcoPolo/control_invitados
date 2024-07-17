<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $fillable = ['n_invitado','evento_id','nombre','apellido_p','apellido_m','dependencia','cargo','area','telefono','email','folio','hora_ingreso','estado','municipio'];
    // protected $fillable = ['n_invitado'];
    // // protected $fillable = ['nombre'];  
    // protected $fillable = ['apellido_p'];
    // protected $fillable = ['apellido_m'];
    // protected $fillable = ['dependencia'];
    // protected $fillable = ['cargo'];
    // protected $fillable = ['area']; 
    // protected $fillable = ['telefono']; 
    // protected $fillable = ['email'];
    // protected $fillable = ['folio'];
    
    // protected $fillable = ['hora_ingreso'];
    // protected $fillable = ['estado'];
    // protected $fillable = ['municipio'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
