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

    public function edit(Desk $desk)
    {
        return view('desk.edit', compact('desk'));
    }

    public function update(Request $request, $id)
    {
        $desk = Desk::findOrFail($id);
        $desk->name = $request->name;
        $desk->symbol = $request->symbol;
        $desk->save();

        $desks = Desk::get();
        return view('desk.create', compact('desks'));
    }

    public function destroy($id)
    {
        $desk = Desk::findOrFail($id);
        $desk->delete();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $desks = Desk::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('symbol', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($desks);
    }

    public function updatePosition(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:desks,id',
                'position_x' => 'required|integer',
                'position_y' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->all(),], 422);
            }

            $desk = Desk::findOrFail($request->id);
            $desk->update([
                'position_x' => $request->position_x,
                'position_y' => $request->position_y,
            ]);

            return response()->json(['success' => 'Desk position updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating desk position.'], 500);
        }
    }

}
