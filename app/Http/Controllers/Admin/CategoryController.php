<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch All category from DB
        $cat_sql = "SELECT id, name, homepage,url, main_image FROM categories ORDER BY id DESC";
        $categories = DB::select($cat_sql);

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // print_r($request->all());


        $validator = Validator::make($request->all(), [


            'cat_name'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'seo_title'        => 'nullable|string|max:255',
            'seo_keyword'      => 'nullable|string|max:255',
            'seo_description'  => 'nullable|string',
            'homepage'         => 'required|in:0,1',
            'main_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'pdf'              => 'nullable|mimes:pdf|max:5120',
            'video'            => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            dd($validator->errors(), $request->all());
        }

        // ✅ Slug (URL Key)
        $url_key = Str::slug($request->cat_name);


        // ✅ Upload Main Image
        $main_image = null;
        if ($request->hasFile('main_image')) {
            $main_image = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')->move(public_path('main-images/categories'), $main_image);
        }

        // ✅ Upload PDF
        $pdf = null;
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->move(public_path('main-images/categories/pdf'), $pdf);
        }

        // ✅ Insert using Query Builder
        $inserted = DB::table('categories')->insert([
            'homepage'        => $request->homepage,

            'url'             => $url_key,
            'name'            => $request->cat_name,
            'detail'          => $request->description,
            'pdf'             => $pdf,
            'main_image'      => $main_image,
            'video'           => $request->video,
            'seo_title'       => $request->seo_title,
            'seo_keyword'     => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            'reg_date'        => now()->toDateString(),
        ]);

        if ($inserted) {
            return redirect()->back()->with('success', 'Record inserted successfully');
        }

        dd('Insert failed');
    }

    /**
     * Display the specified resource.
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    public function edit(Request $request, $id)
    {
        // Fetch all categories
        $categories = DB::table('categories')
            // ->select('id', 'name', 'main_image', 'pdf', 'video', 'detail')
            ->select()
            ->where('id', $id)
            ->first();

        if (!$categories) {
            abort(404, 'Category not found');
        }

        return view('admin.category.edit', compact('categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        // update record

        //dd($request->all());
        $id = $request->route('id');
        // ✅ Validate input
        $validated = $request->validate([

            'homepage'         => 'required|in:0,1',
            'cat_name'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'seo_title'        => 'nullable|string|max:255',
            'seo_keyword'      => 'nullable|string|max:255',
            'seo_description'  => 'nullable|string',
            'video'            => 'nullable|string|max:255',
            // 'main_image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'pdf'              => 'nullable|mimes:pdf|max:5120',
            // 'hidden_main_image' => 'nullable|string',
            'hidden_pdf'       => 'nullable|string',
        ]);

        // ✅ Slug
        $url_key = Str::slug($validated['cat_name']);

        /* ===========================
       Main Image Upload
    ============================ */
        if ($request->hasFile('main_image')) {
            $main_image = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')
                ->move(public_path('main-images/categories'), $main_image);
        } else {
            $main_image = $request->hidden_main_image;
        }

        /* ===========================
       PDF Upload
    ============================ */
        if ($request->hasFile('pdf')) {
            $pdf = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->move(public_path('main-images/categories/pdf'), $pdf);
        } else {
            $pdf = $request->hidden_pdf;
        }

        /* ===========================
       Update Query
    ============================ */
        $updated = DB::table('categories')
            ->where('id', $id)
            ->update([
                'homepage'        => $validated['homepage'],

                'name'           => $validated['cat_name'],
                'url'             => $url_key,
                'detail'          => $validated['description'],
                'seo_title'       => $validated['seo_title'],
                'seo_keyword'     => $validated['seo_keyword'],
                'seo_description' => $validated['seo_description'],
                'video'           => $validated['video'],
                'pdf'             => $pdf,
                'main_image'      => $main_image,
                'updated_at'      => now(),
            ]);

        // ✅ Result handling
        if ($updated) {
            //return redirect()->back()->with('success', 'Category Updated Successfully');
            return redirect('/admin/category')->with('success', 'Category Updated Successfully');
        }

        return redirect()->back()->with('error', 'No changes were made');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            return redirect()->back()->with('error', 'category not found');
        }

        if ($category->main_image && file_exists(public_path('main-images/categories/' . $category->main_image))) {
            unlink(public_path('main-images/categories/' . $category->main_image));
        }

        if ($category->pdf && file_exists(public_path('main-images/categories/pdf/' . $category->pdf))) {
            unlink(public_path('main-images/categories/pdf/' . $category->pdf));
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'category deleted successfully');
    }
}
