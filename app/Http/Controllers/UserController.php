<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
    // function to create user in database from api
    public function create(Request $request){

        // validate if the user email is already taken
        $validator = Validator::make( $request->all() , ['email' => 'exists:users']);


        $token = Str::random(100);

        // if validation fails then the email is not taken and you can create one
        if ($validator->fails()){
            // validate if the data is valid or not
            $validator = Validator::make( $request->all() , [
                'email' => ['max:100' , 'email' , 'required'],
                'name' => ['max:100' , 'required'],
                'password' => ['min:8' , 'max:100'  , 'required'],
                'phone' => ['min:10' , 'max:20', 'required'],
                'birthDate' => ['required'],
            ]);

            if ($validator->fails()){

                // the response if the data was invalid while validation
                return Response::json([
                    "status_code" => "400",
                    'message'=> "Invalid Data",
                    'user' => [
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'phone' => $request['phone'],
                        'birthDate' => $request['birthDate'],
                        'token'=> $token,
                    ]
                ] , 400 );

            }else{

                // insert data into database
                User::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'phone' => $request['phone'],
                    'birthDate' => $request['birthDate'],
                    'token'=> $token,
                ]);


                // the response if the data was valid while validation
                return Response::json([
                    "status_code" => "200",
                    'message'=> "validated successfully ",
                    'user' => [
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'password' => Hash::make($request['password']),
                        'phone' => $request['phone'],
                        'birthDate' => $request['birthDate'],
                        'token'=> $token,
                    ]
                ] , 200 );
            }

        } else {

            // the response id the email is taken
            return Response::json([
                "status_code" => "409",
                'message'=> "Your Email as Already Taken",
                'user' => null
            ] , 409 );

        }
    }

    public function uploadImage(Request $request){

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = "UserImage-".uniqid().Str::random(40).".". $ext;
        $image->move(public_path('images/UserImages') , $imageName);

        $response = User::where('token' , $request['token'])->update(['image' => $imageName]);

        return response()->json([
            'Status Code' => "200",
            'Status Message' => "image uploaded Successfully",
            'user Token' => $request['token'],
            'image' => $imageName
        ],200);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|string'
        ]);

        //Check email

        $user= User::where('email', $request['email'])->first();

        //Check Password
        if(!$user || !Hash::check($fields['password'], $user->password) ){
            return response()->json([
                'status Code' => '401',
                'message'=>'Invalid Credentials',
                'token' => null
            ], 401);
        }

        $token = User::select('token')->where('email' , $request['email'])->get();

        return response()->json([
            'status Code' => '200',
            'message'=>'valid Email and Password',
            'token' => $token[0]->token
        ],200);
    }

    public function getUserData(Request $request){
        $user= User::where('token', '=' , $request['token'])->get();
        if($user[0]->image !== null){
            $user[0]->image =  "http://192.168.1.9/Gaya-Store/public/images/UserImages/".$user[0]->image;
        }
        return response()->json([
            'statusCode' => 200,
            "message" => "Data Retrieved Successfully",
            "user" => $user[0]
        ]);
    }


    public function updateUserData(Request $request){
        if($request->password == null){
            User::where('token' , '=' , $request->token)->update([
                'name' => $request->name ,
                'phone' => $request->phone,
                'birthDate' => $request->birthDate,
            ]);

            $user = User::where('token' , '=' , $request->token)->get();
            return response()->json([
                'statusCode' => 200,
                'message' => 'data not the password updated successfully',
                'user' => $user[0],
            ]);

        }else {
            User::where('token' , '=' , $request->token)->update([
                'name' => $request->name ,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'birthDate' => $request->birthDate,
            ]);
            $user = User::where('token' , '=' , $request->token)->get();


            return response()->json([
                'statusCode' => 200,
                'message' => 'data updated successfully',
                'user' => $user[0],
            ]);
        }


    }
}
