<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanPersetujuanTeknisResource extends JsonResource
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
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'no_bast_admin' => $this->no_bast_admin,
            'tgl_bast_admin' => $this->tgl_bast_admin,
            'catatan' => $this->catatan,
            'status' => $this->status,
            'jenis_bast' => $this->jenis_bast,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'permohonan_persetujuan_teknis_file' => PermohonanPersetujuanTeknisFileResource::collection($this->whenLoaded('permohonan_persetujuan_teknis_file')),
            'permohonan_persetujuan_teknis_timeline' => PermohonanPersetujuanTeknisTimelineResource::collection($this->whenLoaded('permohonan_persetujuan_teknis_timeline')),
        ];

        return $result;
    }
}
