<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <!--map-->
        <div class="col-md-7 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-auto">
                            <h5 class="card-title">Google Maps with Location</h5>
                        </div>
                        <?= $this->include('web/layouts/map-head'); ?>
                    </div>
                </div>
                <?= $this->include('web/layouts/map-body'); ?>
            </div>
        </div>


        <div class="col-md-5 col-12">
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
                                objectMarker("<?= esc($data['id_ta']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>);
                                digitUniqueAtt();
                                map.setZoom(14);
                                map.panTo({
                                    lat: <?= esc($data['lat']); ?>,
                                    lng: <?= esc($data['lng']); ?>
                                })
                            </script>
                            <div class="row">
                                <div class="col table-responsive">
                                    <table class="table table-borderless mt-3 text-dark">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p><?= $data['description']; ?></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Object Media -->
            <?= $this->include('web/layouts/gallery_video'); ?>
            <!-- Nearby section -->
            <?= $this->include('web/layouts/nearby'); ?>
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
</script>
<script>
    const myModal = document.getElementById('videoModal');
    const videoSrc = document.getElementById('video-play').getAttribute('data-src');

    myModal.addEventListener('shown.bs.modal', () => {
        console.log(videoSrc);
        document.getElementById('video').setAttribute('src', videoSrc);
    });
    myModal.addEventListener('hide.bs.modal', () => {
        document.getElementById('video').setAttribute('src', '');
    });
</script>
<?= $this->endSection() ?>