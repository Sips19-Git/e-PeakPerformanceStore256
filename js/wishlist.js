
document.addEventListener("DOMContentLoaded", function () {
    const wishlistButtons = document.querySelectorAll(
        ".wishlist-btn"
    );

    wishlistButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            // Toggle the wishlist state
            const isAdded = button.classList.toggle("wishlist-added");

            // Update the heart icon
            const heartIcon = button.querySelector("i");

            if (heartIcon) {
                heartIcon.style.color = isAdded ? "red" : "";
            }

            // Update button label for accessibility
            button.setAttribute(
                "aria-label",
                isAdded ? "Remove from wishlist" : "Add to wishlist"
            );

            console.log(
                isAdded
                    ? "Product added to wishlist"
                    : "Product removed from wishlist"
            );
        });
    });
});
