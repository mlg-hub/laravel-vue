<?php

namespace App\Http\Requests;

use App\Comment;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;

class PostValid extends Request
{

    public function wantsJson()
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Validator::extend('canReply', function ($attributes, $value, $parameter){
           if(!$value){
               return true; //si tu ne veux pas commenter
           }
            $comment = Comment::find($value);

            if($comment){
                return $comment->reply == 0;
            }

            return false;

        });
        return [
            'username' => 'required|max:255',
            'email'=> 'required|email',
            'reply'=>'canReply'
        ];
    }
}
