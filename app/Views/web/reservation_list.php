<?php
$uri = service('uri')->getSegments();
$users = in_array('users', $uri);
?>

<?= $this->extend('web/layouts/main'); ?>

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
                    <h3 class="card-title">Reservation List</h3>
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
                            <th>Request Date</th>
                            <th>Check In</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php if (isset($data)) : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $item) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td><?= esc($item['id']); ?></td>
                                    <td><?= esc(date_format(date_create($item['request_date']), "d F Y, H:i")); ?></td>
                                    <td><?= esc(date_format(date_create($item['check_in']), "d F Y, H:i")); ?></td>
                                    <td>
                                        <?php if (($item['status'] == null) && ($item['canceled_at'] == null)) : ?>
                                            <button title="Reservation Incomplete" class="btn-sm btn-dark float-center" disabled>Incomplete</button>
                                        <?php elseif (($item['status'] == '0') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Waiting for the homestay owner to accept the reservation" class="btn-sm btn-warning float-center" disabled>Waiting</button>
                                        <?php elseif (($item['status'] == '1') && ($item['canceled_at'] == null) && ($item['is_rejected'] == '1')) : ?>
                                            <button title="Reservation Rejected" class="btn-sm btn-danger float-center" disabled>Rejected</button>
                                        <?php elseif (($item['status'] == '1') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Paying Deposit" class="btn-sm btn-info float-center" disabled>Pay Deposit</button>
                                        <?php elseif (($item['status'] == 'Deposit Pending') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Deposit Pending" class="btn-sm btn-warning float-center" disabled>Deposit Pending</button>
                                        <?php elseif (($item['status'] == 'Deposit Successful') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Deposit Successful" class="btn-sm btn-success float-center" disabled>Deposit Successful</button>
                                        <?php elseif (($item['status'] == 'Deposit Expired') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Deposit Expired" class="btn-sm btn-danger float-center" disabled>Deposit Expired</button>
                                        <?php elseif (($item['status'] == 'Full Pay Pending') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Full Pay Pending" class="btn-sm btn-warning float-center" disabled>Full Pay Pending</button>
                                        <?php elseif (($item['status'] == 'Full Pay Successful') && ($item['canceled_at'] == null)) : ?>
                                            <button title="Full Pay Successful" class="btn-sm btn-success float-center" disabled>Full Pay Successful</button>
                                        <?php elseif (($item['canceled_at'] != null) && ($item['is_refund'] == '1') && ($item['refund_proof'] == null)) : ?>
                                            <button title="Waiting for the homestay owner to pay refund" class="btn-sm btn-danger float-center" disabled>Refund</button>
                                        <?php elseif (($item['canceled_at'] != null) && ($item['is_refund'] == '1') && ($item['refund_proof'] != null) && ($item['refund_paid_confirmed_at'] == null)) : ?>
                                            <button title="Waiting for the customer to confirm refund" class="btn-sm btn-danger float-center" disabled>Confirm Refund</button>
                                        <?php elseif (($item['canceled_at'] != null) && ($item['is_refund'] == '1') && ($item['refund_proof'] != null) && ($item['refund_paid_confirmed_at'] != null)) : ?>
                                            <button title="Reservation Canceled" class="btn-sm btn-danger float-center" disabled>Canceled</button>
                                        <?php elseif (($item['canceled_at'] != null) && ($item['is_refund'] == '0')) : ?>
                                            <button title="Reservation Canceled" class="btn-sm btn-danger float-center" disabled>Canceled</button>
                                        <?php elseif ($item['status'] == 'Done') : ?>
                                            <button title="Reservation Done" class="btn-sm btn-primary float-center" disabled>Done</button>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a title="More Info" class="btn icon btn-outline-info btn-sm" href="reservation/detail/<?= esc($item['id']); ?>">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <?php if ((($item['status'] == null) && ($item['canceled_at'] == null)) || (($item['status'] == '1') && ($item['canceled_at'] == null) && ($item['is_rejected'] == '1'))) : ?>
                                            <a title="Delete Reservation" class="btn icon btn-outline-danger btn-sm" href="#" onclick="deleteObject('<?= $item['id']?>', '<?= $item['id']?>', true)">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
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