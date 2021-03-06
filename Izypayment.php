<?php

class Izypayment {
    /**
     * [payment description]
     * @param  [string] $secret : buying number given by the user
     * @param  [int] $amount : total to pay
     * @param  [string] $description : description of the purchase
     * @param  [string] $lang : language for this transaction ('fr' ou 'en')
     * @param  [string] $key : application key provided to authenticate the app
     */
    public function payment($secret, $amount, $description, $lang, $key)
    {
        $root_url = 'https://www.izypayment.com/api/v1/payment/pay';

        $curl_postfields = [
            'secret'         => $request->secret,
            'amount'         => (int) $amount,
            'description'    => $description,
            'lang'           => $lang
        ];

        $headers = array(
            'key' => $key
        );

        $data = [];
        $data = $this->apiCurl($headers, $curl_postfields, $root_url);

        $response_json = (array)json_decode($data['response'], true);
        $response = $response_json['content'];
        $statusCode = $response_json['statusCode'];

        if ($statusCode != 1) {
            $error = $response_json['content']
            /**
             * TODO when error in the transaction
             */
        }

        /**
         * TODO when transaction is successfull
         */
    }


    /**
     * Curl POST
     * @param  [type] $headers         [description]
     * @param  [type] $curl_postfields [description]
     * @param  [type] $url             [description]
     * @return [type]                  [description]
     */
    private function apiCurl($headers, $curl_postfields, $url)
    {
        $curl = curl_init();

        $params = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($curl_postfields),
            CURLOPT_HTTPHEADER => array(
                "key: ".$headers['key']
            ),                                                                                                                                            
        );
        curl_setopt_array($curl, $params);

        $data['response'] = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $data['status'] = $httpcode;
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $data;
        }                                                                                                            
    }

?>
