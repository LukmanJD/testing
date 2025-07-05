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
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Edit Village Information</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body text-dark">
                    <div class="row">
                        <form class="form form-vertical mt-3" action="<?= base_url('dashboard/villages/update') . '/' . $data['id_vi']; ?>" method="post" id="uploadForm" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="id" value="<?= $data['id_vi']; ?>" required>
                                <div class="form-group mb-4">
                                    <label for="address" class="form-label">Village</label>
                                    <input type="text" class="form-control" name="name" aria-label="Name" aria-describedby="name" value="<?= $data['name']; ?>" required disabled>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required><?= $data['address']; ?></textarea>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required><?= $data['description']; ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12 mb-4">
                                        <label for="capacity" class="mb-2">Open</label>
                                        <div class="input-group">
                                            <input type="time" id="capacity" class="form-control" name="open" placeholder="Capacity" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['open']; ?>" required>
                                            <span class="input-group-text">WIB</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 col-12 mb-4">
                                    </div>
                                    <div class="form-group col-md-4 col-12 mb-4">
                                        <label for="capacity" class="mb-2">Ticket Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp.</span>
                                            <input type="number" id="capacity" class="form-control" name="ticket_price" placeholder="Ticket Price" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['ticket_price']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 col-12 mb-4">
                                        <label for="capacity" class="mb-2">Close</label>
                                        <div class="input-group">
                                            <input type="time" id="capacity" class="form-control" name="close" placeholder="Capacity" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['close']; ?>" required>
                                            <span class="input-group-text">WIB</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group col-md-6 col-12 mb-4">
                                        <label for="email" class="mb-2">Email</label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Email" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['email']; ?>">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="form-group col-md-3 col-12 mb-4">
                                        <label for="capacity" class="mb-2">Facebook</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text" id="capacity" class="form-control" name="facebook" placeholder="Facebook" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['facebook']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12 mb-4">
                                        <label for="capacity" class="mb-2">Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text" id="capacity" class="form-control" name="instagram" placeholder="Instagram" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['instagram']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12 mb-4">
                                        <label for="capacity" class="mb-2">Youtube</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text" id="capacity" class="form-control" name="youtube" placeholder="Youtube" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['youtube']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-12 mb-4">
                                        <label for="capacity" class="mb-2">TikTok</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text" id="capacity" class="form-control" name="tiktok" placeholder="TikTok" aria-label="Ticket Price" aria-describedby="ticket-price" value="<?= $data['tiktok']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 mb-4">
                                    <div class="form-group col-md-6 col-12 mb-4">
                                        <label for="gallery" class="form-label">Photos</label>
                                        <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery" multiple>
                                    </div>
                                    <div class="form-group col-md-6 col-12 mb-4">
                                        <label for="video" class="form-label">Video</label>
                                        <input class="form-control" accept="video/*, .mkv" type="file" name="video" id="video">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                            </div>
                        </form>
                    </div>
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
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageExifOrientation,
        FilePondPluginImagePreview,
        FilePondPluginImageResize,
        FilePondPluginMediaPreview
    );

    // Get a reference to the file input element
    const photo = document.querySelector('input[id="gallery"]');
    const video = document.querySelector('input[id="video"]');

    // Create a FilePond instance
    const pond = FilePond.create(photo, {
        maxFileSize: "1920MB",
        maxTotalFileSize: "1920MB",
        imageResizeTargetHeight: 720,
        imageResizeUpscale: false,
        credits: false,
    });
    const vidPond = FilePond.create(video, {
        maxFileSize: "1920MB",
        maxTotalFileSize: "1920MB",
        credits: false,
    });

    pond.addFiles(
        <?php foreach ($data['gallery'] as $gallery) : ?> `<?= base_url('media/photos/' . $gallery); ?>`,
        <?php endforeach; ?>
    );

    <?php if ($data['video_url']) : ?>
        vidPond.addFiles(`<?= base_url('media/videos/' . $data['video_url']); ?>`);
    <?php endif; ?>

    let uploadedPhotos = 0;

    pond.setOptions({
        server: {
            timeout: 3600000,
            process: {
                url: "/upload/photo",
                onload: (response) => {
                    console.log("processed:", response);
                    uploadedPhotos++;
                    console.log(uploadedPhotos);
                    return response;
                },
                onerror: (response) => {
                    console.log("error:", response);
                    return response;
                },
            },
            revert: {
                url: "/upload/photo",
                onload: (response) => {
                    console.log("reverted:", response);
                    uploadedPhotos--;
                    console.log(uploadedPhotos);
                    return response;
                },
                onerror: (response) => {
                    console.log("error:", response);
                    return response;
                },
            },
        },
    });

    vidPond.setOptions({
        server: {
            timeout: 86400000,
            process: {
                url: "/upload/video",
                onload: (response) => {
                    console.log("processed:", response);
                    return response;
                },
                onerror: (response) => {
                    console.log("error:", response);
                    return response;
                },
            },
            revert: {
                url: "/upload/video",
                onload: (response) => {
                    console.log("reverted:", response);
                    return response;
                },
                onerror: (response) => {
                    console.log("error:", response);
                    return response;
                },
            },
        },
    });
    document
        .getElementById("uploadForm")
        .addEventListener("submit", function(e) {
            e.preventDefault(); // Mencegah form dikirim langsung

            // Validasi jumlah file yang diupload
            if (uploadedPhotos < 4) {
                Swal.fire("You must upload a minimum of 4 photos!");
            } else {
                // alert("Form valid dan bisa dikirim!");
                // Lakukan pengiriman form secara manual jika validasi berhasil
                // Misalnya dengan AJAX, atau submit form di sini jika diperlukan
                this.submit(); // Uncomment jika ingin melanjutkan pengiriman
            }
        });
</script>
<?= $this->endSection() ?>