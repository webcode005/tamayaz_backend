<?php

namespace App\Http\Controllers;

use App\Models\Service;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // return response()->json(Service::all());
        // return response()->json(
        //     Service::select('id', 'title', 'main_image', 'cat_id')->get()
        // );
        return response()->json(
            Service::select('services.id AS sid', 'title', 'services.main_image AS p_main_image', 'c.id AS cat_id', 'name AS category_name')
                ->leftjoin('categories AS c', 'services.cat_id', '=', 'c.id')
                ->where('c.homepage', 1)
                ->get()
        );
    }

    public function show($id)
    {
        return response()->json(Service::findOrFail($id));
    }
}
