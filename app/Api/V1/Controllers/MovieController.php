<?php


namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Movie;
use App\Torrents;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
class MovieController extends Controller
{
    use Helpers;
    public function show($id){
//        $currentUser = JWTAuth::parseToken()->authenticate();
        return Movie::find($id);
    }
    public function getAll($limit){
        return Movie::orderBy('id','desc')->paginate($limit);
    }
    public function addMovie(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
        if($currentUser->admin !='1'){
            return view('Forbidden');
        }else {
            $movie = new Movie();
            $movie->title = $request->get('title');
            $movie->title_long = $request->get('title_long');
            $movie->year = $request->get('year');
            $movie->rating = $request->get('rating');
            $movie->runtime = $request->get('runtime');
            $movie->synopsis = $request->get('synopsis');
            $movie->yt_trailer_code = $request->get('yt_trailer_code');
            $movie->small_cover_image = $request->get('small_cover_image');
            $movie->large_cover_image = $request->get('large_cover_image');
            if ($currentUser->movies()->save($movie))
                return $this->response->created();
            else
                return $this->response->error('could_not_create_book', 500);
        }
    }
    public function getTorrent($movieId){
        return Torrents::where('movieId', $movieId)->get();
    }

}
