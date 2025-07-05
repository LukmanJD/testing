<?= $this->extend('web/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section text-dark">
    <!-- <style>
        .seven-days-weather {
            padding: 10px 0;
        }

        .weather-item {
            min-width: 120px;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .weather-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .weather-img {
            width: 50px;
            height: 50px;
        }

        .date-box {
            font-size: 0.9rem;
        }

        .weather-description span {
            font-size: 0.8rem;
            padding: 4px 8px;
        }

        .temperature-box {
            font-size: 0.85rem;
        }

        .temp-min,
        .temp-max {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .overflow-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style> -->
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';

            function checkRequired(event) {
                event.preventDefault();

                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);

                if (!checkedOne) {
                    Swal.fire('Please select at least 1 unit to make reservation!');
                    return false;
                }

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


        <!-- <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="seven-days-weather">
                        <h5 class="card-title mb-3">Prediksi Cuaca hingga 14 Hari ke Depan</h5>
                        <div class="overflow-auto">
                            <ul class="list-unstyled d-flex">
                                <?php foreach ($weather_dates as $index => $date): ?>
                                    <li class="mx-3 text-center weather-item">
                                        <div class="date-box mb-2">
                                            <strong><?= $date ?></strong>
                                        </div>
                                        <div class="weather-icon mb-2">
                                            <img src="<?= $weather_icons[$index] ?>" alt="Weather Icon" class="weather-img">
                                        </div>
                                        <div class="weather-description mb-2">
                                            <span class="badge bg-light text-dark">
                                                <?= $weather_descriptions[$index] ?? 'N/A' ?>
                                            </span>
                                        </div>
                                        <div class="temperature-box">
                                            <div class="temp-min mb-1">
                                                <i class="bi bi-thermometer-low"></i>
                                                <span><?= $weather_data['temperature_2m_min'][$index] ?? 'N/A' ?>°C</span>
                                            </div>
                                            <div class="temp-max">
                                                <i class="bi bi-thermometer-high"></i>
                                                <span><?= $weather_data['temperature_2m_max'][$index] ?? 'N/A' ?>°C</span>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Object Detail Information -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title"><?= esc($title); ?> for Personal</h4>
                        </div>
                        <div class="col">
                            <button form="reservation-form" type="submit" class="float-end btn btn-primary">Make Reservation</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="reservation-form" class="form form-vertical" action="" method="post" enctype="multipart/form-data" onsubmit="checkRequired(event)">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-5 col-12" style="border-right: 1px dashed #333;">
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
                                        <input type="number" id="day_of_stay" class="form-control" name="day_of_stay" onchange="getCheckOut(this.value)" min="1" value="" required>
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
                                    <fieldset class="form-group mb-4 col-md-5 col-12">
                                        <label for="unit_type" class="mb-2">Unit Type</label>
                                        <select class="form-select" id="unit_type" name="unit_type" onchange="getUnitType('<?= esc($homestay_id); ?>')" required>
                                            <option value="" selected disabled>--Choose Unit Type--</option>
                                            <option value="1">Room</option>
                                            <option value="2">Villa</option>
                                            <option value="3">Hall</option>
                                        </select>
                                    </fieldset>
                                    <div class="form-group mb-4 col-md-4 col-12">
                                        <label for="name" class="mb-2">Total People</label>
                                        <input type="number" id="total_people" class="form-control" name="total_people" min="1" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-7 col-12" id="unit-available">
                                    <div class="text-center mb-3">
                                        <span class="fw-bold">Unit Available</span>
                                    </div>
                                    <div id="units-available" required>
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