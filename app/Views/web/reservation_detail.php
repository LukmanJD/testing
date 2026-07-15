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

            function checkRequired(event) {
                const available_stock = document.getElementById("available_stock");
                const total_order = document.getElementById("totalOrder");

                if (parseInt(total_order.value) > parseInt(available_stock.textContent)) {
                    event.preventDefault();
                    Swal.fire('Total order cannot exceed available stock!');
                }

            }
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
                                    <?php

                                    use App\Controllers\Web\Reservation\Reservation;
                                    use phpDocumentor\Reflection\Types\Null_;

                                    if ($reservation['rating'] != null) : ?>
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
                                        <tr>
                                            <td class="fw-bold">Bonus Coin</td>
                                            <td><?= number_format($reservation['total_price'] * 0.05); ?></td>
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
                                        <?php $package_total_price = 0; ?>
                                        <?php $homestay_activity_total_price = 0; ?>
                                        <?php foreach ($homestay_unit as $item) : ?>
                                            <div class="card border mb-3">
                                                <div class="row g-0">
                                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                                        <img width="500px" src="<?= base_url('media/photos/' . esc($item['galleries'][0])) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 150px;">
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
                                            <span>Homestay unit total price = <?= esc("Rp " . number_format($homestay_unit_total_price, 0, ',', '.')) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                        Tourism Package
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <?php if (empty($packages)) : ?>
                                            <?php if (($reservation['status'] == null) && ($reservation['canceled_at'] == null)) : ?>
                                                <a title="Choose Package" class="btn icon btn-primary btn-sm" href="/web/reservation/package/<?= esc($homestay['id']) ?>/<?= esc($reservation['id']) ?>">
                                                    <i class="fa-solid fa-plus"></i> Choose Package
                                                </a>
                                            <?php else : ?>
                                                <span>No package chosen</span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php foreach ($packages as $package) : ?>
                                                <div class="card border mb-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                                                            <img width="500px" src="/media/photos/<?= esc($package['brochure_url']) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 150px;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body">
                                                                <h5 class="card-title">
                                                                    <?= esc($package['name']) ?>
                                                                    <?php if (($reservation['status'] == null) && ($reservation['canceled_at'] == null)) : ?>
                                                                        <a class="text-danger float-end" onclick="deletePackage('<?= esc($reservation['id']); ?>')"><i class="fa-solid fa-trash"></i></a>
                                                                    <?php endif; ?>
                                                                    <a class="text-info float-end me-2" target="_blank" href="/web/homestayPackage/detail/<?= esc($package['homestay_id']) ?>/<?= esc($package['id']) ?>"><i class="fa-solid fa-circle-info"></i></a>
                                                                </h5>
                                                                <p class="card-text">
                                                                    Package Day: <?= esc($package['total_day']) ?> day <br>
                                                                    Minimum Capacity: <?= esc($package['min_capacity']) ?> people
                                                                </p>
                                                                <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($package['price'], 0, ',', '.')); ?></small></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $package_total_price = $package['price'];
                                                if (isset($package['package_order'])) {
                                                    $package_total_price = $package['price'] * $package['package_order'];
                                                }
                                                ?>
                                                <span>Package total price = <?= esc("Rp " . number_format($package_total_price, 0, ',', '.')); ?></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (empty($packages) && !empty($available_packages) && ($reservation['status'] == null || $reservation['status'] == '0' || $reservation['status'] == '1')) : ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                            Available Packages
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                                        <div class="accordion-body">
                                            <?php foreach ($available_packages as $ap) : ?>
                                                <div class="card border mb-3">
                                                    <div class="row g-0">
                                                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                                                            <img width="500px" src="/media/photos/<?= esc($ap['brochure_url']) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 150px;">
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="card-body">
                                                                <h5 class="card-title">
                                                                    <?= esc($ap['name']) ?>
                                                                    <a class="text-info float-end me-2" target="_blank" href="/web/homestayPackage/detail/<?= esc($ap['homestay_id']) ?>/<?= esc($ap['id']) ?>"><i class="fa-solid fa-circle-info"></i></a>
                                                                </h5>
                                                                <p class="card-text">
                                                                    Package Day: <?= esc($ap['total_day']) ?> day <br>
                                                                    Minimum Capacity: <?= esc($ap['min_capacity']) ?> people
                                                                </p>
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <p class="card-text mb-0"><small class="text-dark fw-bold"><?= esc("Rp " . number_format($ap['price'], 0, ',', '.')); ?></small></p>
                                                                    <form action="/web/reservation/package/buy/<?= esc($homestay['id']) ?>/<?= esc($reservation['id']) ?>/<?= esc($ap['id']) ?>" method="post">
                                                                        <?= csrf_field() ?>
                                                                        <input type="hidden" name="total_people" value="<?= esc($reservation['total_people']); ?>">
                                                                        <button type="submit" class="btn btn-sm btn-success">
                                                                            <i class="fa-solid fa-plus"></i> Add to Reservation
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <a title="Custom Package" class="btn icon btn-outline-primary btn-sm" href="/web/reservation/package/custom/<?= esc($homestay['id']) ?>/<?= esc($reservation['id']) ?>">
                                                <i class="fa-solid fa-plus"></i> Create Custom Package
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($homestay_unit[0]['unit_type'] != "3") : ?>
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
                                                <?php if (($reservation['status'] == null) || ($reservation['status'] == '0') || ($reservation['status'] == '1')) : ?>
                                                    <a title="Add amenities" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#insertService">
                                                        <i class="fa-solid fa-plus"></i> Add Amenities
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($reservation_additional_amenities)) : ?>
                                                <?php foreach ($reservation_additional_amenities as $activity) : ?>
                                                    <li><?= esc($activity['name']) ?>
                                                        <div class="float-end">
                                                            <a class="text-info" target="_blank"><i class="fa-solid fa-circle-info" data-bs-toggle="modal" data-bs-target="#infoActivity<?= esc($activity['id']); ?>"></i></a>
                                                            <?php if (($reservation['status'] == null) || ($reservation['status'] == '0') || ($reservation['status'] == '1')) : ?>
                                                                <a class="text-warning ms-2" data-bs-toggle="modal" data-bs-target="#editAmenities<?= esc($activity['id']); ?>"><i class="fa-solid fa-pencil"></i></a>
                                                                <a class="text-danger ms-2" onclick="deleteAmenities('<?= esc($reservation['id']); ?>', '<?= esc($activity['homestay_id']); ?>', '<?= esc($activity['additional_amenities_id']); ?>', '<?= esc($activity['name']); ?>')"><i class="fa-solid fa-trash"></i></a>
                                                            <?php endif; ?>
                                                        </div>
                                                        <br>
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
                            <?php endif; ?>
                        </div>

                        <?php if ($reservation['reservation_type'] == 1 && ($reservation['status'] == null || $reservation['status'] == '0' || $reservation['status'] == '1')) : ?>
                            <div class="form-check form-switch mt-3">
                                <?php if (!empty($coin) && $coin['total_coin'] > 0): ?>
                                    <input hidden readonly type="number" id="coin" name="coin" class="form-control" value="<?= esc($coin['total_coin']); ?>">
                                    <div class="mb-1 d-flex align-items-center">
                                        <label class="form-check-label me-auto" for="useCoinsSwitch">
                                            Use Coins? <span class="text-muted"><i>*(Min. 25.000, Max. 15% of Total Price)</i></span>
                                        </label>
                                        <input
                                            onchange="getTpac()"
                                            class="form-check-input ms-2"
                                            type="checkbox"
                                            id="useCoinsSwitch"
                                            data-total-coins="<?= esc($coin['total_coin']) ?>" <?= ($coin['total_coin'] < 25000) ? 'disabled' : '' ?>>
                                    </div>
                                <?php else: ?>
                                    <p>No coins available</p>
                                <?php endif; ?>
                            </div>

                        <?php elseif ($reservation['reservation_type'] == 2 && ($reservation['status'] == null || $reservation['status'] == '0' || $reservation['status'] == '1')) : ?>
                            <div class="form-check form-switch mt-3">
                                <?php if (!empty($coin) && $coin['total_coin'] > 0): ?>
                                    <input hidden readonly type="number" id="coin" name="coin" class="form-control" value="<?= esc($coin['total_coin']); ?>">
                                    <div class="mb-1 d-flex align-items-center">
                                        <label class="form-check-label me-auto" for="useCoinsSwitch">
                                            Use Coins? <span class="text-muted"><i>*(Min. 50.000, Max. 15% of Total Price)</i></span>
                                        </label>
                                        <input
                                            onchange="getTpac()"
                                            class="form-check-input ms-2"
                                            type="checkbox"
                                            id="useCoinsSwitch"
                                            data-total-coins="<?= esc($coin['total_coin']) ?>" <?= ($coin['total_coin'] < 50000) ? 'disabled' : '' ?>>
                                    </div>
                                <?php else: ?>
                                    <p>No coins available</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // // Calculate total price on the server side

        // // Check if the switch is checked and adjust the total price accordingly
        // if (isset($_POST['useCoinsSwitch']) && $_POST['useCoinsSwitch'] == 'on') {
        //     $total_price -= $coin['total_coin'];
        // }

        // Calculate deposit and full payment
        $total_price = $homestay_unit_total_price + $homestay_activity_total_price + $package_total_price;
        $deposit = $total_price * 0.20; // 20%
        $fullPay = $total_price * 0.80; // 80%
        $total_price_after_coin = $total_price - $coin['total_coin'];
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

        // Calculate refund based on reservation status
        $refund = ($reservation['is_refund'] == '1') ? ($deposit * 0.50) : 0; // 50% of deposit if refundable
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
                                        <td>: <?= esc("Rp " . number_format($deposit ?? 0, 0, ',', '.')) ?> <i>*(20% of total price)</i></td>
                                    </tr>
                                <?php elseif (($reservation['reservation_type'] == 2)) : ?>
                                    <tr>
                                        <td class="fw-bold">Total Price</td>
                                        <td>: <?= esc("Rp " . number_format($homestay_unit_total_price * 90 / 100, 0, ',', '.')) ?></td>
                                        <input hidden type="number" id="total_price_for_bonus_coin" name="coin" class="form-control" value="<?= esc($homestay_unit_total_price * 90 / 100); ?>">

                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Deposit</td>
                                        <td>: <?= esc("Rp " . number_format(($homestay_unit_total_price * 90 / 100 * 20 / 100) ?? 0, 0, ',', '.')) ?> <i>*(20% of total price)</i></td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td class="fw-bold">
                                        <div id="used_coin_1" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>Coin Used</div>
                                    </td>
                                    <td>
                                        <div id="used_coin_2" <?= (($reservation['status'] == null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>
                                            <?php if ($reservation['status'] != null && isset($reservation['coin_use']) && $reservation['coin_use'] != '0') : ?>
                                                <?= esc("-Rp " . number_format($reservation['coin_use'] ?? 0, 0, ',', '.')) ?>
                                            <?php elseif (isset($coin) && $coin != null && $coin != '0') : ?>
                                                <?= esc("-Rp " . number_format($coin ?? 0, 0, ',', '.')) ?>
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
                                            <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format(($reservation['total_price'] ?? 0) - ($reservation['coin_use'] ?? 0), 0, ',', '.')) ?></div>
                                        <?php else : ?>
                                            <?php if (($reservation['reservation_type'] == 1)) : ?>
                                                <?php if (($coin > 0.15 * $total_price)) : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format(($total_price ?? 0) - 0.15 * ($total_price ?? 0), 0, ',', '.')) ?></div>
                                                <?php else : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format(($total_price ?? 0) - ($coin ?? 0), 0, ',', '.')) ?></div>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <?php if (($coin > 0.15 * $total_price)) : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format((($homestay_unit_total_price ?? 0) * 90 / 100) - (0.15 * ($homestay_unit_total_price ?? 0) * 90 / 100), 0, ',', '.')) ?></div>
                                                <?php else : ?>
                                                    <div id="used_coin_4" <?= (($reservation['status'] == Null) || ($reservation['coin_use'] == '0')) ? 'style="display: none;"' : '' ?>>: <?= esc("Rp " . number_format((($homestay_unit_total_price ?? 0) * 90 / 100) - ($coin ?? 0), 0, ',', '.')) ?></div>
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
                                        <td>:
                                            <?php if ($reservation['status'] == 'Full Pay Successful' || ($reservation['canceled_at'] != null && $reservation['full_paid_at'] != null)) : ?>
                                                <?= esc("Rp " . number_format($reservation['total_price'] * 0.5, 0, ',', '.')) ?>
                                                <br>
                                                <small><i>(Based on <b>Full Payment</b>, 50% of total price)</i></small>
                                            <?php else : ?>
                                                <?= esc("Rp " . number_format($refund, 0, ',', '.')) ?>
                                                <br>
                                                <small><i>(Based on <b>Deposit</b>, 50% of deposit)</i></small>
                                            <?php endif; ?>
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

                        <div class="col-md-11">
                            <?php if (($reservation['status'] != null) && ($reservation['status'] != '0')) : ?>
                                <a title="Download Invoice" class="btn icon btn-success btn-sm mt-3 float-end" href="/web/reservation/invoice/<?= esc($reservation['id']) ?>" target="_blank">
                                    <i class="fa-solid fa-print"></i> Invoice
                                </a>
                            <?php endif; ?>

                            <?php if ((($reservation['status'] == null) || ($reservation['status'] == '0') || ($reservation['status'] == '1') || ($reservation['status'] == 'Full Pay Successful')) && ($reservation['canceled_at'] == null)) : ?>
                                <a title="Extend Reservation" class="btn icon btn-info btn-sm mt-3 float-end me-2" href="/web/reservation/extend/<?= esc($reservation['id']) ?>">
                                    <i class="fa-solid fa-calendar-plus"></i> Extend Reservation
                                </a>
                            <?php endif; ?>

                            <?php if ((($reservation['status'] == 'Deposit Successful') || ($reservation['status'] == 'Full Pay Successful')) && ($reservation['canceled_at'] == null)) : ?>
                                <a title="Cancel Reservation" class="btn icon btn-danger btn-sm mt-3 float-end" onclick="confirmCancelReservation('<?= esc($reservation['id']); ?>')">
                                    <i class="fa-solid fa-xmark"></i> Cancel Reservation
                                </a>
                            <?php endif; ?>


                        </div>

                        <?php
                        $cancelDeadline = date("d F Y, H:i", strtotime($reservation['check_in'] . ' - 1 days'));

                        date_default_timezone_set("Asia/Jakarta");
                        if (strtotime(date("d F Y, H:i")) < strtotime($cancelDeadline)) {
                            $text = "You will get back 50% of the deposit you have paid!";
                        } else {
                            $text = "Cancellation after 1 day before checking in, you will not get a refund!";
                        }

                        ?>

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
                                <?php if ($reservation['refund_proof']) : ?>
                                    <tr>
                                        <td class="fw-bold">Refund Proof</td>
                                        <td>: <a href="/media/photos/<?= esc($reservation['refund_proof']) ?>" target="_blank">See Document</a></td>
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
                                            <button title="Reservation Canceled" class="btn-sm btn-danger float-center" disabled>Canceled</button>
                                        <?php elseif ($reservation['status'] == 'Done') : ?>
                                            <button title="Reservation Done" class="btn-sm btn-primary float-center" disabled>Done</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr class="hr">
                                    </td>
                                </tr>
                                <?php if (($reservation['status'] == null) && ($reservation['canceled_at'] == null)) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Finish reservation by click button below
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <?php if (($reservation['reservation_type'] == 1)) : ?>
                                                <a title="Finish Reservation" class="btn icon btn-success btn-sm mb-1 mt-3" onclick="confirmDone('<?= esc($reservation['id']); ?>','<?= esc($deposit); ?>','<?= esc($total_price); ?>','<?= esc($coin); ?>')">
                                                    <i class="fa-solid fa-check"></i> Done
                                                </a>
                                            <?php elseif (($reservation['reservation_type'] == 2)) : ?>
                                                <a title="Finish Reservation" class="btn icon btn-success btn-sm mb-1 mt-3" onclick="confirmDone('<?= esc($reservation['id']); ?>','<?= esc($reservation['deposit']); ?>','<?= esc($reservation['total_price']); ?>','<?= esc($coin); ?>')">
                                                    <i class="fa-solid fa-check"></i> Done
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ((($reservation['status'] == '1') || ($reservation['status'] == 'Deposit Pending')) && ($reservation['canceled_at'] == null) && ($reservation['is_rejected'] != '1')) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Pay deposit or full price by click button bellow
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="javascript:void(0)" onclick="processPayment('<?= esc($reservation['id']) ?>', 'deposit')" class="btn icon btn-primary btn-sm mb-1 mt-3">
                                                Pay Deposit
                                            </a>
                                            <a href="javascript:void(0)" onclick="processPayment('<?= esc($reservation['id']) ?>', 'full')" class="btn icon btn-success btn-sm mb-1 mt-3 ms-1">
                                                Pay Full
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ((($reservation['status'] == 'Deposit Successful') || ($reservation['status'] == 'Full Pay Pending')) && ($reservation['canceled_at'] == null) && ($reservation['is_rejected'] != '1')) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Pay full price by click button bellow
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="javascript:void(0)" onclick="processPayment('<?= esc($reservation['id']) ?>', 'full')" class="btn icon btn-primary btn-sm mb-1 mt-3">
                                                Pay Full Price
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($reservation['feedback'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Feedback</td>
                                        <td>: <?= esc($reservation['feedback']) ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php if (in_groups('user') && ($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] == null)) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Add your bank account for refund and then wait for homestay owner to upload refund payment proof.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="col-md-6">
                                                <form class="form form-vertical" action="<?= base_url('web/reservationRefund'); ?>" method="post" enctype="multipart/form-data">
                                                    <?= csrf_field() ?>
                                                    <div class="form-body">
                                                        <input type="hidden" name="reservation_id" value="<?= esc($reservation['id']); ?>">
                                                        <div class="form-group">
                                                            <label for="name" class="mb-2">Account Refund (Ex: Name XX - Bank XX - AccNumber)</label>
                                                            <textarea class="form-control" name="account_refund" placeholder="Budi Setiawan - Bank ABC - 12345678" required><?= $reservation['account_refund'] ? $reservation['account_refund'] : '' ?></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary me-1 my-3">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] != null) && ($reservation['refund_paid_confirmed_at'] == null)) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Confirm refund payment. Please check the refund proof first before confirm.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a title="Confirm Refund" class="btn icon btn-primary btn-sm mb-1 mt-3" data-bs-toggle="modal" data-bs-target="#confirmRefund">
                                                Confirm Refund
                                            </a>
                                        </td>
                                    </tr>
                                <?php elseif (in_groups('user') && ($reservation['status'] == 'Done') && ($reservation['rating'] == null) && ($reservation['review'] == null)) : ?>
                                    <tr>
                                        <td colspan="2">
                                            <span class="fw-bold">To Do : </span>
                                            Add rating and review. And get Bonus Coin 5% from your reservation total prcie
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <center>
                                                <!-- Object Rating and Review -->
                                                <div class="card col-md-6">
                                                    <div class="card-header text-center">
                                                        <h4 class="card-title">Rating and Review</h4>
                                                        <?php if (in_groups('user')) : ?>
                                                            <form class="form form-vertical" method="post" onsubmit="checkRatingStar(event);">
                                                                <div class="form-body">
                                                                    <div class="star-containter mb-3">
                                                                        <i class="fa-solid fa-star fs-4" id="rstar-1" onclick="setRatingStar('rstar-1');"></i>
                                                                        <i class="fa-solid fa-star fs-4" id="rstar-2" onclick="setRatingStar('rstar-2');"></i>
                                                                        <i class="fa-solid fa-star fs-4" id="rstar-3" onclick="setRatingStar('rstar-3');"></i>
                                                                        <i class="fa-solid fa-star fs-4" id="rstar-4" onclick="setRatingStar('rstar-4');"></i>
                                                                        <i class="fa-solid fa-star fs-4" id="rstar-5" onclick="setRatingStar('rstar-5');"></i>
                                                                        <input type="hidden" id="rating_star" value="0" name="rating">
                                                                    </div>
                                                                    <div class="col-12 mb-3">
                                                                        <div class="form-floating">
                                                                            <textarea class="form-control" placeholder="Leave review here" id="floatingTextarea" style="height: 150px;" name="review"></textarea>
                                                                            <label for="floatingTextarea">Review</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 d-flex justify-content-center mb-3">
                                                                        <a type="submit" onclick="reviewAndCoin('<?= esc($reservation['id']); ?>')" class="btn btn-primary me-1 mb-1">Submit</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        <?php else : ?>
                                                            <?php if (!url_is("*detail*")) : ?>
                                                                <p class="card-text">Please login as User to give rating and review</p>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </center>
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
    <!-- Modal Add Service -->
    <div class="modal fade" id="insertService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Additional Amenities</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body text-dark">
                        <form class="form form-vertical" action="<?= base_url('web/reservation/addAmenities'); ?>" method="post" enctype="multipart/form-data" onsubmit="checkRequired(event)">
                            <?= csrf_field() ?>
                            <div class="form-body">
                                <input type="hidden" name="reservation_id" value="<?= esc($reservation['id']); ?>">
                                <fieldset class="form-group mb-4">
                                    <label for="serviceSelect" class="mb-2">Additional Amenities</label>
                                    <select class="form-select" id="serviceSelect" name="additional_amenities_id" onchange="getOrderField(this.value, '<?= esc($homestay['id']) ?>','<?= esc($reservation['day_of_stay']) ?>','<?= esc($reservation['total_people']) ?>','<?= esc(count($homestay_unit)) ?>')" required>
                                    </select>
                                </fieldset>
                                <div id="additionalAmenitiesOrderFields">
                                </div>
                                <input type="hidden" name="homestay_id" value="<?= esc($homestay['id']) ?>">
                                <button type="submit" class="btn btn-primary me-1 mt-5">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-1x1" style="min-height: 600px;">
                        <iframe id="checkoutFrame" src="" style="border: none; width: 100%; height: 100%;" allow="payment"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Info Additional Amenities -->
    <?php if (!empty($reservation_additional_amenities)) : ?>
        <?php foreach ($reservation_additional_amenities as $activity) : ?>
            <div class="modal fade bd-example-modal-lg" id="infoActivity<?= esc($activity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Info Additional Amenities</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3" style="max-width: 1000px;">
                                <div class="row g-0">
                                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                                        <img width="1000px" src="<?= base_url('media/photos/' . esc($activity['image_url'])); ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover;" height="250px">
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

    <!-- Modal Edit Amenities -->
    <?php if (!empty($reservation_additional_amenities)) : ?>
        <?php foreach ($reservation_additional_amenities as $amenity) : ?>
            <div class="modal fade" id="editAmenities<?= esc($amenity['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="editAmenitiesLabel<?= esc($amenity['id']); ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAmenitiesLabel<?= esc($amenity['id']); ?>">Edit <?= esc($amenity['name']); ?></h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form form-vertical" action="<?= base_url('web/reservation/amenities/update'); ?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="reservation_id" value="<?= esc($reservation['id']); ?>">
                                <input type="hidden" name="homestay_id" value="<?= esc($amenity['homestay_id']); ?>">
                                <input type="hidden" name="additional_amenities_id" value="<?= esc($amenity['id']); ?>">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="total_order_edit_<?= esc($amenity['id']); ?>" class="mb-2">Total Order</label>
                                        <input type="number" id="total_order_edit_<?= esc($amenity['id']); ?>" class="form-control" name="total_order" placeholder="Total Order" value="<?= esc($amenity['total_order']); ?>" min="1" onchange="calculatePriceEdit('<?= esc($amenity['id']); ?>', this.value, '<?= esc($amenity['price']); ?>')" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_price_edit_<?= esc($amenity['id']); ?>" class="mb-2">Total Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" id="total_price_edit_<?= esc($amenity['id']); ?>" class="form-control" name="total_price" value="<?= esc($amenity['total_price']); ?>" readonly>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1 my-3">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Modal Refund Confirmation -->
    <?php if (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] != null) && ($reservation['refund_paid_confirmed_at'] == null)) : ?>
        <div class="modal fade" id="confirmRefund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Refund Confirmation</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body text-dark">
                            <img src="<?= base_url('media/photos/' . esc($reservation['refund_proof'])) ?>" class="img-fluid" alt="...">
                            <form class="form form-vertical" action="/web/reservation/refund/confirm/<?= esc($reservation['id']); ?>" method="post" enctype="multipart/form-data">
                                <div class="form-body">
                                    <div class="form-group ">
                                        <label for="name" class="mt-2">Is this refund proof correct?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" name="is_refund_proof_correct" value="1" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                <i class="fa-solid fa-check"></i> Correct
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" name="is_refund_proof_correct" value="0" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                <i class="fa-solid fa-xmark"></i> Incorrect
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-1">Save</button>
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
<script>
    function deletePackage(reservation_id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('web/reservation/package/delete') ?>/${reservation_id}`,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>' // Tambahkan CSRF Token
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'The package has been removed from your reservation.',
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'Failed to delete package. ' + error, 'error');
                    }
                });
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDone(reservation_id, deposit, total_price, coin) {
        if ($('#useCoinsSwitch').is(':checked')) {
            Swal.fire({
                title: "Do you want to finish reservation?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("You have finish the reservation", "Please wait for the Homestay Owner to confirm the reservation. To view the reservation details, you can check the Reservation Menu.").then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/web/reservation/finish/" + reservation_id + "/" + deposit + "/" + total_price + "/" + coin;
                        }
                    });
                }
            });
        } else {
            var zerocoin = 0;
            Swal.fire({
                title: "Do you want to finish reservation?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire("You have finish the reservation", "Please wait for the Homestay Owner to confirm the reservation. To view the reservation details, you can check the Reservation Menu.").then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/web/reservation/finish/" + reservation_id + "/" + deposit + "/" + total_price + "/" + zerocoin;
                        }
                    });
                }
            });
        }
    }

    function processPayment(reservationId, type) {
        console.log('Opening Unified Checkout Popup');
        const url = baseUrl + '/web/checkout/' + reservationId + '/' + type;

        $('#checkoutFrame').attr('src', url);
        $('#checkoutModal').modal('show');
    }

    function deleteAmenities(reservation_id, homestay_id, amenity_id, amenity_name) {
        Swal.fire({
            title: `Are you sure you want to delete ${amenity_name}?`,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('web/reservation/amenities/delete') ?>/${reservation_id}/${homestay_id}/${amenity_id}`,
                    type: 'POST', // Gunakan POST untuk method spoofing
                    data: {
                        '_method': 'DELETE', // Method spoofing untuk CodeIgniter
                        '<?= csrf_token() ?>': '<?= csrf_hash() ?>' // CSRF Token
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The amenity has been removed.',
                            'success'
                        ).then(() => {
                            location.reload(); // Muat ulang halaman setelah berhasil
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'Failed to delete amenity.', 'error');
                    }
                });
            }
        })
    }
