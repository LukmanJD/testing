<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('styles') ?>
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.css">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/form-element-select.css'); ?>">
<style>
    .filepond--root {
        width: 100%;
    }
</style>
<?= $this->endSection() ?>

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
                        <?php if (in_groups('owner')) : ?>
                            <div class="col-auto">
                                <a href="<?= base_url('dashboard/homestay/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                            </div>
                        <?php endif; ?>
                        <?php if (in_groups('admin')) : ?>
                            <div class="col-auto">
                                <a href="<?= base_url('dashboard/homestay/manage/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Category</td>
                                        <td>
                                            <?php if ($data['category'] == '1') : ?>
                                                <?= esc('Non Syariah'); ?>
                                            <?php else : ?>
                                                <?= esc('Syariah'); ?>
                                            <?php endif; ?>
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
                            <?php $i = 1; ?>
                            <?php foreach ($data['facilities'] as $facility) : ?>
                                <p><?= esc($i) . '. ' . esc($facility); ?></p>
                                <?php $i++; ?>
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
                                <?php if (in_groups('owner')) : ?>
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deleteCertification('<?= esc($certification['homestay_id']); ?>','<?= esc($certification['certification_id']); ?>','<?= esc($certification['certificate_name']); ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <a title="Edit" class="btn icon btn-outline-warning btn-sm float-end ms-1" data-bs-toggle="modal" data-bs-target="#editCertificate<?= esc($certification['certification_id']); ?>">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                <a title="Info" class="btn icon btn-outline-primary btn-sm float-end ms-1" data-bs-toggle="modal" data-bs-target="#infoCertificate<?= esc($certification['certification_id']); ?>">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if (in_groups('owner')) : ?>
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertNewAdditionalAmenities"><i class="fa-solid fa-add me-3"></i>Add Certificaion</a>
                    </div>
                <?php endif; ?>
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
    <!-- Add Certification -->
    <div class="modal fade" id="insertNewAdditionalAmenities" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Certification</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" action="<?= base_url('dashboard/homestayCertification/create'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="homestay_id" value="<?= esc($data['id']) ?>">
                                <div class="form-group">
                                    <label for="name" class="mb-2">Certification Name</label>
                                    <input type="text" id="name" class="form-control" name="certificate_name" placeholder="Certification Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="mb-2">Certification Number</label>
                                    <input type="text" id="name" class="form-control" name="certificate_num" placeholder="Certification Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="mb-2">Certifying Agency</label>
                                    <input type="text" id="name" class="form-control" name="certifying_agency" placeholder="Certifying Agency" required>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="mb-2">Date</label>
                                    <input type="date" id="name" class="form-control" name="date" placeholder="Date" required>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="gallery" class="form-label">Image</label>
                                    <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery1" required>
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
        <div class="modal fade" id="editCertificate<?= esc($certification['certification_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Certification</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form class="form form-vertical" action="<?= base_url('dashboard/homestayCertification/update/' . esc($certification['certification_id'])); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" name="homestay_id" value="<?= esc($certification['homestay_id']) ?>">
                                    <div class="form-group">
                                        <label for="name" class="mb-2">Certification Name</label>
                                        <input type="text" id="name" class="form-control" name="certificate_name" placeholder="Certification Name" value="<?= esc($certification['certificate_name']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="mb-2">Certification Number</label>
                                        <input type="text" id="name" class="form-control" name="certificate_num" placeholder="Certification Number" value="<?= esc($certification['certificate_num']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="mb-2">Certifying Agency</label>
                                        <input type="text" id="name" class="form-control" name="certifying_agency" placeholder="Certifying Agency" value="<?= esc($certification['certifying_agency']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="mb-2">Date</label>
                                        <input type="date" id="name" class="form-control" name="date" placeholder="Date" value="<?= esc($certification['date']) ?>" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"><?= esc($certification['description']) ?></textarea>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="gallery" class="form-label">Image</label>
                                        <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery<?= esc($certification['certification_id']); ?>" required>
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

    function deleteCertification(homestay_id = null, certification_id = null, certification_name = null) {
        Swal.fire({
            title: "Delete this certification?",
            text: "You are about to remove " + certification_name,
            icon: "warning",
            showCancelButton: true,
            denyButtonText: "Delete",
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#343a40",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/dashboard/homestayCertification/delete/' + certification_id,
                    type: "POST",
                    data: {
                        homestay_id: homestay_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire(
                                "Deleted!",
                                "Successfully remove " + certification_name,
                                "success"
                            ).then((result) => {
                                if (result.isConfirmed) {
                                    document.location.reload();
                                }
                            });
                        } else {
                            Swal.fire("Failed", "Delete " + certification_name + " failed!", "warning");
                        }
                    },
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>
<script>
    $(document).ready(function() {
        $('#table-manage').DataTable({
            columnDefs: [{
                targets: ['_all'],
                className: 'dt-head-center'
            }],
            lengthMenu: [5, 10, 20, 50, 100]
        });
    });
</script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageResize,
        FilePondPluginMediaPreview,
    );

    // Get a reference to the file input element
    const photo = document.querySelector('input[id="gallery1"]');

    // Create a FilePond instance
    const pond = FilePond.create(photo, {
        maxFileSize: '1920MB',
        maxTotalFileSize: '1920MB',
        imageResizeTargetHeight: 720,
        imageResizeUpscale: false,
        credits: false,
    });

    pond.setOptions({
        server: {
            timeout: 3600000,
            process: {
                url: '/upload/photo',
                onload: (response) => {
                    console.log("processed:", response);
                    return response
                },
                onerror: (response) => {
                    console.log("error:", response);
                    return response
                },
            },
            revert: {
                url: '/upload/photo',
                onload: (response) => {
                    console.log("reverted:", response);
                    return response
                },
                onerror: (response) => {
                    console.log("error:", response);
                    return response
                },
            },
        }
    });
    <?php foreach ($data['certification'] as $certification) : ?>
        const photo<?= esc($certification['certification_id']); ?> = document.querySelector('input[id="gallery<?= esc($certification['certification_id']); ?>"]');
        const pond<?= esc($certification['certification_id']); ?> = FilePond.create(photo<?= esc($certification['certification_id']); ?>, {
            maxFileSize: '1920MB',
            maxTotalFileSize: '1920MB',
            imageResizeTargetHeight: 720,
            imageResizeUpscale: false,
            credits: false,
        });

        pond<?= esc($certification['certification_id']); ?>.addFiles(`<?= base_url('media/photos/' . $certification['image_url']); ?>`);

        pond<?= esc($certification['certification_id']); ?>.setOptions({
            server: {
                timeout: 3600000,
                process: {
                    url: '/upload/photo',
                    onload: (response) => {
                        console.log("processed:", response);
                        return response
                    },
                    onerror: (response) => {
                        console.log("error:", response);
                        return response
                    },
                },
                revert: {
                    url: '/upload/photo',
                    onload: (response) => {
                        console.log("reverted:", response);
                        return response
                    },
                    onerror: (response) => {
                        console.log("error:", response);
                        return response
                    },
                },
            }
        });
    <?php endforeach; ?>
</script>
<?= $this->endSection() ?>