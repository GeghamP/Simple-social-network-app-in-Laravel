<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function postSignUp(Request $request){
	
		$this->validate($request,[
			'email' => 'email|required|unique:users',
			'first_name' => 'required|max:100|min:7',
			'password' => 'required|min:6'
		]);
		
		$email = $request['email'];
		$first_name = $request['first_name'];
		$password = bcrypt($request['password']);
		
		$user = new User();
		$user->email = $email;
		$user->first_name = $first_name;
		$user->password = $password;
		
		$user->save();
		Auth::login($user);
		
		return redirect()->route('dashboard');
	}
	
	
	public function postSignIn(Request $request){
		$this->validate($request,[
			'email2' => 'email|required',
			'password2' => 'required'
		]);
		if( Auth::attempt(['email' => $request['email2'],'password' => $request['password2']])){
			return redirect()->route('dashboard');
		}
		else{
			return redirect()->back();
		}
	}
	
	public function logOut(){
		Auth::logout();
		
		return redirect()->route('welcome');
	}
	
	public function getAccount(){
		return view('account',['user' => Auth::user()]);
	}
	
	public function editAccount(Request $request){
		$this->validate($request,[
			'first_name' => 'required|max:150',
			'image' => 'image|mimes:jpg,jpeg'
		]);
		
		$user = Auth::user();
		$user->first_name = $request['first_name'];
		$user->update();
		
		$file = $request->file('image');
		$filename = $request['first_name'].'-'.$user->id.'.jpg';
		if($file){
			Storage::disk('local')->put($filename,File::get($file));
		}
		
		return redirect()->route('account');
	}
	
	public function getAccountImage($filename){
		$file = Storage::disk('local')->get($filename);
		
		return new Response($file,200);
	}
}
