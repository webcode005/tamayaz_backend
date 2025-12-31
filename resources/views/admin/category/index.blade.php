@extends('layouts.app')

@section('title', 'Category Management')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Category</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="font-weight-bold text-primary add-client">
                        Add Category
                    </h6>
                    <form method="post" role="form" class="php-email-form1 row" action="{{route('admin.category.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-4 form-group">
                            <label>Category Name</label>
                            <input type="text" name="cat_name" class="form-control" id="cname" placeholder="Enter Category Name" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Show on Homepage</label>
                            <select name="homepage" class="form-control" required>
                                <option value="">Are You Sure?</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <!--<div class="col-md-4 form-group">-->
                        <!--   <label>Upload Category Main Image</label>-->
                        <!--   <input class="form-control" type="file" name="images[]" id="formFile" multiple required>-->
                        <!--</div>-->

                        <div class="col-md-4 form-group">
                            <label>Upload Category Main Image</label>
                            <input class="form-control" type="file" name="main_image" id="formFile" required>
                        </div>


                        <div class="col-md-12 form-group">
                            <label>Detail</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Content" required></textarea>
                        </div>

                        <hr>

                        <div class="col-lg-12">
                            <h6 class="font-weight-bold text-primary add-client">
                                Additional Resources
                            </h6>
                            <hr>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Upload PDF</label>
                            <input class="form-control" type="file" name="pdf" id="formFile">
                        </div>


                        <div class="col-md-6 form-group">
                            <label>Upload Video</label>
                            <!--<input class="form-control" type="file" name="video" id="formFile" required>-->
                            <input class="form-control" type="url" name="video" id="formFile">
                        </div>


                        <hr>
                        <div class="col-lg-12">
                            <h6 class="font-weight-bold text-primary add-client">
                                SEO SECTION
                            </h6>
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="seo_title" id="cmessage" rows="3" placeholder="SEO Title" required></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="seo_keyword" id="cmessage" rows="3" placeholder="SEO Keywords" required></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <textarea class="form-control" name="seo_description" id="cmessage" rows="3" placeholder="Description" required></textarea>
                        </div>
                        <div class="col-md-12 buttons-submit"><button type="submit" name="submit" class="btn btn-primary othrCall">Submit</button></div>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Category</th>
                                    <th> URL</th>
                                    <th>Image</th>
                                    <th>On Homepage</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                if (count($categories) > 0) {
                                    // output data of each row
                                    $i = 1;
                                    foreach ($categories as $row) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><?php echo $row->name; ?></td>
                                            <td><?php echo $row->url; ?></td>
                                            <td><img src="<?php echo asset('main-images/categories/' . $row->main_image); ?>" width="100px"></td>
                                            <td><?php if ($row->homepage == '1') {
                                                    echo "Yes";
                                                } else {
                                                    echo "No";
                                                } ?></td>
                                            <td class="edit-section display">

                                                <a href="{{route('admin.category.edit', $row->id)}}">
                                                    <button class="btn btn-success">
                                                        Edit </button>
                                                </a>


                                                <form action="{{ route('admin.category.delete', $row->id) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>

                                <?php
                                    }
                                } else {
                                    echo "0 results";
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#cat").change(function() {
            // alert("The text has been changed.");

            var catid = $("#cat").val();


            jQuery.ajax({
                url: '',
                type: 'post',
                data: 'id=' + catid,
                success: function(result) {
                    console.log(result);
                    // 	jQuery('#tr_'+catid).hide(500);
                    $("#subcat").html(result);
                }
            });



        });
    });
</script>
@endsection