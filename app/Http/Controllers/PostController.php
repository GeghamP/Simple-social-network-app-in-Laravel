<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request){
		
		$this->validate($request,[
			'body' => 'required|max:1000'
		]);
		
		$post = new Post();
		$post->body = $request['body'];
		$message = "There was an error";
		if($request->user()->posts()->save($post)){
			$message = "Post created successfully";
		}
		
		return redirect()->route('dashboard')->with(['message' => $message]);
	}
	
	public function getDashboard(Request $request){
		$posts = Post::orderBy('created_at','DESC')->get();
		//$posts = $request->user()->posts;
		return view('dashboard',["posts" => $posts]);
	}
	
	public function deletePost(Request $request){
		$post = Post::where('id',$request['post_id'])->first();
		if(Auth::user() != $post->user){
			return redirect()->back();
		}
		else{
			$post->delete();
			$request->session()->flash('message', 'Post deleted successfully');
		}	
	}
	
	public function editPost(Request $request){
		if(! Auth::user()){
			return redirect()->route('welcome');
		}
		$this->validate($request,['post_text' => 'required']);
		$post = Post::find($request['post_id']);

		if(Auth::user() != $post->user){
			return redirect()->back();
		}
		else{
			$post->body = $request['post_text'];
			$post->update();
		}	
		
		return response()->json(['new_text' => $post->body],200);
	}
	
	public function likePost(Request $request){
		$post_id = $request['post_id'];
		$is_like = $request['is_like'];
		$update = false;
		
		$post = Post::find($post_id);
		if(!$post){
			return;
		}
		
		$user = Auth::user();
		$like = $user->likes()->where('post_id', $post_id)->first();
		
		if($like){
			$liked_already = $like->is_liked;
			$update = true;
			if($liked_already == $is_like){
				$like->delete();
				return;
			}
		}
		else{
			$like = new Like();
		}
		
		$like->is_liked = $is_like;
		$like->user_id = $user->id;
		$like->post_id = $post->id;
		
		if($update){
			$like->update();
		}
		else{
			$like->save();
		}
	}
	
	public static function verifyStatus(Post $post, $for){
		$liked = Auth::user()->likes()->where('post_id',$post->id)->first() ?? null;
		
		if(is_null($liked)){
			return $for === 'like' ? 'Like' : 'Dislike';
		}
		
		if($liked->is_liked === 1){
			return $for === 'like' ? 'You liked it' : 'Dislike';
		}
		else if($liked->is_liked === 0){
			return $for === 'like' ? 'Like' : 'You disliked it';
		}	
	}
}