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

<section class="section text-dark">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header text-center">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Homestay Reservation</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">ID</td>
                                        <td><?= esc($reservation['id']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Request Date</td>
                                        <td><?= esc(date_format(date_create($reservation['request_date']), "d F Y, H:i")); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Check In</td>
                                        <td><?= esc(date_format(date_create($reservation['check_in']), "d F Y, H:i")); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Check Out</td>
                                        <td><?= esc(date_format(date_create($reservation['check_out']), "d F Y, H:i")); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Day of Stay</td>
                                        <td><?= esc($reservation['day_of_stay']); ?> Days</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Total People</td>
                                        <td><?= esc($reservation['total_people']); ?> people</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Contact Person</td>
                                        <td><?= esc($homestay['phone']); ?></td>
                                    </tr>
                                    <?php if ($reservation['rating'] != null) : ?>
                                        <tr>
                                            <td class="fw-bold">Rating</td>
                                            <td>
                                                <?php for ($i = 0; $i < (int)esc($reservation['rating']); $i++) { ?>
                                                    <i class="fa-solid fa-star fs-4 star-checked"></i>
                                                <?php } ?>
                                                <?php for ($i = 0; $i < (5 - (int)esc($reservation['rating'])); $i++) { ?>
                                                    <i class="fa-solid fa-star fs-4"></i>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Review</td>
                                            <td><?= esc($reservation['review']); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        Homestay Units
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <span class="fw-bold"><?= esc($homestay['name']) ?></span><br>
                                        <span>Type : <?= esc($homestay['unit_type']) ?></span>
                                        <?php $homestay_unit_total_price = 0; ?>
                                        <?php foreach ($homestay_unit as $item) : ?>
                                            <div class="card border mb-3">
                                                <div class="row g-0">
                                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                                        <img width="500px" src="/media/photos/<?= esc($item['galleries'][0]) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 150px;">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <h5 class="card-title"><?= esc($item['name']) ?><a class="text-info float-end" target="_blank" href="/web/homestayUnit/<?= esc($item['homestay_id']) ?>/detail/<?= esc($item['unit_type']) ?><?= esc($item['unit_number']) ?>"><i class="fa-solid fa-circle-info"></i></a></h5>
                                                            </div>
                                                            <p class="card-text text-truncate"><?= esc($item['description']) ?></p>
                                                            <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($item['price'], 0, ',', '.')); ?>/day</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $homestay_unit_total_price = $homestay_unit_total_price + ($item['price'] * $reservation['day_of_stay']); ?>
                                        <?php endforeach; ?>
                                        <?php if ($reservation['reservation_type'] == "1") : ?>
                                            <span>Homestay unit total price = <?= esc("Rp " . number_format($homestay_unit_total_price, 0, ',', '.')) ?></span>
                                        <?php else: ?>
                                            <span>Homestay unit total price = <?= esc("Rp " . number_format($homestay_unit_total_price * 90 / 100, 0, ',', '.')) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                                        Additional Amenities
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour">
                                    <div class="accordion-body">
                                        <div class="mb-3">
                                            <span class="fw-bold"><?= esc($homestay['name']) ?></span>
                                        </div>
                                        <?php $homestay_activity_total_price = 0; ?>
                                        <?php if (!empty($reservation_additional_amenities)) : ?>
                                            <?php foreach ($reservation_additional_amenities as $activity) : ?>

                                                <li><?= esc($activity['name']) ?>
                                                    <a class="text-info float-end" target="_blank"><i class="fa-solid fa-circle-info" data-bs-toggle="modal" data-bs-target="#infoActivity<?= esc($activity['id']); ?>"></i></a><br>
                                                    <p class="ms-4">
                                                        <?= esc("Rp " . number_format($activity['price'], 0, ',', '.')); ?><?= ($activity['is_order_count_per_day'] == '1') ? '/day' : '' ?><?= ($activity['is_order_count_per_person'] == '1') ? '/person' : '' ?><?= ($activity['is_order_count_per_room'] == '1') ? '/room' : '' ?>
                                                        <br>
                                                        <?= ($activity['day_order'] != '0') ? 'Day Order : ' . $activity['day_order'] . ', ' : '' ?><?= ($activity['person_order'] != '0') ? 'Person Order : ' . $activity['person_order'] . ', ' : '' ?><?= ($activity['room_order'] != '0') ? 'Room Order : ' . $activity['room_order'] . ', ' : '' ?><?= (($activity['day_order'] == '0') && ($activity['person_order'] == '0') && ($activity['room_order'] == '0')) ? 'Total Order : ' . $activity['total_order']  : '' ?>
                                                        <br>
                                                        <?= esc("Price : Rp " . number_format($activity['total_price'], 0, ',', '.')); ?>
                                                    </p>
                                                </li>


                                            <?php
                                                $homestay_activity_total_price = $homestay_activity_total_price + $activity['total_price'];
                                            endforeach;
                                            ?>
                                            <span>Homestay additional amenities total price = <?= esc("Rp " . number_format($homestay_activity_total_price, 0, ',', '.')) ?></span>
                                        <?php else : ?>
                                            <span>No additional amenities added</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $total_price = $homestay_unit_total_price + $homestay_activity_total_price;
        $deposit = $total_price * 20 / 100;
        $fullPay = $total_price * 80 / 100;
        if($reservation['customer_id'] == null){
            $coin['total_coin'] = 0;
            $total_price_after_coin = 0;
        } else{
            $total_price_after_coin = $total_price - $coin['total_coin'];
        }
        $coin = $coin['total_coin'];

        if ($reservation['reservation_type'] == '1') {
            if (($coin > 0.15 * $total_price)) {
                $coin = 0.15 * $total_price;
            }
        } else {
            if (($coin > 0.15 * $homestay_unit_total_price * 0.9)) {
                $coin = 0.15 * $homestay_unit_total_price * 0.9;
            }
        }
        
        if ($reservation['is_refund'] == '1') {
            $refund = $deposit * 50 / 100;
        } elseif ($reservation['is_refund'] == '0') {
            $refund = 0;
        }
        ?>
        <div class="row">
            <div class="card">
                <div class="card-header text-center">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Transaction History</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col table-responsive">
                        <table class="table table-borderless text-dark">
                            <tbody>
                            <?php if (($reservation['reservation_type'] == 1)) : ?>
                                    <tr>
                                        <td class="fw-bold">Total Price</td>
                                        <td>: <?= esc("Rp " . number_format($total_price, 0, ',', '.')) ?></td>
                                        <input hidden type="number" id="total_price_for_bonus_coin" name="coin" class="form-control" value="<?= esc($total_price); ?>">

                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Deposit</td>
                                        <td>: <?= esc("Rp " . number_format($deposit, 0, ',', '.')) ?> <i>*(20% of total price)</i></td>
                                    </tr>
                                <?php elseif (($reservation['reservation_type'] == 2)) : ?>
                                    <tr>
                                        <td class="fw-bold">Total Price</td>
                                        <td>: <?= esc("Rp " . number_format($homestay_unit_total_price * 90 / 100, 0, ',', '.')) ?></td>
                                        <input hidden type="number" id="total_price_for_bonus_coin" name="coin" class="form-control" value="<?= esc($homestay_unit_total_price * 90 / 100); ?>">

                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Deposit</td>
                                        <td>: <?= esc("Rp " . number_format($homestay_unit_total_price * 90 / 100 * 20 / 100, 0, ',', '.')) ?> <i>*(20% of total price)</i></td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td class="fw-bold">
                                        <div id="used_coin_1" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>Coin Used</div>
                                    </td>
                                    <td>
                                        <div id="used_coin_2" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>:
                                            <?php if ($reservation['status'] != null) : ?>
                                                <?= esc("-Rp " . number_format($reservation['coin_use'], 0, ',', '.')) ?>
                                            <?php else : ?>
                                                <?= esc("-Rp " . number_format($coin, 0, ',', '.')) ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">
                                        <div id="used_coin_3" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>Total Price After Coin</div>
                                    </td>
                                    <td>
                                        <?php if (($reservation['status'] != null)) : ?>
                                            <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format($reservation['total_price'] - $reservation['coin_use'], 0, ',', '.')) ?></div>
                                        <?php else : ?>
                                            <?php if (($reservation['reservation_type'] == 1)) : ?>
                                                <?php if (($coin > 0.15 * $total_price)) : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format($total_price - 0.15 * $total_price, 0, ',', '.')) ?></div>
                                                <?php else : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format($total_price - $coin, 0, ',', '.')) ?></div>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <?php if (($coin > 0.15 * $total_price)) : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format(($homestay_unit_total_price * 90 / 100) - (0.15 * $homestay_unit_total_price * 90 / 100), 0, ',', '.')) ?></div>
                                                <?php else : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format($homestay_unit_total_price * 90 / 100 - $coin, 0, ',', '.')) ?></div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- <script>
                                    usedCoinText();
                                </script> -->

                                <?php if ((($reservation['status'] == 'Deposit Successful') || ($reservation['status'] == 'Full Pay Pending') || ($reservation['status'] == 'Full Pay Successful')) && ($reservation['canceled_at'] == null)) : ?>
                                    <?php if (($reservation['reservation_type'] == 1 && $reservation['coin_use'] == 0)) : ?>
                                        <tr>
                                            <td class="fw-bold">Full Price</td>
                                            <td>
                                                : <?= esc("Rp " . number_format($reservation['total_price'] - $reservation['deposit'], 0, ',', '.')) ?> <i>*(80% of total price)</i>
                                            </td>
                                        </tr>
                                    <?php elseif (($reservation['reservation_type'] == 2 &&  $reservation['coin_use'] == 0)) : ?>
                                        <tr>
                                            <td class="fw-bold">Full Price</td>
                                            <td>
                                                : <?= esc("Rp " . number_format($reservation['total_price'] - $reservation['deposit'], 0, ',', '.')) ?> <i>*(80% of total price)</i>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if (($reservation['reservation_type'] == 1 && $reservation['coin_use'] > 0)) : ?>
                                        <tr>
                                            <td class="fw-bold">Full Price</td>
                                            <td>
                                                : <?= esc("Rp " . number_format($reservation['total_price'] - $reservation['coin_use'] - $reservation['deposit'], 0, ',', '.')) ?> <i>*(Total Price After Deposit and Using Coin)</i>
                                            </td>
                                        </tr>
                                    <?php elseif (($reservation['reservation_type'] == 2 &&  $reservation['coin_use'] > 0)) : ?>
                                        <tr>
                                            <td class="fw-bold">Full Price</td>
                                            <td>
                                                : <?= esc("Rp " . number_format($reservation['total_price'] - $reservation['coin_use'] - $reservation['deposit'], 0, ',', '.')) ?> <i>*(Total Price After Deposit and Using Coin)</i>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($reservation['is_refund'] == '1') : ?>
                                    <tr>
                                        <td class="fw-bold">Refund</td>
                                        <td>
                                            : <?= esc("Rp " . number_format($refund, 0, ',', '.')) ?> <i>*(50% of deposit)</i>
                                            <?php if ($reservation['refund_paid_confirmed_at'] != null) : ?>
                                                <span class="text-success">(Paid by homestay owner)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (($reservation['is_refund'] == '0') && ($reservation['cancelation_reason'] == '1')) : ?>
                                    <tr>
                                        <td class="fw-bold">Refund</td>
                                        <td>: <?= esc("Rp 0") ?> <i>*(canceled after 1 day before check in)</i></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <hr class="hr">
                        <table class="table table-borderless text-dark">
                            <tbody>
                                <?php if ($reservation['reservation_finish_at'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Reservation Finish at</td>
                                        <td>: <?= esc(date_format(date_create($reservation['reservation_finish_at']), "d F Y, H:i")) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($reservation['confirmed_at'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Reservation <?= ($reservation['is_rejected'] == '1') ? 'Rejected' : 'Confirmed' ?> at</td>
                                        <td>: <?= esc(date_format(date_create($reservation['confirmed_at']), "d F Y, H:i")) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($reservation['canceled_at'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Canceled at</td>
                                        <td>: <?= esc(date_format(date_create($reservation['canceled_at']), "d F Y, H:i")) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Cancelation Reason</td>
                                        <?php if ($reservation['cancelation_reason'] == '1') : ?>
                                            <td>: Canceled by customer</td>
                                        <?php elseif ($reservation['cancelation_reason'] == '2') : ?>
                                            <td>: Deposit payment has exceeded the deadline</td>
                                        <?php elseif ($reservation['cancelation_reason'] == '3') : ?>
                                            <td>: Full payment has exceeded the deadline</td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($reservation['refund_paid_confirmed_at'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Refund Paid Confirmed at</td>
                                        <td>: <?= esc(date_format(date_create($reservation['refund_paid_confirmed_at']), "d F Y, H:i")) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>:
                                        <?php if (($reservation['status'] == null) && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Reservation Incomplete" class="btn-sm btn-dark float-center" disabled>Incomplete</button>
                                        <?php elseif (($reservation['status'] == '0') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Waiting for the homestay owner to accept the reservation" class="btn-sm btn-warning float-center" disabled>Waiting</button>
                                        <?php elseif (($reservation['status'] == '1') && ($reservation['canceled_at'] == null) && ($reservation['is_rejected'] == '1')) : ?>
                                            <button title="Reservation Rejected" class="btn-sm btn-danger float-center" disabled>Rejected</button>
                                        <?php elseif (($reservation['status'] == '1') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Paying Deposit" class="btn-sm btn-info float-center" disabled>Pay Deposit</button>
                                        <?php elseif (($reservation['status'] == 'Deposit Pending') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Deposit Pending" class="btn-sm btn-warning float-center" disabled>Deposit Pending</button>
                                        <?php elseif (($reservation['status'] == 'Deposit Successful') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Deposit Successful" class="btn-sm btn-success float-center" disabled>Deposit Successful</button>
                                        <?php elseif (($reservation['status'] == 'Deposit Expired') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Deposit Expired" class="btn-sm btn-danger float-center" disabled>Deposit Expired</button>
                                        <?php elseif (($reservation['status'] == 'Full Pay Pending') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Full Pay Pending" class="btn-sm btn-warning float-center" disabled>Full Pay Pending</button>
                                        <?php elseif (($reservation['status'] == 'Full Pay Successful') && ($reservation['canceled_at'] == null)) : ?>
                                            <button title="Full Pay Successful" class="btn-sm btn-success float-center" disabled>Full Pay Successful</button>
                                        <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] == null)) : ?>
                                            <button title="Waiting for the homestay owner to pay refund" class="btn-sm btn-danger float-center" disabled>Refund</button>
                                        <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] != null) && ($reservation['refund_paid_confirmed_at'] == null)) : ?>
                                            <button title="Waiting for the customer to confirm refund" class="btn-sm btn-danger float-center" disabled>Confirm Refund</button>
                                        <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] != null) && ($reservation['refund_paid_confirmed_at'] != null)) : ?>
                                            <button title="Reservation Canceled" class="btn-sm btn-danger float-center" disabled>Canceled</button>
                                        <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '0')) : ?>
                                            <button title="Reservation Canceled" class="btn-sm btn-danger float-center" disabled>Cancel</button>
                                        <?php elseif ($reservation['status'] == 'Done') : ?>
                                            <button title="Reservation Done" class="btn-sm btn-primary float-center" disabled>Done</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($reservation['feedback'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Feedback</td>
                                        <td>: <?= esc($reservation['feedback']) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="2">
                                        <hr class="hr">
                                    </td>
                                </tr>
                                <?php if (($reservation['status'] == '0') && ($reservation['confirmed_at'] == null) && ($reservation['canceled_at'] == null)) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Confirm reservation.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a title="Confirm Reservation" class="btn icon btn-primary btn-sm mb-1 mt-3" data-bs-toggle="modal" data-bs-target="#confirmReservation">
                                                Confirm Reservation
                                            </a>
                                        </td>
                                    </tr>
                                <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_paid_confirmed_at'] == null)) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Pay refund and then upload payment proof.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Pay refund to customer account :
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php if ($reservation['account_refund'] == null) : ?>
                                                <span><i>Customer has not entered his refund account</i></span>
                                            <?php else : ?>
                                                <div class="col-md-6">
                                                    <div class="card border" style="display: flex;">
                                                        <div class="card-body">
                                                            <span class="fw-bold">
                                                                <?= esc($reservation['account_refund']) ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-5">
                                                    <form class="form form-vertical" action="/dashboard/reservation/refund/<?= esc($reservation['id']); ?>" method="post" enctype="multipart/form-data">
                                                        <div class="form-body">
                                                            <div class="form-group mb-4">
                                                                <label for="gallery" class="form-label">
                                                                    <?php if ($reservation['refund_proof'] == null) : ?>
                                                                        Refund Proof
                                                                    <?php else : ?>
                                                                        Change Refund Proof
                                                                        <?php if ($reservation['is_refund_proof_correct'] == '0') : ?>
                                                                            <br>
                                                                            <span class="text-danger"><i>*refund proof that you uploaded previously is incorrect</i></span>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </label>
                                                                <input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Info Activity -->
    <?php if (!empty($reservation_additional_amenities)) : ?>
        <?php foreach ($reservation_additional_amenities as $activity) : ?>
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
                                        <img width="1000px" src="<?= base_url('media/photos'); ?>/<?= esc($activity['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;" height="250px">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($activity['name']); ?>
                                                <?php if (!empty($activity['category'] == '1')) : ?>
                                                    (Facility)
                                                <?php else : ?>
                                                    (Service)
                                                <?php endif; ?>
                                            </h5>
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
    <!-- Modal Info Activity -->
    <?php if (!empty($reservation_homestay_activity)) : ?>
        <?php foreach ($reservation_homestay_activity as $activity) : ?>
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
                                        <img width="1000px" src="<?= base_url('media/photos'); ?>/<?= esc($activity['image_url']); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;" height="250px">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($activity['name']); ?></h5>
                                            <p class="card-text"><?= esc($activity['description']); ?></p>
                                            <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($activity['price'], 0, ',', '.')) ?>/person</small></p>
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

    <!-- Modal Confirm Reservation -->
    <?php if (($reservation['status'] == '0') && ($reservation['confirmed_at'] == null) && ($reservation['canceled_at'] == null)) : ?>
        <div class="modal fade" id="confirmReservation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reservation Confirmation</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body text-dark">
                            <form class="form form-vertical" action="/dashboard/reservation/confirm/<?= esc($reservation['id']); ?>" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group mb-4">
                                        <label for="name" class="mb-2">Reservation Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" name="is_rejected" value="0" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <i class="fa-solid fa-check"></i> Accept
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="is_rejected" value="1" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <i class="fa-solid fa-xmark"></i> Reject
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="description" class="form-label">Feedback</label>
                                        <textarea class="form-control" id="description" name="feedback" rows="4"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 my-3">Save</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDone(reservation_id, deposit) {
        Swal.fire({
            title: "Do you want to finish reservation?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/web/reservation/finish/" + reservation_id + "/" + deposit;
            }
        });
    }
</script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>
<script>
    function confirmCancelReservation(reservation_id) {
        Swal.fire({
            title: "Do you want to cancel reservation?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/web/reservation/cancel/" + reservation_id;
            }
        });
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

    function usedCoinText() {
        $("#used_coin_1").hide();
        $("#used_coin_2").hide();
        $("#used_coin_3").hide();
        $("#used_coin_4").hide();
        const coinDiv = document.getElementById('used_coin_text');
        if ($('#useCoinsSwitch').is(':checked')) {
            $("#used_coin_1").show();
            $("#used_coin_2").show();
            $("#used_coin_3").show();
            $("#used_coin_4").show();
        } else {
            $("#used_coin_1").hide();
            $("#used_coin_2").hide();
            $("#used_coin_3").hide();
            $("#used_coin_4").hide();
        }
    };

    window.onload = function() {
        usedCoinText();
    };
</script>
<?= $this->endSection() ?>