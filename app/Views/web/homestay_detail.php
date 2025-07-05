<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Homestay Information</h4>
                        </div>
                        <?php if (!logged_in()) : ?>
                            <div class="col">
                                <a id="btn-booking1" class="btn btn-success float-end" onclick="redirectToLogin()"><i class="fa-solid fa-bookmark me-3"></i>Booking</a>
                                <script>
                                    function redirectToLogin() {
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'You are not logged in as User',
                                            text: 'Please log in to proceed.',
                                            confirmButtonText: 'OK',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = '<?= base_url('/login'); ?>';
                                            } else {

                                            }
                                        });
                                    }
                                </script>
                            </div>
                        <?php endif; ?>
                        <?php if (in_groups('user')) : ?>
                            <div class="col">
                                <a id="btn-booking" class="btn btn-success float-end"><i class="fa-solid fa-bookmark me-3"></i>Booking</a>
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
                                    <!-- <tr>
                                        <td class="fw-bold">Ticket Price</td>
                                        <td><?php
                                            // 'Rp ' . number_format(esc($data['ticket_price']), 0, ',', '.'); 
                                            ?></td>
                                    </tr> -->
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
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Homestay Certifications
                </div>
                <div class="card-body mt-4">
                    <ul class="list-group">
                        <?php foreach ($data['certification'] as $certification) : ?>
                            <li class="list-group-item">
                                <h5><?= esc($certification['certificate_name']); ?></h5>
                                <p class="text-mute mb-1"><?= esc($certification['certificate_num']); ?></p>
                                <p class="mb-1"><?= esc($certification['description']); ?></p>
                                <p class="mb-1"><strong>Certifying Agency:</strong> <?= esc($certification['certifying_agency']); ?> | <strong>Certification Date:</strong> <?= esc(date('d-m-Y', strtotime($certification['date']))); ?> </p>
                                <a title="Info" class="btn icon btn-outline-primary btn-sm float-end ms-1" data-bs-toggle="modal" data-bs-target="#infoCertificate<?= esc($certification['certification_id']); ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
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

        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card text-dark">
                <div class="card-header">
                    <h5 class="card-title">Google Maps</h5>
                </div>

                <?= $this->include('web/layouts/map-body'); ?>
                <script>
                    initMap(<?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>)
                    markerClickable = false;
                    digitObject("<?= esc(json_encode($data['geoJson'])); ?>");
                </script>
                <script>
                    objectMarker("<?= esc($data['id']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>);
                    map.setZoom(20);
                </script>
            </div>

            <!-- Object Media -->
            <?= $this->include('web/layouts/gallery_video'); ?>
        </div>
    </div>
    <?php foreach ($data['certification'] as $certification) : ?>
        <div class="modal fade" id="infoCertificate<?= esc($certification['certification_id']); ?>" tabindex="-1" aria-labelledby="certificateModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="certificateModalLabel1">Homestay Certificate</h5>
                    </div>
                    <div class="modal-body text-center">
                        <img src="<?= base_url('media/photos/' . esc($certification['image_url'])); ?>" alt="Homestay Certificate" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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