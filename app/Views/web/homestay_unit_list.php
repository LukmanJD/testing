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
                            <h4 class="card-title">Homestay Unit</h4>
                        </div>
                        <?php if (in_groups('user')) : ?>
                            <div class="col">
                                <a id="btn-booking" class="btn btn-success float-end"><i class="fa-solid fa-bookmark me-3"></i>Booking</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php foreach ($data as $item) : ?>
                        <div class="card border mb-3">
                            <div class="row g-0">
                                <div class="col-md-3 d-flex align-items-center justify-content-center">
                                    <img width="500px" src="/media/photos/<?= esc($item['galleries'][0]) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 200px;">
                                </div>
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                            </div>
                                            <div class="col">
                                                <a title="Detail Homestay Unit" class="btn icon btn-outline-info btn-sm mb-1 me-1 float-end" href="<?= esc($homestay_id) ?>/detail/<?= esc($item['id']) ?>">
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
                                        <p class="card-text text-truncate">
                                            <?php

                                            if ($item['unit_type'] == '1') {
                                                echo "Room";
                                            } elseif ($item['unit_type'] == '2') {
                                                echo "Villa";
                                            } else {
                                                echo "Hall";
                                            }

                                            ?>
                                            , Capacity: <?= esc($item['capacity']) ?> people</p>
                                        <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($item['price'], 0, ',', '.')) ?>/day</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<script>
    // Tambahkan event listener untuk tombol
    document.getElementById("btn-booking").addEventListener("click", function() {
        // Tampilkan SweetAlert
        Swal.fire({
            title: 'Select Booking Options',
            text: 'Please choose one of the booking options below:',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Personal',
            confirmButtonColor: "#3085d6",
            cancelButtonText: 'Event',
            cancelButtonColor: "#039e00",
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('<?= base_url('web/reservation'); ?><?= esc('/' . $homestay_id); ?>', '_blank');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.open('<?= base_url('web/reservationEvent'); ?><?= esc('/' . $homestay_id); ?>', '_blank');
            }
        });
    });
</script>
<?= $this->endSection() ?>