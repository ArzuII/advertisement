<?php

namespace App\Http\Controllers\Dashboard\Car;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CarCreateRequest;
use App\Models\Car;

class QueryController extends Controller
{
    public function create()
    {
        return view('dashboard.car.create');
    }

    public function index(Request $request)
    {
        $cars = Car::query()
            ->from('cars as c')
            ->select(
                'c.*',
                'u.name as creator'
            )
            ->join('users as u', 'u.id', 'c.created_by')
            ->whereNull('c.deleted_at');

        if ($request->name != null) 
        {
            $cars = $cars->where('c.name', 'like', "%$request->name%");
        }
        
        if ($request->creator != null) 
        {
            $cars = $cars->where('u.name', 'like', "%$request->creator%");
        }

        $cars = $cars->paginate(5);

        return view('dashboard.car.index', compact('cars'));
    }
    
    public function trash(Request $request)
    {
        $cars = Car::query()
            ->from('cars as c')
            ->select(
                'c.*',
                'u.name as creator'
            )
            ->join('users as u', 'u.id', 'c.created_by')
            ->whereNotNull('c.deleted_at');

        if ($request->name != null) 
        {
            $cars = $cars->where('c.name', 'like', "%$request->name%");
        }
        
        if ($request->creator != null) 
        {
            $cars = $cars->where('u.name', 'like', "%$request->creator%");
        }

        $cars = $cars->paginate(5);
        
    

        return view('dashboard.car.index-trash', compact('cars'));
    }

    public function edit($id)
    {
        $car = Car::query()
            ->where('id', $id)
            ->first();
            
        if (!$car) 
            abort(404);

        return view('dashboard.car.edit', compact('car'));
    }
    

   
}