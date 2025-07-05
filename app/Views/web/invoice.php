<style>
    p,
    span,
    table {
        font-size: 10px
    }

    table {
        width: 100%;
        border: 1px solid #dee2e6;
    }

    table#tb-item tr th,
    table#tb-item tr td {
        border: 1px solid #000
    }
</style>
<?php
$dateTime = new DateTime('now'); // Waktu sekarang
$datenow = $dateTime->format('Y-m-d H:i:s');
?>
<h5 style="font-size:14pt;text-align:right">RESERVATION INVOICE</h5>
<span>Dear Sir/Madam,</span><br />
<table cellpadding="0">
    <tr>
        <th width="10%">Name</th>
        <?php if (!empty($customer['fullname'])) : ?>
            <th width="40%">: <strong><?= esc($customer['fullname']); ?></strong></th>
        <?php else : ?>
            <th width="40%">: <strong>@<?= esc($customer['username']); ?></strong></th>
        <?php endif; ?>
        <th width="12%">No.Invoice</th>
        <th width="40%">: <strong><?= esc($reservation['id']); ?></strong></th>
    </tr>
    <tr>
        <th width="10%">Address</th>
        <?php if (!empty($customer['address'])) : ?>
            <th width="40%">: <strong><?= esc($customer['address']); ?></strong></th>
        <?php else : ?>
            <th width="40%">: <i>(profil is incomplete)</i></th>
        <?php endif; ?>
        <th width="12%">Request at</th>
        <?php $request_date = strtotime($reservation['request_date']); ?>
        <th width="60%">: <strong><?= esc(date('l, j F Y H:i:s', $request_date)); ?></strong></th>
    </tr>
    <tr>
        <th width="10%">Phone</th>
        <?php if (!empty($customer['phone'])) : ?>
            <th width="40%">: <strong><?= esc($customer['phone']); ?></strong></th>
        <?php else : ?>
            <th width="40%">: <i>(profil is incomplete)</i></th>
        <?php endif; ?>
    </tr>
</table>
<br> <br>
<span><b>Reservation Detail</b></span><br>
<table>

    <tr>
        <th width="20%">Homestay Name</th>
        <th width="60%">: <?= esc($homestay['name']); ?></th>
    </tr>
    <tr>
        <th width="20%">Unit Type</th>
        <th width="60%">: <?= esc($homestay['unit_type']); ?></th>
    </tr>
    <tr>
        <th width="20%">Check In</th>
        <?php $check_in = strtotime($reservation['check_in']); ?>
        <th width="60%">: <?= esc(date('l, j F Y H:i:s', $check_in)); ?></th>
    </tr>
    <tr>
        <th width="20%">Check Out</th>
        <th width="60%">: <?= esc(date('l, j F Y H:i:s', strtotime($reservation['check_out']))); ?></th>
    </tr>
    <tr>
        <th width="20%">Day of Stay</th>
        <th width="60%">: <?= esc($reservation['day_of_stay']); ?> days</th>
    </tr>
    <tr>
        <th width="20%">Total People</th>
        <th width="60%">: <?= esc($reservation['total_people']); ?> people</th>
    </tr>
