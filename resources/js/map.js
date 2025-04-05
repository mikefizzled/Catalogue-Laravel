import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L; // Make Leaflet available globally
//console.log("Leaflet Loaded:", L);

function initMap() {
    const map = L.map("map").setView([53.386111, -1.506000], 13);

    // Add OpenStreetMap tiles
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 18,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // store global marker for pointing
    let marker = null;


    // Add markers for existing locations
    if (window.existingLocations && Array.isArray(window.existingLocations)) {
        window.existingLocations.forEach(location => {
            if (location.latitude && location.longitude) {
                L.marker([location.latitude, location.longitude])
                    .addTo(map)
                    .bindPopup(`<strong>${location.name}</strong>`);
                 
            }
        });
    }

    // Use map on click to set the values in the 
    map.on("click", function (e) {

        let lat = e.latlng.lat;
        let latRounded = parseFloat(lat.toFixed(4));
        let lng = e.latlng.lng;
        let lngRounded = parseFloat(lng.toFixed(4));

        console.log("Clicked at:", lat, lng);

        // Auto-fill input fields
        let xInput = document.getElementById("latitude");
        let yInput = document.getElementById("longitude");

        if(marker)
            map.removeLayer(marker);
        
        marker = L.marker([lat, lng]).addTo(map);
        
        if (xInput && yInput) {
            xInput.value = latRounded;
            yInput.value = lngRounded;
        }
    });
}

// Make sure the map only loads after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", initMap);
