<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use League\Csv\Statement;

class MasksInquiryApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/masks-inquiry-api",
     *      tags={"MasksInquiry"},
     *      summary="Get mask datas filter by area",
     *      description="Return mask datas filter by area",
     *      @OA\Parameter(
     *          name="area",
     *          description="Area to search",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     * )
     */
    public function masksInquiryApi(Request $request)
    {
        $url = "http://data.nhi.gov.tw/Datasets/Download.ashx?rid=A21030000I-D50001-001&l=https://data.nhi.gov.tw/resource/mask/maskdata.csv";
        $fileName = basename($url);
        if (file_put_contents($fileName, file_get_contents($url))) {
            // echo "成功下載 maskdata.csv" . PHP_EOL;
        } else {
            // echo "檔案下載失敗" . PHP_EOL;
        }

        $csv = Reader::createFromPath('maskdata.csv', 'r');
        $csv->setHeaderOffset(0); //set the CSV header offset
        $stmt = (new Statement())
            ->offset(0);
        $records = $stmt->process($csv);

        $area = $request->query('area');
        $recordDatas = [];

        foreach ($records as $record) {
            if ($area == "") {
                break;
            }
            if (strpos($record["醫事機構地址"], $area) !== false) {
                $recordDatas[] = array("醫事機構名稱" => $record["醫事機構名稱"],
                                       "醫事機構地址" => $record["醫事機構地址"],
                                       "成人口罩剩餘數" => $record["成人口罩剩餘數"]);
            }
        }

        usort($recordDatas, function ($a, $b) {
            if ($a["成人口罩剩餘數"] == $b["成人口罩剩餘數"]) {
                return 0;
            }
            return ($a["成人口罩剩餘數"] > $b["成人口罩剩餘數"]) ? -1 : 1;
        });

        $transCode = [];
        $i = 0;
        foreach ($recordDatas as $recordData) {
            foreach ($recordData as $key => $value) {
                $transCode[$i][urlencode($key)] = urlencode($value);
            }
            $i++;
        }
        $dataJson = json_encode($transCode);
        $dataJson = urldecode($dataJson);
        return $dataJson;
    }
}
