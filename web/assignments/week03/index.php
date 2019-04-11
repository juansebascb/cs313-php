<?php
$page_title = 'Store';
$current_page = htmlspecialchars($_SERVER["PHP_SELF"]);

require 'shared.php';
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = intval(safe_post('item_id'));
    if ($item_id > 0) {
        incrementItemQuantity($item_id);
    }
    header("Location: $current_page"); 
} else {
    require 'navigation.php';
?>
    <main role="main">
        <form name="form_browse" action="<?php echo $current_page; ?>" method="post">
            <input type="hidden" id="item_id" name="item_id" />
            <div class="container-fluid">
                <div class="row">
                    <?php
                    foreach($items as $item) {
                        $item_id = $item['id'];
                        $item_name = $item['name'];
                        $item_price = number_format($item['price'], 2);
                        $item_qty = getCartItemQuantity($item_id);
                    ?>
                    <div class="col-sm-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="card text-white m-3">
                        <img class="card-img-top" src="assets/item_<?php echo $item_id; ?>.jpg" alt="<?php echo $item_name; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo "$item_name ($$item_price)"; ?></h5>
                            </div>
                            <p class="text-center">
                                <button class="btn btn-primary btn-lg" onclick="addToCart(<?php echo "($item_id)"; ?>)">Add to cart <?php echo ($item_qty > 0 ? "<span class=\"badge badge-secondary ml-1\">" . $item_qty . "</span>" : ""); ?></button>
                            </p>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </main>
<?php
}
require 'footer.php';
?>