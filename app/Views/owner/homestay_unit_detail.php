<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-8 col-12">
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
                        <?php if (in_groups('owner')) : ?>
                            <div class="col-auto">
                                <a href="<?= base_url('dashboard/homestayUnit/edit'); ?>/<?= esc($data['unit_type']); ?><?= esc($data['unit_number']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                            </div>
                        <?php endif; ?>
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

        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Facilities <a class="float-end" data-bs-toggle="modal" data-bs-target="#insertService"><i class="fa-solid fa-add"></i></a></td>
                                    </tr>
                                    <?php if (!empty($facilities)) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($facilities as $facility) : ?>
                                            <tr>
                                                <td class="fw-bold"><?= esc($no); ?>. <?= esc($facility['name']); ?><a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deleteUnitFacility('<?= esc($data['homestay_id']); ?>', '<?= esc($data['unit_type']); ?>', '<?= esc($data['unit_number']); ?>', '<?= esc($facility['id']); ?>', '<?= esc($facility['name']); ?>', 'false')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a><a class="btn icon btn-outline-warning btn-sm float-end" data-bs-toggle="modal" data-bs-target="#editService<?= esc($facility['id']); ?>" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-edit"></i></a></td>
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
        </div>
        <!-- Modal Add Service -->
        <div class="modal fade" id="insertService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Facility</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form class="form form-vertical" action="facility/<?= esc($data['homestay_id']); ?>/<?= esc($data['unit_type']); ?>/<?= esc($data['unit_number']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" name="homestay_id" value="<?= esc($data['homestay_id']); ?>">
                                    <input type="hidden" name="unit_type" value="<?= esc($data['unit_type']); ?>">
                                    <input type="hidden" name="unit_number" value="<?= esc($data['unit_number']); ?>">
                                    <fieldset class="form-group mb-4">
                                        <script>
                                            getListFHU('<?= esc($data['homestay_id']); ?>', '<?= esc($data['unit_type']); ?>', '<?= esc($data['unit_number']); ?>');
                                        </script>
                                        <label for="catSelect" class="mb-2">Facility</label>
                                        <select class="form-select" id="proSelect" name="facility_id" required>
                                        </select>
                                    </fieldset>
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
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
        <?php if (!empty($facilities)) : ?>
            <?php foreach ($facilities as $facility) : ?>
                <div class="modal fade" id="editService<?= esc($facility['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <form class="form form-vertical" action="facility/edit/<?= esc($data['homestay_id']); ?>/<?= esc($data['unit_type']); ?>/<?= esc($data['unit_number']); ?>/<?= esc($facility['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <input type="hidden" name="homestay_id" value="<?= esc($data['homestay_id']); ?>">
                                            <input type="hidden" name="unit_type" value="<?= esc($data['unit_type']); ?>">
                                            <input type="hidden" name="unit_number" value="<?= esc($data['unit_number']); ?>">
                                            <input type="hidden" name="facility_id" value="<?= esc($facility['id']); ?>">
                                            <fieldset class="form-group mb-4">
                                                <label for="catSelect" class="mb-2">Facility</label>
                                                <select class="form-select" id="proSelect" name="facility_id" required disabled>
                                                    <option value="" selected disabled><?= esc($facility['name']); ?></option>
                                                </select>
                                            </fieldset>
                                            <div class="form-group mb-4">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="4"><?= esc($facility['description']); ?></textarea>
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