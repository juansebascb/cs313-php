<?php
    require 'shared.php';
    $page_title = 'Sign-up';
    require 'header.php';

    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["sign-up"])) {
                $user_name = safe_post('user_name');
                $user_password = safe_post('user_password');
          
                $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
                $insert = $db->prepare('INSERT INTO cs313_php_project.user (user_name, user_password) VALUES (:user_name, :user_password);');
                $insert->execute(array('user_name' => $user_name, 'user_password' => $hashed_password));
          
                header("Location: signin.php"); 
                die();
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

        <input class="form-text" type="text" name="user_name" placeholder="username" />
        <br/>
        <input class="form-control" type="password" name="user_password" placeholder="password" />
        <br/>
        <input class="btn btn-primary" type="submit" name="sign-up" value="Sign-up" />
    </form>

<?php
    require 'footer.php';
?>