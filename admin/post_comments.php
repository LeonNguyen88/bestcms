<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->

<?php include "includes/admin_navigation.php"; ?>


<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">

                
                <h1 class="page-header">
                    Welcome To Comments
                    <small>Author</small>
                </h1>

<?php 

if(isset($_POST['checkBoxArray'])) {

    foreach ($_POST['checkBoxArray'] as $postValueId) {
        
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'published':
                
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}' ";
                $update_to_published_status = mysqli_query($connection, $query);

                confirmQuery($update_to_published_status);
                break;

            case 'draft':
                
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueId}' ";
                $update_to_draft_status = mysqli_query($connection, $query);

                confirmQuery($update_to_draft_status);
                break;   

            case 'delete':
                
                $query = "DELETE FROM posts WHERE post_id = '{$postValueId}' ";
                $update_to_delete_status = mysqli_query($connection, $query);

                confirmQuery($update_to_delete_status);
                break; 

            case 'clone':

                $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                $select_post_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_array($select_post_query)) {

                    $post_title             = $row['post_title'];
                    $post_category_id       = $row['post_category_id'];
                    $post_date              = $row['post_date'];
                    $post_author            = $row['post_author'];                   
                    $post_status            = $row['post_status'];
                    $post_image             = $row['post_image'];
                    $post_tags              = $row['post_tags'];
                    $post_content           = $row['post_content'];
                    
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
                $copy_query = mysqli_query($connection, $query);
                if(!$copy_query) {
                    die("Query Failed" . mysqli_error($connection));
                }
                break;
            
            default:
                # code...
                break;
        }

    }
}


 ?>


<form action="" method="post">

<table class="table table-bordered table-hover">

    <div id="bulkOptionsContainer" class="col-xs-4">
        
        <select class="form-control" name="bulk_options" style="margin-left: -15px;">            
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>


    </div>

<div class="col-xs-4">
    
    <input type="submit" name="submit" class="btn btn-success" value="Apply">
    <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>

</div>    


<table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>In response to</th>
                            <th>Date</th>
                            <th>Aprrove</th>
                            <th>Unaprrove</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>




<?php 

$query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']) ." ";
$select_comments = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_comments)) {

	$comment_id                	= $row['comment_id'];
	$comment_post_id            = $row['comment_post_id'];
	$comment_author             = $row['comment_author'];
	$comment_content            = $row['comment_content'];
	$comment_email       		= $row['comment_email'];
	$comment_status             = $row['comment_status'];
	$comment_date              	= $row['comment_date'];


echo "<tr>";

echo "<td><input name='checkBoxArray[]'  type='checkbox' class='checkBoxes' value='<?php echo $comment_id ?>'></td>";

echo "<td>{$comment_id}</td>";
echo "<td>{$comment_author}</td>";
echo "<td>{$comment_content}</td>";


    // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
    // $select_categories_id = mysqli_query($connection, $query);

    // while($row = mysqli_fetch_assoc($select_categories_id)) {
    // $cat_id = $row['cat_id'];
    // $cat_title = $row['cat_title']; 

    // echo "<td>{$cat_title}</td>";

    // }


echo "<td>{$comment_email}</td>";
echo "<td>{$comment_status}</td>";

$query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
$select_post_id_query = mysqli_query($connection, $query);

while($row = mysqli_fetch_assoc($select_post_id_query)) {

$post_id 	= $row['post_id'];
$post_title = $row['post_title'];

echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";

}

echo "<td>{$comment_date}</td>";
echo "<td><a href='post_comments.php?approve=$comment_id&id=" . $_GET['id'] ."'>Aprrove</a></td>";
echo "<td><a href='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] ."'>Unaprrove</a></td>";
echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] ."'>Delete</a></td>";
echo "</tr>";
}
 ?>

                    </tbody>
                </table>

<?php 


if(isset($_GET['approve'])) {

$the_comment_id = $_GET['approve'];
$query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id ";
$approve_comment_query = mysqli_query($connection, $query);
header("Location: post_comments.php?id=" . $_GET['id']." ");

}



if(isset($_GET['unapprove'])) {

$the_comment_id = $_GET['unapprove'];
$query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
$unapprove_comment_query = mysqli_query($connection, $query);
header("Location: post_comments.php?id=" . $_GET['id']." ");

}



if(isset($_GET['delete'])) {

$the_comment_id = $_GET['delete'];
$query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
$delete_query = mysqli_query($connection, $query);
header("Location: post_comments.php?id=" . $_GET['id']." ");

}

 ?>




  </div>
            </div>
            <!-- /.row -->

        </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>