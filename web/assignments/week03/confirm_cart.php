<?php
$cart_total = number_format(getCartTotal(), 2);
?>
<table class="table table-responsive-sm text-right">
    <thead>
        <th>&nbsp;</th>
        <th>Price</th>
        <th class="text-center">Quantity</th>
        <th>Total</th>
    </thead>
    <tbody>
        <?php
            foreach($cart as $item_id => $item_qty) {
                $item = getItem($item_id);
                $item_name = $item['name'];
                $item_price = number_format($item['price'], 2);
                $item_total = number_format($item_qty * $item['price'], 2);
            ?>
            <tr>
                <td class="text-left align-middle cart-item"><img src="assets/item_<?php echo $item_id; ?>.jpg" class="img-thumbnail mr-4 d-none d-md-inline" alt="<?php echo $item_name; ?>" /> <?php echo $item_name; ?></td>
                <td class="align-middle"><?php echo "$$item_price"; ?></td>
                <td class="text-center align-middle"><?php echo $item_qty; ?></td>
                <td class="align-middle"><?php echo "$$item_total"; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="4" class="text-right font-weight-bold"><?php echo "$$cart_total"; ?></td>
        </tr>
    </tbody>
</table>