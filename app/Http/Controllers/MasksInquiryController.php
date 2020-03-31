<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\CallApiException;

class MasksInquiryController extends Controller
{
    public function masksInquiry(Request $request)
    {
        $area = $request->query('area');
        if (!$area) {
            $area = "";
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, "http://laravel.api/api/masks-inquiry-api?area=$area");
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $dataJson = curl_exec($curl_handle);
        curl_close($curl_handle);

        try {
            if (isJson($dataJson) === false) {
                throw new CallApiException('masks-inquiry-api');
            }
            $recordDatas = json_decode($dataJson, true);
            foreach ($recordDatas as &$recordData) {
                $recordData = (array) $recordData;
            }
        } catch (Exception $e) {
            return false;
        }
        
        return view('masks-inquiry', ['area' => $area, 'recordDatas' => $recordDatas]);
    }
}

// https://vector.cool/php-is-json/
function isJson($string)
{
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}
