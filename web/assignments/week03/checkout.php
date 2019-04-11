<?php
$page_title = 'Checkout';
$current_page = htmlspecialchars($_SERVER["PHP_SELF"]);
$hide_checkout = true;

require 'shared.php';
require 'header.php';

$show_checkout = true;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = safe_post('name');
    $address = safe_post('address');
    $city = safe_post('city');
    $state = safe_post('state');
    $zip = safe_post('zip');    

    if (empty($name)) array_push($errors, 'Name is required');
    if (empty($address)) array_push($errors, 'Address is required');
    if (empty($city)) array_push($errors, 'City is required');
    if (empty($state)) array_push($errors, 'State is required');
    if (!empty($state) && !array_key_exists($state, $states)) array_push($errors, 'State is invalid');
    if (empty($zip)) array_push($errors, 'Zip is required');
    if (!preg_match("/^\d{5}(?:-\d{4})?$/", $zip)) array_push($errors, 'Zip is not valid');

    $show_checkout = (count($errors) > 0);
} else {
    $name = '';
    $address = '';
    $city = '';
    $state = '';
    $zip = '';
}

if (!$show_checkout) {
    saveShipping($name, $address, $city, $state, $zip);
    header("Location: confirmation.php"); 
} else {
    require 'navigation.php';
?>
    <form name="form_checkout" action="<?php echo $current_page; ?>" method="post">
        <div class="container">
            <h2>Checkout</h2>

            <h4 class="mt-5">Shipping Information</h4>
            <?php if (count($errors) > 0) { ?>
                <div class="alert alert-warning">
                    <ul>
                        <?php foreach ($errors as $error) {
                            echo "<li>$error</li>";
                        }?>
                    </ul>
                </div>
            <?php } ?>
            <div class="form-group row">
                <label for="txtName" class="col-md-2 col-form-label">Name</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="txtName" name="name" placeholder="Name" value="<?php echo $name; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="txtAddress" class="col-md-2 col-form-label">Address</label>
                <div class="col-md-10">
                    <input type="text" class="form-control" id="txtAddress" name="address" placeholder="Address"value="<?php echo $address; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label class="d-none d-md-block col-md-2 col-form-label">&nbsp;</label>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="txtCity" name="city" placeholder="City" value="<?php echo $city; ?>" />
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="cmbState" name="state">
                        <?php
                        foreach($states as $state_abbr => $state_name) {
                            $selected = ($state_abbr == $state ? 'selected' : '');
                            echo "<option value=\"$state_abbr\" $selected>$state_name</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtZip" name="zip" placeholder="Zip"  value="<?php echo $zip; ?>" />
                </div>
            </div>

            <h4 class="mt-5">Items in Cart</h4>
            <?php require 'confirm_cart.php'; ?>

            <button  class="btn btn-primary btn-block update">Complete the purchase</button>
            <a href="cart.php" class="btn btn-primary btn-block">Return to Cart</a>
        </div>
    </form>
<?php
}
require 'footer.php';
?>