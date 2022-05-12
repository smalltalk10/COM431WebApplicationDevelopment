<?php

namespace App\Http\Controllers;
use App\Models\Comment; // use comment
use Illuminate\Http\Request; // use request
use Illuminate\Support\Facades\Validator; //use validator
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMessage;

class AjaxCOMMENTCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    //fetches comments from db
    public function fetchComments()
    {
        $comments = Comment::all(); 
        return response()->json([ 
            'comments'=>$comments,
        ]);
    }
    //fetches comments from db orderedBy comment type
    public function fetchCommentsByType()
    {
        $comments = Comment::orderBy('type')->get(); 
        return response()->json([ 
            'comments'=>$comments,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @property messages
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //Form Validation
        $validator = Validator::make($request->all(), [
            'type'=> 'required',
            'comment'=>'required|max:999',
            'author'=>'required|max:25',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|max:50',
            'effect'=>'required',
            'validated'=>'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        }
        else
        {
            $comment = new Comment;
            $comment->type = $request->input('type');
            $comment->comment = $request->input('comment');
            $comment->author = $request->input('author');
            $comment->email = $request->input('email');
            $comment->effect = $request->input('effect');
            $comment->validated = $request->input('validated');
            
            $comment->save();
            
            

            if($comment->validated == 0){
                return response()->json([
                    'status'=>200,
                    Mail::to('me@somewhere.com')->send(new SendMessage($request->input('author'))),
                    'message'=>'Comment Suggested Successfully'
                ]);
            }
            if($comment->validated == 1){
                return response()->json([
                    'status'=>200,
                    'message'=>'Comment Added Successfully'
                ]);
            }
            
        }
    }
      
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $comment = Comment::find($id);
        if($comment)
        {
            return response()->json([
                'status'=>200,
                'comment'=> $comment,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Comment Found.'
            ]);
        }
    }

    /**
     * Update an existing resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   //Form Validation
        $validator = Validator::make($request->all(), [
            'type'=> 'required',
            'comment'=>'required|max:999',
            'author'=>'required|max:25',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|max:50',
            'effect'=>'required',
            'validated'=>'required',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->getMessageBag()
            ]);
        }
        else
        {
            $comment = Comment::find($id);
            if($comment)
            {
                $comment->type = $request->input('type');
                $comment->comment = $request->input('comment');
                $comment->author = $request->input('author');
                $comment->email = $request->input('email');
                $comment->effect = $request->input('effect');
                $comment->validated = $request->input('validated');
                
                $comment->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Comment with id:'.$id. ' Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Comment Found.'
                ]);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if($comment)
        {
            $comment->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Comment Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Comment Found.'
            ]);
        }
    }
}