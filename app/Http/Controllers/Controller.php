<?php

namespace App\Http\Controllers;

use App\Helpers\HelperPublic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

use App\Models\AssessmentTeam;
use App\Models\AssessmentTeamEmployee;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $responseCode = Response::HTTP_OK;
    protected $responseStatus = null;
    protected $responseMessage = null;
    protected $responseData = [];
    protected $responseRequest = [];

    protected function getResponse()
    {
        return HelperPublic::helpResponse($this->responseCode, $this->responseData, $this->responseMessage, $this->responseStatus, $this->responseRequest);
    }
    
    public function syncMaster($data, $url, $id = '')
    {
        $url = ($id == '') ? $this->url_psu_lama().$url : $this->url_psu_lama().$url.'/'.$id;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer xaJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9s'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data) );

        $result=curl_exec ($ch);
        $respon = (array)json_decode($result);
        $code = $respon['code'];

        if(!empty($code)) {
            if($code == 200) {
                $arsip = (array)$respon['data'];
                $id_arsip = $arsip['id'];
            } else
            $id_arsip = NULL;
        } else
        $id_arsip = NULL;

        return $id_arsip;

    }
    
    public function getSyncMaster($url)
    {
        $url = $this->url_psu_lama().$url;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POST, false );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer xaJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9s'
        ));

        $result=curl_exec ($ch);

        $respon = (array)json_decode($result);
        $code = $respon['code'];

        if(!empty($code)) 
        {
            if($code == 200) 
            {
                $data = (array)$respon['data'];
            } 
            else
            $data = NULL;
        } 
        else
        $data = NULL;

        return $data;

    }

    public function url_psu_lama() 
    {
        $url = ENV('PSU_OLD');
        return $url;
    }
}
