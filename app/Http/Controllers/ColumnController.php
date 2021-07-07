<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Board $board, Request $request)
    {
        if(!$board) {
            return response()->json(['status' => false, 'msg' => 'There was an error, this board does not exist.']);
        }

        $validate = $request->validate([
            'name' => ['required', 'max:50'],
            'order' => ['required'],
        ]);

        $column = new Column();

        $column->name = $validate['name'];
        $column->board_id = $board->id;
        $column->order = $validate['order'];

        $column->save();

        $column = Column::where('id', $column->id)->with('tasks')->first();

        return response()->json($column);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Column $column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function destroy(Column $column)
    {
        $column->delete();

        return Redirect::route('boards.index');
    }
}
