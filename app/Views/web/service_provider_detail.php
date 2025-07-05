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
                            <h4 class="card-title text-center">Service Provider Information</h4>
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
                                        <td><?= esc($data['phone']) . ' (' . esc($data['employee_name']) . ')'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold" colspan="2">Description</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?= esc($data['description']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="col table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold" colspan="3">List of Service</td>
                                        </tr>
                                        <?php if (empty($services)) : ?>
                                            <tr>
                                                <td colspan="3">There is No Service</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php $no = 1; ?>
                                            <?php foreach ($services as $service) : ?>
                                                <tr style="font-size: 15px;">
                                                    <td><?= esc($no); ?></td>
                                                    <td><?= esc($service['name']); ?></td>
                                                    <td>Rp <?= number_format(esc($service['price']), 0, ',', '.'); ?>/<?= esc($service['unit_price']); ?></td>
                                                </tr>
                                                <?php $no++; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <!-- Modal Add Service -->
                                <div class="modal fade" id="insertService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add New Service</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form class="form form-vertical" action="service" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                        <div class="form-body">
                                                            <input type="hidden" name="service_provider_id" value="<?= esc($data['id']); ?>">
                                                            <div class="form-group">
                                                                <label for="name" class="mb-2">Service Name</label>
                                                                <input type="text" id="name" class="form-control" name="name" placeholder="Service Name" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-6 col-12">
                                                                        <label for="price" class="mb-2">Price</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">Rp.</span>
                                                                            <input type="number" id="price" class="form-control" name="price" placeholder="Price" aria-label="Price" aria-describedby="price" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <label for="unit_price" class="mb-2">Unit Price</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">/</span>
                                                                            <input type="text" id="unit_price" class="form-control" name="unit_price" placeholder="Unit Price" aria-label="unit Price" aria-describedby="unit_price" required>
                                                                        </div>
                                                                    </div>
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
                                <?php if (!empty($services)) : ?>
                                    <?php foreach ($services as $service) : ?>
                                        <div class="modal fade" id="editService<?= esc($service['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card-body">
                                                            <form class="form form-vertical" action="service/edit/<?= esc($service['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                                <div class="form-body">
                                                                    <input type="hidden" name="service_provider_id" value="<?= esc($service['service_provider_id']); ?>">
                                                                    <div class="form-group">
                                                                        <label for="name" class="mb-2">Service Name</label>
                                                                        <input type="text" id="name" class="form-control" name="name" placeholder="Service Name" value="<?= esc($service['name']); ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-md-6 col-12">
                                                                                <label for="price" class="mb-2">Price</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text">Rp.</span>
                                                                                    <input type="number" id="price" class="form-control" name="price" placeholder="Price" aria-label="Price" aria-describedby="price" value="<?= esc($service['price']); ?>" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 col-12">
                                                                                <label for="unit_price" class="mb-2">Unit Price</label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text">/</span>
                                                                                    <input type="text" id="unit_price" class="form-control" name="unit_price" placeholder="Unit Price" aria-label="unit Price" aria-describedby="unit_price" value="<?= esc($service['unit_price']); ?>" required>
                                                                                </div>
                                                                            </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    objectMarker("<?= esc($data['id']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>);
                    map.setZoom(20);
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