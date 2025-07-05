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
                            <h4 class="card-title">Additional Amenities</h4>
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
                        <div class="card border mb-3">
                            <div class="row g-0">
                                <div class="col-md-3 d-flex align-items-center justify-content-center">
                                    <img width="500px" src="/media/photos/<?= esc($item['image_url']) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 200px;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                            </div>
                                            <div class="col">
                                                <a title="Detail Homestay Unit" class="btn icon btn-outline-info btn-sm mb-1 me-1 float-end" data-bs-toggle="modal" data-bs-target="#infoAmenities<?= esc($item['id']); ?>">
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
                                        <p class="card-text text-truncate"><?= esc($item['description']) ?></p>
                                        <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($item['price'], 0, ',', '.')) ?><?= ($item['is_order_count_per_day'] == '1') ? '/day' : '' ?><?= ($item['is_order_count_per_person'] == '1') ? '/person' : '' ?><?= ($item['is_order_count_per_room'] == '1') ? '/room' : '' ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Info Additional Amenities -->
    <?php if ($category == 'Homestay Additional Amenities') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                <div class="modal fade bd-example-modal-lg" id="infoAmenities<?= esc($activity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Info Additional Amenities</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card mb-3" style="max-width: 1000px;">
                                    <div class="row g-0">
                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                            <img width="1000px" src="<?= base_url('media/photos'); ?>/<?= esc($activity['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <?= esc($activity['name']); ?>
                                                    <?php if (!empty($activity['category'] == '1')) : ?>
                                                        (Facility)
                                                    <?php else : ?>
                                                        (Service)
                                                    <?php endif; ?>
                                                </h5>
                                                <?php
                                                for ($i = 0; $i < (int)esc($activity['avg_rating']); $i++) {
                                                ?>
                                                    <i name="rating" class="fas fa-star text-warning" aria-hidden="true"></i>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                for ($i = 0; $i < (5 - (int)esc($activity['avg_rating'])); $i++) {
                                                ?>
                                                    <i name="rating" class="far fa-star" aria-hidden="true"></i>
                                                <?php
                                                }
                                                ?>
                                                <p class="card-text"><?= esc($activity['description']); ?></p>
                                                <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($activity['price'], 0, ',', '.')) ?><?= ($activity['is_order_count_per_day'] == '1') ? '/day' : '' ?><?= ($activity['is_order_count_per_person'] == '1') ? '/person' : '' ?><?= ($activity['is_order_count_per_room'] == '1') ? '/room' : '' ?></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>