<?php
$page_title = 'Confirmation';
$current_page = htmlspecialchars($_SERVER["PHP_SELF"]);
$hide_checkout = true;
$hide_view_cart = true;

require 'shared.php';
require 'header.php';
require 'navigation.php';

$shipping = getShipping();
$name = $shipping['name'];
$address = $shipping['address'];
$city = $shipping['city'];
$state = $shipping['state'];
$zip = $shipping['zip'];

?>
<div class="container">
    <h2>Your order is on the way!</h2>
    <h4 class="mt-4">Shipping Information</h4>
    <div>
        <?php echo $name; ?><br/>
        <?php echo $address; ?><br/>
        <?php echo "$city, $state $zip"; ?>
    </div>

    <h4 class="mt-5">Purchased Items</h4>
    <?php require 'confirm_cart.php'; ?>
    <a href="./" class="btn btn-primary btn-block mt-4">Continue shopping</a>
</div>
<?php
require 'footer.php';
emptyCart();
clearShipping();
?>