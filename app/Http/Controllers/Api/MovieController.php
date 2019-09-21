<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Genre;
use App\Actor;
use App;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MovieCollection as MovieCollection;

class MovieController extends Controller
{

    // return all the movies details
    public function index()
    {

        $response['request descreption'] = "get group of movies details";

        $number = 10;
        if(request()->has('number') && (int)request()->input('number') > 0){
          $number = request()->input('number');
        }

        $order_by = 'id';
        if(request()->has('order_by')){
          $possible_order_options = ["title", "rating", "release_year"];
          if(in_array(request()->input('order_by'), $possible_order_options)){
            $order_by = request()->input('order_by');
          }
        }

        $order_by_value = 'asc';
        if(request()->has('order_by_value')){
          $possible_order_value_options = ["asc", "desc"];
          if(in_array(request()->input('order_by_value'), $possible_order_value_options)){
            $order_by_value = request()->input('order_by_value');
          }
        }

        $page = 1;
        if(request()->has('page') && (int)request()->input('page') > 0){
          $page = request()->input('page');
        }


        // $movies = Movie::orderBy($order_by, $order_by_value)->paginate($number, ['*'], 'page', $page);

        if(request()->has('genre')){
            if((int)request()->input('genre') > 0){
                $movies = DB::table('movies')
                    ->leftJoin('movie_genre', 'movies.id', '=', 'movie_genre.movie_id')->where('movie_genre.genre_id', request()->input('genre'))
                    ->orderBy($order_by, $order_by_value)->paginate($number, ['*'], 'page', $page);
            }
            else {
                $movies = DB::table('movies')
                    ->leftJoin('movie_genre', 'movies.id', '=', 'movie_genre.movie_id')
                    ->leftJoin('genres', 'genres.id', '=', 'movie_genre.genre_id')
                    ->where('genres.name', request()->input('genre'))
                    ->orderBy($order_by, $order_by_value)->paginate($number, ['*'], 'page', $page);
            }
            $movies->appends(['genre' => request()->input('genre')])->links();
        }
        else{
          $movies = DB::table('movies')
              ->leftJoin('movie_genre', 'movies.id', '=', 'movie_genre.movie_id')
              ->orderBy($order_by, $order_by_value)->paginate($number, ['*'], 'page', $page);
        }
        $movies->appends(['number' => $number])->links();
        $movies->appends(['order_by' => $order_by])->links();
        $movies->appends(['order_by_value' => $order_by_value])->links();

        $rowdescreption['id'] = 'int';
        $rowdescreption['title'] = 'string';
        $rowdescreption['description'] = 'string';
        $rowdescreption['image_url'] = 'string';
        $rowdescreption['rating'] = 'decimal';
        $rowdescreption['release_year'] = 'int';
        $rowdescreption['gross_profit'] = 'string';
        $rowdescreption['director'] = 'string';
        $rowdescreption['genres'] = "array of the movie's genres";
        $rowdescreption['actors'] = "array of the movie's actors";

        foreach ($movies as $movie) {
          $entity = Movie::find($movie->movie_id);
          $movie->genres = $entity->genres;
          $movie->actors = $entity->actors;
        }

        $movies['row descreption'] = $rowdescreption;

        $response['rows affected'] = 0;
        return response()->json(['success'=>$movies], 200);
    }

    // return selected movie details
    public function details($id)
    {
        $response['request descreption'] = "get selected movie details";

        $movie = Movie::findOrFail($id);

        // App::setLocale('de');
        app()->setLocale('fr');
        $frenchText = "hello";
        dd($frenchText);
        $rowdescreption['id'] = 'int';
        $rowdescreption['title'] = 'string';
        $rowdescreption['description'] = trans('string');
        $rowdescreption['image_url'] = 'string';
        $rowdescreption['rating'] = 'decimal';
        $rowdescreption['release_year'] = 'int';
        $rowdescreption['gross_profit'] = 'string';
        $rowdescreption['director'] = 'string';
        $rowdescreption['genres'] = "array of the movie's genres";
        $rowdescreption['actors'] = "array of the movie's actors";

        $row = $movie->toArray();
        $row['genres'] = $movie->genres;
        $row['actors'] = $movie->actors;
        $rows = [$row];


        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;

        $response['rows affected'] = 0;
        return response()->json(['success'=>$response], 200);
    }

