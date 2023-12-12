<?php

namespace App\Models;

use App\Traits\HasRepositoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory, HasRepositoryTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'owner_id',
        'chat_key',
    ];

    /**
     * Relationship.
     *
     * @var array<int, string>
     */
    public array $relationships = [
        "user",
        "owner"
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->attributes['owner_id'];
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return User|null
     */
    public function getOwner(): ?User
    {
        return $this->owner;
    }

    /**
     * @return int
     */
    public function getChatKey(): int
    {
        return $this->attributes['chat_key'];
    }

}
