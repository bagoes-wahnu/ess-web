<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PermohonanPersetujuanTeknisTimelineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'deskripsi' => $this->deskripsi,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y H:i'),
            'deleted_at' => Carbon::parse($this->deleted_at)->format('d-m-y H:i'),
            'permohonan_persetujuan_teknis' => new PermohonanPersetujuanTeknisResource($this->whenLoaded('permohonan_persetujuan_teknis'))
        ];

        return $result;
    }
}
