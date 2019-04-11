<?php
$page_title = 'View Cart';
$current_page = htmlspecialchars($_SERVER["PHP_SELF"]);

require 'shared.php';
require 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = safe_post('action');
    $item_id = intval(safe_post('item_id'));
    if ($action == "empty") {
        emptyCart();
    } else if ($action == "remove") {
        if ($item_id > 0) {
            updateItemQuantity($item_id, 0);
        }
    } else if ($action == "update") {
        foreach($cart as $item_id => $item_qty) {
            if (!isset($_POST["item_$item_id"]) || !ctype_digit($_POST["item_$item_id"])) continue;
            $item_qty = intval(safe_post("item_$item_id"));
            updateItemQuantity($item_id, $item_qty);
        }
    }
    header("Location: $current_page"); 
} else {
    require 'navigation.php';
    $cart_total = number_format(getCartTotal(), 2);
?>
    <form name="form_cart" action="<?php echo $current_page; ?>" method="post">
        <input type="hidden" id="action" name="action" />
        <input type="hidden" id="item_id" name="item_id" />
        <div class="container">
            <h2>Shopping Cart</h2>
            <table class="table table-responsive-sm text-right">
                <thead>
                    <th>&nbsp;</th>
                    <th>Price</th>
                    <th class="text-center">Quantity</th>
                    <th>Total</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    <?php
                    if ($cart_qty == 0) {
                    ?>
                        <tr>
                            <td colspan="5" class="text-center font-weight-bold"><div class="alert alert-primary">Your cart is empty!</div></td>
                        </tr>
                    <?php
                    } else {
                        foreach($cart as $item_id => $item_qty) {
                            $item = getItem($item_id);
                            $item_name = $item['name'];
                            $item_price = number_format($item['price'], 2);
                            $item_total = number_format($item_qty * $item['price'], 2);
                        ?>
                        <tr>
                            <td class="text-left align-middle cart-item"><img src="assets/item_<?php echo $item_id; ?>.jpg" class="img-thumbnail mr-4 d-none d-md-inline" alt="<?php echo $item_name; ?>" /> <?php echo $item_name; ?></td>
                            <td class="align-middle"><?php echo "$$item_price"; ?></td>
                            <td class="text-center align-middle"><input type="text" name="item_<?php echo $item_id; ?>" value="<?php echo $item_qty; ?>" class="cart-qty"/></td>
                            <td class="align-middle"><?php echo "$$item_total"; ?></td>
                            <td class="text-center align-middle"><button class="btn btn-primary btn-sm delete" onclick="removeItem(<?php echo $item_id; ?>)">Delete</button>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="2" class="text-left"><button class="btn btn-primary btn-sm delete" onclick="emptyCart()">Empty Cart</button></td>
                        <td class="text-center"><button class="btn btn-primary btn-sm update" onclick="updateCart()">Update</button>
                        <td class="font-weight-bold"><?php echo "$$cart_total"; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <a href="checkout.php" class="<?php echo ($cart_qty == 0 ? "disabled " : ""); ?>btn btn-primary btn-block">Proceed to Checkout</a>
            <a href="./" class="btn btn-primary btn-block mt-4">Continue shopping</a>
        </div>
    </form>
<?php
}
require 'footer.php';
?>