<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedBack;
use App\Models\User;


class FeedBackController extends Controller
{
    public function getFeedBacks(){
        $feedback = FeedBack::get();
        return response()->json([
            'feedbacks' => $feedback
        ]);
    }

    public function addFeedBack(Request $request){

        $user = User::where('token' ,"=" , $request->token)->get();

        echo $user[0]->id;

        $rating = null;
        if($request->rating !== null){
            $rating = $request->rating ;
        }

        $comment = null;
        if($request->comment !== null){
            $comment = $request->comment ;
        }
    }
}
