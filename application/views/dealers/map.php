<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration with Location</title>

<!-- Leaflet CSS -->
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 20px;
  }
  form {
    max-width: 400px;
    margin-bottom: 20px;
  }
  label {
    display: block;
    margin-top: 10px;
  }
  input[type="text"], input[type="email"] {
    width: 100%;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  #map {
    height: 300px;
    width: 100%;
    border-radius: 10px;
  }
  button {
    margin-top: 10px;
    padding: 8px 12px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
  }
</style>
</head>

<body>
<h2>Registration Form</h2>

<form id="registration-form">
  <label>Name:</label>
  <input type="text" name="name" required>

  <label>Email:</label>
  <input type="email" name="email" required>

  <label>Latitude:</label>
  <input type="text" id="latitude" name="latitude" readonly>

  <label>Longitude:</label>
  <input type="text" id="longitude" name="longitude" readonly>

  <button type="button" id="get-location">Get My Location</button>
</form>

<div id="map"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // Initialize map with a default location (India center)
  const map = L.map('map').setView([20.5937, 78.9629], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker;

  document.getElementById('get-location').addEventListener('click', () => {
    if (!navigator.geolocation) {
      alert("Geolocation is not supported by your browser.");
      return;
    }

    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const lat = pos.coords.latitude.toFixed(6);
        const lng = pos.coords.longitude.toFixed(6);

        // Fill form inputs
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Update or add marker on map
        if (marker) {
          marker.setLatLng([lat, lng]);
        } else {
          marker = L.marker([lat, lng]).addTo(map);
        }

        map.setView([lat, lng], 15);
        marker.bindPopup(`You are here<br>Lat: ${lat}<br>Lng: ${lng}`).openPopup();
      },
      (err) => {
        alert("Unable to retrieve your location. Error: " + err.message);
      },
      { enableHighAccuracy: true }
    );
  });
</script>
</body>
</html>
