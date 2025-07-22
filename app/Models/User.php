<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'employee_id',
        'password',
        'phone',
        'status',
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
        ];
    }

    /**
     * Many-to-Many relationship with roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Role>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role')
            ->withPivot('assigned_at', 'assigned_by', 'notes')
            ->withTimestamps();
            // ->orderBy('assigned_at', 'desc');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Get all roles of the user
     *
     * @return \Illuminate\Database\Eloquent\Collection<Role>
     */
    public function getRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->roles()->get();
    }

    /** 
     * Check if user has any of the specified roles
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('slug', $roleSlugs)->exists();
    }

    /**
     * Check if user has all specified roles
     */
    public function hasAllRoles(array $roleSlugs): bool
    {
        return $this->roles()->whereIn('slug', $roleSlugs)->count() === count($roleSlugs);
    }

    /**
     * Assign a role to the user
     */
    public function assignRole(Role|string $role, ?int $assignedBy = null, ?string $notes = null): void
    {
        $roleId = $role instanceof Role ? $role->id : Role::where('slug', $role)->first()?->id;
        
        if ($roleId && !$this->hasRole($role instanceof Role ? $role->slug : $role)) {
            $this->roles()->attach($roleId, [
                'assigned_at' => now(),
                'assigned_by' => $assignedBy,
                'notes' => $notes,
            ]);
        }
    }

    /**
     * Remove a role from the user
     */
    public function removeRole(Role|string $role): void
    {
        if ($role instanceof Role) {
            $this->roles()->detach($role->id);
        } else {
            $roleId = Role::where('slug', $role)->first()?->id;
            if ($roleId) {
                $this->roles()->detach($roleId);
            }
        }
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function isAdmin()
    {
        return $this->where('role_id', 1)->exists();
    }
}
