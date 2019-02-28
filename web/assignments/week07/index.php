<?php
    require 'shared.php';
    $page_title = 'TO-DO';
    require 'header.php';

    try {
        $user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["log-out"])) {
                $user_id = 0;
            }
        }
        
        if ($user_id == 0) {
          session_destroy();
          header("Location: signin.php");
          die();
        }
        $user_query = $db->prepare('SELECT user_name FROM cs313_php_project.user WHERE user_id = :user_id;');
        $user_query->execute(array('user_id' => $user_id));
        $user = $user_query->fetch();
        $user_name = $user['user_name'];
      }
      catch (PDOException $ex) {
        print "<p>error: {$ex->getMessage()} </p>\n\n";
        die();
      }

    try {
        $query = $db->prepare('SELECT content, list_id FROM list WHERE user_id=:user_id');
        $query->execute(array('user_id' => $user_id));
    }
    catch (PDOException $ex) {
        print "<p>error: {$ex->getMessage()} </p>\n\n";
        die();
    }

    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!empty($_POST["add"])) {
                $content = safe_post('content');

                $insert = $db->prepare('INSERT INTO list (content, user_id) VALUES (:content, :user_id);');
                $insert->execute(array('content' => $content, 'user_id' => $user_id));
            }
            elseif (!empty($_POST["edit"])) {
                $list_id = $_POST["edit"];
                $content = safe_post('edited_content');

                $edit_content = $db->prepare('UPDATE list SET content = :content WHERE list_id = :list_id');
                $edit_content->execute(array('content' => $content, 'list_id' => $list_id));
            }
            elseif (!empty($_POST["done"])) {
                $list_id = $_POST["done"];

                $delete_content = $db->prepare('DELETE FROM list WHERE list_id = :list_id');
                $delete_content->execute(array('list_id' => $list_id));
            }
      
            header("Location: index.php");
            die();
        }
    }
    catch (PDOException $ex) {
        print "<p>error: {$ex->getMessage()} </p>\n\n";
        die();
    }

    require 'navigation.php';
    $content = "";
    $edited_content = "";
?>
<form name="form" action="<?php echo $current_page; ?>" method="post">
    <main role="main" class="container">
        <h1><?php echo $user_name; ?>'s TO-DO list</h1>

        <ul class="list-group">
        <?php foreach($query as $row) { ?>
            <li class="list-group-item" style="color: #3E4649;">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </button>

                    <?php echo $row['content']; ?>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="btn btn-primary" type="submit" name="done" value="<?php echo $row['list_id']; ?>">Done</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $row['list_id']; ?>">Edit</button>
                    </div>
                </div>

                <div class="modal fade" id="<?php echo $row['list_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $row['list_id']; ?>Title" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="<?php echo $row['list_id']; ?>Title">Edit Item</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea type="text" id="form7" class="md-textarea form-control" style="width:50vw;display: inline-block;" placeholder="<?php echo $row['content']; ?>" rows="1" name="edited_content"><?php echo $edited_content;?></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" name= "edit" value="<?php echo $row['list_id']; ?>">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        <?php } ?>
        </ul>
    </main>
    
    <div class="md-form" style="width:100vw; text-align:center;">
        <textarea type="text" id="form7" class="md-textarea form-control" style="width:50vw;display: inline-block;" placeholder="Task to add" rows="1" name="content"><?php echo $content;?></textarea>
        <br>
        <input type="submit" class="btn btn-primary btn-sm" name="add" value="Add">
    </div>
</form>
<?php
    require 'footer.php';
?>