
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms/index.php?page=1"><strong>Live On Him</strong></a>
            </div>


            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

<?php 

    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_all_categories_query)) {
    $cat_title = $row['cat_title'];
    $cat_id    = $row['cat_id'];

    $category_class = '';

    $registration_class = '';
    $registration = 'registration.php';

    $contact_class = '';
    $contact = 'contact.php';

    $login_class = '';
    $login = 'login.php';

    $pageName = basename($_SERVER['PHP_SELF']);

    if(isset($_GET['category']) && $_GET['category'] == $cat_id) {

        $category_class = 'active';


    } else if ($pageName == $registration) {

        $registration_class = 'active';
    } else if ($pageName == $contact) {

        $contact_class = 'active';

    } else if ($pageName == $login) {

        $login_class = 'active';
    }

    echo "<li class='$category_class'><a href='category.php?category={$cat_id}'><strong>{$cat_title}</strong></a></li>";
}


?>

                    <?php if(ifLoggedIn()): ?>
                        <li>
                            <a href="/cms/admin"><strong>Admin</strong></a>
                        </li>

                        <li>
                            <a href="/cms/includes/logout.php"><strong>Logout</strong></a>
                        </li>

                    <?php else: ?>

                        <li class="<?php echo $login_class ?>">
                            <a href="/cms/login"><strong>Login</strong></a>
                        </li>

                    <?php  endif; ?>

                    <li class="<?php echo $registration_class ?>">
                        <a href="/cms/registration"><strong>Registration</strong></a>
                    </li>

                    <li class="<?php echo $contact_class ?>">
                        <a href="/cms/contact"><strong>Contact</strong></a>
                    </li>


                    
    <?php 

    if(isset($_SESSION['user_role'])) {

        if(isset($_GET['p_id'])) {

            $the_post_id = $_GET['p_id'];
            echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
        }


    }


     ?>

                </ul>
                    
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>