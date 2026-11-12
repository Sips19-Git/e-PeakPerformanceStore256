
document.addEventListener("DOMContentLoaded", function () {
    const cartCount = document.getElementById("cart-count");

    console.log("Peak Performance Store JavaScript is working!");

    if (cartCount) {
        console.log("Cart counter found:", cartCount.textContent.trim());
    }
});
