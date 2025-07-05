<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section text-dark">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Package Available</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <a title="Detail Package" class="btn icon btn-primary btn-sm me-1 mb-3" href="/web/reservation/package/custom/<?= esc($h_id) ?>/<?= esc($reservation_id) ?>">
                        <i class="fa-solid fa-plus"></i> Custom Package
                    </a>
                    <?php if (!empty($package)) : ?>
                        <?php foreach ($package as $item) : ?>
                            <div class="card border mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3 d-flex align-items-center justify-content-center">
                                        <img src="/media/photos/<?= esc($item['brochure_url']) ?>" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 210px;">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= esc($item['name']) ?></h5>
                                            <?php
                                            for ($i = 0; $i < (int)esc($item['avg_rating']); $i++) {
                                            ?>
                                                <i name="rating" class="fas fa-star text-warning" aria-hidden="true"></i>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            for ($i = 0; $i < (5 - (int)esc($item['avg_rating'])); $i++) {
                                            ?>
                                                <i name="rating" class="far fa-star" aria-hidden="true"></i>
                                            <?php
                                            }
                                            ?>
                                            <p class="card-text">Package Day : <?= esc($item['total_day']) ?> day <br>
                                                Minimun Capacity : <?= esc($item['min_capacity']) ?> people</p>
                                            <div class="row">
                                                <div class="col">
                                                    <p class="card-text"><small class="text-dark"><?= esc("Rp " . number_format($item['price'], 0, ',', '.')); ?></small></p>
                                                </div>
                                                <div class="col">
                                                    <a title="Buy Package" class="btn icon btn-success btn-sm float-end me-1" data-bs-toggle="modal" data-bs-target="#buyPackage<?= esc($item['id']) ?>">
                                                        <i class="fa-solid fa-dollar-sign"></i> Buy
                                                    </a>
                                                    <a title="Extend Package" class="btn icon btn-primary btn-sm float-end me-1" href="/web/reservation/package/extend/<?= esc($h_id) ?>/<?= esc($reservation_id) ?>/<?= esc($item['id']) ?>">
                                                        <i class="fa-solid fa-square-plus"></i> Extend
                                                    </a>
                                                    <a title="Detail Package" class="btn icon btn-info btn-sm float-end me-1" href="/web/homestayPackage/detail/<?= esc($item['homestay_id']) ?>/<?= esc($item['id']) ?>" target="_blank">
                                                        <i class="fa-solid fa-circle-info"></i> Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Package -->
    <?php if (!empty($package)) : ?>
        <?php foreach ($package as $item) : ?>
            <div class="modal fade" id="buyPackage<?= esc($item['id']) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Buy Package</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">Package Name</td>
                                            <td><?= esc($item['name']); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Minimum Capacity</td>
                                            <td><?= esc($item['min_capacity']); ?> People</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Package Price</td>
                                            <td><?= esc("Rp " . number_format($item['price'], 0, ',', '.')); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <form class="form form-vertical" action="/web/reservation/package/buy/<?= esc($h_id) ?>/<?= esc($reservation_id) ?>/<?= esc($item['id']) ?>" method="post" onsubmit="checkRequired()" enctype="multipart/form-data">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="price" class="mb-2">Total People</label>
                                            <div class="input-group">
                                                <input type="number" value="<?= esc($total_people); ?>" id="total_people" class="form-control" name="total_people" placeholder="Total People" aria-label="Price" aria-describedby="price" min="1" onchange="getPrice(this.value,'<?= esc($item['min_capacity']); ?>','<?= esc($item['price']); ?>','<?= esc($item['id']); ?>')" readonly required>
                                                <span class="input-group-text">people</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="price" class="mb-2">Package Order</label>
                                            <div class="input-group">
                                                <input type="number" id="package_order[<?= esc($item['id']) ?>]" class="form-control" placeholder="Package Order" aria-label="Price" aria-describedby="price" readonly required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="price" class="mb-2">Total Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" id="total_price[<?= esc($item['id']) ?>]" class="form-control" placeholder="Total Price" aria-label="Price" aria-describedby="price" readonly required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-1 my-3">Buy</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    getPrice('<?= esc($total_people); ?>', '<?= esc($item['min_capacity']); ?>', '<?= esc($item['price']); ?>', '<?= esc($item['id']); ?>')
                });
            </script>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
    function getPrice(val, min_capacity, price, id) {

        let packageOrderVal = val / min_capacity;

        if (packageOrderVal < 1) {
            packageOrderVal = 1;
        } else if (val % min_capacity <= min_capacity / 2 && val % min_capacity > 0) {
            packageOrderVal = Math.floor(packageOrderVal) + 0.5;
        } else if (val % min_capacity > min_capacity / 2) {
            packageOrderVal = Math.floor(packageOrderVal) + 1;
        }

        let totalPriceVal = packageOrderVal * price;

        setPrice(packageOrderVal, totalPriceVal, id);

        console.log(packageOrderVal);
        console.log(totalPriceVal);

    }

    function setPrice(packageOrderVal, totalPriceVal, id) {
        const packageOrder = document.getElementById("package_order[" + id + "]");
        const totalPrice = document.getElementById("total_price[" + id + "]");

        packageOrder.value = packageOrderVal;
        totalPrice.value = totalPriceVal;
    }
</script>
<?= $this->endSection() ?>