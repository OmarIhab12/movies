<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actor;
use Validator;

class ActorController extends Controller
{
  // return all the actors details
  public function index()
  {
      $response['request descreption'] = "get all actors details";

      $actors = Actor::all();

      $rowdescreption['id'] = 'int';
      $rowdescreption['name'] = 'string';
      $rows = $actors->toArray();

      $rowset['row descreption'] = $rowdescreption;
      $rowset['rows'] = $rows;

      $response['rowset'] = $rowset;

      $response['rows affected'] = 0;
      return response()->json(['success'=>$response], 200);
  }

  // show a spacefic genra entity details
  public function details($id)
  {
      $response['request descreption'] = "get selected actor entity details";

      $actor = Actor::findOrFail($id);

      $rowdescreption['id'] = 'int';
      $rowdescreption['name'] = 'string';
      $rows = [$actor->toArray()];

      $rowset['row descreption'] = $rowdescreption;
      $rowset['rows'] = $rows;

      $response['rowset'] = $rowset;

      $response['rows affected'] = 0;
      return response()->json(['success'=>$response], 200);
  }

  // create new genra entity
  public function create(Request $request)
  {
      $response['request descreption'] = "create new actor entity";
      $validator = Validator::make($request->all(), [
        'name' => 'required | unique:actors',
      ]);
      if ($validator->fails()) {
        $response['error descreption'] = "the request data has validation errors";
        $response['validation errors'] = $validator->errors();
        return response()->json(['error'=>$response], 400);
      }
      $actor = Actor::create($request->all());

      $rowdescreption['id'] = 'int';
      $rowdescreption['name'] = 'string';
      $rows = $actor->toArray();

      $rowset['row descreption'] = $rowdescreption;
      $rowset['rows'] = $rows;

      $response['rowset'] = $rowset;

      $response['rows affected'] = 1;
      return response()->json(['success'=>$response], 201);
  }

  //update actor details from the database
  public function update(Request $request, $id)
  {
      $response['request descreption'] = "edit selected actor entity details";
      $validator = Validator::make($request->all(), [
        'name' => 'required | unique:actors',
      ]);
      if ($validator->fails()) {
        $response['error descreption'] = "the request data has validation errors";
        $response['validation errors'] = $validator->errors();
        return response()->json(['error'=>$response], 400);
      }

      $actor = Actor::findOrFail($id);
      $actor->update($request->all());
      $actor->save();

      $rowdescreption['id'] = 'int';
      $rowdescreption['name'] = 'string';
      $rows = $actor->toArray();

      $rowset['row descreption'] = $rowdescreption;
      $rowset['rows'] = $rows;

      $response['rowset'] = $rowset;

      $response['rows affected'] = 1;
      return response()->json(['success'=>$response], 200);
  }

  // delete actor from the database
  public function delete($id)
  {
      $response['request descreption'] = "delete actor entity";

      $actor = Actor::findOrFail($id);
      $actor->delete();


      $response['rows affected'] = 1;
      return response()->json(['success'=>$response], 200);
  }
}
