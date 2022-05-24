<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Role;
use App\Models\Dinas;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\BerkasKonsep;
use App\Models\Berkas;
use App\Models\HariLibur;
use App\Models\ProsesPermohonan;
use App\Models\Permohonan;

class SelectListController extends Controller
{
    public function role(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = Role::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function dinas(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = Dinas::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function kecamatan(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = Kecamatan::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function kelurahan(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->id_kecamatan = $request->filled('id_kecamatan') ? $request->id_kecamatan : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = Kelurahan::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function berkasKonsep(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = BerkasKonsep::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function berkas(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = Berkas::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function hariLibur(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = HariLibur::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function prosesPermohonan(Request $request)
    {
        try
        {
            $params = new \stdClass;
            $params->search_field = $request->filled('search_field') ? $request->search_field : 'nama';
            $params->search_value = $request->filled('search_value') ? $request->search_value : null;
            $params->order_field = $request->filled('order_field') ? $request->order_field : 'nama';
            $params->order_sort = $request->filled('order_sort') ? $request->order_sort : 'asc';
            // $params->page = $request->filled('page') ? $request->page : null;
            // $params->per_page = $request->filled('per_page') ? $request->per_page : null;
            $params->jenis = $request->filled('jenis') ? $request->jenis : null;
            $params->status = true;

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = ProsesPermohonan::get_data('list', $params);
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function permohonanBastAdminHist($id_induk_awal)
    {
        try
        {
            $permohonan = Permohonan::select(['id', DB::raw("('Pengajuan ' || permohonan_ke) AS permohonan_ke")])
            ->where('id_induk_awal', $id_induk_awal)
            ->where('is_bast_admin', true)->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = $permohonan;
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function permohonanBastFisikHist($id_induk_fisik_awal)
    {
        try
        {
            $permohonan = Permohonan::select(['id', DB::raw("('Pengajuan ' || permohonan_fisik_ke) AS permohonan_fisik_ke")])
            ->where('id_induk_fisik_awal', $id_induk_fisik_awal)
            ->where('is_bast_fisik', true)->get();

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil ditampilkan';
            $this->responseData = $permohonan;
        }
        catch (\Exception $ex) 
        {
            $this->responseCode = 500;
            $this->responseMessage = $ex->getMessage();
        }
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
