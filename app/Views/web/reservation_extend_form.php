<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section text-dark">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Extend Reservation</h4>
                        </div>
                        <div class="col">
                            <button form="extend-form" type="submit" class="float-end btn btn-primary">Extend and Recalculate</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>
                    <form id="extend-form" class="form form-vertical" action="<?= base_url('web/reservation/extend/' . $reservation['id']); ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <h5>Current Reservation Details</h5>
                                    <div class="form-group mb-3">
                                        <label for="check_in" class="mb-2">Check In</label>
                                        <input type="text" id="check_in" class="form-control" value="<?= esc(date('l, d F Y', strtotime($reservation['check_in']))); ?>" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="check_out" class="mb-2">Current Check Out</label>
                                        <input type="text" id="check_out" class="form-control" value="<?= esc(date('l, d F Y', strtotime($check_out))); ?>" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="day_of_stay" class="mb-2">Current Day of Stay</label>
                                        <div class="input-group">
                                            <input type="number" id="day_of_stay" class="form-control" value="<?= esc($day_of_stay); ?>" disabled>
                                            <span class="input-group-text">Days</span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="total_people" class="mb-2">Total People</label>
                                        <div class="input-group">
                                            <input type="number" id="total_people" class="form-control" value="<?= esc($reservation['total_people']); ?>" disabled>
                                            <span class="input-group-text">People</span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="unit_numbers" class="mb-2">Units</label>
                                        <input type="text" id="unit_numbers" class="form-control" value="<?= implode(', ', $unit_numbers); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12" style="border-left: 1px dashed #333;">
                                    <h5>Extend Reservation</h5>
                                    <div class="form-group mb-3">
                                        <label for="extend_day" class="form-label">Extend Day</label>
                                        <input type="number" class="form-control" id="extend_day" name="extend_day" min="1" required>
                                        <div class="form-text">Number of Days Added</div>
                                    </div>
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Attention!</h4>
                                        <p>By extending the reservation, the total price will be recalculated. If you have already made a payment, the payment status will be reset, and you will need to make a new payment for the new total amount.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>