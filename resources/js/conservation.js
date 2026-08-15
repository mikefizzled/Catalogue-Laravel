export async function fetchBoccData() {
    const sciField = document.getElementById("scientific_name");
    const scientificName = sciField?.value.trim();

    if (!scientificName) {
        alert("Please enter a scientific name first.");
        return;
    }

    try {
        const res = await fetch(
            `/conservation-status?scientific_name=${encodeURIComponent(scientificName)}`,
        );
        if (!res.ok) {
            throw new Error(await res.text());
        }
        const birdData = await res.json();

        const statusFields = [
            "bocc_1",
            "bocc_2",
            "bocc_3",
            "bocc_4",
            "bocc_5",
            "bocc_5a",
        ];

        // fill selects
        statusFields.forEach((field) => {
            const val = birdData[field]?.toLowerCase();
            const sel = document.getElementById(field);
            if (sel && val) {
                Array.from(sel.options).forEach((opt) => {
                    if (opt.value.toLowerCase() === val) opt.selected = true;
                });
            }
        });

        // fill criteria inputs
        ["bocc_5_criteria", "bocc_5a_criteria"].forEach((field) => {
            const el = document.getElementById(field);
            if (el && birdData[field] != null) {
                el.value = birdData[field];
            }
        });

        alert("Conservation status updated successfully!");
    } catch (err) {
        console.error("Error fetching conservation data:", err);
        alert("Failed to fetch conservation status.");
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("fetchBoccBtn");
    if (btn) {
        btn.addEventListener("click", fetchBoccData);
    }
});
