<?= $this->extend('web/layouts/main'); ?>

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
                            <h4 class="card-title text-center">Culinary Place Information</h4>
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
                                    <tr>
                                        <td colspan="2">
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
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if (!empty($products)) : ?>
                        <div class="row">
                            <div class="col table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">List of Product</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($products as $product) : ?>
                                                        <div class="col-md-6 col-12">
                                                            <a data-bs-toggle="modal" data-bs-target="#infoProduct<?= esc($product['culinary_product_id']); ?>">
                                                                <div class="card" style="border: 1px solid #969696;">
                                                                    <img height="200px" src="<?= base_url('media/photos'); ?>/<?= esc($product['image_url']); ?>" class="card-img-top" alt="..." style="object-fit: cover;">
                                                                    <div class=" card-body">
                                                                        <span class="fw-bold"><?= esc($product['name']); ?></span>
                                                                        <p class="card-text">Rp. <?= esc($product['price']); ?></p>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <?php $no++ ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- Modal Info Product -->
                                <?php if (!empty($products)) : ?>
                                    <?php foreach ($products as $product) : ?>
                                        <div class="modal fade bd-example-modal-lg" id="infoProduct<?= esc($product['culinary_product_id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Info Product</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="card mb-3" style="max-width: 1000px;">
                                                            <div class="row g-0">
                                                                <div class="col-md-6">
                                                                    <img width="1000px" src="<?= base_url('media/photos'); ?>/<?= esc($product['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title"><?= esc($product['name']); ?></h5>
                                                                        <p class="card-text"><?= esc($product['description']); ?></p>
                                                                        <p class="card-text"><small class="text-muted">Rp. <?= esc($product['price']); ?></small></p>
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
                            </div>
                        </div>
                    <?php endif; ?>
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
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>
<script>
    getFacility();
</script>
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

    function checkRequired() {
        if (!$('#proSelect').val()) {
            event.preventDefault();
            Swal.fire('Please select a Product');
        }
    }
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

    <?php if (!empty($products)) : ?>
        <?php foreach ($products as $product) : ?>
            const photo<?= esc($product['culinary_product_id']); ?> = document.querySelector('input[id="gallery<?= esc($product['culinary_product_id']); ?>"]');
            const pond<?= esc($product['culinary_product_id']); ?> = FilePond.create(photo<?= esc($product['culinary_product_id']); ?>, {
                maxFileSize: '1920MB',
                maxTotalFileSize: '1920MB',
                imageResizeTargetHeight: 720,
                imageResizeUpscale: false,
                credits: false,
            });

            pond<?= esc($product['culinary_product_id']); ?>.addFiles(`<?= base_url('media/photos/' . $product['image_url']); ?>`);

            pond<?= esc($product['culinary_product_id']); ?>.setOptions({
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
    <?php endif; ?>
</script>
<?= $this->endSection() ?>