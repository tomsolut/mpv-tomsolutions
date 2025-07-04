<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
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

    public function employees()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function employer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all locations owned by this user.
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get total count of devices across all locations.
     */
    public function getTotalDevicesCountAttribute()
    {
        $totalDevices = 0;
        foreach ($this->locations as $location) {
            $totalDevices += $location->getTotalDevicesCountAttribute();
        }
        return $totalDevices;
    }

    /**
     * Get all overdue devices across all locations.
     */
    public function getOverdueDevicesAttribute()
    {
        $overdueDevices = collect();
        foreach ($this->locations as $location) {
            $overdueDevices = $overdueDevices->merge($location->getOverdueDevicesAttribute());
        }
        return $overdueDevices;
    }

    /**
     * Check if user is a doctor.
     */
    public function getIsDoctorAttribute()
    {
        return $this->hasRole('Doctor');
    }

    /**
     * Check if user is an admin.
     */
    public function getIsAdminAttribute()
    {
        return $this->hasRole(['Admin', 'Super Admin']);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
