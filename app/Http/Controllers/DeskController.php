<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeskRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Category;
use App\Models\Desk;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $categories = Category::all();
        $desks = Desk::get();

        return view('desk.create', compact('desks', 'categories'));
    }

    /**
     * Update the position of the desk
     *
     * @param DeskRequest $request
     * @return JsonResponse
     */
    public function store(DeskRequest $request)
    {
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

    /**
     * Update the position of the desk
     *
     * @param DeskRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(DeskRequest $request, $id)
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
        return response()->json(['success' => 'Desk updated successfully.']);
    }

    /**
     * Update the position of the desk
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (Gate::denies('viewAny', Desk::class)) {
            abort(403, 'Unauthorized');
        }
        $desk = Desk::findOrFail($id);
        $desk->delete();

        return response()->json(['success' => 'Desk deleted successfully.']);
    }

    /**
     * Update the position of the desk
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $desks = Desk::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('symbol', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($desks);
    }

    /**
     * Update the position of the desk
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePosition(UpdatePositionRequest $request)
    {
            $desk = Desk::findOrFail($request->id);
            $desk->position_x = $request->position_x;
            $desk->position_y = $request->position_y;
            $desk->save();

            return response()->json(['success' => 'Desk position updated successfully.']);
    }
}
