<?php

namespace App\Abstractions\Implementations;

use App\Abstractions\AbstractClasses\ChatMessageAbstract;
use App\Events\ChatMessageEvent;
use App\Http\Resources\ContactResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UsersResource;
use App\Models\Contact;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ChatMessageService extends ChatMessageAbstract
{

    /**
     * @param User $user
     * @return array
     */
    public static function getAllUsers(User $user): array
    {
        try {
            $data = [];
            $contact = Contact::repo()->getByWhereContact(['owner_id' => $user->getId()]);
            $records = User::repo()->getByWhereNotContact( 'id', $user->getId(), $contact);

            if(count($records))
                collect($records)->each( function ($record) use (&$data) {
                    $data[] = new UsersResource($record);
                });

            return $data;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return [];
        }
    }

    /**
     * @param User $user
     * @return array
     */
    public static function getAllUserContacts(User $user): array
    {
        try {
            $data = [];
            $records = Contact::repo()->getByWhere( ['owner_id' => $user->getId()]);

            if(count($records))
                collect($records)->each( function ($record) use (&$data) {
                    $data[] = new ContactResource($record);
                });

            return $data;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return [];
        }
    }

    /**
     * @param User $owner
     * @param int $userId
     * @return Contact|null
     */
    public static function addToContact(User $owner, int $userId): ?Contact
    {
        try {
            $data = null;
            if(! Contact::repo()->findByWhere(['owner_id' => $owner->getId(), 'user_id' => $userId]))
                $data = Contact::repo()->setUserContact($owner, $userId);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return $data;
    }

    /**
     * @param string $chatKey
     * @return array
     */
    public static function getMessages(string $chatKey): array
    {
        try {
            $data = [];
            $records = Message::repo()->getUserMessages(['chat_key' => $chatKey]);

            if(count($records))
                collect($records)->each( function ($record) use (&$data) {
                    $data[] = new MessageResource($record);
                });

            return $data;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return [];
        }
    }

    /**
     * @param User $initiator
     * @param string $chatKey
     * @param string $message
     * @return void
     */
    public static function sendMessage(User $initiator, string $chatKey, string $message): void
    {
        try {
            $Contact = Contact::repo()->findByWhere(['chat_key' => $chatKey]);
            $message = Message::repo()->createModel([
                'receiver_id' => $Contact->getUserId(),
                'initiator_id' => $initiator->getId(),
                'chat_key' => $chatKey,
                'message' => $message,
            ]);

            //fire up event
            broadcast(new ChatMessageEvent($chatKey, $message));

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

}
