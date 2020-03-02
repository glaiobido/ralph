<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    private $totalRecords;
    private $dataTableDraw;

     /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource, $totalRecords, $draw)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        
        $this->totalRecords = $totalRecords;
        $this->dataTableDraw = $draw;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'draw' => $this->dataTableDraw,
            'recordsTotal' => $this->totalRecords,
            'recordsFiltered' => $this->collection->count(),
            'data' => $this->collection,
        ];
    }
}
