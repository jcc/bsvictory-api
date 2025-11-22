<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailyProfit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyController extends Controller
{
    public function getDaily(Request $request)
    {
        $date = $request->get('date', Carbon::now()->format('Y-m-d'));

        return DailyProfit::where('date', $date)->first();
    }
}
