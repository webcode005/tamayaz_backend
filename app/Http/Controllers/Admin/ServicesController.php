<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch All category from DB
        $cat_sql = "SELECT id, name FROM categories ORDER BY id ASC";
        $categories = DB::select($cat_sql);

        // Fetch All Services from DB
        $services = DB::table('services as s')
            ->leftJoin('categories as c', 's.cat_id', '=', 'c.id')
            ->select(
                's.id as sid',
                's.cat_id',
                's.title',
                's.pdf',
                's.video',
                's.homepage',
                's.main_image',
                's.id as cid',
                'c.name as catname'
            )
            ->orderBy('s.id', 'desc') // FIXED
            ->get();

        return view('admin.service.index', compact('categories', 'services'));
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
            'cat_id'           => 'required|integer',

            'title'            => 'required|string|max:255',
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
        $url_key = Str::slug($request->title);


        // ✅ Upload Main Image
        $main_image = null;
        if ($request->hasFile('main_image')) {
            $main_image = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')->move(public_path('main-images/services'), $main_image);
        }

        // ✅ Upload PDF
        $pdf = null;
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->move(public_path('pdf'), $pdf);
        }

        // ✅ Insert using Query Builder
        $inserted = DB::table('services')->insert([
            'homepage'        => $request->homepage,
            'cat_id'          => $request->cat_id,
            'url'             => $url_key,
            'title'           => $request->title,
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
            ->select('id', 'name')
            ->orderBy('id', 'asc')
            ->get();

        // Fetch single service
        $service = DB::table('services as s')
            ->where('s.id', $id)
            ->select(
                's.id as sid',
                's.cat_id',
                's.title',
                's.detail',
                's.pdf',
                's.video',
                's.homepage',
                's.main_image',
                's.seo_title',
                's.seo_keyword',
                's.seo_description'
            )
            ->first();

        if (!$service) {
            abort(404, 'Service not found');
        }

        return view('admin.service.edit', compact('categories', 'service'));
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
            'cat_id'           => 'required|integer',
            'homepage'         => 'required|in:0,1',
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'seo_title'        => 'nullable|string|max:255',
            'seo_keyword'      => 'nullable|string|max:255',
            'seo_description'  => 'nullable|string',
            'video'            => 'nullable|string|max:255',
            // 'main_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'pdf'              => 'nullable|mimes:pdf|max:5120',
            // 'hidden_main_image' => 'nullable|string',
            'hidden_pdf'       => 'nullable|string',
        ]);

        // ✅ Slug
        $url_key = Str::slug($validated['title']);

        /* ===========================
       Main Image Upload
    ============================ */
        if ($request->hasFile('main_image')) {
            $main_image = time() . '_' . $request->file('main_image')->getClientOriginalName();
            $request->file('main_image')
                ->move(public_path('main-images/services'), $main_image);
        } else {
            $main_image = $request->hidden_main_image;
        }

        /* ===========================
       PDF Upload
    ============================ */
        if ($request->hasFile('pdf')) {
            $pdf = time() . '_' . $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->move(public_path('main-images/services/pdf'), $pdf);
        } else {
            $pdf = $request->hidden_pdf;
        }

        /* ===========================
       Update Query
    ============================ */
        $updated = DB::table('services')
            ->where('id', $id)
            ->update([
                'homepage'        => $validated['homepage'],
                'cat_id'          => $validated['cat_id'],
                'title'           => $validated['title'],
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
            //return redirect()->back()->with('success', 'Service Updated Successfully');
            return redirect('/admin/service')->with('success', 'Service Updated Successfully');
        }

        return redirect()->back()->with('error', 'No changes were made');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = DB::table('services')->where('id', $id)->first();

        if (!$service) {
            return redirect()->back()->with('error', 'Service not found');
        }

        if ($service->main_image && file_exists(public_path('main-images/services/' . $service->main_image))) {
            unlink(public_path('main-images/services/' . $service->main_image));
        }

        if ($service->pdf && file_exists(public_path('main-images/services/pdf/' . $service->pdf))) {
            unlink(public_path('main-images/services/pdf/' . $service->pdf));
        }

        DB::table('services')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Service deleted successfully');
    }
}
