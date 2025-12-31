@extends('layouts.app')

@section('title', 'Service Management')
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Service Details</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="font-weight-bold text-primary add-client">
                        Add Service Details
                    </h6>
                    <form method="post" role="form" action="{{route('admin.service.store')}}" class="php-email-form row" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-4 form-group">
                            <label>Select Main Category</label>
                            <select class="form-select" aria-label="Default select example" name="cat_id" id="cat" required>
                                <option selected>Select Category</option>
                                <?php


                                // output data of each row
                                foreach ($categories as $cat_row) {
                                ?>

                                    <option value="<?php echo $cat_row->id; ?>"><?php echo $cat_row->name; ?></option>
                                <?php }
                                ?>

                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Service Title</label>
                            <input type="text" name="title" class="form-control" id="cname" placeholder="Title" required>
                        </div>



                        <div class="col-md-4 form-group">
                            <label>Upload Image</label>

                            <input class="form-control" type="file" name="main_image" id="formFile" required>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Content" required></textarea>
                        </div>

                        <hr>


                        <div class="col-md-4 form-group">
                            <label>Upload PDF</label>
                            <input class="form-control" type="file" name="pdf" id="formFile">
                        </div>


                        <div class="col-md-4 form-group">
                            <label>Upload Video</label>
                            <!--<input class="form-control" type="file" name="video" id="formFile" required>-->
                            <input class="form-control" type="url" name="video" id="formFile">
                        </div>



                        <hr>

                        <div class="col-md-4 form-group">
                            <label>Show on Homepage</label>
                            <select class="form-select" aria-label="Default select example" name="homepage">
                                <option value="1">Yes</option>
                                <option value="0">No</option>

                            </select>
                        </div>


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
                                    <th>Service Title</th>
                                    <th>Main Category</th>
                                    <th>Image</th>
                                    <th>PDF</th>
                                    <th>Youtube Video</th>
                                    <th>On Homepage</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                $i = 1;
                                if (count($services) > 0) {
                                    // output data of each row
                                    foreach ($services as $row) {


                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><?php echo $row->title; ?></td>
                                            <td><?php echo $row->catname; ?></td>
                                            <td><img src="<?php echo asset('main-images/services/' . $row->main_image); ?>" width="100px"></td>
                                            <?php if (!empty($row->pdf)) { ?><td><a href="pdf/<?php echo $row->pdf; ?>"><img src="<?php echo asset('main-images/pdf-icon.png'); ?>"></a></td>
                                            <?php } else {
                                                echo "<td></td>";
                                            }
                                            if (!empty($row->video)) { ?><td><iframe width="100%" height="150" src="<?php echo $row->video; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></td>
                                            <?php } else {
                                                echo "<td></td>";
                                            } ?>
                                            <td><?php echo $row->homepage; ?></td>
                                            <td class="edit-section display">

                                                <a href="{{route('admin.service.edit', $row->sid)}}">
                                                    <button class="btn btn-success">
                                                        Edit </button>
                                                </a>


                                                <form action="{{ route('admin.service.delete', $row->sid) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this service?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                <?php }
                                } ?>
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