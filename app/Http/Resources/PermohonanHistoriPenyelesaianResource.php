<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PermohonanHistoriPenyelesaianResource extends JsonResource
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
            'id_permohonan' => $this->id_permohonan,
            'id_proses_permohonan' => $this->id_proses_permohonan,
            'jumlah_hari' => $this->jumlah_hari,
            'is_pengembalian' => $this->is_pengembalian,
            'jenis_bast' => $this->jenis_bast,
            'is_terlambat' => $this->when(isset($this->proses_permohonan), function() {
                $isTerlambat = ($this->jumlah_hari <= $this->proses_permohonan->batas_waktu) ? false : true;
                return $isTerlambat;
            }),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y H:i'),
            'deleted_at' => Carbon::parse($this->deleted_at)->format('d-m-y H:i'),
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan')),
            'proses_permohonan' => new ProsesPermohonanResource($this->whenLoaded('proses_permohonan'))
        ];

        return $result;
    }
}
