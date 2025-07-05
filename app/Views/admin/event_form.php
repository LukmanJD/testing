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
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"><?= $title; ?></h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="<?= ($edit) ? base_url('dashboard/event/update') . '/' . $data['id'] : base_url('dashboard/event'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group mb-4">
                                <label for="geo-json" class="mb-2">GeoJSON</label>
                                <input type="text" id="geo-json" class="form-control" name="geo-json" placeholder="GeoJSON" readonly="readonly" required value='<?= ($edit) ? $data['geoJson'] : ''; ?>'>
                            </div>
                            <div class="form-group mb-4">
                                <label for="name" class="mb-2">Event Name</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Event Name" value="<?= ($edit) ? $data['name'] : old('name'); ?>" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="ticket_price" class="mb-2">Ticket Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp </span>
                                    <input type="number" id="ticket_price" class="form-control" name="ticket_price" placeholder="Ticket Price" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= ($edit) ? $data['ticket_price'] : old('ticket_price'); ?>">
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="contact_person" class="mb-2">Event Organizer</label>
                                <input type="tel" id="contact_person" class="form-control" name="event_organizer" placeholder="Contact Person" value="<?= ($edit) ? $data['event_organizer'] : old('contact_person'); ?>">
                            </div>
                            <div class="form-group mb-4">
                                <label for="contact_person" class="mb-2">Phone</label>
                                <input type="tel" id="contact_person" class="form-control" name="phone" placeholder="Contact Person" value="<?= ($edit) ? $data['phone'] : old('phone'); ?>">
                            </div>
                            <div class="form-group mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"><?= ($edit) ? $data['description'] : old('description'); ?></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="gallery" class="form-label">Gallery</label>
                                <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery" multiple>
                            </div>

                            <input type="hidden" name="lat" id="lat" value="<?= ($edit) ? $data['lat'] : old('lat'); ?>">
                            <input type="hidden" name="lng" id="lng" value="<?= ($edit) ? $data['lng'] : old('lng'); ?>">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12 mb-3">
                            <h5 class="card-title">Google Maps</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="eg. -0.52435750" value="<?= ($edit) ? $data['lat'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="eg. 100.49234850" value="<?= ($edit) ? $data['lng'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-auto mx-1">
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search" class="btn icon btn-outline-primary" onclick="findCoords('RG');">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                        </div>
                        <div class="col-auto mx-1">
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clear" class="btn icon btn-outline-danger" id="clear-drawing">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </div>

                </div>
                <?= $this->include('web/layouts/map-body'); ?>
                <script>
                    goToVillage();
                    initDrawingManager(<?= $edit ?>);
                </script>
            </div>
            <!-- Object Media -->
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
    $('#datepicker_start').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d'
    });
    $('#datepicker_end').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '-3d'
    });
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
            Swal.fire('Please select location for the New Event');
        }
        let selection = $('#repeatSelect').val();
        if (selection !== 'none') {
            if (!$('#date_end').val() && !$('#occurrence').val()) {
                event.preventDefault();
                Swal.fire('Please select Date End or Occurrence for the New Event');
            }
        }
    }

    function triggerOccur() {
        let selection = $('#repeatSelect').val();
        if (selection !== 'none') {
            $('#occurrence').removeAttr('readonly');
        } else {
            $('#occurrence').attr('readonly', 'readonly');
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