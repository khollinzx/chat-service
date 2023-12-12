<?php

namespace App\Http\Controllers;

use App\Abstractions\Implementations\ChatMessageService;
use App\Http\Requests\MessageRequest;
use App\Services\JsonResponseAPI;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    /**
     * @param ChatMessageService $service
     */
    public function __construct(protected ChatMessageService $service){}


    /** Get All users records
     * @return JsonResponse
     */
    public function fetchAllUsers(): JsonResponse
    {
        try {
            $records = $this->service->getAllUsers($this->getUser());

            return JsonResponseAPI::successResponse(count($records)? "all users." : "no record found.", $records);

        } catch (\Exception $exception) {
            Log::error($exception);

            return JsonResponseAPI::internalErrorResponse();
        }
    }

    /** Get All users records
     * @return JsonResponse
     */
    public function fetchAllUserContacts(): JsonResponse
    {
        try {
            $records = $this->service->getAllUserContacts($this->getUser());

            return JsonResponseAPI::successResponse(count($records)? "all user contact." : "no record found.", $records);

        } catch (\Exception $exception) {
            Log::error($exception);

            return JsonResponseAPI::internalErrorResponse();
        }
    }

    /** Get All user contact messages
     * @param string $chatKey
     * @return JsonResponse
     */
    public function fetchUserContactMessages(string $chatKey): JsonResponse
    {
        try {
            $records = $this->service->getMessages($chatKey);

            return JsonResponseAPI::successResponse(count($records)? "all messages." : "no record found.", $records);

        } catch (\Exception $exception) {
            Log::error($exception);

            return JsonResponseAPI::internalErrorResponse();
        }
    }

    /** send message
     * @param int $userId
     * @return JsonResponse
     */
    public function addUserToMyContact(int $userId): JsonResponse
    {
        try {
            return JsonResponseAPI::successResponse("contact saved.",
                $this->service->addToContact($this->getUser(), $userId));

        } catch (\Exception $exception) {
            Log::error($exception);

            return JsonResponseAPI::internalErrorResponse();
        }
    }

    /** send message
     * @param MessageRequest $request
     * @param string $chatKey
     * @return JsonResponse
     */
    public function sendMessageToUserContact(MessageRequest $request, string $chatKey): JsonResponse
    {
        try {
            $validated = $request->validated();
            $this->service->sendMessage($this->getUser(), $chatKey, $validated['message']);

            return JsonResponseAPI::successResponse("message sent.");

        } catch (\Exception $exception) {
            Log::error($exception);

            return JsonResponseAPI::internalErrorResponse();
        }
    }
}
