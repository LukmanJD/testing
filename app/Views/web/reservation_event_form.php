<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section text-dark">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';

            function checkRequired(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure about the weather predictions for that day?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "OK",
                    denyButtonText: `Cancel`
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    } else if (result.isDenied) {
                        return false;
                    }
                });
            }
        </script>

        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="seven-days-weather">
                        <p>Weather Forecast up to 14 Days Ahead</p>
                        <div class="overflow-auto">
                            <ul class="list-unstyled d-flex">
                                <?php foreach ($weather_dates as $index => $date): ?>
                                    <li class="mx-3 text-center">
                                        <strong><?= $date ?></strong>
                                        <img src="<?= $weather_icons[$index] ?>" alt="Weather Icon">
                                        <div class="weather-desc mb-2">
                                            <?= $weather_data['weather_descriptions'][$index] ?? 'N/A' ?>
                                        </div>
                                        <span>Min: <?= $weather_data['temperature_2m_min'][$index] ?? 'N/A' ?>°C</span>
                                        <span>Max: <?= $weather_data['temperature_2m_max'][$index] ?? 'N/A' ?>°C</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Object Detail Information -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title"><?= esc($title); ?> for Event</h4>
                        </div>
                        <div class="col">
                            <button form="reservation-form" type="submit" class="float-end btn btn-primary">Make Reservation</button>
                        </div>
                    </div>
                </div>
                <?php if (session()->getFlashdata('failed')): ?>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "<?= session()->getFlashdata('failed') ?> is unavailable",
                            text: "Please  check unavailable date first!",
                        });
                    </script>
                <?php endif; ?>
                <div class="card-body">
                    <form id="reservation-form" class="form form-vertical" action="" method="post" enctype="multipart/form-data" onsubmit="checkRequired(event)">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-8 col-12">
                                    <div class="form-group mb-4">
                                        <a class="btn btn-success" data-bs-toggle="modal" data-bs-target="#dateDisable">See Unavailable Date</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7 col-12">
                                            <div class="form-group mb-4">
                                                <label for="check_in" class="mb-2">Check In</label>
                                                <div class="input-group">
                                                    <input type="date" id="check_in" class="form-control" name="check_in" onchange="getCheckOut2()" value="" required>
                                                    <input type="time" class="form-control" id="check_in_time" value="14:00" required disabled>
                                                    <script>
                                                        function getCheckOut2() {
                                                            const dayOfStay = document.getElementById("day_of_stay");
                                                            if (dayOfStay.value != 0) {
                                                                getCheckOut(dayOfStay.value);
                                                            }
                                                        }
                                                    </script>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#units-available').hide();
                                                        });
                                                    </script>
                                                    <script>
                                                        var date = new Date();
                                                        date.setDate(date.getDate() + 3);

                                                        let year = date.getFullYear();
                                                        let month = date.getMonth() + 1;
                                                        if (month < 10) {
                                                            month = '0' + month;
                                                        }
                                                        let daydate = date.getDate();
                                                        if (daydate < 10) {
                                                            daydate = '0' + daydate;
                                                        }
                                                        let minDate = year + '-' + month + '-' + daydate;

                                                        const checkInInput = document.getElementById("check_in");
                                                        checkInInput.setAttribute("min", minDate);
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-12">
                                            <div class="form-group mb-4">
                                                <label for="check_out" class="mb-2">Check Out</label>
                                                <div class="input-group">
                                                    <input type="datetime-local" id="check_out" class="form-control" name="check_out" value="" disabled required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4 col-md-4 col-12">
                                        <label for="name" class="mb-2">Day of Stay</label>
                                        <div class="input-group">
                                            <input type="number" id="day_of_stay" class="form-control" name="day_of_stay" onchange="getCheckOut(this.value)" min="1" value="" required>
                                            <span class="input-group-text">Days</span>
                                        </div>
                                        <script>
                                            function getCheckOut(val) {
                                                const dayOfStay = document.getElementById("day_of_stay");
                                                const checkOutInput = document.getElementById("check_out");
                                                let checkInVal = checkInInput.value;
                                                if (checkInVal === '') {
                                                    Swal.fire('Please insert check in date first!');
                                                    dayOfStay.value = "";
                                                } else {
                                                    var checkInDate = new Date(checkInInput.value);
                                                    checkInDate.setDate(checkInDate.getDate() + parseInt(dayOfStay.value));
                                                    let coyear = checkInDate.getFullYear();
                                                    let comonth = checkInDate.getMonth() + 1;
                                                    if (comonth < 10) {
                                                        comonth = '0' + comonth;
                                                    }
                                                    let codaydate = checkInDate.getDate();
                                                    if (codaydate < 10) {
                                                        codaydate = '0' + codaydate;
                                                    }

                                                    let checkOutVal = coyear + '-' + comonth + '-' + codaydate + 'T12:00';
                                                    checkOutInput.value = checkOutVal;
                                                }
                                                getUnitType('<?= esc($homestay_id); ?>');
                                            }
                                        </script>
                                    </div>
                                    <div class="form-group mb-4 col-md-4 col-12">
                                        <label for="name" class="mb-2">Total People</label>
                                        <div class="input-group">
                                            <input type="number" min="1" max="<?= esc($max_people_for_event) ?>" id="total_people" class="form-control" name="total_people" min="1" value="" required>
                                            <span class="input-group-text">People</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="dateDisable" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateModalLabel">List of Unavailable Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="dateList" class="list-group">
                        <?php if ($date_disabled) : ?>
                            <?php foreach ($date_disabled as $disabled_date) : ?>
                                <p><?= esc(date('d F Y', strtotime($disabled_date))) ?></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <center>
                                <p>
                                    All dates available
                                </p>
                            </center>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>