    // create new movie entity
    public function create(Request $request)
    {
        $response['request descreption'] = "create new movie entity";
        $validator = Validator::make($request->all(), [
          'title' => 'required',
          'description' => 'required',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
          // 'image_url' => 'required',
          'rating' => 'required | numeric | between:0,10',
          'release_year' => 'required | integer',
          'gross_profit' => 'required',
          'director' => 'required',
        ]);
        if ($validator->fails()) {
          $response['error descreption'] = "the request data has validation errors";
          $response['validation errors'] = $validator->errors();
          return response()->json(['error'=>$response], 400);
        }

        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);
        // dd("omar");
        // $movie = Movie::create($request->all());
        $movie = new Movie;
        $movie->title = $request->input('title');
        $movie->description = $request->input("description");
        $movie->image_url = url('images').'/'.$imageName;
        $movie->rating = $request->input('rating');
        $movie->release_year = $request->input('release_year');
        $movie->gross_profit = $request->input('gross_profit');
        $movie->director = $request->input('director');
        $movie->save();
        // dd($movie->image_url);

        $genres = Genre::find($request->input('genres'));
        $movie->genres()->attach($genres);

        $actors = Actor::find($request->input('actors'));
        $movie->actors()->attach($actors);

        $rowdescreption['id'] = 'int';
        $rowdescreption['title'] = 'string';
        $rowdescreption['description'] = 'string';
        $rowdescreption['image_url'] = 'string';
        $rowdescreption['rating'] = 'decimal';
        $rowdescreption['release_year'] = 'int';
        $rowdescreption['gross_profit'] = 'string';
        $rowdescreption['director'] = 'string';
        $rowdescreption['genres'] = "array of the movie's genres";
        $rowdescreption['actors'] = "array of the movie's actors";

        $row = $movie->toArray();
        $row['genres'] = $movie->genres;
        $row['actors'] = $movie->actors;
        $rows = [$row];

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;
        $response['rows affected'] = 1 + count($actors) + count($genres);
        return response()->json(['success'=>$response], 201);
    }


    // update movie entity
    public function update(Request $request, $id)
    {
        $response['request descreption'] = "create new movie entity";
        $validator = Validator::make($request->all(), [
          'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
          'rating' => 'numeric | between:0,10',
          'release_year' => 'integer',
        ]);
        if ($validator->fails()) {
          $response['error descreption'] = "the request data has validation errors";
          $response['validation errors'] = $validator->errors();
          return response()->json(['error'=>$response], 400);
        }

        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        if($request->hasFile('image')){
          $imageName = time().'.'.request()->image->getClientOriginalExtension();
          request()->image->move(public_path('images'), $imageName);
          $movie->image_url = url('images').'/'.$imageName;
        }

        $affected = $movie->save();
        $numbers_of_affected_rows = 1;

        $genres = Genre::find($request->input('genres'));
        $affected = $movie->genres()->sync($genres);
        $numbers_of_affected_rows += count($affected["attached"]) + count($affected["detached"]) + count($affected["updated"]);

        $actors = Actor::find($request->input('actors'));
        $affected = $movie->actors()->attach($actors);
        $numbers_of_affected_rows += count($affected["attached"]) + count($affected["detached"]) + count($affected["updated"]);

        $rowdescreption['id'] = 'int';
        $rowdescreption['title'] = 'string';
        $rowdescreption['description'] = 'string';
        $rowdescreption['image_url'] = 'string';
        $rowdescreption['rating'] = 'decimal';
        $rowdescreption['release_year'] = 'int';
        $rowdescreption['gross_profit'] = 'string';
        $rowdescreption['director'] = 'string';
        $rowdescreption['genres'] = "array of the movie's genres";
        $rowdescreption['actors'] = "array of the movie's actors";

        $row = $movie->toArray();
        $row['genres'] = $movie->genres;
        $row['actors'] = $movie->actors;
        $rows = [$row];

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;
        $response['rows affected'] = $numbers_of_affected_rows;
        return response()->json(['success'=>$response], 200);
    }

    // delete genre from the database
    public function delete($id)
    {
        $response['request descreption'] = "delete movie entity";

        $movie = Movie::findOrFail($id);
        $affected = $movie->delete();

        $response['rows affected'] = 1;
        return response()->json(['success'=>$response], 200);
    }
}
