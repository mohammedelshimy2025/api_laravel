<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Resources\PostResources;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(){

        $posts = PostResources::collection(Post::get());
        return $this->apiResponse($posts,'ok',200);
    }

    public function show($id){

      $post = Post::find($id);

      if($post){
        return $this->apiResponse(new PostResources($post),'ok',200);
      }
        return $this->apiResponse(null ,'The Post Not Null',404);

    }

    public function save(Request $request){

      $validator = Validator::make($request->all(), [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
      ]);

      if($validator->fails()){
        return $this->apiResponse(null,$validator->errors(),201);
      }


      $posts = Post::create($request->all());

      if($posts){
        return $this->apiResponse(new PostResources($posts),'The Post Save',201);
      }
      return $this->apiResponse(null,'The Post Not Save',404);

    }

    public function update(Request $request , $id){

      $validator = Validator::make($request->all(), [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
      ]);

      if($validator->fails()){
        return $this->apiResponse(null,$validator->errors(),201);
      }

      $posts = Post::find($id);
      $posts->update($request->all());

      if($posts){
        return $this->apiResponse(new PostResources($posts),'The Post Update',201);
      }
      return $this->apiResponse(null,'The Post Not Update',404);

    }

    public function delete( $id){

      $posts = Post::find($id);
      if(!$posts){
        return $this->apiResponse(null,'The Post Not Found',404);
      }

      $posts->delete($id);
      if($posts){
        return $this->apiResponse(new PostResources($posts),'The Post deleted',201);
      }
      return $this->apiResponse(null,'The Post Not deleted',404);

    }


}
