<?php
$uri = service('uri')->getSegments();
$users = in_array('users', $uri);
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
    <div class="card">
        <div class="card-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title">Manage <?= $category; ?></h3>
                </div>
                <div class="col">
                    <?php if ($category != 'Users') : ?>
                        <?php if (($category == 'Souvenir Product') || ($category == 'Culinary Product') || ($category == 'Attraction Facility') || ($category == 'Homestay Facility') || ($category == 'Homestay Unit Facility') || ($category == 'Souvenir Place Facility') || ($category == 'Culinary Place Facility') || ($category == 'Worship Place Facility')) : ?>
                            <a class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#insertNewProduct"><i class="fa-solid fa-add me-3"></i> New <?= $category; ?></a>
                        <?php elseif ($category == 'Homestay Exclusive Activity') : ?>
                            <a class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#insertNewActivity"><i class="fa-solid fa-add me-3"></i> New <?= $category; ?></a>
                        <?php elseif ($category == 'Homestay Additional Amenities') : ?>
                            <a class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#insertNewAdditionalAmenities"><i class="fa-solid fa-add me-3"></i> New <?= $category; ?></a>
                        <?php else : ?>
                            <a href="<?= current_url(); ?>/new" class="btn btn-primary float-end"><i class="fa-solid fa-plus me-3"></i> New <?= $category; ?></a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dt-head-center text-dark" id="table-manage">
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php if ($category != 'Homestay Unit') : ?>
                                <th>ID</th>
                            <?php endif; ?>
                            <th>Name</th>
                            <?php if (count($data) > 0 && array_key_exists('role', $data[0])) : ?>
                                <th>Role</th>
                            <?php endif; ?>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($data)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <?php if ($category != 'Homestay Unit') : ?>
                                        <?php if (isset($item['username'])) : ?>
                                            <td>@<?= esc($item['username']); ?></td>
                                        <?php else : ?>
                                            <td><?= esc($item['id']); ?></td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php
                                    $name = '';
                                    if (isset($item['name'])) {
                                        $name = esc($item['name']);
                                    } elseif (isset($item['facility'])) {
                                        $name = esc($item['facility']);
                                    } else {
                                        $name = esc($item['first_name']) . ' ' . esc($item['last_name']);
                                    }

                                    ?>
                                    <td class="fw-bold"><?= $name; ?></td>
                                    <?php if (isset($item['role'])) : ?>
                                        <td><?= ucfirst(esc($item['role'])); ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if (($category == 'Souvenir Product') || ($category == 'Culinary Product') || ($category == 'Attraction Facility') || ($category == 'Homestay Facility') || ($category == 'Homestay Unit Facility') || ($category == 'Souvenir Place Facility') || ($category == 'Culinary Place Facility') || ($category == 'Worship Place Facility')) : ?>
                                            <a title="Edit" class="btn icon btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProduct<?= esc($item['id']); ?>">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        <?php elseif ($category == 'Homestay Exclusive Activity') : ?>
                                            <a title="More Info" class="btn icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#infoActivity<?= esc($item['id']); ?>">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <a title="Edit" class="btn icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editActivity<?= esc($item['id']); ?>">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        <?php elseif ($category == 'Homestay Additional Amenities') : ?>
                                            <a title="More Info" class="btn icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#infoAmenities<?= esc($item['id']); ?>">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <a title="Edit" class="btn icon btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editAmenities<?= esc($item['id']); ?>">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                        <?php else : ?>
                                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-outline-primary mx-1" href="<?= (isset($item['facility'])) ? base_url('dashboard/facility/edit') . '/' . esc($item['id']) : current_url() . '/' . esc($item['id']); ?>">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if (($category == 'Souvenir Product') || ($category == 'Culinary Product') || ($category == 'Attraction Facility') || ($category == 'Homestay Facility') || ($category == 'Homestay Unit') || ($category == 'Homestay Unit Facility') || ($category == 'Homestay Exclusive Activity') || ($category == 'Package') || ($category == 'Homestay Additional Amenities') || ($category == 'Souvenir Place Facility') || ($category == 'Culinary Place Facility') || ($category == 'Worship Place Facility') || ($category == 'Announcement')) : ?>
                                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm" onclick="deleteObject('<?= ($category == 'Souvenir Product') ? 'Z' . $item['id'] : ''; ?><?= ($category == 'Culinary Product') ? 'X' . $item['id'] : ''; ?><?= ($category == 'Attraction Facility') ? 'T' . $item['id'] : ''; ?><?= ($category == 'Homestay Facility') ? 'B' . $item['id'] : ''; ?><?= ($category == 'Souvenir Place Facility') ? 'K' . $item['id'] : ''; ?><?= ($category == 'Culinary Place Facility') ? 'M' . $item['id'] : ''; ?><?= ($category == 'Worship Place Facility') ? 'N' . $item['id'] : ''; ?><?= ($category == 'Homestay Unit') ? 'I' . $item['id'] : ''; ?><?= ($category == 'Announcement') ? 'L' . $item['id'] : ''; ?><?= ($category == 'Homestay Unit Facility') ? 'D' . $item['id'] : ''; ?><?= ($category == 'Homestay Additional Amenities') ? 'G' . $item['id'] . $item['homestay_id'] : ''; ?><?= ($category == 'Package') ? $item['id'] . $item['homestay_id'] : ''; ?>', '<?= esc($item['name']); ?>', 'false')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php else : ?>
                                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger" onclick="deleteObject('<?= esc($item['id']); ?>', '<?= esc($name); ?>', <?= ($users) ? 'true' : 'false'; ?>)">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <?php $i++ ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Add New Product -->
    <div class="modal fade" id="insertNewProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New <?= esc($category); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <?php if ($category == 'Souvenir Product') : ?>
                            <form class="form form-vertical" action="product" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                            <?php endif; ?>
                            <?php if ($category == 'Culinary Product') : ?>
                                <form class="form form-vertical" action="product" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                <?php endif; ?>
                                <?php if ($category == 'Attraction Facility') : ?>
                                    <form class="form form-vertical" action="facility" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                    <?php endif; ?>
                                    <?php if ($category == 'Homestay Facility') : ?>
                                        <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                        <?php endif; ?>
                                        <?php if ($category == 'Souvenir Place Facility') : ?>
                                            <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                            <?php endif; ?>
                                            <?php if ($category == 'Culinary Place Facility') : ?>
                                                <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                <?php endif; ?>
                                                <?php if ($category == 'Worship Place Facility') : ?>
                                                    <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                    <?php endif; ?>
                                                    <?php if ($category == 'Homestay Unit Facility') : ?>
                                                        <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                        <?php endif; ?>
                                                        <div class="form-body">
                                                            <div class="form-group">
                                                                <label for="name" class="mb-2"><?= esc($category); ?> Name</label>
                                                                <input type="text" id="name" class="form-control" name="name" placeholder="<?= esc($category); ?> Name" required>
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
    <?php if (!empty($data)) : ?>
        <?php foreach ($data as $product) : ?>
            <?php if (!empty($product['name'])) : ?>
                <div class="modal fade" id="editProduct<?= esc($product['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit <?= esc($category); ?></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <?php if ($category == 'Souvenir Product') : ?>
                                        <form class="form form-vertical" action="product/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                        <?php endif; ?>
                                        <?php if ($category == 'Culinary Product') : ?>
                                            <form class="form form-vertical" action="product/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                            <?php endif; ?>
                                            <?php if ($category == 'Attraction Facility') : ?>
                                                <form class="form form-vertical" action="facility/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                <?php endif; ?>
                                                <?php if ($category == 'Homestay Facility') : ?>
                                                    <form class="form form-vertical" action="/dashboard/facilityHomestay/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                    <?php endif; ?>
                                                    <?php if ($category == 'Souvenir Place Facility') : ?>
                                                        <form class="form form-vertical" action="/dashboard/facilitySouvenirPlace/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                        <?php endif; ?>
                                                        <?php if ($category == 'Culinary Place Facility') : ?>
                                                            <form class="form form-vertical" action="/dashboard/facilityCulinaryPlace/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                            <?php endif; ?>
                                                            <?php if ($category == 'Worship Place Facility') : ?>
                                                                <form class="form form-vertical" action="/dashboard/facilityWorshipPlace/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                                <?php endif; ?>
                                                                <?php if ($category == 'Homestay Unit Facility') : ?>
                                                                    <form class="form form-vertical" action="/dashboard/facilityUnit/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                                    <?php endif; ?>
                                                                    <form class="form form-vertical" action="<?= ($category == 'Attraction Facility') ? 'facility' : 'product'; ?>/edit/<?= esc($product['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                                                        <div class="form-body">
                                                                            <div class="form-group">
                                                                                <label for="name" class="mb-2"><?= esc($category); ?> Name</label>
                                                                                <input type="text" id="name" class="form-control" name="name" placeholder="<?= esc($category); ?> Name" value="<?= esc($product['name']); ?>" required>
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
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Modal Add New Additional Amenities -->
    <div class="modal fade" id="insertNewAdditionalAmenities" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New <?= esc($category); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="mb-2">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="<?= esc($category); ?> Name" required>
                                </div>
                                <fieldset class="form-group mb-4">
                                    <label for="catSelect" class="mb-2">Category</label>
                                    <select class="form-select" id="catSelect" name="category" required>
                                        <option value="1">Facility</option>
                                        <option value="2">Service</option>
                                    </select>
                                </fieldset>
                                <div class="form-group mb-4">
                                    <label for="name" class="mb-2">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" id="name" class="form-control" name="price" placeholder="Price" required>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_order_count_per_day">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Order Count by Day
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_order_count_per_person">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Order Count per Person
                                    </label>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_order_count_per_room">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Order Count by Room
                                    </label>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="name" class="mb-2">Stock</label>
                                    <input type="number" id="name" class="form-control" name="stock" placeholder="Stock" min="0" required>
                                    <span class="text-secondary"><i>*make it '0' if it is not based on stock</i></span>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
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
    <!-- Modal Info Additional Amenities -->
    <?php if ($category == 'Homestay Additional Amenities') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                <div class="modal fade bd-example-modal-lg" id="infoAmenities<?= esc($activity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Info Activity</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card mb-3" style="max-width: 1000px;">
                                    <div class="row g-0">
                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                            <img width="1000px" src="<?= base_url('media/photos'); ?>/<?= esc($activity['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= esc($activity['name']); ?></h5>
                                                <p class="card-text"><?= esc($activity['description']); ?></p>
                                                <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($activity['price'], 0, ',', '.')) ?><?= ($activity['is_order_count_per_day'] == '1') ? '/day' : '' ?><?= ($activity['is_order_count_per_person'] == '1') ? '/person' : '' ?><?= ($activity['is_order_count_per_room'] == '1') ? '/room' : '' ?></small></p>
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
    <?php endif; ?>
    <!-- Modal Edit Amenities -->
    <?php if ($category == 'Homestay Additional Amenities') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                <div class="modal fade" id="editAmenities<?= esc($activity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit <?= esc($category); ?></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form class="form form-vertical" action="<?= current_url(); ?>/update/<?= esc($activity['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="name" class="mb-2">Name</label>
                                                <input type="text" id="name" class="form-control" name="name" placeholder="<?= esc($category); ?> Name" value="<?= esc($activity['name']) ?>" required>
                                            </div>
                                            <fieldset class="form-group mb-4">
                                                <label for="catSelect" class="mb-2">Category</label>
                                                <select class="form-select" id="catSelect" name="category" required>
                                                    <option value="1" <?= ($activity['category'] == '1' ? 'selected' : '') ?>>Facility</option>
                                                    <option value="2" <?= ($activity['category'] == '2' ? 'selected' : '') ?>>Service</option>
                                                </select>
                                            </fieldset>
                                            <div class="form-group mb-4">
                                                <label for="name" class="mb-2">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="number" id="name" class="form-control" name="price" placeholder="Price" value="<?= esc($activity['price']) ?>" min="0" required>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_order_count_per_day" <?= ($activity['is_order_count_per_day'] == '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Order Count by Day
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_order_count_per_person" <?= ($activity['is_order_count_per_person'] == '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Order Count per Person
                                                </label>
                                            </div>
                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_order_count_per_room" <?= ($activity['is_order_count_per_room'] == '1' ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Order Count by Room
                                                </label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="name" class="mb-2">Stock</label>
                                                <input type="number" id="name" class="form-control" name="stock" min="0" value="<?= esc($activity['stock']) ?>" required>
                                                <span class="text-secondary"><i>*make it '0' if it is not based on stock</i></span>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="4" required><?= esc($activity['description']) ?></textarea>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="gallery" class="form-label">Image</label>
                                                <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery<?= esc($activity['id']); ?>" required>
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
    <?php endif; ?>
    <!-- Modal Add New Activity -->
    <div class="modal fade" id="insertNewActivity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New <?= esc($category); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" action="" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="mb-2">Activity Name</label>
                                    <input type="text" id="name" class="form-control" name="name" placeholder="<?= esc($category); ?> Name" required>
                                </div>
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_daily">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Daily
                                    </label>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="name" class="mb-2">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp.</span>
                                        <input type="number" id="name" class="form-control" name="price" placeholder="Price" required>
                                        <span class="input-group-text">/person</span>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
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
    <!-- Modal Info Activity -->
    <?php if ($category == 'Homestay Exclusive Activity') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                <div class="modal fade bd-example-modal-lg" id="infoActivity<?= esc($activity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Info Activity</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card mb-3" style="max-width: 1000px;">
                                    <div class="row g-0">
                                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                                            <img width="1000px" src="<?= base_url('media/photos'); ?>/<?= esc($activity['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= esc($activity['name']); ?></h5>
                                                <p class="card-text"><?= esc($activity['description']); ?></p>
                                                <p class="card-text"><small class="text-muted"><?= esc("Rp " . number_format($item['price'], 0, ',', '.')) ?></small></p>
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
    <?php endif; ?>
    <!-- Modal Edit Activity -->
    <?php if ($category == 'Homestay Exclusive Activity') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                <div class="modal fade" id="editActivity<?= esc($activity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit <?= esc($category); ?></h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form class="form form-vertical" action="<?= current_url(); ?>/update/<?= esc($activity['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <input type="hidden" name="homestay_id" value="<?= esc($activity['homestay_id']); ?>">
                                            <input type="hidden" name="id" value="<?= esc($activity['id']); ?>">
                                            <div class="form-group">
                                                <label for="name" class="mb-2">Activity Name</label>
                                                <input type="text" id="name" class="form-control" name="name" placeholder="<?= esc($category); ?> Name" value="<?= esc($activity['name']); ?>" required>
                                            </div>
                                            <div class="form-check mb-4">
                                                <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" name="is_daily" <?= ($activity['is_daily'] == "1") ? "checked" : "" ?>>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Daily
                                                </label>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="name" class="mb-2">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="number" id="name" class="form-control" name="price" placeholder="Price" value="<?= esc($activity['price']); ?>" required>
                                                    <span class="input-group-text">/person</span>
                                                </div>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="4" required><?= esc($activity['description']); ?></textarea>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="gallery" class="form-label">Image</label>
                                                <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery<?= esc($activity['id']); ?>" required>
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

    <?php if ($category == 'Homestay Exclusive Activity') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                const photo<?= esc($activity['id']); ?> = document.querySelector('input[id="gallery<?= esc($activity['id']); ?>"]');
                const pond<?= esc($activity['id']); ?> = FilePond.create(photo<?= esc($activity['id']); ?>, {
                    maxFileSize: '1920MB',
                    maxTotalFileSize: '1920MB',
                    imageResizeTargetHeight: 720,
                    imageResizeUpscale: false,
                    credits: false,
                });

                pond<?= esc($activity['id']); ?>.addFiles(`<?= base_url('media/photos/' . $activity['image_url']); ?>`);

                pond<?= esc($activity['id']); ?>.setOptions({
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
    <?php endif; ?>
    <?php if ($category == 'Homestay Additional Amenities') : ?>
        <?php if (!empty($data)) : ?>
            <?php foreach ($data as $activity) : ?>
                const photo<?= esc($activity['id']); ?> = document.querySelector('input[id="gallery<?= esc($activity['id']); ?>"]');
                const pond<?= esc($activity['id']); ?> = FilePond.create(photo<?= esc($activity['id']); ?>, {
                    maxFileSize: '1920MB',
                    maxTotalFileSize: '1920MB',
                    imageResizeTargetHeight: 720,
                    imageResizeUpscale: false,
                    credits: false,
                });

                pond<?= esc($activity['id']); ?>.addFiles(`<?= base_url('media/photos/' . $activity['image_url']); ?>`);

                pond<?= esc($activity['id']); ?>.setOptions({
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
    <?php endif; ?>
</script>
<?= $this->endSection() ?>