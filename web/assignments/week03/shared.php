<?php
session_start();

$items = array(
    array('id' => 1, 'name' => 'Phone', 'price' => 899.00),
    array('id' => 2, 'name' => 'Screen Replacement', 'price' => 49.00),
    array('id' => 3, 'name' => 'Battery Replacement', 'price' => 49.00),
    array('id' => 4, 'name' => 'Charger', 'price' => 29.00),
    array('id' => 5, 'name' => 'Charger Cable', 'price' => 9.00),
    array('id' => 6, 'name' => 'Back Camera Replacement', 'price' => 29.00),
    array('id' => 7, 'name' => 'Portable Charger', 'price' => 29.00),
    array('id' => 8, 'name' => 'Wireless Charger', 'price' => 14.00),
    array('id' => 9, 'name' => 'Headphones', 'price' => 29.00)
);

$cart = isset($_SESSION['CART']) ? $_SESSION['CART'] : [];

$states	= array(
    'AL' => 'Alabama',
    'AK' => 'Alaska',
    'AZ' => 'Arizona',
    'AR' => 'Arkansas',
    'CA' => 'California',
    'CO' => 'Colorado',
    'CT' => 'Connecticut',
    'DE' => 'Delaware',
    'FL' => 'Florida',
    'GA' => 'Georgia',
    'HI' => 'Hawaii',
    'ID' => 'Idaho',
    'IL' => 'Illinois',
    'IN' => 'Indiana',
    'IA' => 'Iowa',
    'KS' => 'Kansas',
    'KY' => 'Kentucky',
    'LA' => 'Louisiana',
    'ME' => 'Maine',
    'MD' => 'Maryland',
    'MA' => 'Massachusetts',
    'MI' => 'Michigan',
    'MN' => 'Minnesota',
    'MS' => 'Mississippi',
    'MO' => 'Missouri',
    'MT' => 'Montana',
    'NE' => 'Nebraska',
    'NV' => 'Nevada',
    'NH' => 'New Hampshire',
    'NJ' => 'New Jersey',
    'NM' => 'New Mexico',
    'NY' => 'New York',
    'NC' => 'North Carolina',
    'ND' => 'North Dakota',
    'OH' => 'Ohio',
    'OK' => 'Oklahoma',
    'OR' => 'Oregon',
    'PA' => 'Pennsylvania',
    'RI' => 'Rhode Island',
    'SC' => 'South Carolina',
    'SD' => 'South Dakota',
    'TN' => 'Tennessee',
    'TX' => 'Texas',
    'UT' => 'Utah',
    'VT' => 'Vermont',
    'VA' => 'Virginia',
    'WA' => 'Washington',
    'WV' => 'West Virginia',
    'WI' => 'Wisconsin',
    'WY' => 'Wyoming',
    'DC' => 'Washington D.C.'
);

function clearShipping() {
    unset($_SESSION['SHIPPING']);
}

function emptyCart() {
    global $cart;
    $cart = [];
    saveCart();
}

function getCartQuantity() {
    global $cart;
    $qty = 0;
    foreach ($cart as $item_id => $item_qty) {
        $qty += $item_qty;
    }
    return $qty;
}

function getCartItemQuantity($id) {
    global $cart;
    return (array_key_exists($id, $cart) ? $cart[$id] : 0);
}

function getCartTotal() {
    global $cart;
    $total = 0;
    foreach ($cart as $item_id => $qty) {
        $item = getItem($item_id);
        $total += $qty * $item['price'];
    }
    return $total;
}

function getItem($id) {
    global $items;
    foreach ($items as $item) {
        if ($item['id'] == $id) return $item;
    }
    return null;
}

function getShipping() {
    return (isset($_SESSION['SHIPPING']) ? $_SESSION['SHIPPING'] : array('name' => '', 'address' => '', 'city' => '', 'state' => '', 'zip' => ''));
}

function incrementItemQuantity($id, $qty = 1) {
    updateItemQuantity($id, getCartItemQuantity($id) + $qty);
}

function safe_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function safe_post($key, $default = '') {
    return safe_input(isset($_POST[$key]) ? $_POST[$key] : $default);
}

function saveCart() {
    global $cart;
    $_SESSION['CART'] = $cart;
}

function saveShipping($name, $address, $city, $state, $zip) {
    $_SESSION['SHIPPING'] = array(
        'name' => $name, 
        'address' => $address, 
        'city' => $city, 
        'state' => $state, 
        'zip' => $zip);
}

function updateItemQuantity($id, $qty) {
    global $cart;
    if (getItem($id) == null) throw new Exception('Item not found');
    $itemInCart = array_key_exists($id, $cart);
    if ($qty <= 0) {
        if ($itemInCart) unset($cart[$id]);
    } else {
        $cart[$id] = $qty;
    }
    saveCart();
}

?>