<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(){
      if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        $response['request descreption'] = "create new user entity in the database";
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required',
          'c_password' => 'required|same:password',
          'admin' =>'required',
        ]);
        if ($validator->fails()) {
          $response['error descreption'] = "the request data has validation errors";
          $response['validation errors'] = $validator->errors();
          return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $rowdescreption['email'] = 'string';
        $rowdescreption['name'] = 'string';
        $rowdescreption['token'] = 'string';

        $rows['email'] = $user->email;
        $rows['name'] =  $user->name;
        $rows['token'] =  $user->createToken('MyApp')-> accessToken;

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;

        $response['rows affected'] = 1;
        return response()->json(['success'=>$response], 201);
    }
    /**
    * details api
    *
    * @return \Illuminate\Http\Response
    */
    public function details()
    {
      $user = Auth::user();
      return response()->json(['success' => $user], $this-> successStatus);
    }
}
