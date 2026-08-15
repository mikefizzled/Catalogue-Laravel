document.addEventListener("DOMContentLoaded", () => {
    const familySelect = document.getElementById("taxon");
    if (!familySelect) return;

    familySelect.addEventListener("change", function () {
        const selectedFamily = this.value;
        const url = new URL(window.location.href);

        // Reset to the first page
        url.searchParams.delete("page");

        if (selectedFamily) {
            url.searchParams.set("family", selectedFamily);
        } else {
            url.searchParams.delete("family");
        }

        // Navigate
        window.location.href = url.toString();
    });
});
