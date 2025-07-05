<?= $this->extend('maps/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title text-center">Homestay Information</h4>
                        </div>
                        <?php if (in_groups('user')) : ?>
                            <div class="col">
                                <a href="<?= base_url('web/reservation'); ?><?= esc('/' . $homestay_id); ?>" class="btn btn-success float-end" target=”_blank”><i class="fa-solid fa-bookmark me-3"></i>Booking</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body text-dark">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?>
                                            <br>
                                            (
                                            <?php
                                            for ($i = 0; $i < (int)esc($data['avg_rating']); $i++) {
                                            ?>
                                                <i name="rating" class="fas fa-star text-warning" aria-hidden="true"></i>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            for ($i = 0; $i < (5 - (int)esc($data['avg_rating'])); $i++) {
                                            ?>
                                                <i name="rating" class="far fa-star" aria-hidden="true"></i>
                                            <?php
                                            }
                                            ?>
                                            )
                                        </td>
                                    </tr>
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
                                        <td class="fw-bold">Contact Person</td>
                                        <td><?= esc($data['phone']);
                                            ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Description</p>
                            <p><?= esc($data['description']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Facilities</p>
                            <?php foreach ($data['facilities'] as $facility) : ?>
                                <li><?= esc($facility); ?></li>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="accordion mt-3" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    Homestay Units
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <?php if (empty($data['unit'])) : ?>
                                        <span>There no homestay unit</span>
                                    <?php else : ?>
                                        <?php foreach ($data['unit'] as $unit) : ?>
                                            <li><a href="/web/homestay_unit_detail_mobile/<?= esc($unit['homestay_id']); ?>/<?= esc($unit['unit_type']); ?>/<?= esc($unit['unit_number']); ?>"><?= esc($unit['name']); ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    Additional Amenities
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body">
                                    <?php if (empty($data['additional_amenities'])) : ?>
                                        <span>There no additional amenities</span>
                                    <?php else : ?>
                                        <?php foreach ($data['additional_amenities'] as $additional_amenities) : ?>
                                            <li><a href="/web/additional_amenitie_detail_mobile/<?= esc($additional_amenities['homestay_id']); ?>/<?= esc($additional_amenities['additional_amenities_id']); ?>"><?= esc($additional_amenities['name']); ?></a></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Reviews</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <?php if (empty($data['rating_review'])) : ?>
                                <center>
                                    <span>No reviews yet</span>
                                </center>
                            <?php else : ?>
                                <?php foreach ($data['rating_review'] as $rating_review) : ?>
                                    <strong>@<?= esc($rating_review['username']); ?></strong>
                                    <br>
                                    <div>Rating :
                                        <?php
                                        for ($i = 0; $i < (int)esc($rating_review['rating']); $i++) {
                                        ?>
                                            <i name="rating" class="fas fa-star text-warning" aria-hidden="true"></i>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        for ($i = 0; $i < (5 - (int)esc($rating_review['rating'])); $i++) {
                                        ?>
                                            <i name="rating" class="far fa-star" aria-hidden="true"></i>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div>Review : <?= esc($rating_review['review']); ?></div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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