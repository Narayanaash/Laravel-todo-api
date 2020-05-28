<?php

namespace App\Http\Controllers;
use App\Todo;
use App\Http\Resources\Todo as TodoResource;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $items = Todo::all();

        return TodoResource::collection($items);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|max:255',
        ]);

        $todo = Todo::create($request->all());

        return (new TodoResource($todo))
                ->response()
                ->setStatusCode(201);
    }

    public function update($id)
    {
        $item = Todo::findOrFail($id);
        $item->done = true;

        if ($item->save()) {
            return response()->json(['msg' => 'updated'], 200);
        } else {
            return response()->json(['msg' => 'error updating'], 404);
        }

    }

    public function delete($id)
    {
        $item = Todo::findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}
