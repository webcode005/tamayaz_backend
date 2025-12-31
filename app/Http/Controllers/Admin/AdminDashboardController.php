<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function category()
    {
        echo "asddsa";
    }


    public function service()
    {

        // Fetch All category from DB
        $cat_sql = "SELECT id, name FROM tl_cat ORDER BY id ASC";
        $categories = DB::select($cat_sql);

        // Fetch All Services from DB
        $services = DB::table('tl_products as p')
            ->leftJoin('tl_cat as c', 'p.cat_id', '=', 'c.id')
            ->select(
                'p.id as Pid',
                'p.cat_id',
                'p.subcat_id',
                'p.title',
                'p.pdf',
                'p.video',
                'p.homepage',
                'p.main_image',
                'c.id as cid',
                'c.name as catname'
            )
            ->orderBy('p.id', 'desc') // FIXED
            ->get();




        /*    
if (isset($_POST['submit'])) {

    $cat_id = $_POST['cat_id'];


    $name = $_POST['name'];
    $title = $_POST['title'];

    $url_key = str_replace("---", "-", preg_replace("/[^-a-zA-Z0-9s]/", "-", strtolower(trim($title))));


    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $seo_title = mysqli_real_escape_string($conn, $_POST['seo_title']);
    $seo_keyword = mysqli_real_escape_string($conn, $_POST['seo_keyword']);
    $seo_description = mysqli_real_escape_string($conn, $_POST['seo_description']);

    $homepage = $_POST['homepage'];



    $main_image = time() . '_' . $_FILES['main_image']['name'];
    //   $image1 =time().'_'.$_FILES['image1']['name'];
    //   $image2 =time().'_'.$_FILES['image2']['name'];
    //   $image3 =time().'_'.$_FILES['image3']['name'];
    //   $image4 =time().'_'.$_FILES['image4']['name'];


    if (!empty($_FILES['main_image']['tmp_name'])) {

        move_uploaded_file($_FILES['main_image']['tmp_name'], 'main-images/products/' . $main_image);
    }

    //   //gallery image 1

    //     if(!empty($_FILES['image1']['tmp_name'])) {

    //      move_uploaded_file($_FILES['image1']['tmp_name'],'main-images/gallery/'.$image1);
    //   }




    //   //gallery image 2

    //     if(!empty($_FILES['image2']['tmp_name'])) {

    //      move_uploaded_file($_FILES['image2']['tmp_name'],'main-images/gallery/'.$image2);
    //   }



    //   //gallery image 3

    //     if(!empty($_FILES['image3']['tmp_name'])) {

    //      move_uploaded_file($_FILES['image3']['tmp_name'],'main-images/gallery/'.$image3);
    //   }



    //   //gallery image 4

    //     if(!empty($_FILES['image4']['tmp_name'])) {

    //      move_uploaded_file($_FILES['image4']['tmp_name'],'main-images/gallery/'.$image4);
    //   }




    //gallery image 5

    //  if(!empty($_FILES['image5']['tmp_name'])) {

    //   move_uploaded_file($_FILES['image5']['tmp_name'],'main-images/gallery/'.$image5);
    // }


    // pdf

    $pdf = $_FILES['pdf']['name'];

    if (!empty($_FILES['pdf']['tmp_name'])) {

        move_uploaded_file($_FILES['pdf']['tmp_name'], 'pdf/' . $pdf);
    }
    // video

    //   $video =time().'_'.$_FILES['video']['name'];

    $video = $_POST['video'];

    //     if(!empty($_FILES['video']['tmp_name'])) {

    //      move_uploaded_file($_FILES['video']['tmp_name'],'video/'.$video);
    //   }



    $reg_date = date("Y-m-d");

    $sql = "INSERT INTO `tl_products` ( `homepage`,`cat_id`,`sname`, `url`, `title`, `detail`, `pdf`, `main_image`, `gimg1`, `gimg2`, `gimg3`, `gimg4`, `video`, `seo_title`, `seo_keyword`, `seo_description`, `reg_date`) VALUES ('$homepage','$cat_id', '$name', '$url_key', '$title', '$description', '$pdf', '$main_image', '$image1', '$image2', '$image3', '$image4','$video', '$seo_title', '$seo_keyword', '$seo_description', '$reg_date')";


    if ($conn->query($sql) === TRUE) {

        echo "<script>alert('Product Added Successfully');window.location='add-product.php'</script>";
    } else {
        echo "<script>alert('Failed');window.location='add-product.php'</script>";
    }
}

if (!empty($_GET['id'])) {
    // sql to delete a record
    $sql = "DELETE FROM tl_products WHERE id=" . $_GET['id'];

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Product deleted Successfully');window.location='add-product.php'</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

*/

        return view('admin.service.index', compact('categories', 'services'));
    }
}
