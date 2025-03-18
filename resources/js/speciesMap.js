import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L; // Make Leaflet available globally
console.log("Leaflet Loaded:", L);

function initMap() {
    var map = L.map("map").setView([53.386111, -1.506000], 13);

    // Add OpenStreetMap tiles
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add markers for existing locations
    if (window.existingLocations && Array.isArray(window.existingLocations)) {
        window.existingLocations.forEach(location => {
            if (location.latitude && location.longitude) {
                let content = `<b>${location.name}, ${location.city}</b>`;
                if (location.image) {
                    //content += `<img src="../images/locations/${location.image}" class="location-picture">`;
                }
                if (location.area_caption) {
                    content += `<p><i>${location.area_caption}</i></p>`;
                }
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(content); 
            }
        });
    }
}

// Make sure the map only loads after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", initMap);
