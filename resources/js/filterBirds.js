document.addEventListener("DOMContentLoaded", () => {
    const familySelect = document.getElementById("taxon");

    if (!familySelect) return;

    familySelect.addEventListener("change", () => {
        const selectedFamilySlug = familySelect.value;
        const url = new URL(window.location.href);

        if (selectedFamilySlug) {
            url.searchParams.set("family", selectedFamilySlug); // assuming you're passing slugs
        } else {
            url.searchParams.delete("family");
        }

        window.location.href = url.toString();
    });
});
