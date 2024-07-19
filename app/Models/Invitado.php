<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
}