</script>
<script>
    var amenitiesData = [];

    function getListAdditionalAmenities(reservationId, homestayId) {
        $.ajax({
            url: baseUrl + "/web/getAdditionalAmenities/" + homestayId + "/" + reservationId,
            type: "GET",
            dataType: "json",
            success: function(response) {
                amenitiesData = response.data;
                var options = '<option value="" selected disabled>--Select Additional Amenities--</option>';
                $.each(response.data, function(index, value) {
                    options += '<option value="' + value.additional_amenities_id + '">' + value.name + '</option>';
                });
                $('#serviceSelect').html(options);
            }
        });
    }

    function getOrderField(amenitiesId, homestayId, dayOfStay, totalPeople, totalRoom) {
        const amenity = amenitiesData.find(x => x.additional_amenities_id === amenitiesId);
        const container = $('#additionalAmenitiesOrderFields');
        container.empty();

        if (!amenity) return;

        // Image
        if (amenity.image_url) {
            container.append(`<div class="text-center mb-3"><img src="/media/photos/${amenity.image_url}" class="img-fluid rounded" style="max-height: 200px;"></div>`);
        }

        // Description
        container.append(`<p>${amenity.description}</p>`);

        // Price Info
        container.append(`<p class="fw-bold">Price: ${amenity.price}</p>`);

        let html = '';

        // Inputs
        html += `<div class="form-group mb-3">
                    <label class="mb-2">Total Order</label>
                    <input type="number" class="form-control" name="total_order" id="totalOrder" value="1" min="1" oninput="calculateTotalPrice()">
                 </div>`;

        if (amenity.is_order_count_per_day == '1') {
            html += `<div class="form-group mb-3">
                        <label class="mb-2">Day Order</label>
                        <input type="number" class="form-control" name="day_order" id="dayOrder" value="${dayOfStay}" min="1" oninput="calculateTotalPrice()">
                     </div>`;
        } else {
            html += `<input type="hidden" name="day_order" id="dayOrder" value="0">`;
        }

        if (amenity.is_order_count_per_person == '1') {
            html += `<div class="form-group mb-3">
                        <label class="mb-2">Person Order</label>
                        <input type="number" class="form-control" name="person_order" id="personOrder" value="${totalPeople}" min="1" oninput="calculateTotalPrice()">
                     </div>`;
        } else {
            html += `<input type="hidden" name="person_order" id="personOrder" value="0">`;
        }

        if (amenity.is_order_count_per_room == '1') {
            html += `<div class="form-group mb-3">
                        <label class="mb-2">Room Order</label>
                        <input type="number" class="form-control" name="room_order" id="roomOrder" value="${totalRoom}" min="1" oninput="calculateTotalPrice()">
                     </div>`;
        } else {
            html += `<input type="hidden" name="room_order" id="roomOrder" value="0">`;
        }

        // Total Price Display & Hidden Input
        html += `<div class="form-group mb-3">
                    <label class="mb-2 fw-bold">Total Price Calculation</label>
                    <h5 id="totalPriceDisplay">Rp 0</h5>
                    <input type="hidden" name="total_price" id="totalPriceInput">
                 </div>`;

        // Stock validation helper
        if (amenity.stock > 0) {
            html += `<div class="alert alert-info">Available Stock: <span id="available_stock">${amenity.available_stock}</span></div>`;
        } else {
            html += `<span id="available_stock" style="display:none">999999</span>`;
        }

        container.append(html);
        calculateTotalPrice();
    }

    function calculateTotalPrice() {
        const amenityId = $('#serviceSelect').val();
        const amenity = amenitiesData.find(x => x.additional_amenities_id === amenityId);
        if (!amenity) return;

        let price = parseFloat(amenity.real_price);
        let totalOrder = parseFloat($('#totalOrder').val()) || 0;
        let dayOrder = parseFloat($('#dayOrder').val());
        let personOrder = parseFloat($('#personOrder').val());
        let roomOrder = parseFloat($('#roomOrder').val());

        let total = price * totalOrder;

        if (amenity.is_order_count_per_day == '1' && dayOrder > 0) total *= dayOrder;
        if (amenity.is_order_count_per_person == '1' && personOrder > 0) total *= personOrder;
        if (amenity.is_order_count_per_room == '1' && roomOrder > 0) total *= roomOrder;

        $('#totalPriceDisplay').text('Rp ' + total.toLocaleString('id-ID'));
        $('#totalPriceInput').val(total);
    }

    // Initialize amenities list
    getListAdditionalAmenities('<?= esc($reservation['id']); ?>', '<?= esc($homestay['id']) ?>');
