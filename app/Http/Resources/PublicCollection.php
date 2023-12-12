<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PublicCollection extends BaseCollection
{
    public function __construct($resource, protected string $name)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request)
    {
        return [
            $this->name => $this->collection,
            'pagination' => $this->pagination
        ];
    }
}
