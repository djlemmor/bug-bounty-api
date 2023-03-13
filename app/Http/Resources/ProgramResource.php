<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'type' => 'Programs',
            'attributes' => [
                'name' => $this->name,
                'pentesting_start_date' => (string) $this->pentesting_start_date,
                'pentesting_end_date' => (string) $this->pentesting_end_date,
            ],
            'relationships' => [
                'reports' => [
                    'data' => ReportResource::collection($this->reports),
                ],
            ]
        ];
    }
}
