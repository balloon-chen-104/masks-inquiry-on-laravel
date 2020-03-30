<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasksInquiryController extends Controller {
    public function masksInquiry(Request $request) {
        $area = $request->query('area');
        if(!$area){
            $area = "";
        }
        $masksInquiryApi = "http://laravel.api/api/masks-inquiry-api?area=$area";
        $dataJson = file_get_contents($masksInquiryApi);
        
        $recordDatas = json_decode($dataJson, true);
        foreach($recordDatas as &$recordData){
            $recordData = (array) $recordData;
        }

        return view('masks-inquiry', ['area'=>$area, 'recordDatas'=>$recordDatas]);
    }
}
