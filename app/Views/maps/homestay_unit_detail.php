<?= $this->extend('maps/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <div class="col">
            <a href="/web/homestay_detail_mobile/detail/<?= esc($data['homestay_id']); ?>" class="btn btn-primary ms-3 mt-3 mb-3"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
    </div>
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>
        <div class="col-md-7 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Homestay Unit Information</h4>
                            <!-- <div class="text-center">
                                <?php
                                // for ($i = 0; $i < (int)esc($data['avg_rating']); $i++) { 
                                ?>
                                    <span class="material-symbols-outlined rating-color">star</span>
                                <?php
                                // } 
                                ?>
                                <?php
                                // for ($i = 0; $i < (5 - (int)esc($data['avg_rating'])); $i++) { 
                                ?>
                                    <span class="material-symbols-outlined">star</span>
                                <?php
                                // } 
                                ?>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php $i = 0; ?>
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
                                        <img src="<?= base_url('media/photos/' . esc($item)); ?>" class="d-block w-100" alt="<?= esc($data['name']); ?>" style="height:400px; object-fit: cover;">
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
                    <div class="row mt-3">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Rating</td>
                                        <td>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td>Rp <?= number_format(esc($data['price']), 0, ',', '.'); ?>/day</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Capacity</td>
                                        <td><?= esc($data['capacity']); ?> people</td>
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
                </div>
            </div>
        </div>

        <div class="col-md-5 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Facilities</td>
                                    </tr>
                                    <?php if (!empty($facilities)) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($facilities as $facility) : ?>
                                            <tr>
                                                <td class="fw-bold"><?= esc($no); ?>. <?= esc($facility['name']); ?></td>
                                            </tr>
                                            <?php if (!empty($facility['description'])) : ?>
                                                <tr>
                                                    <td class="ms-2"><?= esc($facility['description']); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php $no++; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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