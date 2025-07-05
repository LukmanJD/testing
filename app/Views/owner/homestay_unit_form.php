<?php
$uri = service('uri')->getSegments();
$edit = in_array('edit', $uri);
?>

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
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"><?= $title; ?></h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="<?= ($edit) ? base_url('dashboard/homestayUnit/update') . '/' . $data['unit_type'] . $data['unit_number'] : base_url('dashboard/homestayUnit'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <fieldset class="form-group mb-4">
                                <label for="catSelect" class="mb-2">Unit Type</label>
                                <?php if (!$edit) : ?>
                                    <select class="form-select" id="catSelect" name="unit_type" required>
                                        <?php foreach ($unit_type as $unit) : ?>
                                            <?php if ($edit && in_array(esc($unit['id']), $data['type'])) : ?>
                                                <option value="<?= esc($unit['id']); ?>" selected><?= esc($unit['name']); ?></option>
                                            <?php else : ?>
                                                <option value="<?= esc($unit['id']); ?>"><?= esc($unit['name']); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else : ?>
                                    <select class="form-select" id="catSelect" name="unit_type" disabled>
                                        <option value="" selected><?= esc($data['unit']); ?></option>
                                    </select>
                                <?php endif; ?>
                            </fieldset>
                            <div class="form-group mb-4">
                                <label for="name" class="mb-2">Homestay Unit Name</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Homestay Unit Name" value="<?= ($edit) ? $data['name'] : old('name'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="price" class="mb-2">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp.</span>
                                    <input type="number" id="price" class="form-control" name="price" placeholder="Price" aria-label="Price" aria-describedby="price" value="<?= ($edit) ? $data['price'] : old('price'); ?>" required>
                                    <span class="input-group-text">/ day</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="mb-2">Capacity</label>
                                <div class="input-group">
                                    <input type="number" id="price" class="form-control" name="capacity" placeholder="Capacity" aria-label="Price" aria-describedby="price" value="<?= ($edit) ? $data['capacity'] : old('capacity'); ?>" required>
                                    <span class="input-group-text">people</span>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= ($edit) ? $data['description'] : old('description'); ?></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="gallery" class="form-label">Gallery</label>
                                <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
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

    function checkRequired(event) {
        if (!$('#geo-json').val()) {
            event.preventDefault();
            Swal.fire('Please select location for the New Rumah Gadang');
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
    const photo = document.querySelector('input[id="gallery"]');
    const video = document.querySelector('input[id="video"]');

    // Create a FilePond instance
    const pond = FilePond.create(photo, {
        maxFileSize: '1920MB',
        maxTotalFileSize: '1920MB',
        imageResizeTargetHeight: 720,
        imageResizeUpscale: false,
        credits: false,
    });
    const vidPond = FilePond.create(video, {
        maxFileSize: '1920MB',
        maxTotalFileSize: '1920MB',
        credits: false,
    })

    <?php if ($edit && count($data['gallery']) > 0) : ?>
        pond.addFiles(
            <?php foreach ($data['gallery'] as $gallery) : ?> `<?= base_url('media/photos/' . $gallery); ?>`,
            <?php endforeach; ?>
        );
    <?php endif; ?>
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
</script>
<?= $this->endSection() ?>