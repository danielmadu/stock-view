<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Repositories\StockRepository;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('stock/{symbol}')->group(function () {
    Route::get('/', function ($symbol) {
        $dateEnd = Carbon::now();
        $dateEnd->setHour('16');

        $dateStart = Carbon::now();
        $dateStart->setHour('9');
        $dateStart->setMinute('30');

        $minutesToStart = $dateStart->diffInMinutes(Carbon::now('US/Eastern'), false);
        $minutesToEnd = Carbon::now('US/Eastern')->diffInMinutes($dateEnd, false);

        if($minutesToStart < 0 && $minutesToEnd >= 0) {
            return response()->json([
                'stopLogging' => true
            ]);
        }
        $stockRepository = new StockRepository();
        $response = $stockRepository->getStock($symbol);

        return response()->json([
            'latestPrice' => $response->latestPrice,
            'latestTime' => $response->latestTime,
            'change' => $response->change,
            'changePercent' => $response->changePercent
        ]);
    });

    Route::get('company', function ($symbol) {
        $stockRepository = new StockRepository();
        $response = $stockRepository->getCompany($symbol);
        return response()->json([
            'companyName' => $response->companyName,
            'exchange' => $response->exchange,
            'logoUrl' => $response->logoUrl,
        ]);
    });

    Route::get('history/{range}', function ($symbol, $range) {
        $stockRepository = new StockRepository();
        $response = $stockRepository->getHistory($symbol, $range);
        return response()->json($response->data ?? $response);
    });
});
