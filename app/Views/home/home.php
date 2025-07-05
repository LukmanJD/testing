<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <?php if ($data3 != null) : ?>
        <div class="row">
            <!-- announcement -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-left" style="color: #dc3545;"><i class="fa-solid fa-bullhorn"></i> Announcement</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <?php foreach ($data3 as $item3) : ?>
                                <li class="text-left"><strong><?= esc($item3['announcement']); ?></strong></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <!--map-->
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <!-- <div class="col-md-auto">
                            <h5 class="card-title">Google Maps with Location</h5>
                        </div> -->
                        <div class="col-md-auto">
                            <h4 class="card-title">Google Maps</h4>
                            <div class="col-12 d-flex align-items-center gap-1">
                                <!-- Checkbox 1 -->
                                <div class="form-check" style="font-size: 14px;">
                                    <input class="form-check-input" type="checkbox" id="check-label" value="check-label" onchange="checkLabel()">
                                    <label class="form-check-label" for="check-label">Labels</label>
                                </div>&nbsp;
                                <!-- Checkbox 2 -->
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
            <div class="row">
                <!--popular-->
                <div class="col-12" id="list-rec-col">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center"><?= esc($data['name']); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php $i = 0; ?>
                            <script>
                                clearMarker();
                                clearRadius();
                                clearRoute();
                                digitTourismVillage();
                                // objectMarker("L", -0.45645247101825404, 100.49283409109306);
                                const checkCountry = document.getElementById("checkCountry");
                                checkCountry.checked = true;
                                const checkProvince = document.getElementById("checkProvince");
                                checkProvince.checked = true;
                                const checkCity = document.getElementById("checkCity");
                                checkCity.checked = true;
                                const checkVillage = document.getElementById("checkVillage");
                                checkVillage.checked = true;
                            </script>
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php foreach ($data['gallery'] as $item) : ?>
                                        <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= esc($i); ?>" class="<?= ($i == 0) ? 'active' : ''; ?>"></li>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </ol>
                                <div class="carousel-inner">
                                    <?php $i = 0; ?>
                                    <?php foreach ($data['gallery'] as $item) : ?>
                                        <div class="carousel-item<?= ($i == 0) ? ' active' : ''; ?>">
                                            <a>
                                                <img src="<?= base_url('media/photos/' . esc($item)); ?>" class="d-block w-100" alt="<?= esc($data['name']); ?>" onclick="focusObject(`<?= esc($data['id_ta']); ?>`);" style="object-fit: cover; height: 250px;">
                                            </a>
                                        </div>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                            <div class="row">
                                <div class="col table-responsive">
                                    <table class="table table-borderless mt-3 text-dark">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bold">Address</td>
                                                <td><?= esc($data['address']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Open</td>
                                                <td><?= date('H:i', strtotime(esc($data['open']))) . ' WIB'; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Close</td>
                                                <td><?= date('H:i', strtotime(esc($data['close']))) . ' WIB'; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Ticket Price</td>
                                                <td>Rp <?= number_format(esc($data['ticket_price']), 2, ',', '.'); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Contact Person</td>
                                                <td><?= esc($data['phone']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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

                <!-- Search result all -->
                <!-- <div class="col-12" id="result-exploreall-col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Search Result All Object</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive overflow-auto" id="table-resultall-nearby">
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Homestay">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Culinary">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Souvenir">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Worship">
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

                <!-- Search result nearby -->


                <!-- Nearby section -->
                <?= $this->include('web/layouts/nearby'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12" id="result-explore-col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Result Object</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive overflow-auto" id="table-result-nearby">
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-uAttraction">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Attraction">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Homestay">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Culinary">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Souvenir">
                            </table>
                            <table class="table table-hover mb-md-5 mb-3 table-lg" id="table-Worship">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Results Panel -->
        <div class="card" id="result-nearbyyou-col">
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

    <!-- Direction section -->
    <?= $this->include('web/layouts/direction'); ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    $('#direction-row').hide();
    $('#check-nearby-col').hide();
    $('#result-nearby-col').hide();
    $("#result-explore-col").hide();
    $('#check-nearbyyou-col').hide();
    $("#result-nearbyyou-col").hide();

    $("#table-uatt").empty();
    $("#table-att").empty();
    $("#table-hs").empty();
    $("#table-cp").empty();
    $("#table-wp").empty();
    $("#table-sp").empty();

    $("#table-uatt").hide();
    $("#table-att").hide();
    $("#table-hs").hide();
    $("#table-cp").hide();
    $("#table-wp").hide();
    $("#table-sp").hide();

    map.setZoom(6);
</script>
<?= $this->endSection() ?>