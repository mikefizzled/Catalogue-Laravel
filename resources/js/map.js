import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L; // Make Leaflet available globally
//console.log("Leaflet Loaded:", L);



// these imports tell Vite to copy the assets into your build
import iconUrl       from 'leaflet/dist/images/marker-icon.png';
import iconRetinaUrl from 'leaflet/dist/images/marker-icon-2x.png';
import shadowUrl     from 'leaflet/dist/images/marker-shadow.png';

// override the defaults so every map on every route picks up the right paths
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl,
  iconUrl,
  shadowUrl,
});

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
