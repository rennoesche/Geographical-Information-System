<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #map { height: 600px; }
        .controls {
            margin: 10px;
        }
    </style>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <div class="controls">
        <label for="provinceDropdown">Pilih Provinsi:</label>
        <select id="provinceDropdown">
            <option value="">-- Pilih Provinsi --</option>
            @foreach($provinsis as $provinsi)
                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
            @endforeach
        </select>
    </div>

    <div id="map"></div>

    <script>
        var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        document.getElementById('provinceDropdown').addEventListener('change', function () {
            var provinceId = this.value;

            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            if (provinceId) {
                fetch(`/map/kabkota/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function (kabupaten) {
                            var marker = L.marker([kabupaten.latitude, kabupaten.longitude]).addTo(map);
                            marker.bindPopup(
                                `<b>Nama:</b> ${kabupaten.nama}<br>` +
                                `<b>Alt Name:</b> ${kabupaten.alt_name || 'N/A'}<br>` +
                                `<b>Latitude:</b> ${kabupaten.latitude}<br>` +
                                `<b>Longitude:</b> ${kabupaten.longitude}`
                            );
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>
