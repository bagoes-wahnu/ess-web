<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\PermohonanPersetujuanTeknis;
use App\Models\KodeGeneratePerstek;

class HelperPublic
{
    /**
     * Function helpNumeric
     * Fungsi ini digunakan untuk mengecek apakah sebuah variabel berisi nilai yang bersifat numeric (int, float, double).
    * @access public
    * @param (any) $var
    * @param (int) $res
    * @return (int) {0}
    */
    public static function helpNumeric($var, $res = 0)
    {
        return is_numeric($var) ? $var : $res;
    }

    /**
     * Function helpRoman
     * Fungsi ini digunakan untuk merubah angka menjadi bilangan romawi
     * @access public
     * @param (int) $var
     * @return (string) {''}
     */
    public static function helpRoman($var)
    {
        $n = intval($var);
        $result = '';
        $lookup = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        );
        foreach ($lookup as $roman => $value) {
            $matches = intval($n / $value);
            $result .= str_repeat($roman, $matches);
            $n = $n % $value;
        }
        return $result;
    }

    public static function helpRomanToNumeric($var)
    {
        $romans = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        );

        $result = 0;

        foreach ($romans as $key => $value) {
            while (strpos($var, $key) === 0) {
                $result += $value;
                $var = substr($var, strlen($key));
            }
        }
        return $result;
    }

    /**
    * Function helpIndoDay
    * Fungsi ini digunakan untuk mencari nama hari dalam bahasa Indonesia
    * @access public
    * @param (int) $var Nomor urut hari yang dimulai dari angka 0 untuk hari minggu
    * @return (string) {'Undefined'}
    */
    public static function helpIndoDay($var)
    {
        $dayArray = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
        if(array_key_exists($var, $dayArray )){
            return $dayArray[$var];
        }else{
            return 'Undefined';
        }
    }

    /**
    * Function helpIndoMonth
    * Fungsi ini digunakan untuk mencari nama bulan dalam bahasa Indonesia
    * @access public
    * @param (int) $var Nomor urut bulan yang dimulai dari angka 0 untuk bulan januari
    * @return (string) {'Undefined'}
    */
    public static function helpIndoMonth($num)
    {
        $monthArray = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        if(array_key_exists($num, $monthArray)){
            return $monthArray[$num];
        }else{
            return 'Undefined';
        }
    }

    public static function helpShortIndoMonth($num)
    {
        $monthArray = array("Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agst", "Sep", "Okt", "Nov", "Des");
        if(array_key_exists($num, $monthArray)){
            return $monthArray[$num];
        }else{
            return 'Undefined';
        }
    }

    public static function helpReverseMonth($param, $mode='indo')
    {
        if($mode == 'indo'){
            $monthArray = array("januari" => 1, "februari" => 2, "maret" => 3, "april" => 4, "mei" => 5, "juni" => 6, "juli" => 7, "agustus" => 8, "september" => 9, "oktober" => 10, "november" => 11, "desember" => 12);
        }else{
            $monthArray = [];
        }

        if(array_key_exists($param, $monthArray)){
            return $monthArray[$param];
        }else{
            return 'Undefined';
        }
    }

    public static function helpDate($var, $mode = 'se')
    {
        switch($mode){
            case 'se':
                return date('Y-m-d', strtotime($var));
            break;
            case 'si':
                return date('d-m-Y', strtotime($var));
            break;
            case 'me':
                return date('F d, Y', strtotime($var));
            break;
            case 'mi':
                $day = date('d', strtotime($var));
                $month = date('n', strtotime($var));
                $year = date('Y', strtotime($var));

                $month = HelperPublic::helpIndoMonth($month - 1);
                return $day.' '.$month.' '.$year;
            break;
            case 'msi':
                $day = date('d', strtotime($var));
                $month = date('n', strtotime($var));
                $year = date('Y', strtotime($var));

                $month = HelperPublic::helpShortIndoMonth($month - 1);
                return $day.' '.$month.' '.$year;
            break;
            case 'mhi':
                $day = date('d', strtotime($var));
                $month = date('n', strtotime($var));
                $year = date('Y', strtotime($var));
                $time = date('H:i', strtotime($var));

                $month = HelperPublic::helpIndoMonth($month - 1);
                return $day.' '.$month.' '.$year.' '.$time;
            break;
            case 'le':
                return date('l F d, Y', strtotime($var));
            break;
                case 'li':
                $dow = date('w', strtotime($var));
                $day = date('d', strtotime($var));
                $month = date('n', strtotime($var));
                $year = date('Y', strtotime($var));

                $hari = HelperPublic::helpIndoDay($dow);
                $month = HelperPublic::helpIndoMonth($month - 1);
                return $hari .', '. $day.' '.$month.' '.$year;
            break;
            case 'bi':
                $month = date('n', strtotime($var));
                $year = date('Y', strtotime($var));

                $month = HelperPublic::helpIndoMonth($month - 1);
                return $month.' '.$year;
            break;
            default:
                return 'Undefined';
            break;
        }
    }

    /**
     * Function helpSecSql
     * Fungsi ini digunakan untuk merubah variabel menjadi aman sebelum dimasukkan ke dalam database
     * @access public
     * @param (string) $var
     * @return (string)
     */
    public static function helpSecSql($var)
    {
        return addslashes(strtolower($var));
    }

    /**
     * Function helpTerbilang
     * Fungsi ini digunakan untuk merubah angka yang dimasukkan menjadi ejaan
     * @access public
     * @param (int) $var
     * @return (string)
     */
    public static function helpTerbilang($num)
    {
        $num = abs($num);
        $angka = array('', 'satu', 'dua', 'tiga', 'empat', 'lima',
        'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
        $result = '';
        if ($num <12) {
            $result = ' '. $angka[$num];
        } else if ($num <20) {
            $result = self::helpTerbilang($num - 10). ' belas';
        } else if ($num <100) {
            $result = self::helpTerbilang($num/10).' puluh'. self::helpTerbilang($num % 10);
        } else if ($num <200) {
            $result = ' seratus' . self::helpTerbilang($num - 100);
        } else if ($num <1000) {
            $result = self::helpTerbilang($num/100) . ' ratus' . self::helpTerbilang($num % 100);
        } else if ($num <2000) {
            $result = ' seribu' . self::helpTerbilang($num - 1000);
        } else if ($num <1000000) {
            $result = self::helpTerbilang($num/1000) . ' ribu' . self::helpTerbilang($num % 1000);
        } else if ($num <1000000000) {
            $result = self::helpTerbilang($num/1000000) . ' juta' . self::helpTerbilang($num % 1000000);
        } else if ($num <1000000000000) {
            $result = self::helpTerbilang($num/1000000000) . ' milyar' . self::helpTerbilang(fmod($num,1000000000));
        } else if ($num <1000000000000000) {
            $result = self::helpTerbilang($num/1000000000000) . ' trilyun' . self::helpTerbilang(fmod($num,1000000000000));
        }
        return $result;
    }

    /**
     * Function helpResponse
     * Fungsi ini digunakan untuk mengambil response restful
     * @access public
     * @param (string) $code
     * @param (array) $data
     * @param (string) $msg
     * @param (string) $status
     * @return (array)
     */
    public static function helpResponse($code = null, $data = null, $msg = null, $status = null, $request = null)
    {
        switch ($code) {
            case '200':
                $s = 'OK';
                $m = 'Sukses';
                break;
            case '201':
                $s = 'Created';
                $m = 'Data berhasil dibuat';
                break;
            case '202':
                $s = 'Saved';
                $m = 'Data berhasil disimpan';
                break;
            case '204':
                $s = 'No Content';
                $m = 'Data tidak ditemukan';
                break;
            case '304':
                $s = 'Not Modified';
                $m = 'Data gagal disimpan';
                break;
            case '400':
                $s = 'Bad Request';
                $m = 'Fungsi tidak ditemukan';
                break;
            case '401':
                $s = 'Unauthorized';
                $m = 'Silahkan login terlebih dahulu';
                break;
            case '402':
                $s = 'Payment Needed';
                $m = 'User harus melakukan pembayaran terlebih dahulu';
                break;
            case '403':
                $s = 'Forbidden';
                $m = 'Anda tidak dapat mengakses halaman ini, silahkan hubungi Administrator';
                break;
            case '404':
                $s = 'Not Found';
                $m = 'Halaman tidak ditemukan';
                break;
            case '405':
                $s = 'Method Not Allowed';
                $m = 'Metode request tidak diizinkan';
                break;
            case '414':
                $s = 'Request URI Too Long';
                $m = 'Data yang dikirim terlalu panjang';
                break;
            case '422':
                $s = 'Unprocessable Entity';
                $m = 'Data yang Anda inputkan tidak sesuai ketentuan';
                break;
            case '500':
                $s = 'Internal Server Error';
                $m = 'Maaf, terjadi kesalahan dalam mengolah data';
                break;
            case '502':
                $s = 'Bad Gateway';
                $m = 'Tidak dapat terhubung ke server';
                break;
            case '503':
                $s = 'Service Unavailable';
                $m = 'Server tidak dapat diakses';
                break;
            case '504':
                $s = 'Gateway Timeout';
                $m = 'Server tidak merespon';
                break;
            default:
                $s = 'Undefined';
                $m = 'Undefined';
                break;
        }

        $status = ($status != null) ? $status : $s;
        $msg = ($msg != null) ? $msg : $m;
        return [
            'status' => [
                'code' => $code,
                'message' => $msg
            ],
            'data' => $data,
            'request' => $request
        ];
    }

    public static function helpRandomString($length = 10, $token = false)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if ($token) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        }
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // start by: dimas

    public static function helpCurrency($nominal = '', $start = '', $pemisah = '.', $cent = true)
    {
        if (empty($nominal)) {
            $hasil = '-';
        } else {
            $nominal = empty($nominal) ? 0 : $nominal;
            $angka_belakang = ',00';
            $temp_rp = explode('.', $nominal);

            if (count($temp_rp) > 1) {
                $nominal = $temp_rp[0];
                $angka_belakang = ',' . $temp_rp[1];
            }

            if (!$cent) {
                $angka_belakang = '';
            }

            $hasil = $start . number_format($nominal, 0, "", $pemisah) . $angka_belakang;
        }

        return $hasil;
    }

    public static function helpToNum($data)
    {
        $alphabet = array(
            'a', 'b', 'c', 'd', 'e',
            'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y',
            'z'
        );
        $alpha_flip = array_flip($alphabet);
        $return_value = -1;
        $length = strlen($data);
        for ($i = 0; $i < $length; $i++) {
            $return_value +=
                ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
        }
        return $return_value;
    }

    public static function toAlpha($data)
    {
        $alphabet =   array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        if ($data <= 25) {
            return $alphabet[$data];
        } else {
            $dividend = ($data + 1);
            $alpha = '';
            $modulo = '';
            while ($dividend > 0) {
                $modulo = ($dividend - 1) % 26;
                $alpha = $alphabet[$modulo] . $alpha;
                $dividend = floor((($dividend - $modulo) / 26));
            }
            return $alpha;
        }
    }

    public static function helpRename($value = '', $replace_with = '')
    {
        $pattern = '/[^a-zA-Z0-9 &.,-_]/u';

        return preg_replace($pattern, $replace_with, $value);
    }

    public static function helpText($value, $tags = true, $zalgo = true)
    {
        $result = $value;

        if ($tags) {
            $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        }

        if ($zalgo) {
            $pattern = "~[\p{M}]~uis";
            $result = preg_replace($pattern, "", $result);
        }

        return $result;
    }
    // end by: dimas

    public static function roleAsVerificatorWithLocation()
    {
        $role = explode(',', config('myconfig.role.verificator_with_location'));
        return $role;
    }

    public static function roleAsVerificatorWithoutLocation()
    {
        $role = explode(',', config('myconfig.role.verificator_without_location'));
        return $role;
    }

    public static function roleAsVerificator()
    {
        $role = explode(',', config('myconfig.role.verificator'));
        return $role;
    }

    public static function roleAsVerificatorWithLocationWithoutRayon()
    {
        $role = explode(',', config('myconfig.role.verificator_with_location_without_rayon'));
        return $role;
    }

    public static function roleAsVerificatorWithoutRayon()
    {
        $role = explode(',', config('myconfig.role.verificator_without_rayon'));
        return $role;
    }

    public static function roleAsApproveAndCorrectionConceptAdmin()
    {
        $role = explode(',', config('myconfig.role.approve_or_correction_concept_admin'));
        return $role;
    }

    public static function roleAsComposeSurveyFisik()
    {
        $role = explode(',', config('myconfig.role.compose_survey_fisik'));
        return $role;
    }

    public static function roleAsHeadOfCKTR()
    {
        $role = explode(',', config('myconfig.role.head_of_cktr'));
        return $role;
    }

    public static function generateTechnicalApprovalMailNumber($jenis_bast)
    {
        $result = null;
        $templateUtama = ($jenis_bast == 1) ? config('myconfig.generate_code.admin.perstek.template_utama') : config('myconfig.generate_code.fisik.perstek.template_utama');
        $templateNoSeq = ($jenis_bast == 1) ? config('myconfig.generate_code.admin.perstek.template_no_seq') : config('myconfig.generate_code.fisik.perstek.template_no_seq');
        $noTahun = Carbon::now()->year;

        $kodeGeneratePerstek = KodeGeneratePerstek::where('template_utama', $templateUtama)
        ->where('template_no_seq', $templateNoSeq)
        ->where('no_tahun', $noTahun)
        ->where('jenis_bast', $jenis_bast)->first();

        if(empty($kodeGeneratePerstek))
        {
            $kodeGeneratePerstek = new KodeGeneratePerstek();
            $kodeGeneratePerstek->template_utama = ($jenis_bast == 1) ? config('myconfig.generate_code.admin.perstek.template_utama') : config('myconfig.generate_code.fisik.perstek.template_utama');
            $kodeGeneratePerstek->template_no_seq = ($jenis_bast == 1) ? config('myconfig.generate_code.admin.perstek.template_no_seq') : config('myconfig.generate_code.fisik.perstek.template_no_seq');
            $kodeGeneratePerstek->no_seq = 0;
            $kodeGeneratePerstek->no_tahun = $noTahun;
            $kodeGeneratePerstek->jenis_bast = $jenis_bast;
            $kodeGeneratePerstek->save();
        }

        $nextNumber = $kodeGeneratePerstek->no_seq + 1;
        $templateNoSeq = substr_replace($kodeGeneratePerstek->template_no_seq, strval($nextNumber), strlen($kodeGeneratePerstek->template_no_seq) - strlen(strval($nextNumber)));
        $result = str_replace('@template_non_seq', $templateNoSeq, $kodeGeneratePerstek->template_utama);
        $result = str_replace('@no_tahun', strval($noTahun), $result);

        $kodeGeneratePerstek = KodeGeneratePerstek::find($kodeGeneratePerstek->id);
        $kodeGeneratePerstek->no_seq = $nextNumber;
        $kodeGeneratePerstek->save();

        return $result;
    }
}
