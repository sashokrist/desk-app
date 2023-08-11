<?php

namespace App\Http\Controllers;

use App\Models\Desk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeskController extends Controller
{
    public function index()
    {
        $desks = Desk::get();

        return view('desk.create', compact('desks'));
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function store(Request $request)
    {
       // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'symbol' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }

        Desk::create([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'position_x' => $request->position_x,
            'position_y' => $request->position_y,
        ]);

        return response()->json(['success' => 'Post created successfully.']);
    }

//    public function updatePosition(Request $request, $id)
//    {
//        $desk = Desk::findOrFail($id);
//        $desk->position_x = $request->position_x;
//        $desk->position_y = $request->position_y;
//        $desk->save();
//
//        return response()->json(['message' => 'Desk position updated successfully.']);
//    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $desks = Desk::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('symbol', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($desks);
    }
}
