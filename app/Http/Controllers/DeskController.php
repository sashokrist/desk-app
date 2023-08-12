<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Desk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DeskController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $desks = Desk::get();

        return view('desk.create', compact('desks', 'categories'));
    }

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

        $desk = new Desk([
            'name' => $request->name,
            'symbol' => $request->symbol,
            'position_x' => $request->position_x,
            'position_y' => $request->position_y,
        ]);

        $desk->category()->associate($request->category_id);
        $desk->save();
        return response()->json(['success' => 'Desk created successfully.']);
    }

    public function edit(Desk $desk)
    {
        if (Gate::denies('viewAny', Desk::class)) {
            abort(403, 'Unauthorized');
        }
        $categories = Category::all();
        return view('desk.edit', compact('desk', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('viewAny', Desk::class)) {
            abort(403, 'Unauthorized');
        }
        $desk = Desk::findOrFail($id);
        $desk->name = $request->name;
        $desk->symbol = $request->symbol;

        // Update the category relation if a new category is selected
        if ($request->has('category_id')) {
            $desk->category()->associate($request->category_id);
        }

        $desk->save();
        $desks = Desk::get();
        $categories = Category::all();
        return response()->json(['success' => 'Desk updated successfully.']);
    }

    public function destroy($id)
    {
        if (Gate::denies('viewAny', Desk::class)) {
            abort(403, 'Unauthorized');
        }
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
            $desk = Desk::findOrFail($request->id);
            $desk->position_x = $request->position_x;
            $desk->position_y = $request->position_y;
            $desk->save();

            return response()->json(['success' => 'Desk position updated successfully.']);
    }
}
