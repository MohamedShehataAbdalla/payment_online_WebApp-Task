<?php

namespace App\Http\Services;

use App\Model\User;
// use http\Client;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class FatoorahServices
{

    private $base_url;
    private $headers;
    private $request_client;

    public function __construct(Client $request_client){

        $this->request_client = $request_client;
        $this->base_url = env('FATOORAH_BASE_URL');
        $this->headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Bearer ' .  env('FATOORAH_TOKEN'),
        ];

    }

    public function buildRequest($uri, $method, $data = []){

        $request = new Request ( $method ,  $this->base_url . $uri , $this->headers );
        if (!$data)
            return false;
        
        $response = $this->request_client->send($request , [
            'json' =>  $data
        ]) ;
        
        if ($response->getStatusCode() != 200) {
                return false ;
        }

        $response = json_decode( $response->getBody() , true );

        return $response;

    }

    public function sendPayment($data)
    {
        // if ($response){
        //     $this->saveTransactionPayment($patient_id, $response['Data']['InvoiceId']);
        // }
        return  $this->buildRequest('/v2/SendPayment' , 'POST' , $data);
        

    }

    public function getPaymentStatus($data){
        return  $this->buildRequest('/v2/getPaymentStatus' , 'POST' , $data);
    }



    public function saveTransactionPayment(){

    }

    public function transactionCallback($request){
        return $request;
    }






}
