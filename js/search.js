
document.addEventListener("DOMContentLoaded", function () {
    const searchInputs = document.querySelectorAll(
        'input[placeholder="Search for products"]'
    );

    searchInputs.forEach(function (searchInput) {
        searchInput.addEventListener("keydown", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();

                const searchTerm = searchInput.value.trim();

                if (searchTerm !== "") {
                    window.location.href =
                        "shop.php?search=" + encodeURIComponent(searchTerm);
                }
            }
        });
    });
});
