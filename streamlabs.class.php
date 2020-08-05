<?php

/* 
 * 
 * Author: omerfarukucuk.com - Ömer Faruk Küçük 
 * github.com/omerfarukucuk
 * 
 * */

class StreamLabs 
{

    const API_URL = 'https://streamlabs.com/api/';
    private $API_VERSION = 'v1.0';

    private $CLIENT_ID = '';
    private $CLIENT_SECRET_KEY = '';
    private $REDIRECT_URL = '';
    private $APP_NAME = '';

    public $access_token = '';
    public $token_type = 'Bearer';
    public $expires_in = 3600;
    public $refresh_token = '';

    public function __construct(array $_arr = array())
    {
        $this->CLIENT_ID = $_arr['client_id'];
        $this->CLIENT_SECRET_KEY = $_arr['client_secret'];
        $this->REDIRECT_URL = $_arr['redirect_url'];
        if (isset($_arr['app_name'])){
            $this->APP_NAME = $_arr['app_name'];
        }
        if (isset($_arr['api_version'])) {
            $this->API_VERSION = $_arr['api_version'];
        }
    }

    //
    public function token($code, $grant_type = 'authorization_code', $refresh_token = null)
    {
        $params = [
            'grant_type' => $grant_type,
            'client_id' => $this->CLIENT_ID,
            'client_secret' => $this->CLIENT_SECRET_KEY,
            'redirect_uri' => $this->REDIRECT_URL,
            'code' => $code,
            'refresh_token' => $refresh_token
        ];
        $jsonResponse = $this->_response(
            $this->_curl($this->buildApiUrl('token'), $params),
        );
        if (isset($jsonResponse->access_token)) {
            $this->token = $jsonResponse;
        }
        return $jsonResponse;
    }

    public function authorize($scope = '')
    {
        $params = [
            'response_type' => 'code',
            'client_id' => $this->CLIENT_ID,
            'redirect_uri' => $this->REDIRECT_URL,
            'scope' => $scope
        ];
        return $this->buildApiUrl('authorize') . '?' . http_build_query($params);
    }
 
    private function buildApiUrl($endpoint = '')
    {
        return self::API_URL . $this->API_VERSION . '/' . $endpoint;
    }

    private function _response($response, $returnJson = true)
    {
        if ($returnJson)
            return json_decode($response);
        else
            return $response;
    }

    private function _curl($url, $post = null) 
    {
        if (!extension_loaded("curl")) {
            die('You must install CURL');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json'
        ));
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        if (is_array($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response)
            die('CURL ERROR: ' . curl_error($ch));
        else
            return $response;
    }

}