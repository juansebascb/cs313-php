function addToCart(id) {
    $("#item_id").val(id);
    return true;
}

function emptyCart() {
    $("#action").val("empty");
    return true;
}

function removeItem(id) {
    $("#action").val("remove");
    $("#item_id").val(id);
    return true;
}

function updateCart() {
    $("#action").val("update");
    return true;
}