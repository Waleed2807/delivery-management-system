document.addEventListener('DOMContentLoaded', function() {
    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([-2.2426, 53.4808]), // Coordinates of Manchester
            zoom: 10
        })
    });

    locations.forEach(function(location, index) {
        var feature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([location.lng, location.lat])),
            name: location.address
        });

        var markerStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                src: 'http://cdn.mapmarker.io/api/v1/pin?text=P&size=50&hoffset=1'
            })
        });

        feature.setStyle(markerStyle);

        var vectorSource = new ol.source.Vector({
            features: [feature]
        });

        var markerLayer = new ol.layer.Vector({
            source: vectorSource
        });

        map.addLayer(markerLayer);

        feature.setId('marker-' + index); // Assign an ID to each marker

        // Popup and QR code
        var element = document.createElement('div');
        element.id = 'popup-' + index;
        var popup = new ol.Overlay({
            element: element,
            positioning: 'bottom-center',
            stopEvent: true,
            offset: [0, -50]
        });
        map.addOverlay(popup);

        // Display popup on click
        map.on('click', function(event) {
            map.forEachFeatureAtPixel(event.pixel, function(feature) {
                var coordinates = feature.getGeometry().getCoordinates();
                popup.setPosition(coordinates);
                element.innerHTML = '<strong>' + feature.get('name') + '</strong><br><div id="qr-' + feature.getId().replace('marker-', '') + '"></div>';
                new QRCode(document.getElementById('qr-' + feature.getId().replace('marker-', '')), {
                    text: "https://example.com/delivery/" + encodeURIComponent(feature.get('name')),
                    width: 128,
                    height: 128
                });
                return true; // Stop the loop once the first feature is matched
            });
        });

        map.on('pointermove', function(event) {
            if (event.dragging) {
                popup.setPosition(undefined);
                return;
            }
            var pixel = map.getEventPixel(event.originalEvent);
            var hit = map.hasFeatureAtPixel(pixel);
            map.getTargetElement().style.cursor = hit ? 'pointer' : '';
        });
    });
});