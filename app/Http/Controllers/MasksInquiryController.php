<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasksInquiryController extends Controller {
    public function masksInquiry(Request $request) {
        $url = "http://data.nhi.gov.tw/Datasets/Download.ashx?rid=A21030000I-D50001-001&l=https://data.nhi.gov.tw/resource/mask/maskdata.csv";
        $csv = file_get_contents($url);
        $records = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $csv));
        array_pop($records);
        $area = $request->query('area');
        $recordDatas = [];
        
        foreach ($records as $record) {
            if ($area == "") {
                break;
            }
            if (strpos($record[2], $area) !== false) {
                $recordDatas[] = array($record[1], $record[2], $record[4]);
            }
        }
        
        usort($recordDatas, function ($a, $b) {
            if ($a[2] == $b[2]) {
                return 0;
            }
            return ($a[2] > $b[2]) ? -1 : 1;
        });

        return view('masks-inquiry', ['area'=>$area, 'recordDatas'=>$recordDatas]);
    }
}
