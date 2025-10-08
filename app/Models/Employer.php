<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'contact',
        'telephone',
        'adresse',
        'date_naissance',
        'date_embauche',
        'poste',
        'montant_journalier',
        'departement_id',
    ];


   


    public function departement ()
    {
        return $this->belongsTo(Departement::class);
    }

}
