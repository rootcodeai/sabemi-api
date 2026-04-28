<?php

namespace App\Domain\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Support\Traits\ClearsCacheOnChanges;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, ClearsCacheOnChanges, HasApiTokens;

    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Added role
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
     * Get the base cache tag for the model.
     *
     * @return string
     */
    public function getCacheTag(): string
    {
        return 'users';
    }

    /**
     * Get the cache invalidation rules for the model.
     * Returns an array mapping foreign keys to cache tag prefixes.
     *
     * @return array<string, array<string>>
     */
    public function getCacheInvalidationRules(): array
    {
        return [
            // When a user changes, we might want to clear specific caches related to them
            // For now, just clearing the specific user cache is handled by id -> users:{id}
            'id' => ['users'],
        ];
    }
}
