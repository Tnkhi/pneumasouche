<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_activity' => 'datetime',
        ];
    }

    /**
     * Vérifier si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifier si l'utilisateur est direction
     */
    public function isDirection(): bool
    {
        return $this->role === 'direction';
    }

    /**
     * Vérifier si l'utilisateur est déclarateur
     */
    public function isDeclarateur(): bool
    {
        return $this->role === 'declarateur';
    }

    /**
     * Vérifier si l'utilisateur est mécanicien
     */
    public function isMecanicien(): bool
    {
        return $this->role === 'mecanicien';
    }

    /**
     * Vérifier si l'utilisateur peut créer des utilisateurs
     */
    public function canCreateUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Vérifier si l'utilisateur peut gérer les mutations
     */
    public function canManageMutations(): bool
    {
        return in_array($this->role, ['admin', 'direction', 'mecanicien']);
    }

    /**
     * Vérifier si l'utilisateur peut voir les statistiques
     */
    public function canViewStats(): bool
    {
        return in_array($this->role, ['admin', 'direction']);
    }

    /**
     * Obtenir le nom du rôle en français
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrateur',
            'direction' => 'Direction',
            'declarateur' => 'Déclarateur',
            'mecanicien' => 'Mécanicien',
            default => 'Inconnu'
        };
    }

    /**
     * Obtenir la couleur du rôle
     */
    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'danger',
            'direction' => 'primary',
            'declarateur' => 'success',
            'mecanicien' => 'warning',
            default => 'secondary'
        };
    }

    /**
     * Mettre à jour la dernière activité
     */
    public function updateLastActivity(): void
    {
        $this->update(['last_activity' => now()]);
    }

    /**
     * Relations avec les maintenances
     */
    public function maintenancesMecanicien()
    {
        return $this->hasMany(Maintenance::class, 'mecanicien_id');
    }

    public function maintenancesDeclarateur()
    {
        return $this->hasMany(Maintenance::class, 'declarateur_id');
    }

    public function maintenancesDirection()
    {
        return $this->hasMany(Maintenance::class, 'direction_id');
    }
}
