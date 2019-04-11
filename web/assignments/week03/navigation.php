<?php
    $hide_view_cart = (isset($hide_view_cart) ? $hide_view_cart : false );
    $hide_checkout = (isset($hide_checkout) ? $hide_checkout : false );
    $cart_qty = getCartQuantity();
?>
<header>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="./">Phone Services</a>
            </div>
            <div class="nav navbar-nav">
                <?php if (!$hide_view_cart) { ?>
                <a href="cart.php" class="<?php echo ($cart_qty == 0 ? "disabled " : ""); ?>btn btn-primary btn-lg mr-2">View Cart <?php echo ($cart_qty > 0 ? "<span class=\"badge badge-pill badge-light ml-1\">" . $cart_qty . "</span>" : ""); ?></a>

                <?php } if (!$hide_checkout) { ?>
                <a href="checkout.php" class="<?php echo ($cart_qty == 0 ? "disabled " : ""); ?>btn btn-primary btn-lg">Checkout</a>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>