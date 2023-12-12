<?php

namespace App\Abstractions\Interfaces;

use App\Models\Contact;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

interface ChatMessageInterface
{

    /**
     *
     * @param User $user
     * @return array
     */
    public static function getAllUsers(User $user): array;

    /**
     * @param User $user
     * @return array
     */
    public static function getAllUserContacts(User $user): array;

    /**
     *
     * @param User $owner
     * @param int $userId
     * @return Contact|null
     */
    public static function addToContact(User $owner, int $userId): ?Contact;

    /**
     *
     * @param string $chatKey
     * @return array
     */
    public static function getMessages(string $chatKey): array;

    /**
     * @param User $initiator
     * @param string $chatKey
     * @param string $message
     * @return void
     */
    public static function sendMessage(User $initiator, string $chatKey, string $message): void;
}
