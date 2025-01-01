<div wire:ignore>
    <div id="map" style="height: 400px;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi peta
        var map = L.map('map').setView([-0.3155398750904368, 117.1371634207888], 5);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Tambahkan fitur menggambar polygon
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,
                circle: false,
                rectangle: false,
                polyline: false,
                marker: false,
                circlemarker: false
            }
        });
        map.addControl(drawControl);

        // Ambil data boundary dari PHP
        var boundary = json_encode($getState('boundary'));
        if (boundary) {
            var polygon = L.geoJSON(boundary);
            polygon.addTo(map);
            drawnItems.addLayer(polygon);
        }

        // Event ketika polygon baru dibuat
        map.on(L.Draw.Event.CREATED, function (e) {
            var layer = e.layer;

            var geojson = layer.toGeoJSON().geometry;
            Livewire.emit('updateBoundary', JSON.stringify(geojson)); // Emit event Livewire

            drawnItems.addLayer(layer);
        });

        // Event ketika polygon diedit
        map.on('draw:edited', function (e) {
            e.layers.eachLayer(function (layer) {
                var geojson = layer.toGeoJSON().geometry;
                Livewire.emit('updateBoundary', JSON.stringify(geojson)); // Emit event Livewire
            });
        });
    });
</script>
