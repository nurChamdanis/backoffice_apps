<?php

namespace Modules\Api\App\Http\Controllers\Travel;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Klick\App\Http\Controllers\KlickController;

class KeretaController extends Controller
{
    public function listStation(KlickController $klik)
    {
        $d = $klik->station();
        if($d->rc == "00"){
            return successResponse('Sukses', $d->data);
        }else {
            return successResponse('Sukses', $d);
        }
    }

    public function cariJadwal(Request $request, KlickController $klik)
    {
        $t = $klik->searchTrain($request);
        if($t->rc == "00"){
            return successResponse('Sukses', $t->data);
        }else {
            return successResponse('Sukses', $t);
        }
    }

    public function bookingTrain(Request $request, KlickController $klik)
    {
        $t = $klik->bookTrain($request);
        if($t->rc == "00"){

            $data = array(
                'bookingCode'   => $t->data->bookingCode,
                'transactionId' => $t->data->transactionId,
                'price'         => intval($t->data->normalSales),
                'expired'       => $t->data->timeLimit,
                'passengers'    => $t->data->passengers,
                'seats'         => $t->data->seats,
            );
            return successResponse('Sukses', $data);
        }else {
            return successResponse('Sukses', $t);
        }
    }

    public function layoutSeatTrain(Request $request, KlickController $klik)
    {
        $t = $klik->layoutSeat($request);
        if($t->rc == "00"){
            return successResponse('Sukses', $t->data);
        }else {
            return successResponse('Sukses', $t);
        }
    }

    public function changeLayoutSeatTrain(Request $request, KlickController $klik)
    {
        $t = $klik->changeSeat($request);
        if($t->rc == "00"){
            return successResponse('Sukses', $t->data);
        }else {
            return successResponse('Sukses', $t);
        }
    }

    public function paymentBookingTrain(Request $request, KlickController $klik)
    {
        $t = $klik->paymentTrain($request);
        if($t->rc == "00"){
            return successResponse('Sukses', $t->data);
        }else {
            return successResponse('Sukses', $t);
        }
    }
}
