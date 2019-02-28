<?php
    require 'shared.php';
    $page_title = 'Sign-in';
    require 'header.php';

    try {
        $error = '';
        $user_name = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["sign-in"])) {
                $user_name = safe_post('user_name');
                $user_password = safe_post('user_password');
      
                $user_query = $db->prepare('SELECT user_id, user_password FROM cs313_php_project.user WHERE user_name = :user_name;');
                $user_query->execute(array('user_name' => $user_name));
                $user = $user_query->fetch();
                if ($user && password_verify($user_password, $user['user_password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['user_id'];
                    header("Location: index.php"); 
                    die();
                } else {
                    $error = 'Invalid username or password';
                }   
            }
        }
    }
    catch (PDOException $ex) {
        print "<p>error: {$ex->getMessage()} </p>\n\n";
        die();
    }

    require 'navigation.php';
?>

<h1><?php echo $page_title; ?></h1>
<form name="form" action="<?php echo $current_page; ?>" method="post">

    <p id="error" class="error"><?php echo $error; ?></p>

    <input class="form-text" type="text" id="user_name" name="user_name" placeholder="username" value="<?php echo $user_name; ?>" />
    <br/>
    <input class="form-control" type="password" id="user_password" name="user_password" placeholder="password" />
    <br/>
    <input class="btn btn-primary" name="sign-in" type="submit" value="Sign-in" />
</form>
<br/>
<a class="btn btn-danger" href="signup.php">Sign-up</a><br/>

<?php
    require 'footer.php';
?>