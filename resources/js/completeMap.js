import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L; // Make Leaflet available globally
console.log("Leaflet Loaded:", L);

    const map = L.map("map").setView([53.386111, -1.506000], 13);

    // Add OpenStreetMap tiles
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    /* Add markers for existing locations
    if (window.existingLocations && Array.isArray(window.existingLocations)) {
        window.existingLocations.forEach(location => {
            if (location.latitude && location.longitude) {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(`<strong>${location.name}</strong>`);
                 
            }
        });
    }*/


/**
 * Fetch and display markers for all locations and attach animals for each.
 */
async function loadCoordinates() {
    try {
        const res = await fetch('/map-data'); // Our new unified endpoint
        const data = await res.json();
        data.forEach((location) => {
            let content = `
            
                <h3 class="text-lg font-bold text-gray-900 mb-2">${location.location_name}</h3>`;
            if (location.image) {
                content += `<img src="${location.image}" class="location-picture" alt="${location.location_name}">`;
            }
            if (location.area_caption) {
                content += `<p class="text-gray-700 mb-2"><em>${location.area_caption}</em></p>`;
            }
            content += location.animal_list_html; // HTML list of animals
            //content += '</div>';
            L.marker([location.latitude, location.longitude]).addTo(map)
                .bindPopup(content);
        });
    } catch (error) {
        console.error('Error fetching coordinates:', error);
    }
}

loadCoordinates();
