<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatEvent;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
   public function __construct(){
       $this->middleware('auth');
   }
    public function index(){
        return view('chat');
    }
    public function getMessage(){
        return Chat::with('user')->get();
    }
    public function sendMessage(Request $request){
       $message= auth()->user()->messages()->create([
            'message' =>$request->message
        ]);
        broadcast(new ChatEvent($message->load('user')))->toOthers();

        return ['status' =>'success'];
    }
}
