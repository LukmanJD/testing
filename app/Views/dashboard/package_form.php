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
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center"><?= $title; ?></h4>
                </div>
                <div class="card-body">
                    <form class="form form-vertical" action="<?= ($edit) ? base_url('dashboard/tourismPackage/update') . '/' . $data['id'] : base_url('dashboard/tourismPackage'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="form-group mb-4">
                                <label for="name" class="mb-2">Package Name</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Package Name" value="<?= ($edit) ? $data['name'] : old('name'); ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label for="address" class="mb-2">Minimum Capacity</label>
                                        <div class="input-group">
                                            <input type="number" id="address" class="form-control" name="min_capacity" placeholder="Minimum Capacity" value="<?= ($edit) ? $data['min_capacity'] : old('min_capacity'); ?>">
                                            <span class="input-group-text">People</span>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($edit) : ?>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-4">
                                            <label for="employee_name" class="mb-2">Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" maxlength="25" id="employee_name" class="form-control" name="price" placeholder="Price" value="<?= ($edit) ? $data['price'] : old('price'); ?>" max="<?= ($edit) ? $data['price'] : old('price'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="4"><?= ($edit) ? $data['description'] : old('description'); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-4">
                                        <label for="gallery" class="form-label">Brochure</label>
                                        <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery" required multiple>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($edit) : ?>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-center">Package Activity</h4>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <a class="btn icon btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addDay"><i class="fa-solid fa-add"></i> Day</a>
                            <?php if (!empty($list_day)) : ?>
                                <?php foreach ($list_day as $day) : ?>
                                    <div class="table-responsive">
                                        <span class="fw-bold">Day <?= esc($day['day']); ?></span>
                                        <a class="btn icon btn-danger btn-sm mb-3 float-end" onclick="deletePackageDay('<?= esc($data['homestay_id']); ?>','<?= esc($data['id']); ?>','<?= esc($day['day']); ?>')"><i class="fa-solid fa-trash"></i></a>
                                        <p><?= esc($day['description']); ?></p>
                                        <table class="table table-hover dt-head-center" id="table-manage" style="font-size: small;">
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
                                                                <td><a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deletePackageDetail('<?= esc($data['homestay_id']); ?>','<?= esc($activity['package_id']); ?>','<?= esc($activity['day']); ?>','<?= esc($activity['activity']); ?>')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a></td>
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
                            <div class="table-responsive">
                                <span class="fw-bold">Included</span>
                                <table class="table table-hover dt-head-center" id="table-manage" style="font-size: small;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($list_service)) : ?>
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
                                                        <td><a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deletePackageService('<?= esc($data['homestay_id']); ?>','<?= esc($service['package_id']); ?>','<?= esc($service['package_service_id']); ?>')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a></td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="hr" />
                            <div class="table-responsive">
                                <span class="fw-bold">Excluded</span>
                                <table class="table table-hover dt-head-center" id="table-manage" style="font-size: small;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($list_service)) : ?>
                                            <?php $n = 1; ?>
                                            <?php foreach ($list_service as $service) : ?>
                                                <?php if ($service['status'] == '0') : ?>
                                                    <tr class="text-center">
                                                        <td><?= esc($n); ?></td>
                                                        <td><?= esc($service['name']); ?></td>
                                                        <td><a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deletePackageService('<?= esc($data['homestay_id']); ?>','<?= esc($service['package_id']); ?>','<?= esc($service['package_service_id']); ?>')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a></td>
                                                    </tr>
                                                    <?php $n++; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <a class="btn icon btn-success btn-sm mb-3 float-end" href="/dashboard/tourismPackage/<?= esc($data['id']); ?>"><i class="fa-solid fa-check"></i> Done</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($edit) : ?>
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
                            <form class="form form-vertical" action="<?= base_url(); ?>/dashboard/packageDay" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" name="homestay_id" value="<?= esc($data['homestay_id']); ?>">
                                    <input type="hidden" name="package_id" value="<?= esc($data['id']); ?>">
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
    <?php endif; ?>
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
                                <form class="form form-vertical" action="<?= base_url(); ?>/dashboard/packageDetail" method="post" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <input type="hidden" name="homestay_id" value="<?= esc($data['homestay_id']); ?>">
                                        <input type="hidden" name="package_id" value="<?= esc($data['id']); ?>">
                                        <input type="hidden" name="day" value="<?= esc($day['day']); ?>">
                                        <input type="hidden" name="total_people" value="<?= esc($data['min_capacity']); ?>">
                                        <fieldset class="form-group mb-4">
                                            <script>
                                                getListObject('<?= esc($data['homestay_id']); ?>', '<?= esc($data['id']); ?>', '<?= esc($day['day']); ?>');
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
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Modal Add Service -->
    <?php if ($edit) : ?>
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
                            <form class="form form-vertical" action="<?= base_url(); ?>/dashboard/packageService" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <input type="hidden" name="homestay_id" value="<?= esc($data['homestay_id']); ?>">
                                    <input type="hidden" name="package_id" value="<?= esc($data['id']); ?>">
                                    <input type="hidden" name="total_people" value="<?= esc($total_people); ?>">
                                    <fieldset class="form-group mb-4">
                                        <script>
                                            getListPackageService('<?= esc($data['homestay_id']); ?>', '<?= esc($data['id']); ?>');
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status2" value="00">
                                        <label class="form-check-label" for="status2">
                                            Excluded
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
    <?php endif; ?>
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