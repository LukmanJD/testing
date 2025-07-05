<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section text-dark">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Tourism Package</h4>
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
                    <?php foreach ($data as $item) : ?>
                        <?php if (($item['is_custom'] == '0') && $item['total_day'] != '0') : ?>
                            <div class="card border mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                        <img width="500px" src="/media/photos/<?= esc($item['brochure_url']) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 210px;">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                                </div>
                                                <div class="col">
                                                    <a title="Detail Homestay Unit" class="btn icon btn-outline-info btn-sm mb-1 me-1 float-end" href="detail/<?= esc($homestay_id) ?>/<?= esc($item['id']) ?>">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            for ($i = 0; $i < (int)esc($item['avg_rating']); $i++) {
                                            ?>
                                                <i name="rating" class="fas fa-star text-warning" aria-hidden="true"></i>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            for ($i = 0; $i < (5 - (int)esc($item['avg_rating'])); $i++) {
                                            ?>
                                                <i name="rating" class="far fa-star" aria-hidden="true"></i>
                                            <?php
                                            }
                                            ?>
                                            <p class="card-text">Package Day : <?= esc($item['total_day']) ?> day <br>
                                                Minimun Capacity : <?= esc($item['min_capacity']) ?> people</p>
                                            <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($item['price'], 0, ',', '.')) ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
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