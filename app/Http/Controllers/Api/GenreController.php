<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Genre;
use Validator;

class GenreController extends Controller
{
    // return all the genres details
    public function index()
    {
        $response['request descreption'] = "get all genres details";

        $genres = Genre::all();

        $rowdescreption['id'] = 'int';
        $rowdescreption['name'] = 'string';
        $rows = $genres->toArray();

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;

        $response['rows affected'] = 0;
        return response()->json(['success'=>$response], 200);
    }

    // show a spacefic genra entity details
    public function details($id)
    {
        $response['request descreption'] = "get selected genre entity details";

        $genre = Genre::findOrFail($id);

        $rowdescreption['id'] = 'int';
        $rowdescreption['name'] = 'string';
        $rows = [$genre->toArray()];

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;

        $response['rows affected'] = 0;
        return response()->json(['success'=>$response], 200);
    }

    // create new genra entity
    public function create(Request $request)
    {
        $response['request descreption'] = "create new genre entity";
        $validator = Validator::make($request->all(), [
          'name' => 'required | unique:genres',
        ]);
        if ($validator->fails()) {
          $response['error descreption'] = "the request data has validation errors";
          $response['validation errors'] = $validator->errors();
          return response()->json(['error'=>$response], 400);
        }
        $genre = Genre::create($request->all());

        $rowdescreption['id'] = 'int';
        $rowdescreption['name'] = 'string';
        $rows = $genre->toArray();

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;

        $response['rows affected'] = 1;
        return response()->json(['success'=>$response], 201);
    }

    //update genre details from the database
    public function update(Request $request, $id)
    {
        $response['request descreption'] = "edit selected genre entity details";
        $validator = Validator::make($request->all(), [
          'name' => 'required | unique:genres',
        ]);
        if ($validator->fails()) {
          $response['error descreption'] = "the request data has validation errors";
          $response['validation errors'] = $validator->errors();
          return response()->json(['error'=>$response], 400);
        }

        $genre = Genre::findOrFail($id);
        $genre->update($request->all());
        $genre->save();

        $rowdescreption['id'] = 'int';
        $rowdescreption['name'] = 'string';
        $rows = $genre->toArray();

        $rowset['row descreption'] = $rowdescreption;
        $rowset['rows'] = $rows;

        $response['rowset'] = $rowset;

        $response['rows affected'] = 1;
        return response()->json(['success'=>$response], 200);
    }

    // delete genre from the database
    public function delete($id)
    {
        $response['request descreption'] = "delete genre entity";

        $genre = Genre::findOrFail($id);
        $genre->delete();


        $response['rows affected'] = 1;
        return response()->json(['success'=>$response], 200);
    }

}
