<?= $this->extend('dashboard/layouts/main'); ?>

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
                            <h4 class="card-title text-center">Attraction Information</h4>
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
                        <div class="col-auto">
                            <a href="<?= base_url('dashboard/attraction/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Category</td>
                                        <td><?= ($data['attraction_category'] == '1') ? 'Unique' : 'Ordinary'; ?></td>
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
                                        <td><?= esc($data['phone']); ?> (<?= esc($data['employee_name']); ?>)</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td>Rp <?= number_format(esc($data['price']), 0, ',', '.'); ?></td>
                                    </tr>
                                    
                                <tr>
                                    <td class="fw-bold" colspan="2">Description</td>
                                </tr>
                                <tr>
                                    <td colspan="4"><?= esc($data['description']); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Facilities</p>
                            <?php $i = 1; ?>
                            <?php foreach ($data['facilities'] as $facility) : ?>
                                <p><?= esc($i) . '. ' . esc($facility); ?></p>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Add Service -->
        <div class="modal fade" id="insertService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Ticket</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form class="form form-vertical" action="ticket" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" name="attraction_id" value="<?= esc($data['id']); ?>">
                                    <div class="form-group">
                                        <label for="name" class="mb-2">Ticket Category Name</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Ticket Category Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="mb-2">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" id="price" class="form-control" name="price" placeholder="Price" aria-label="Price" aria-describedby="price" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 my-3">Save</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 my-3">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit Service -->
        <?php if (!empty($ticket_prices)) : ?>
            <?php foreach ($ticket_prices as $ticket_price) : ?>
                <div class="modal fade" id="editService<?= esc($ticket_price['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Ticket</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form class="form form-vertical" action="ticket/edit/<?= esc($ticket_price['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <input type="hidden" name="attraction_id" value="<?= esc($ticket_price['attraction_id']); ?>">
                                            <div class="form-group">
                                                <label for="name" class="mb-2">Ticket Category Name</label>
                                                <input type="text" id="name" class="form-control" name="name" placeholder="Ticket Category Name" value="<?= esc($ticket_price['name']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price" class="mb-2">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="number" id="price" class="form-control" name="price" placeholder="Price" aria-label="Price" aria-describedby="price" value="<?= esc($ticket_price['price']); ?>" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-1 my-3">Save</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 my-3">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Google Maps</h5>
                </div>

                <?= $this->include('web/layouts/map-body'); ?>
                <script>
                    initMap(<?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>)
                    digitObject("<?= esc(json_encode($data['geoJson'])); ?>");
                </script>
                <script>
                    objectMarker("<?= esc($data['id']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>, true, "<?= esc($data['attraction_category']); ?>");
                    map.setZoom(16);
                </script>
            </div>

            <!-- Object Media -->
            <?= $this->include('web/layouts/gallery_video'); ?>
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