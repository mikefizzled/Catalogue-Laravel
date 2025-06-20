import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L; // Make Leaflet available globally
//console.log("Leaflet Loaded:", L);

function initMap() {
    
    // Default center (Sheffield)
    let initialLat = 53.386111;
    let initialLng = -1.506000;
    let zoomLevel = 11;

        // If a valid location exists, center on that instead
    if (window.existingLocations && Array.isArray(window.existingLocations)) {
        const firstValid = window.existingLocations.find(loc => loc.latitude && loc.longitude);
        if (firstValid) {
            initialLat = firstValid.latitude;
            initialLng = firstValid.longitude;
        }
    }

    const map = L.map("map").setView([initialLat, initialLng], zoomLevel);

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
