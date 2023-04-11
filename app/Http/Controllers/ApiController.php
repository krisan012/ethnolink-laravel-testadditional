<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserDataService;

class ApiController extends Controller
{
    private $userDataService;

    public function __construct(UserDataService $userDataService)
    {
        $this->UserDataService = $userDataService;
    }

    public function index(Request $request)
    {
        // default view
        return view('api_view');
    }

    /*
    * Illuminate\Http\Request $request
    * fetch data using the UserDataService class
    */ 
    public function fetchData(Request $request)
    {
        $url = $request->input('url');
        $client = new \GuzzleHttp\Client();
        $errorMessage = '';

        try {
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody(), true);

            $result = $this->UserDataService->processUserData($data['users']);

        } catch (\GuzzleHttp\Exception\RequestException $e)
        {
            $errorMessage = $e->getMessage();
        }

        return view('api_view', array_merge(['errorMessage' => $errorMessage], $result));
    }

    
}