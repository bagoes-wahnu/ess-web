<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PermohonanTimelineResource extends JsonResource
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
            'status' => $this->status,
            'jenis_bast' => $this->jenis_bast,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-y H:i'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-m-y H:i'),
            'deleted_at' => Carbon::parse($this->deleted_at)->format('d-m-y H:i'),
            'permohonan' => new PermohonanResource($this->whenLoaded('permohonan'))
        ];

        //logo_type 1 = proses
        //logo_type 2 = approve
        //logo_type 3 = pengembalian
        //logo_type 4 = telah membuat konsep
        //logo_type 5 = telah revisi konsep
        //logo_type 6 = telah membuat persetujuan teknis

        $logo_type = null;
        $status_text = null;
        $deskripsi = $this->deskripsi;

        if($this->jenis_bast == 1)
        {
            if($this->status == 1)
            {
                $logo_type = 1;
                $status_text = 'Diproses';
            }
            elseif(in_array($this->status, [3, 6, 9]))
            {
                $logo_type = 2;
                $status_text = 'Disetujui';

                if($this->status == 9) {
                    $status_text = 'Selesai';
                }
            }
            elseif(in_array($this->status, [2, 5]))
            {
                $logo_type = 3;
                $status_text = 'Dikembalikan';
            }
            elseif($this->status == 4)
            {
                $logo_type = 4;
                $status_text = 'Menyusun Konsep';
            }
            elseif($this->status == 7)
            {
                $logo_type = 5;
                $status_text = 'Revisi Konsep';
            }
            elseif($this->status == 8)
            {
                $logo_type = 6;
                $status_text = 'Persetujuan Teknis';
            }

            if(in_array($this->status, [2, 3]))
            {
                $deskripsi = str_replace('Tim Verifikasi', '<a href="javascript:;" onclick="timelineVerifikasi(' . $this->permohonan->id . ');">Tim Verifikasi</a>', $deskripsi);
            }
        }
        elseif($this->jenis_bast == 2)
        {
            if($this->status == 1)
            {
                $logo_type = 1;
                $status_text = 'Diproses';
            }
            elseif(in_array($this->status, [2, 3, 5, 8, 11]))
            {
                $logo_type = 2;
                $status_text = 'Disetujui';

                if($this->status == 11)
                {
                    $status_text = 'Selesai';
                }
            }
            elseif(in_array($this->status, [4, 7]))
            {
                $logo_type = 3;
                $status_text = 'Dikembalikan';
            }
            elseif($this->status == 6)
            {
                $logo_type = 4;
                $status_text = 'Menyusun Konsep';
            }
            elseif($this->status == 9)
            {
                $logo_type = 5;
                $status_text = 'Revisi Konsep';
            }
            elseif($this->status == 10)
            {
                $logo_type = 6;
                $status_text = 'Persetujuan Teknis';
            }

            if(in_array($this->status, [2, 4, 5]))
            {
                $deskripsi = str_replace('Tim Verifikasi', '<a href="javascript:;" onclick="timelineVerifikasi(' . $this->permohonan->id . ');">Tim Verifikasi</a>', $deskripsi);
            }
        }

        $result['logo_type'] = $logo_type;
        $result['status_text'] = $status_text;
        $result['deskripsi'] = $deskripsi;

        return $result;
    }
}
