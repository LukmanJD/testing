<?php
$uri = service('uri')->getSegments();
$edit = in_array('edit', $uri);
?>

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

<section class="section text-dark">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">
                        <?php
                        if (url_is('*extendPackage*')) {
                            echo "Extend Package";
                        } else {
                            echo "Custom Package";
                        }
                        ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="col table-responsive">
                        <table class="table table-borderless text-dark">
                            <tbody>
                                <tr>
                                    <td class="fw-bold" style="width: 20%;">Name</td>
                                    <td><?= esc($package['name']); ?></td>
                                </tr>
                                <?php if (url_is('*customPackage*')) : ?>
                                    <tr>
                                        <td class="fw-bold">Total People</td>
                                        <td><?= esc($total_people); ?> people</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td>Rp <?= number_format(esc($package['price']), 0, ',', '.'); ?></td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td class="fw-bold">Minimum Capacity</td>
                                        <td><?= esc($package['min_capacity']); ?> people</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Price</td>
                                        <td>Rp <?= number_format(esc($package['price']), 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Total People</td>
                                        <td><?= esc($res_total_people); ?> people</td>
                                    </tr>
                                    <?php
                                    if ($package['min_capacity'] == 0) {
                                        $packageOrder = 1;
                                    } else {
                                        $packageOrder = $res_total_people / $package['min_capacity'];
                                        if ($packageOrder < 1) {
                                            $packageOrder = 1;
                                        } elseif (($res_total_people % $package['min_capacity'] <= $package['min_capacity'] / 2) && ($res_total_people % $package['min_capacity'] > 0)) {
                                            $packageOrder = floor($packageOrder) + 0.5;
                                        } elseif ($res_total_people % $package['min_capacity'] > $package['min_capacity'] / 2) {
                                            $packageOrder = floor($packageOrder) + 1;
                                        }
                                    }
                                    $package_total_price = $packageOrder * $package['price'];
                                    ?>
                                    <tr>
                                        <td class="fw-bold">Package Order</td>
                                        <td><?= esc($packageOrder); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Total Price</td>
                                        <td>Rp <?= number_format(esc($package_total_price), 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Package Activity</h4>
                </div>
                <div class="card-body">
                    <div class="col">
                        <?php $check_in1 = $check_in; ?>
                        <?php $check_in2 = $check_in; ?>
                        <?php if (count($list_day) < $day_of_stay) : ?>
                            <a class="btn icon btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addDay"><i class="fa-solid fa-add"></i> Day</a>
                        <?php endif; ?>
                        <?php if (!empty($list_day)) : ?>
                            <?php foreach ($list_day as $day) : ?>
                                <div class="table-responsive">
                                    <span class="fw-bold">Day <?= esc($day['day']); ?> (<?= esc(date_format(date_create($check_in1), "d F Y")); ?>)</span>
                                    <?php if ($day['is_base_for_extend'] == "0") : ?>
                                        <a class="btn icon btn-danger btn-sm mb-3 float-end" onclick="deleteCustomPackageDay('<?= esc($package['homestay_id']); ?>','<?= esc($package['id']); ?>','<?= esc($day['day']); ?>')"><i class="fa-solid fa-trash"></i></a>
                                    <?php endif; ?>
                                    <p><?= esc($day['description']); ?></p>
                                    <table class="table table-hover dt-head-center text-dark" id="table-manage" style="font-size: small;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Activity Type</th>
                                                <th>Object</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($list_activity)) : ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($list_activity as $activity) : ?>
                                                    <?php if ($activity['day'] == $day['day']) : ?>
                                                        <tr>
                                                            <td><?= esc($no); ?></td>
                                                            <td><?= esc($activity['type']); ?></td>
                                                            <td>
                                                                <?= esc($activity['object_name']); ?>
                                                                <?php if (isset($activity['price_for_package'])) : ?>
                                                                    <br>
                                                                    <?php if ($activity['price_for_package'] == '0') : ?>
                                                                        (Free)
                                                                    <?php else : ?>
                                                                        (Rp <?= number_format(esc($activity['price_for_package']), 0, ',', '.'); ?>/person)
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= esc($activity['description']); ?></td>
                                                            <td>
                                                                <?php if ($activity['is_base_for_extend'] == "0") : ?>
                                                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deletePackageDetailC('<?= esc($package['homestay_id']); ?>','<?= esc($activity['package_id']); ?>','<?= esc($activity['day']); ?>','<?= esc($activity['activity']); ?>')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                        <?php $no++; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <center>
                                    <a class="btn icon btn-info btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addActivityDay<?= esc($day['day']); ?>"><i class="fa-solid fa-add"></i> Activity</a>
                                </center>
                                <hr class="hr" />
                                <?php $check_in1 = date("Y-m-d", strtotime($check_in1 . ' + 1 days')); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Package Service</h4>
                </div>
                <div class="card-body">
                    <div class="col">
                        <a class="btn icon btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addPackageService"><i class="fa-solid fa-add"></i> Service</a>
                        <?php if (!empty($list_service)) : ?>
                            <div class="table-responsive">
                                <table class="table table-hover dt-head-center text-dark" id="table-manage" style="font-size: small;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($list_service as $service) : ?>
                                            <?php if ($service['status'] == '1') : ?>
                                                <tr class="text-center">
                                                    <td><?= esc($i); ?></td>
                                                    <td><?= esc($service['name']); ?></td>
                                                    <td>
                                                        <?php if ($service['category'] == '1') : ?>
                                                            Rp <?= number_format(esc($service['price']), 0, ',', '.'); ?>/person
                                                        <?php else : ?>
                                                            Rp <?= number_format(esc($service['price']), 0, ',', '.'); ?>/group
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($service['is_base_for_extend'] == "0") : ?>
                                                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deletePackageServiceC('<?= esc($package['homestay_id']); ?>','<?= esc($service['package_id']); ?>','<?= esc($service['package_service_id']); ?>')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <br>
                            <center>
                                <p><i>No Service Added</i></p>
                            </center>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <a title="Done" class="btn icon btn-success btn-sm float-end me-1" href="/web/reservation/detail/<?= esc($reservation_id); ?>">
                <i class="fa-solid fa-check"></i> Done
            </a>
        </div>
    </div>

    <!-- Modal Add Day -->
    <div class="modal fade" id="addDay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Day <?= esc(count($list_day) + 1); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" action="<?= base_url(); ?>/web/packageDay" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="reservation_id" value="<?= esc($reservation_id); ?>">
                                <input type="hidden" name="homestay_id" value="<?= esc($package['homestay_id']); ?>">
                                <input type="hidden" name="package_id" value="<?= esc($package['id']); ?>">
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
    <!-- Modal Add Activity -->
    <?php if (!empty($list_day)) : ?>
        <?php foreach ($list_day as $day) : ?>
            <div class="modal fade" id="addActivityDay<?= esc($day['day']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Activity Day <?= esc($day['day']); ?></h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <form class="form form-vertical" action="<?= base_url(); ?>/web/packageDetail" method="post" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <input type="hidden" name="reservation_id" value="<?= esc($reservation_id); ?>">
                                        <input type="hidden" name="homestay_id" value="<?= esc($package['homestay_id']); ?>">
                                        <input type="hidden" name="package_id" value="<?= esc($package['id']); ?>">
                                        <input type="hidden" name="day" value="<?= esc($day['day']); ?>">
                                        <input type="hidden" name="total_people" value="<?= esc($total_people); ?>">
                                        <fieldset class="form-group mb-4">
                                            <script>
                                                getListObjectC('<?= esc($package['homestay_id']); ?>', '<?= esc($package['id']); ?>', '<?= esc($day['day']); ?>', '<?= esc(date_format(date_create($check_in2), "Y-m-d")); ?>');
                                            </script>
                                            <label for="activitySelect<?= esc($day['day']); ?>" class="mb-2">Object</label>
                                            <select class="form-select" id="activitySelect<?= esc($day['day']); ?>" name="id_object" required>
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
            <?php $check_in2 = date("Y-m-d", strtotime($check_in2 . ' + 1 days')); ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Modal Add Service -->
    <div class="modal fade" id="addPackageService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Package Service</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" action="<?= base_url(); ?>/web/packageService" method="post" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="reservation_id" value="<?= esc($reservation_id); ?>">
                                <input type="hidden" name="homestay_id" value="<?= esc($package['homestay_id']); ?>">
                                <input type="hidden" name="package_id" value="<?= esc($package['id']); ?>">
                                <input type="hidden" name="total_people" value="<?= esc($total_people); ?>">
                                <fieldset class="form-group mb-4">
                                    <script>
                                        getListPackageServiceC('<?= esc($package['homestay_id']); ?>', '<?= esc($package['id']); ?>');
                                    </script>
                                    <label for="serviceSelect" class="mb-2">Service</label>
                                    <select class="form-select" id="serviceSelect" name="package_service_id" required>
                                    </select>
                                </fieldset>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                                    <label class="form-check-label" for="status1">
                                        Included
                                    </label>
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

    <?php if ($edit && count($package['gallery']) > 0) : ?>
        pond.addFiles(
            <?php foreach ($package['gallery'] as $gallery) : ?> `<?= base_url('media/photos/' . $gallery); ?>`,
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
    vidPond.setOptions({
        server: {
            timeout: 86400000,
            process: {
                url: '/upload/video',
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
                url: '/upload/video',
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