</table>
<br><br>
<table id="tb-item" cellpadding="4">
    <tr style="background-color:#a9a9a9">
        <th width="38%" style="height: 20px"><strong>Unit Name</strong></th>
        <th width="10%" style="height: 20px"><strong>Capacity</strong></th>
        <th width="30%" style="height: 20px"><strong>Unit Price</strong></th>
        <th width="18%" style="height: 20px"><strong>Total Price</strong></th>
    </tr>
    <?php foreach ($homestay_unit as $unit) : ?>
        <tr>
            <td><?= esc($unit['name']); ?></td>
            <td style="height: 20px;text-align:center"><?= esc($unit['capacity']); ?></td>
            <td style="height: 20px;text-align:right"><?= 'Rp' . number_format(esc($unit['price']), 0, ',', '.'); ?>/day</td>
            <td style="height: 20px;text-align:right"><?= 'Rp' . number_format(esc($unit['price'] * $reservation['day_of_stay']), 0, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php if ($reservation_additional_amenities != null) : ?>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="background-color:#a9a9a9">
            <th width="28%" style="height: 20px"><strong>Additional Amenities</strong></th>
            <th width="20%" style="height: 20px"><strong>Order Detail</strong></th>
            <th width="10%" style="height: 20px"><strong>Total Order</strong></th>
            <th width="20%" style="height: 20px"><strong>Price</strong></th>
            <th width="18%" style="height: 20px"><strong>Total Price</strong></th>
        </tr>
        <?php foreach ($reservation_additional_amenities as $activity) : ?>
            <tr>
                <td><?= esc($activity['name']); ?></td>
                <td style="height: 20px;"><?= ($activity['day_order'] != '0') ? 'Day Order : ' . $activity['day_order'] : '' ?><?= ($activity['person_order'] != '0') ? '<br>Person Order : ' . $activity['person_order'] : '' ?><?= ($activity['room_order'] != '0') ? '<br>Room Order : ' . $activity['room_order'] : '' ?><?= (($activity['day_order'] == '0') && ($activity['person_order'] == '0') && ($activity['room_order'] == '0')) ? '-'  : '' ?></td>
                <td style="height: 20px;text-align:center"><?= esc($activity['total_order']); ?></td>
                <td style="height: 20px;text-align:right"><?= 'Rp' . number_format(esc($activity['price']), 0, ',', '.'); ?></td>
                <td style="height: 20px;text-align:right"><?= 'Rp' . number_format(esc($activity['total_price']), 0, ',', '.'); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (isset($package)) : ?>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="background-color:#a9a9a9">
            <th width="35%" style="height: 20px"><strong>Name Package</strong></th>
            <th width="12%" style="height: 20px"><strong>Capacity</strong></th>
            <th width="10%" style="height: 20px"><strong>Total People</strong></th>
            <th width="7%" style="height: 20px;text-align:center"><strong>Qty</strong></th>
            <th width="14%" style="height: 20px"><strong>Package Price</strong></th>
            <th width="18%" style="height: 20px"><strong>Total Price</strong></th>
        </tr>
        <tr>
            <td style="height: 20px">Package <?= esc($package['name']); ?></td>
            <td style="height: 20px; text-align:center"><?= esc($package['min_capacity']); ?></td>
            <td style="height: 20px; text-align:center"><?= esc($reservation['total_people']); ?></td>
            <?php
            if ($package['min_capacity'] == 0) {
                $packageOrder = 1;
            } else {
                $packageOrder = $reservation['total_people'] / $package['min_capacity'];
                if ($packageOrder < 1) {
                    $packageOrder = 1;
                } elseif (($reservation['total_people'] % $package['min_capacity'] <= $package['min_capacity'] / 2) && ($reservation['total_people'] % $package['min_capacity'] > 0)) {
                    $packageOrder = floor($packageOrder) + 0.5;
                } elseif ($reservation['total_people'] % $package['min_capacity'] > $package['min_capacity'] / 2) {
                    $packageOrder = floor($packageOrder) + 1;
                }
            }
            ?>
            <td style="height: 20px;text-align:center"><?= $packageOrder; ?></td>
            <td style="height: 20px;text-align:right"><?= 'Rp' . number_format(esc($package['price']), 0, ',', '.'); ?></td>
            <td style="height: 20px;text-align:right"><?= 'Rp' . number_format(esc($package['price'] * $packageOrder), 0, ',', '.'); ?></td>
        </tr>
    <?php endif; ?>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr style="border:1px solid #000">
        <td width="78%" style="height: 20px"><strong>Grand Total</strong></td>
        <td width="18%" style="height: 20px;text-align:right"><strong><?= 'Rp' . number_format(esc($reservation['total_price']), 0, ',', '.'); ?></strong></td>
    </tr>
    <tr style="border:1px solid #000">
        <td width="78%" style="height: 20px"><strong>Deposit</strong></td>
        <td width="18%" style="height: 20px;text-align:right"><strong><?= 'Rp' . number_format(esc($reservation['deposit']), 0, ',', '.'); ?></strong></td>
    </tr>
    <tr style="border:1px solid #000">
        <td width="78%" style="height: 20px"><strong>Coin Used</strong></td>
        <td width="18%" style="height: 20px;text-align:right"><strong><?= '-Rp' . number_format(esc($reservation['coin_use']), 0, ',', '.'); ?></strong></td>
    </tr>
    <tr style="border:1px solid #000">
        <td width="78%" style="height: 20px"><strong>Grand Total After Using Coin</strong></td>
        <td width="18%" style="height: 20px;text-align:right"><strong><?= 'Rp' . number_format(esc($reservation['total_price'] - $reservation['coin_use']), 0, ',', '.'); ?></strong></td>
    </tr>
    <?php if ($reservation['canceled_at'] == null) : ?>
        <tr style="border:1px solid #000">
            <td width="78%" style="height: 20px"><strong>Full Pay</strong></td>
            <td width="18%" style="height: 20px;text-align:right"><strong><?= 'Rp' . number_format(esc($reservation['total_price'] - $reservation['deposit'] - $reservation['coin_use']), 0, ',', '.'); ?></strong></td>
        </tr>
    <?php endif; ?>
    <?php if ($reservation['is_refund'] == '1') : ?>
        <tr style="border:1px solid #000">
            <td width="78%" style="height: 20px"><strong>Refund</strong></td>
            <td width="18%" style="height: 20px;text-align:right"><strong><?= 'Rp' . number_format(esc(50 / 100 * $reservation['deposit']), 0, ',', '.'); ?></strong></td>
        </tr>
    <?php elseif ($reservation['is_refund'] == '0') : ?>
        <tr style="border:1px solid #000">
            <td width="78%" style="height: 20px"><strong>Refund</strong></td>
            <td width="18%" style="height: 20px;text-align:right"><strong><?= 'Rp' . number_format(esc(0), 0, ',', '.'); ?></strong></td>
        </tr>
    <?php endif; ?>
</table>
<br>
<br>
<br>

<table cellpadding="0">
    <?php $confirmation_date = strtotime($reservation['confirmed_at']); ?>
    <?php if ($reservation['refund_paid_at']) : ?>
        <?php $refund_date = strtotime($reservation['refund_paid_at']); ?>
    <?php endif; ?>

    <tr>
        <th width="25%">Confirmation </th>
        <?php if (!empty($reservation['confirmed_at'])) : ?>
            <th width="70%">: Confirmation on <strong><?= esc(date('l, j F Y H:i:s', $confirmation_date)); ?></strong> <br> (by homestay owner)</th>
        <?php else : ?>
            <th width="70%">: Incomplete</th>
        <?php endif; ?>
    </tr>
    <?php if ($reservation['is_refund'] == '1') : ?>
        <tr>
            <th width="25%">Refund </th>
            <?php if (!empty($reservation['refund_proof'])) : ?>
                <th width="70%">: Complete on <strong><?= esc(date('l, j F Y H:i:s', $refund_date)); ?></strong> <br> (by homestay owner)</th>
            <?php else : ?>
                <th width="70%">: Please wait, admin will send to your account</th>
            <?php endif; ?>
        </tr>
    <?php endif; ?>
    <br>
    <tr>
        <th width="25%"> Status </th>
        <?php if (($reservation['status'] == '1') && ($reservation['canceled_at'] == null)) : ?>
            <th width="20%" style="background-color:#34ebd5">: Pay Deposit</th>
        <?php elseif (($reservation['status'] == 'Deposit Pending') && ($reservation['canceled_at'] == null)) : ?>
            <th width="20%" style="background-color:#e1eb34">: Deposit Pending</th>
        <?php elseif (($reservation['status'] == 'Deposit Successful') && ($reservation['canceled_at'] == null)) : ?>
            <th width="20%" style="background-color:#30ab3a">: Deposit Successful</th>
        <?php elseif (($reservation['status'] == 'Full Pay Pending') && ($reservation['canceled_at'] == null)) : ?>
            <th width="20%" style="background-color:#e1eb34">: Full Pay Pending</th>
        <?php elseif (($reservation['status'] == 'Full Pay Successful') && ($reservation['canceled_at'] == null)) : ?>
            <th width="20%" style="background-color:#30ab3a">: Full Pay Successful</th>
        <?php elseif (($reservation['status'] == 'Done') && ($reservation['canceled_at'] == null)) : ?>
            <th width="20%" style="background-color:#6772ab">: Done</th>
        <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '0')) : ?>
            <th width="20%" style="background-color:#F78CA2">: Reservation Canceled</th>
    </tr>
    <tr>
        <?php if ($reservation['cancelation_reason'] == '1') : ?>
            <th></th>
            <th> <i>(canceled by customer)</i></th>
        <?php elseif ($reservation['cancelation_reason'] == '2') : ?>
            <th></th>
            <th width="40%"> <i>(deposit payment has exceeded the deadline)</i></th>
        <?php elseif ($reservation['cancelation_reason'] == '3') : ?>
            <th></th>
            <th width="40%"> <i>(full payment has exceeded the deadline)</i></th>
        <?php endif; ?>
    <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] == null)) : ?>
        <th width="40%" style="background-color:#F78CA2">: Waiting for the homestay owner to pay refund</th>
    <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] != null) && ($reservation['refund_paid_confirmed_at'] == null)) : ?>
        <th width="40%" style="background-color:#F78CA2">: Waiting for the customer to confirm refund</th>
    <?php elseif (($reservation['canceled_at'] != null) && ($reservation['is_refund'] == '1') && ($reservation['refund_proof'] != null) && ($reservation['refund_paid_confirmed_at'] != null)) : ?>
        <th width="20%" style="background-color:#F78CA2">: Reservation Canceled</th>
    </tr>
    <tr>
        <?php if ($reservation['cancelation_reason'] == '1') : ?>
            <th></th>
            <th> <i>(canceled by customer)</i></th>
        <?php elseif ($reservation['cancelation_reason'] == '2') : ?>
            <th></th>
            <th width="40%"> <i>(deposit payment has exceeded the deadline)</i></th>
        <?php elseif ($reservation['cancelation_reason'] == '3') : ?>
            <th></th>
            <th width="40%"> <i>(full payment has exceeded the deadline)</i></th>
        <?php endif; ?>
    <?php endif; ?>
    </tr>
</table>
<table cellpadding="4">
    <tr>
        <td width="50%" style="height: 20px;text-align:center">
            <p>&nbsp;</p>
        </td>
        <td width="50%" style="height: 20px;text-align:center">
            <?php $date = date('Y-m-d H:i');
            $date_now = strtotime($date); ?>
            <p><?= esc(date('j F Y', $date_now)); ?></p>
            <p>Best regards,</p>
            <p></p>
            <p>Chief of <?= esc($village['name']) ?></p>
        </td>
    </tr>
</table>