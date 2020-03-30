<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DateController extends Controller
{
    public function findDate(Request $request)
    {
        $date = $request->query('date');
        $a = explode('-', $date);
        $b = true;
        foreach ($a as $val) {
            if ($val == '') {
                $b = false;
            } else {
                $b = $b && is_int((int)$val);
            }
        }
        // 日期不符合規格
        if (count($a) !== 3 || !$b) {
            return JsonResponse::create([ 'error' => 'the date is not valid.']);
        }
        if (!checkdate($a[1], $a[2], $a[0])) {
            return JsonResponse::create([ 'error' => 'the date does not exist.']);
        }
        $dateTime = new \DateTime($date);
        return date('l', $dateTime->getTimestamp());
    }
}
