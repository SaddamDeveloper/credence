<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use DB;
use Hash;

class RegisterController extends Controller
{
    public function registration(Request $request) {

    	$validatedData = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'same:confirm_password'],
			'contact_no' =>  ['required','digits:10','numeric','unique:users'],
		],
		[
			'contact_no.required' => 'Contact no. should be of 10 digits'
		]);

    	$user = User::create([
			'name' => $request->input('name'),
			'email' => $request->input('email'),
			'contact_no' => $request->input('contact_no'),
			'password' =>  Hash::make($request->input('password')),
			'original_password' =>  $request->input('password'),
		]);

		return redirect()->back()->with('msg','Your account has been open successfully.');
    }

    public function registrationPage() {
    	
    	return view('web.user.register');
    }
}
