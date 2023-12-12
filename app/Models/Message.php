<?php

namespace App\Models;

use App\Traits\HasRepositoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory, HasRepositoryTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'receiver_id',
        'initiator_id',
        'chat_key',
        'message',
    ];

    /**
     * Relationship.
     *
     * @var array<int, string>
     */
    public array $relationships = [
        "receiver",
        "initiator"
    ];

    /**
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * @return BelongsTo
     */
    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiator_id');
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
    public function getReceiverId(): int
    {
        return $this->attributes['receiver_id'];
    }

    /**
     * @return int
     */
    public function getInitiatorId(): int
    {
        return $this->attributes['initiator_id'];
    }

    /**
     * @return User|null
     */
    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    /**
     * @return User|null
     */
    public function getInitiator(): ?User
    {
        return $this->initiator;
    }

    /**
     * @return int
     */
    public function getChatKey(): int
    {
        return $this->attributes['chat_key'];
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->attributes['message'];
    }
}
