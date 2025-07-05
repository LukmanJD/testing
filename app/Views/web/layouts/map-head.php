<div class="col">
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Current Location" class="btn icon btn-primary mx-1" id="current-position" onclick="currentPosition()">
        <span class="material-symbols-outlined">my_location</span>
    </a>
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Manual Location" class="btn icon btn-primary mx-1" id="manual-position" onclick="manualPosition()">
        <span class="material-symbols-outlined">pin_drop</span>
    </a>
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle Legend" class="btn icon btn-primary mx-1" id="legend-map" onclick="viewLegend();">
        <span class="material-symbols-outlined">visibility</span>
    </a>
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Show Traffic" class="btn icon btn-primary mx-1" id="legend-map" onclick="showTraffic(); viewLegendTraffic();">
        <span class="material-symbols-outlined"> traffic </span>
    </a>
    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Zoom To Harau Village" class="btn icon btn-primary mx-1" id="legend-map" onclick="digitTourismVillage(true);">
        <span class="material-symbols-outlined">landscape_2</span>
    </a>

    <?php
    $currentURL = $_SERVER['REQUEST_URI'];
    if ($currentURL === '/web') {
        // Jika URL adalah '/web', tampilkan tombol
        // echo '<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="How to Reach Pariangan" class="btn icon btn-primary mx-1" id="go-to" onclick="howToReachPariangan()">
        // <i style="height:1.72rem;width:1.5rem" class="fa-solid fa-person-walking-luggage"></i>
        // </a>
        // <input class="form-check-input" type="checkbox" id="clearHtro" value="ClearHTRO" onchange="clearHtro()">';
        echo '<div class="btn-group mx-1">
            <button style="height:2.8rem" class="btn btn-primary" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="How to Reach Lembah Harau" onclick="howToReachLembahHarau()"><i style="height:1.3rem;width:1.3rem" class="fa-solid fa-person-walking-luggage"></i></button>
            <button style="height:2.8rem;width" class="btn btn-primary" type="button" data-bs-toggle="tooltip" aria-expanded="false">
                <input class="form-check-input" type="checkbox" id="clearHtro" value="ClearHTRO" onchange="clearHtro()">
            </button>
        </div>';
    }
    ?>

    <!-- <?php if (current_url() == "http://localhost:8080/web"): ?>
        <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="All Object" class="btn icon btn-primary mx-1" id="legend-map" onclick="allObject();">
            <span class="material-symbols-outlined">universal_local</span>
        </a>
        <a class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                Object
            </button>
            <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAttraction" value="Attraction" onchange="checkObject()">
                    <label class="form-check-label" for="checkAttraction">Attraction</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkHomestay" value="Homestay" onchange="checkObject()">
                    <label class="form-check-label" for="checkHomestay">Homestay</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkCulinary" value="Culinary" onchange="checkObject()">
                    <label class="form-check-label" for="checkCulinary">Culinary</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkSouvenir" value="Souvenir" onchange="checkObject()">
                    <label class="form-check-label" for="checkSouvenir">Souvenir</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkWorship" value="Worship" onchange="checkObject()">
                    <label class="form-check-label" for="checkWorship">Worship</label>
                </li>
            </ul>
        </a>
    <?php endif; ?> -->

    <!-- <span class="material-symbols-outlined">file_map_stack</span> -->

    <?php
    $currentURL = $_SERVER['REQUEST_URI'];
    if (($currentURL === '/web')): ?>
        <div class="btn-group mx-1">
            <button style="height:2.8rem" class="btn btn-primary" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View All Objects" onclick="allObject()"><i style="height:1.3rem;width:1.3rem" class="material-symbols-outlined">file_map_stack</i></button>
            <button style="height:2.8rem" class="btn btn-primary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu p-2">
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkuAttraction" value="Attraction" onchange="checkObject()">
                    <label class="form-check-label" for="checkuAttraction">Unique Attraction</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAttraction" value="Attraction" onchange="checkObject()">
                    <label class="form-check-label" for="checkAttraction">Ordinary Attraction</label>
                </li>
                <!-- <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkHomestay" value="Homestay" onchange="checkObject()">
                    <label class="form-check-label" for="checkHomestay">Homestay</label>
                </li> -->
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkCulinary" value="Culinary" onchange="checkObject()">
                    <label class="form-check-label" for="checkCulinary">Culinary</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkSouvenir" value="Souvenir" onchange="checkObject()">
                    <label class="form-check-label" for="checkSouvenir">Souvenir</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkWorship" value="Worship" onchange="checkObject()">
                    <label class="form-check-label" for="checkWorship">Worship</label>
                </li>
            </ul>
        </div>
    <?php endif; ?>



    <!-- <a class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Layer
        </button>
        <ul class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton">
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkCountry" value="Country" onchange="checkLayer()">
                <label class="form-check-label" for="checkCountry">Country</label>
            </li>
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkProvince" value="Province" onchange="checkLayer()">
                <label class="form-check-label" for="checkProvince">Province</label>
            </li>
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkCity" value="City" onchange="checkLayer()">
                <label class="form-check-label" for="checkCity">City</label>
            </li>
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkVillage" value="Village" onchange="checkLayer()">
                <label class="form-check-label" for="checkVillage">Village</label>
            </li>
        </ul>
    </a> -->

    <div class="btn-group mx-1">
        <button style="height:2.8rem" class="btn btn-primary" type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View All Layers" onclick="clickLayer()"><i style="height:1.72rem;width:1.5rem" class="fa-solid fa-layer-group"></i></button>
        <button style="height:2.8rem" class="btn btn-primary dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu p-2">
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkCountry" value="Country" onchange="checkLayer()">
                <label class="form-check-label" for="checkCountry">Country</label>
            </li>
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkProvince" value="Province" onchange="checkLayer()">
                <label class="form-check-label" for="checkProvince">Province</label>
            </li>
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkCity" value="City" onchange="checkLayer()">
                <label class="form-check-label" for="checkCity">City</label>
            </li>
            <li class="form-check">
                <input class="form-check-input" type="checkbox" id="checkVillage" value="Village" onchange="checkLayer()">
                <label class="form-check-label" for="checkVillage">Village</label>
            </li>
        </ul>
    </div>

    <?php
    $currentURL = $_SERVER['REQUEST_URI'];
    if (($currentURL === '/web')): ?>
        <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Homestay" class="btn icon btn-primary mx-1" id="legend-map" onclick="allHomestay(<?= (in_groups('user')) ? 'true' : 'false' ?>);">
            <span class="material-symbols-outlined">night_shelter</span>
        </a>
    <?php endif; ?>

</div>
<div class="row">
    <?php
    $currentURL = $_SERVER['REQUEST_URI'];
    if ($currentURL === '/web') {
        echo ' <script>
    document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM sudah siap!");
    weatherNow();
});
</script>
<div  class="col-md-auto" id="weather-info"></div>';
    }
    ?>
</div>