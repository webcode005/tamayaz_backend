@extends('layouts.app')
@section('title', 'Update Category Details')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Update Category Details</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">

                    <h6 class="font-weight-bold text-primary add-client">Update Category Details</h6>
                    <form method="post" role="form" class="php-email-form1 row" action="{{route('admin.category.update', $categories->id)}}" enctype="multipart/form-data">
                        @csrf


                        <div class="col-md-4 form-group">
                            <label>Category Name</label>
                            <input type="text" name="cat_name" class="form-control" id="cname" placeholder="Title" value="<?php echo $categories->name; ?>">
                        </div>


                        <div class="col-md-4 form-group">
                            <label>Main Category Image</label>

                            <input class="form-control" type="file" name="main_image" id="formFile">
                            <input type="hidden" name="hidden_main_image" value="<?php echo $categories->main_image; ?>">
                            <div style="margin-top:10px;">
                                <img src="{{ asset('main-images/categories/'.$categories->main_image) }}" width="100px">
                            </div>
                        </div>


                        <div class="col-md-4 form-group">
                            <label>Show on Homepage</label>
                            <select class="form-select" aria-label="Default select example" name="homepage">
                                <option <?php if ($categories->homepage === "1") {
                                            echo "selected ";
                                        } ?>value="1">Yes</option>
                                <option <?php if ($categories->homepage === "0") {
                                            echo "selected ";
                                        } ?>value="0">No</option>

                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Upload PDF</label>
                            <input class="form-control" type="file" name="pdf" id="formFile">
                            <input type="hidden" name="hidden_pdf" value="<?php echo $categories->pdf; ?>">
                            @if(!empty($categories->pdf)) <a href="{{ asset('main-images/pdf/' . $categories->pdf) }}">PDF</a>
                            @endif
                        </div>


                        <div class="col-md-6 form-group">
                            <label>Upload Video</label>
                            <!--<input class="form-control" type="file" name="video" id="formFile" >-->
                            <input class="form-control" type="url" name="video" id="formFile" value="<?php echo $categories->video; ?>">
                        </div>


                        <hr>
                        <div class="col-md-12 form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Content"><?php echo $categories->detail; ?></textarea>
                        </div>

                        <hr>


                        <div class="col-lg-12">
                            <h6 class="font-weight-bold text-primary add-client">
                                SEO SECTION
                            </h6>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="seo_title" id="cmessage" rows="3" placeholder="SEO Title" value="<?php echo $categories->seo_title; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="seo_keyword" id="cmessage" rows="3" placeholder="SEO Keywords" value="<?php echo $categories->seo_keyword; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="seo_description" id="cmessage" rows="3" placeholder="Description"><?php echo $categories->seo_description; ?></textarea>
                        </div>

                        <div class="col-md-12 buttons-submit"><button type="submit" class="btn btn-primary othrCall">Update</button></div>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection