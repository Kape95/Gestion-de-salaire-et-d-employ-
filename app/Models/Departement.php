<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'budget_mensuel',
        'responsable_id',
        'status',
        'couleur'
    ];

    protected $casts = [
        'budget_mensuel' => 'decimal:2',
        'status' => 'string'
    ];

    // Relation avec les employés
    public function employers()
    {
        return $this->hasMany(Employer::class);
    }

    // Relation avec le responsable (employé)
    public function responsable()
    {
        return $this->belongsTo(Employer::class, 'responsable_id');
    }

    // Accesseur pour le nombre d'employés
    public function getEmployersCountAttribute()
    {
        return $this->employers()->count();
    }

    // Accesseur pour le salaire moyen du département
    public function getAverageSalaryAttribute()
    {
        return $this->employers()->avg('montant_journalier') ?? 0;
    }

    // Accesseur pour la masse salariale du département
    public function getTotalSalaryAttribute()
    {
        return $this->employers()->sum('montant_journalier') * 22; // 22 jours de travail
    }

    // Scope pour les départements actifs
    public function scopeActif($query)
    {
        return $query->where('status', 'actif');
    }

    // Scope pour les départements inactifs
    public function scopeInactif($query)
    {
        return $query->where('status', 'inactif');
    }
}
