<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use File;

class PermohonanKonsepFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $link = null;
        if(!empty($this->path)) {
            if(File::exists(storage_path('app/' . $this->path))) {
                $link = url('api/show_file/permohonan_konsep/' . $this->id);
            }
        }

        $result = [
            'id' => $this->id,
            'nama' => $this->nama,
            'path' => $this->path,
            'ukuran' => $this->ukuran,
            'ext' => $this->ext,
            'is_gambar' => $this->is_gambar,
            'is_revisi' => $this->is_revisi,
            'jenis_bast' => $this->jenis_bast,
            'link' => $link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'berkas_konsep' => new BerkasKonsepResource($this->whenLoaded('berkas_konsep')),
            'permohonan_konsep_timeline' => PermohonanKonsepTimelineResource::collection($this->whenLoaded('permohonan_konsep_timeline'))
        ];

        return $result;
    }
}
