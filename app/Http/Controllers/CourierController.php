<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'name'); // Default sort by 'name'
        $sortOrder = $request->get('sort_order', 'asc'); // Default ascending
        $search = $request->get('search'); // Filter by name
        $levels = $request->get('level'); // Filter by level
        $paginate = $request->get('paginate'); // Paginate amount

        $query = Courier::query();

        // Filter nama berdasarkan pencarian
        if ($search) {
            $searchPattern = implode('|', explode(' ', $search));
            $query->whereRaw("name REGEXP ?", [$searchPattern]);
        }

        // Filter level
        if ($levels) {
            $levelArray = explode(',', $levels);
            $query->whereIn('level', $levelArray);
        }

        // Sorting
        if (in_array($sortBy, ['name', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc'); // Default sorting
        }

        $couriers = $query->paginate($paginate);

        return view('couriers.index', compact('couriers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('couriers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:couriers,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'sim_number' => 'required|string|max:30',
            'address' => 'nullable|string',
            'level' => 'required|in:1,2,3,4,5',
        ]);

        Courier::create($request->all());

        //Pstikan data telah masuk kedatabase
        if (!Courier::where($request->only(['name', 'code', 'phone', 'email', 'sim_number', 'address', 'level']))->exists()) {
            return redirect()->route('couriers.index')->with('error', 'Courier failed to create');
        }
        return redirect()->route('couriers.index')->with('success', 'Courier created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $courier = Courier::findOrFail($id);
        return view('couriers.show', compact('courier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $courier = Courier::findOrFail($id);
        return view('couriers.edit', compact('courier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50|unique:couriers,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'sim_number' => 'required|string|max:30',
            'address' => 'nullable|string',
            'level' => 'required|in:1,2,3,4,5',
        ]);

        $courier->update($request->all());

        return redirect()->route('couriers.index')->with('success', 'Courier updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();

        // Pastikan data benar-benar terhapus
        if (Courier::find($id)) {
            return redirect()->route('couriers.index')->with('error', 'Courier failed to delete');
        }

        return redirect()->route('couriers.index')->with('success', 'Courier deleted successfully');
    }
}
