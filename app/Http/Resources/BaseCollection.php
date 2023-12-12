<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    protected $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => (int)$resource->total(),
            'count' => (int)$resource->count(),
            'perPage' => (int)$resource->perPage(),
            'currentPage' => (int)$resource->currentPage(),
            'totalPages' => (int)$resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    /**
     * @param Request $request
     * @param JsonResponse $response
     */
    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        $response->setContent(json_encode($jsonResponse));
    }
}
