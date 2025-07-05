<?= $this->extend('maps/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-center">Attraction Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Address</td>
                                        <td><?= esc($data['address']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Open</td>
                                        <td><?= date('H:i', strtotime(esc($data['open']))) . ' WIB'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Close</td>
                                        <td><?= date('H:i', strtotime(esc($data['close']))) . ' WIB'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Contact Person</td>
                                        <td><?= esc($data['phone']); ?> (<?= esc($data['employee_name']); ?>)</td>
                                    </tr>
                                    <?php if (empty($ticket_prices)) : ?>
                                        <tr>
                                            <td class="fw-bold">Ticket Prices</td>
                                            <td>Free <a class="float-end" data-bs-toggle="modal" data-bs-target="#insertService"></td>
                                        </tr>
                                    <?php else : ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless text-dark">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold" colspan="3">List of Ticket Prices</td>
                                    </tr>
                                    <?php $no = 1; ?>
                                    <?php foreach ($ticket_prices as $ticket_price) : ?>
                                        <tr style="font-size: 15px;">
                                            <td><?= esc($no); ?></td>
                                            <td><?= esc($ticket_price['name']); ?></td>
                                            <?php if ($ticket_price['price'] == "0") : ?>
                                                <td>Free</td>
                                            <?php else : ?>
                                                <td>Rp <?= number_format(esc($ticket_price['price']), 0, ',', '.'); ?></td>
                                            <?php endif; ?>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <tr>
                                    <td class="fw-bold" colspan="3">Description</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><?= esc($data['description']); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Description</p>
                            <p><?= esc($data['description']); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">Facilities</p>
                            <?php $i = 1; ?>
                            <?php foreach ($data['facilities'] as $facility) : ?>
                                <p><?= esc($i) . '. ' . esc($facility); ?></p>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Object Media -->
            <?= $this->include('web/layouts/gallery_video'); ?>
        </div>
    </div>
</section>

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