<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PieceDetachee extends Model
{
    use HasFactory;

    protected $table = 'pieces_detachees';

    protected $fillable = [
        'maintenance_id',
        'type_piece',
        'marque',
        'reference',
        'constructeur',
        'fournisseur',
        'cout_unitaire',
        'nombre',
        'montant_total'
    ];

    protected $casts = [
        'cout_unitaire' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'nombre' => 'integer'
    ];

    /**
     * Relation avec la maintenance
     */
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    /**
     * Accessor pour le montant total formaté
     */
    public function getMontantTotalFormateAttribute(): string
    {
        return number_format($this->montant_total, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accessor pour le coût unitaire formaté
     */
    public function getCoutUnitaireFormateAttribute(): string
    {
        return number_format($this->cout_unitaire, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Boot method pour calculer automatiquement le montant total
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($piece) {
            $piece->montant_total = $piece->cout_unitaire * $piece->nombre;
        });
    }
}