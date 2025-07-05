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
        <div class="card mb-3" style="max-width: 1000px;">
            <div class="row g-0">
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <img width="1000px" height="300px" src="<?= base_url('media/photos'); ?>/<?= esc($data['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 300px;">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= esc($data['name']); ?>
                            <?php if (!empty($data['category'] == '1')) : ?>
                                (Facility)
                            <?php else : ?>
                                (Service)
                            <?php endif; ?>
                        </h5>
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
                        <p class="card-text"><?= esc($data['description']); ?></p>
                        <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($data['price'], 0, ',', '.')) ?><?= ($data['is_order_count_per_day'] == '1') ? '/day' : '' ?><?= ($data['is_order_count_per_person'] == '1') ? '/person' : '' ?><?= ($data['is_order_count_per_room'] == '1') ? '/room' : '' ?></small></p>
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