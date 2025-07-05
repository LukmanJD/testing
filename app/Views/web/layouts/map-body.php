<div class="card-body">
    <div class="googlemaps" id="googlemaps"></div>
    <script>
        initMap();
    </script>
    <div id="legend"></div>
    <div id="legend_t"></div>
    <script>
        setCompass();
    </script>
    <script>
        $('#legend').hide();
        getLegend();
    </script>
    <script>
        $('#legend_t').hide();
        getLegendTraffic();
    </script>
</div>