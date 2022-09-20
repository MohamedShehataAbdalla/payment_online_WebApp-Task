<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\FatoorahServices;

class PaymentController extends Controller
{

    private $fatoorahServices;

    public function __construct(FatoorahServices $fatoorahServices){

        $this->fatoorahServices = $fatoorahServices;

    }

    public function paymentOrder(){
        $data =  [
            "CustomerName" => "Mohamed Shehata",
            "CustomerMobile" => "01119421377",
            "NotificationOption" => "LNK",
            "InvoiceValue" => 1000,
            "CustomerEmail" => "moh.shehata143@gmail.com",
            "CallBackUrl" => 'http://emr.local/api/callback',
            "ErrorUrl" => 'http://emr.local/api/error',
            "Language" => app()->getLocale(),
            "DisplayCurrencyIso" => 'SAR',
        ];

        return $this->fatoorahServices->sendPayment($data);
    }

    public function paymentCallback(Request $request){
        // Save the transaction in database ( Subscriube , payment Status, ... )

        $data = [];
        $data['key'] =  $request->paymentId;
        $data['keyType'] =  'paymentId';
        return $this->fatoorahServices->getPaymentStatus($data);

    }

    public function paymentError(Request $request){
        return $request;
    }

}
