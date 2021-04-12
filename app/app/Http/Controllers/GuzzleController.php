<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Psr7;
use Session;
use Exception;
use Illuminate\Support\Facades\View;
use Debugbar;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class GuzzleController extends Controller
{
    protected $token;
    protected $baseUrl;
    public $user;
    public $redis;

    private $client;

    //Constructor method
    public function __constructor()
    {
        //$this->redis = $redis = Redis::connection();

        $this->middleware(function ($request, $next) {

            if (session::has('user')) {
                $this->user = session::get('user');
                // Sharing is caring
                View::share('user', $this->user);
            } else {
                $this->user = NULL;
            }

            return $next($request);
        });

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'bearer ' . $this->user['Token'],
        ];

        $this->client = new Client([
            'headers' => $headers,
            'base_uri' => env('API_URL')
        ]);
    }

    protected function postRequest($url, $body)
    {
        try {
            $response = $this->client->request('POST', $url, ['json' => $body]);
            return json_decode($response->getBody()->getContents(), true);
         } catch (Guzzle\Http\Exception\ClientErrorResponseException | Guzzle\Http\Exception\ServerErrorResponseException | Guzzle\Http\Exception\BadResponseException $e) {
            Log::channel('Guzzle')->emergency(['user' => $this->user['UserName'],'Response' => $e]);
        } catch (Exception $e) {
            //throw new Exception($e->getResponse()->getBody()->getContents());
            throw new Exception($e);
        }
    }

    protected function getRequest($url)
    {
        try {
            //$r = $client->request('GET', env('API_URL') . $url);
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents(), true);
        } catch (Guzzle\Http\Exception\ClientErrorResponseException | Guzzle\Http\Exception\ServerErrorResponseException | Guzzle\Http\Exception\BadResponseException $e) {
            Log::channel('Guzzle')->emergency(['user' => $this->user['UserName'],'Response' => $e]);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
}
