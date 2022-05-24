<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use File;

class PermohonanKoreksiKonsepDetailFileResource extends JsonResource
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
                $link = url('api/show_file/permohonan_koreksi_konsep_detail/' . $this->id);
            }
        }
        
        $result = [
            'id' => $this->id,
            'nama' => $this->nama,
            'path' => $this->path,
            'ukuran' => $this->ukuran,
            'ext' => $this->ext,
            'is_gambar' => $this->is_gambar,
            'link' => $link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'permohonan_koreksi_konsep_detail' => new PermohonanKoreksiKonsepDetailResource($this->whenLoaded('permohonan_koreksi_konsep_detail'))
        ];

        return $result;
    }
}
