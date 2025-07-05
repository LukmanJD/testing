<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section text-dark">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';

            function checkRequired(event) {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
                if (!checkedOne) {
                    event.preventDefault();
                    Swal.fire('Please select at least 1 unit to make reservation!');
                }
            }
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title"><?= esc($title); ?></h4>
                        </div>
                        <div class="col">
                            <button form="reservation-form" type="submit" class="float-end btn btn-primary">Make Reservation</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="reservation-form" class="form form-vertical" action="/dashboard/reservation/<?= esc($homestayid); ?>" method="post" enctype="multipart/form-data" onsubmit="checkRequired(event)">
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
                                                        // var date = new Date();
                                                        // date.setDate(date.getDate() + 3);

                                                        // let year = date.getFullYear();
                                                        // let month = date.getMonth() + 1;
                                                        // if (month < 10) {
                                                        //     month = '0' + month;
                                                        // }
                                                        // let daydate = date.getDate();
                                                        // if (daydate < 10) {
                                                        //     daydate = '0' + daydate;
                                                        // }
                                                        // let minDate = year + '-' + month + '-' + daydate;

                                                        // const checkInInput = document.getElementById("check_in");
                                                        // checkInInput.setAttribute("min", minDate);

                                                        // Get today's date
                                                        const today = new Date();

                                                        // Format the date as YYYY-MM-DD
                                                        const year = today.getFullYear();
                                                        const month = String(today.getMonth() + 1).padStart(2, '0'); // Add leading zero
                                                        const day = String(today.getDate()).padStart(2, '0'); // Add leading zero

                                                        // Set the value as min for the input
                                                        const minDate = `${year}-${month}-${day}`;
                                                        // document.getElementById('check_in').setAttribute('min', minDate);
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
                                                getUnitType('<?= esc($homestayid); ?>');
                                            }
                                        </script>
                                    </div>
                                    <fieldset class="form-group mb-4 col-md-5 col-12">
                                        <label for="unit_type" class="mb-2">Unit Type</label>
                                        <select class="form-select" id="unit_type" name="unit_type" onchange="getUnitType('<?= esc($homestayid); ?>')" required>
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