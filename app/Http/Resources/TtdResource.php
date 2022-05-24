<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use File;

class TtdResource extends JsonResource
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
                $link = url('api/show_file/ttd_kadis/' . $this->id);
            }
        }

        $link_stempel = null;
        if(!empty($this->path_stempel)) {
            if(File::exists(storage_path('app/' . $this->path_stempel))) {
                $link_stempel = url('api/show_file/stempel/' . $this->id);
            }
        }

        $result = [
            'id' => $this->id,
            'nip' => $this->nip,
            'nama_kadis' => $this->nama_kadis,
            'nama' => $this->nama,
            'path' => $this->path,
            'ukuran' => $this->ukuran,
            'ext' => $this->ext,
            'is_gambar' => $this->is_gambar,
            'link' => $link,
            'nama_stempel' => $this->nama_stempel,
            'path_stempel' => $this->path_stempel,
            'ukuran_stempel' => $this->ukuran_stempel,
            'ext_stempel' => $this->ext_stempel,
            'stempel_is_gambar' => $this->stempel_is_gambar,
            'link_stempel' => $link_stempel,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at
        ];

        return $result;
    }
}
