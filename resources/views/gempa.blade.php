<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #map { height: 600px; }
        h1,h2,h3 { text-align: center; }
    </style>
     <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
    <body>
        <header>
            <h1>Data Terkini Gempa</h1>
            <h3>Sumber BMKG</h3>
        </header>
        <div id="map"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{ maxZoom: 5,
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var gempaData = @json($gempaData);

            gempaData.forEach(function(gempa) {
                var marker = L.marker([gempa.latitude, gempa.longitude]).addTo(map);
                marker.bindPopup(`
                    <b>Wilayah:</b> ${gempa.wilayah}<br>
                    <b>Magnitude:</b> ${gempa.magnitudo}<br>
                    <b>Kedalaman:</b> ${gempa.kedalaman}<br>
                    <b>Waktu:</b> ${gempa.tanggal} ${gempa.jam} <br>
                    <b>Potensi:</b> ${gempa.potensi}<br>
                    <b>Kedalaman:</b> ${gempa.kedalaman}<br>
                `);
            });
            })
            
        </script>
    </body>
</html>