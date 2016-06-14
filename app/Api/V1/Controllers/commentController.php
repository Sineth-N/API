<?php
namespace App\Api\V1\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use JWTAuth;
use App\comment;
use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class commentController extends Controller
{
    use Helpers;
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser
            ->comments()
            ->orderBy('created_at', 'DESC')
            ->get()
            ->toArray();
    }
    public function store(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $comment = new comment;

        $comment->author =$currentUser->name;
        $comment->comment=$request->get('comment');
        $comment->movieId=$request->get('movieId');

        if($currentUser->comments()->save($comment))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_book', 500);
    }
    public function getAll($movieId){
        return comment::where('movieId',$movieId)->paginate(5);
    }
    public function show($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $book = $currentUser->books()->find($id);

        if(!$book)

            throw new NotFoundHttpException;

        return $book;
    }

    public function update(Request $request, $id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $book = $currentUser->books()->find($id);
        if(!$book)
            throw new NotFoundHttpException;

        $book->fill($request->all());

        if($book->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_book', 500);
    }

    public function destroy($id)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        $comment = $currentUser->comments()->where('movieId',$id)->first();

        if(!$comment){
            throw new NotFoundHttpException;
        }
        if( $comment->user_id == $currentUser->id){
            if($comment->delete()){
                return $this->response->accepted();
            }else return $this->response->error('unable to delete ', 500);

        } else return $this->response->error('unauthorized action', 500);
}
    private function currentUser() {
        return JWTAuth::parseToken()->authenticate();
    }

}