</script>
<script>
    function calculatePriceEdit(amenityId, totalOrder, price) {
        const totalPriceField = document.getElementById(`total_price_edit_${amenityId}`);
        totalPriceField.value = totalOrder * price;
    }
</script>

<script>
    function reviewAndCoin(reservation_id) {
        var rating = document.getElementById("rating_star").value;
        var review = document.getElementById("floatingTextarea").value;
        var total_price_for_bonus_coin = document.getElementById("total_price_for_bonus_coin").value
        var bonus = total_price_for_bonus_coin * 0.05;

        $.ajax({
            url: baseUrl + "/web/reservation/review/" + reservation_id,
            type: "POST",
            data: {
                rating: rating,
                review: review,
            },
            dataType: "json",
            success: function(response) {
                // swal.fire("Thanks for the ratings and review!, you got " + bonus + " bonus coin");
            },
        });
        Swal.fire({
            title: "Thanks for the ratings and review!, you got " + bonus + " bonus coin",
            icon: "success",
            showCancelButton: false,
            confirmButtonText: "Ok",
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            } else {
                location.reload();
            }
        });
        //alert

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
            text: "<?= esc($text) ?>",
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
</script>
<script>
    function getTpac() {
        usedCoinText();
        if ($('#useCoinsSwitch').is(':checked')) {
            // If "Custom" is checked, uncheck "Default"
            const coin = parseInt($('#coin').val());
            const total_price = parseInt($('#total_price_price').val());
            var total_price_after_coin = total_price - coin;
            console.log(total_price);
            console.log(coin);
            console.log(total_price_after_coin);
            $("#cointpac").val(total_price_after_coin);
        } else {
            const coin = parseInt($('#coin').val());
            const total_price = parseInt($('#total_price_price').val());
            var total_price_after_coin = total_price;
            console.log(total_price);
            console.log(coin);
            console.log(total_price_after_coin);
            $("#cointpac").val(total_price_after_coin);
        }
    };

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

    // Listen for messages from the payment iframe
    window.addEventListener('message', function(event) {
        // IMPORTANT: Check the origin of the message for security
        // The origin should be your web's base URL
        if (event.origin !== window.location.origin) {
            console.warn('Ignored message from unknown origin:', event.origin);
            return;
        }

        if (event.data === 'paymentSuccess') {
            $('#checkoutModal').modal('hide');
            Swal.fire("Payment Successful!", "Your reservation has been updated.", "success").then(() => {
                location.reload();
            });
        }
    }, false);
</script>
<?= $this->endSection() ?>