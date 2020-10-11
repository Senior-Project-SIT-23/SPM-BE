<?php

namespace App\Http\Controllers;

use App\Repositories\LoginRepositoryInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class LoginController extends Controller
{
    private $login;

    public function __construct(LoginRepositoryInterface $login)

    {
        $this->login = $login;
    }

    public function checkAuthentication(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'auth_code' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();

        $auth_code = $data['auth_code'];
        $cliend_id = env('CLIEND_ID');
        $secrete_id = env('SECRETE_ID');
        $response = null;
        try {
            $URL = env('SSO_URL') . "/oauth/token?client_secret=${secrete_id}&client_id=${cliend_id}&code=${auth_code}";
            // http://gatewayservice.sit.kmutt.ac.th/api/oauth/token?client_secret=b46Ivmua&client_id=IlNvm&code=SOn2MTlB1I
            $client = new Client(['base_uri' => $URL]);
            $response = $client->request('GET', $URL);

            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody(), true);
            }
        } catch (\Throwable $th) {
            $responseBody = $th->getResponse();
            $body = json_decode($responseBody->getBody(), true);
            return response()->json($body, $responseBody->getStatusCode());
        }
        $this->login->createUser($response);

        if ($response["user_type"] = 'st_group') {
            $response["user_type"] = 'Student';
        } else if ($response["user_type"] = 'inst_group') {
            $response["user_type"] = 'Teacher';
        } else if ($response["user_type"] = 'staff_group') {
            $response["user_type"] = 'AA';
        }
        $new_response = array(
            "token" => $response["token"]["token"],
            "user_id" => $response["user_id"],
            "user_type" => $response["user_type"],
            "name" => $response["name_en"],
            "email" => $response["email"]
        );

        return response()->json($new_response, 200);
    }

    public function checkMe(Request $request)
    {
        $response = null;
        try {
            $token = $request->header('Authorization');
            $headers = ['Authorization' => $token];
            $URL = env('SSO_URL') . "/me";
            // http://gatewayservice.sit.kmutt.ac.th/api/oauth/token?client_secret=b46Ivmua&client_id=IlNvm&code=SOn2MTlB1I
            $client = new Client(['base_uri' => $URL, 'headers' => $headers]);
            $response = $client->request('GET', $URL,);
            $body = json_decode($response->getBody(), true);

            if ($body["user_type"] = 'st_group') {
                $body["user_type"] = 'Student';
            } else if ($body["user_type"] = 'inst_group') {
                $body["user_type"] = 'Teacher';
            } else if ($body["user_type"] = 'staff_group') {
                $body["user_type"] = 'AA';
            }

            $new_body = array(
                "user_id" => $body["user_id"],
                "user_type" => $body["user_type"],
                "name" => $body["name_en"],
                "email" => $body["email"]
            );

            return response()->json($new_body, 200);
        } catch (\Throwable $th) {
            $responseBody = $th->getResponse();
            $body = json_decode($responseBody->getBody(), true);
            return response()->json($body, $responseBody->getStatusCode());
        }
    }
}
