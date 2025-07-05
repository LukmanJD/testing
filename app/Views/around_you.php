<!-- In your main layout file -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
<?= $this->extend('web/layouts/main'); ?>
<?= $this->section('content') ?>
<section class="section">
    <div class="row">
        <!--map-->
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-auto">
                            <h4 class="card-title">Google Maps</h4>
                            <div class="col-12 d-flex align-items-center gap-1">
                                <div class="form-check" style="font-size: 14px;">
                                    <input class="form-check-input" type="checkbox" id="check-label" value="check-label" onchange="checkLabel()">
                                    <label class="form-check-label" for="check-label">Labels</label>
                                </div>&nbsp;
                                <div class="form-check" style="font-size: 14px;">
                                    <input class="form-check-input" type="checkbox" id="check-terrain" value="check-terrain" onchange="checkTerrain()">
                                    <label class="form-check-label" for="check-terrain">Terrain</label>
                                </div>
                            </div>
                        </div>
                        <?= $this->include('web/layouts/map-head'); ?>
                    </div>
                </div>
                <?= $this->include('web/layouts/map-body'); ?>
            </div>  
        </div>

        <div class="col-md-4 col-12">
            <!-- Object Around Panel -->
            <div class="card text-dark" id="check-nearbyyou-col">
                <div class="card-header">
                    <h5 class="card-title text-center">Object Around</h5>
                </div>
                <div class="card-body">
                    <div class="sidebar-items">
                        <div class="form-check sidebar-item">
                            <input type="checkbox" id="check-uatt" class="form-check-input">
                            <label for="check-uatt" class="sidebar-link">
                                <i></i><span class="text-dark fw-bold">Unique Attraction</span>
                            </label>
                        </div>
                        <div class="form-check sidebar-item">
                            <input type="checkbox" id="check-att" class="form-check-input">
                            <label for="check-att" class="sidebar-link">
                                <i></i><span class="text-dark fw-bold">Ordinary Attraction</span>
                            </label>
                        </div>
                        <div class="form-check sidebar-item">
                            <input type="checkbox" id="check-hs" class="form-check-input">
                            <label for="check-hs" class="sidebar-link">
                                <i></i><span class="text-dark fw-bold">Homestay</span>
                            </label>
                        </div>
                        <div class="form-check sidebar-item">
                            <input type="checkbox" id="check-cp" class="form-check-input">
                            <label for="check-cp" class="sidebar-link">
                                <i></i><span class="text-dark fw-bold">Culinary Place</span>
                            </label>
                        </div>
                        <div class="form-check sidebar-item">
                            <input type="checkbox" id="check-sp" class="form-check-input">
                            <label for="check-sp" class="sidebar-link">
                                <i></i><span class="text-dark fw-bold">Souvenir Place</span>
                            </label>
                        </div>
                        <div class="form-check sidebar-item">
                            <input type="checkbox" id="check-wp" class="form-check-input">
                            <label for="check-wp" class="sidebar-link">
                                <i></i><span class="text-dark fw-bold">Worship Place</span>
                            </label>
                        </div>
                        <div class="mt-2 mb-3" id="radiusNearby">
                            <label for="inputRadiusNearby" class="form-label">Radius: </label>
                            <label id="radiusValueNearby" class="form-label">0 m</label>
                            <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusNearby" name="inputRadius" onchange="updateRadius('Nearby'); checkAround('Nearby');">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results Panel -->
            <div class="card" id="result-nearby-col">
                <div class="card-header">
                    <h5 class="card-title text-center">Search Result Object Around</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto" id="table-result-nearby">
                        <table class="table table-hover mb-md-5 mb-3 table-lg text-dark" id="table-uatt"></table>
                        <table class="table table-hover mb-md-5 mb-3 table-lg text-dark" id="table-att"></table>
                        <table class="table table-hover mb-md-5 mb-3 table-lg text-dark" id="table-hs"></table>
                        <table class="table table-hover mb-md-5 mb-3 table-lg text-dark" id="table-cp"></table>
                        <table class="table table-hover mb-md-5 mb-3 table-lg text-dark" id="table-sp"></table>
                        <table class="table table-hover mb-md-5 mb-3 table-lg text-dark" id="table-wp"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->include('web/layouts/direction'); ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    // $('#direction-row').hide();
    // $('#check-nearby-col').hide();
    $('#result-nearby-col').hide();
    // $("#result-explore-col").hide();
    map.setZoom(6);

    // Initialize map markers
    clearMarker();
    clearRadius();
    clearRoute();
    digitTourismVillage();


    // Set initial checkbox states
    const checkCountry = document.getElementById("checkCountry");
    checkCountry.checked = true;
    const checkProvince = document.getElementById("checkProvince");
    checkProvince.checked = true;
    const checkCity = document.getElementById("checkCity");
    checkCity.checked = true;
    const checkVillage = document.getElementById("checkVillage");
    checkVillage.checked = true;

    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: 'Please Set Your Location First',
            text: 'Choose one of the options below:',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Current Location',
            confirmButtonColor: "#3085d6",
            cancelButtonText: 'Manual Location',
            cancelButtonColor: "#039e00",
        }).then((result) => {
            if (result.isConfirmed) {
                currentPosition();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                manualPosition();
            }
        });
    });
</script>
<?= $this->endSection() ?>