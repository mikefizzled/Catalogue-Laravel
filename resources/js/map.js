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

    console.log("Leaflet Map Initialized");

    // store global marker for pointing
    let marker = null;

    // Handle map click event
    map.on("click", function (e) {

        var lat = e.latlng.lat;
        var latRounded = parseFloat(lat.toFixed(4));
        var lng = e.latlng.lng;
        var lngRounded = parseFloat(lng.toFixed(4));

        console.log("Clicked at:", lat, lng);

        /* Show coordinates in a popup
        L.popup()
            .setLatLng(e.latlng)
            .setContent("Latitude: " + lat + "<br>Longitude: " + lng)
            .openOn(map);
        */
        // Auto-fill input fields
        var xInput = document.getElementById("x-coord");
        var yInput = document.getElementById("y-coord");

        if(marker)
            map.removeLayer(marker);
        
        marker = L.marker([lat, lng]).addTo(map);
        
        if (xInput && yInput) {
            xInput.value = latRounded;
            yInput.value = lngRounded;
        }
    });
}

// Ensure the map initializes after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", initMap);
