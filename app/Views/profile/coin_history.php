<?php
// dd($data);
$uri = service('uri')->getSegments();
$users = in_array('users', $uri);
?>

<?= $this->extend('profile/index'); ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

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
                    <h3 class="card-title">Coin History</h3>
                    <span class="fw-bold">Your Coin : <?= (user()->total_coin !== null) ? number_format(user()->total_coin) : number_format(0); ?></span>
                </div>
                <div class="col">

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dt-head-center text-dark" id="table-manage">
                    <thead class="text-center">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Homestay Name</th>
                            <th>Coin Use</th>
                            <th>Bonus Coin</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($data)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td><?= esc($item['id']); ?></td>
                                    <td><?= esc($item['homestay_name']); ?></td>
                                    <?php if ($item['coin_use'] == null || $item['coin_use'] == 0) : ?>
                                    <td>0</td>
                                    <?php elseif ($item['coin_use'] > 0) : ?>
                                    <td>-<?= esc($item['coin_use']); ?></td>
                                    <?php endif; ?>
                                    <?php if ($item['bonus_coin'] == null || $item['bonus_coin'] == 0) : ?>
                                    <td>0</td>
                                    <?php elseif ($item['bonus_coin'] > 0) : ?>
                                    <td>+<?= esc($item['bonus_coin']); ?></td>
                                    <?php endif; ?>                                
                                </tr>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

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
<?= $this->endSection() ?>