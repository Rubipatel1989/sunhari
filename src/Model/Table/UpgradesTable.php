<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UpgradesTable extends Table {

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
    }

    public function getCryptoCurrencyDetails($cryptoCurrency, $currency){
    	
    	//$url = 'https://www.zebapi.com/api/v1/market/ticker/'.$cryptoCurrency.'/'.$currency;

    	$url = 'https://api.coinbase.com/v2/prices/spot?currency='.$currency;

    	$curl = curl_init();
	 
		curl_setopt($curl, CURLOPT_URL, $url);  
		  
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($curl, CURLOPT_ENCODING, ""); 

		curl_setopt($curl, CURLOPT_MAXREDIRS, 10); 

		curl_setopt($curl, CURLOPT_TIMEOUT , 30); 

		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 

		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		$response = curl_exec($curl);

		$err = curl_error($curl);

		curl_close($curl);

		if($err) {
		  return 0;
		} else {
		    return $response = json_decode($response, true); 
		}
    }
}