<?php
$uri = service('uri')->getSegments();
$edit = in_array('edit', $uri);
?>

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

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-7 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title">Package Information</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('dashboard/tourismPackage/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col table-responsive">
                        <table class="table table-borderless text-dark">
                            <tbody>
                                <tr>
                                    <td class="fw-bold">ID</td>
                                    <td><?= esc($data['id']); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Name</td>
                                    <td><?= esc($data['name']); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Minimum Capacity</td>
                                    <td><?= esc($data['min_capacity']); ?> people</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Price</td>
                                    <td><?= esc("Rp " . number_format($data['price'], 0, ',', '.')); ?></td>
                                </tr>
                                <?php if ($data['brochure_url'] != null) : ?>
                                    <tr>
                                        <td class="fw-bold">Brochure</td>
                                        <td><a href="/media/photos/<?= esc($data['brochure_url']) ?>" target="_blank">See Brochure</a></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="fw-bold">Description</td>
                                    <td><?= esc($data['description']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="ms-2 my-3 ">
                            <span class="fw-bold">Service Included</span>
                            <?php if (!empty($list_service)) : ?>
                                <?php foreach ($list_service as $service) : ?>
                                    <?php if ($service['status'] == '1') : ?>
                                        <li><?= esc($service['name']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="ms-2">
                            <span class="fw-bold">Service Excluded</span>
                            <?php if (!empty($list_service)) : ?>
                                <?php foreach ($list_service as $service) : ?>
                                    <?php if ($service['status'] == '0') : ?>
                                        <li><?= esc($service['name']); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="accordion mt-3" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        Package Activity
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <?php foreach ($list_day as $day) : ?>
                                            <div class="mt-3">
                                                <span class="fw-bold">Day <?= esc($day['day']); ?></span>
                                                <ol type="1">
                                                    <?php foreach ($list_activity as $activity) : ?>
                                                        <?php if ($activity['day'] == $day['day']) : ?>
                                                            <li><?= esc($activity['object_name']); ?>
                                                                <?php if ($activity['description'] != null) : ?>
                                                                    <?= esc(' : ' . $activity['description']); ?>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ol>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Google Maps</h4>
                    <?= $this->include('web/layouts/map-head'); ?>
                </div>
                <?= $this->include('web/layouts/map-body'); ?>
                <div class="card-body">
                    <div class="col-auto ">
                        <br>
                        <div class="btn-group float-right" role="group">
                            <?php foreach ($list_day as $d) : ?>
                                <?php $loop = 0; ?>
                                <script>
                                    function add<?= $d['day'], $d['package_id']; ?>() {

                                        initMap();
                                        map.setZoom(15);
                                        <?php
                                        $activitiesForDay = array_filter($list_activity, function ($list_activity) use ($d) {
                                            return $list_activity['day'] === $d['day'];
                                        });

                                        $activitiesForDayy = $activitiesForDay;

                                        $hs = [
                                            'id_object' => $homestay['id'],
                                            'lat' => $homestay['lat'],
                                            'lng' => $homestay['lng'],
                                        ];

                                        array_unshift($activitiesForDayy, $hs);
                                        array_push($activitiesForDayy, $hs);

                                        foreach ($activitiesForDayy as $object) {
                                            $loop++;

                                            $lat_now = isset($object['lat']) ? esc($object['lat']) : '';
                                            $lng_now = isset($object['lng']) ? esc($object['lng']) : '';
                                            $objectid = isset($object['id_object']) ? esc($object['id_object']) : '';
                                        ?>
                                            objectMarkerRoute("<?= $objectid; ?>", <?= $lat_now; ?>, <?= $lng_now; ?>, true, <?= $loop; ?>);

                                            <?php
                                            if (1 < $loop) { ?>

                                                // new01(<?= $lat_bef; ?>, <?= $lng_bef; ?>, <?= $lat_now; ?>, <?= $lng_now; ?>);
                                                pointA<?= $loop; ?> = new google.maps.LatLng(<?= $lat_bef; ?>, <?= $lng_bef; ?>);
                                                pointB<?= $loop; ?> = new google.maps.LatLng(<?= $lat_now; ?>, <?= $lng_now; ?>);
                                                directionsService<?= $loop; ?> = new google.maps.DirectionsService;
                                                directionsDisplay<?= $loop; ?> = new google.maps.DirectionsRenderer({
                                                    suppressMarkers: true,
                                                    map: map
                                                });
                                                directionsService<?= $loop; ?>.route({
                                                    origin: pointA<?= $loop; ?>,
                                                    destination: pointB<?= $loop; ?>,
                                                    avoidTolls: true,
                                                    avoidHighways: false,
                                                    travelMode: google.maps.TravelMode.DRIVING
                                                }, function(response, status) {
                                                    if (status == google.maps.DirectionsStatus.OK) {
                                                        directionsDisplay<?= $loop; ?>.setDirections(response);
                                                    } else {
                                                        window.alert('Directions request failed due to ' + status);
                                                    }
                                                });

                                            <?php
                                            }
                                            ?>
                                            <?php
                                            $lat_bef = $lat_now;
                                            $lng_bef = $lng_now;
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    }
                                </script>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" type="button" aria-expanded="false" onclick="add<?= $d['day'], $d['package_id']; ?>();">Day <?= $d['day']; ?> Route</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php if (!empty($activitiesForDay)) :  ?>
                                            <?php
                                            $first = array_values($activitiesForDay)[0];
                                            ?>
                                            <li><button type="button" onclick="routeBetweenObjects( <?= $homestay['lat'] ?>, <?= $homestay['lng'] ?>, <?= $first['lat'] ?>, <?= $first['lng'] ?>)" class="btn btn-outline-primary"><i class="fa fa-road"></i> Homestay ke Activity 1</button></a></li>
                                            <?php foreach ($activitiesForDay as $index => $currentActivity) : ?>
                                                <?php $loop++; ?>
                                                <?php if ($currentActivity['day'] === $d['day']) : ?>

                                                    <?php if (isset($activitiesForDay[$index + 1])) :
                                                        $nextActivity = $activitiesForDay[$index + 1];
                                                    ?>
                                                        <li><button type="button" onclick="routeBetweenObjects( <?= $currentActivity['lat'] ?>, <?= $currentActivity['lng'] ?>, <?= $nextActivity['lat'] ?>, <?= $nextActivity['lng'] ?>)" class="btn btn-outline-primary"><i class="fa fa-road"></i> Activity <?= esc($currentActivity['activity']); ?> ke <?= esc($nextActivity['activity']); ?></button></a></li>

                                                    <?php endif; ?>

                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php
                                            $last = end($activitiesForDay);
                                            ?>
                                            <li><button type="button" onclick="routeBetweenObjects( <?= $last['lat'] ?>, <?= $last['lng'] ?>, <?= $homestay['lat'] ?>, <?= $homestay['lng'] ?>)" class="btn btn-outline-primary"><i class="fa fa-road"></i> Activity <?= esc($nextActivity['activity']) ?> ke Homestay</button></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="row" id="direction-row">
                    <div class="col-md-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title text-center">Directions</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 table-lg">
                                        <thead>
                                            <tr>
                                                <th>Distance (m)</th>
                                                <th>Steps</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-direction">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    map.setZoom(15);
                </script>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-media-preview@1.0.11/dist/filepond-plugin-media-preview.min.js"></script>
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="<?= base_url('assets/js/extensions/form-element-select.js'); ?>"></script>
<script>
    getFacility();
</script>
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

    function checkRequired(event) {
        if (!$('#geo-json').val()) {
            event.preventDefault();
            Swal.fire('Please select location for the New Rumah Gadang');
        }
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

    <?php if ($edit && count($data['gallery']) > 0) : ?>
        pond.addFiles(
            <?php foreach ($data['gallery'] as $gallery) : ?> `<?= base_url('media/photos/' . $gallery); ?>`,
            <?php endforeach; ?>
        );
    <?php endif; ?>
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
<?= $this->endSection() ?>