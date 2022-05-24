<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PermohonanKonsepTimelineResource extends JsonResource
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
            'is_revisi' => $this->is_revisi,
            'jenis_bast' => $this->jenis_bast,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y H:i'),
            'deleted_at' => Carbon::parse($this->deleted_at)->format('d-m-y H:i'),
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'berkas_konsep' => new BerkasKonsepResource($this->whenLoaded('berkas_konsep')),
            'permohonan_konsep_file' => PermohonanKonsepFileResource::collection($this->whenLoaded('permohonan_konsep_file'))
        ];

        return $result;
    }
}
