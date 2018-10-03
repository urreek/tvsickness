<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request){
        $this->validate($request, [
            'name' => 'required|min:1|max:30',
            'email' => 'required|email',
            'message' => 'required|min:1|max:1024'
        ]);

        return redirect('/contact')->with('success', 'Message Sent');
    }
}
