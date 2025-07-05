<?= $this->extend('dashboard/layouts/main'); ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="row">
        <script>
            currentUrl = '<?= current_url(); ?>';
        </script>

        <!-- Object Detail Information -->
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title text-center">Event Information</h4>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('dashboard/event/edit'); ?>/<?= esc($data['id']); ?>" class="btn btn-primary float-end"><i class="fa-solid fa-pencil me-3"></i>Edit</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Name</td>
                                        <td><?= esc($data['name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Ticket Price</td>
                                        <td><?= 'Rp ' . number_format(esc($data['ticket_price']), 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Event Organizer</td>
                                        <td><?= esc($data['event_organizer']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Contact Person</td>
                                        <td><?= esc($data['phone']); ?></td>
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
                            <p class="fw-bold">Calendar</p>
                            <div class="table-responsive">
                                <table class="table table-hover" id="table-manage">
                                    <thead>
                                        <tr>
                                            <th>Event Date<a class="float-end" data-bs-toggle="modal" data-bs-target="#insertService"><i class="fa-solid fa-add"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($list_date)) : ?>
                                            <?php foreach ($list_date as $date) : ?>
                                                <tr>
                                                    <td><?= date('d F Y', strtotime(esc($date['date']))); ?><a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" class="btn icon btn-outline-danger btn-sm float-end ms-1" onclick="deleteEventDate('<?= esc($data['id']); ?>','<?= esc($date['date']) ?>')" style="padding: 0; border: none; background: none;"><i class="fa-solid fa-trash"></i></a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6 col-12">
            <!-- Object Location on Map -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Google Maps</h5>
                </div>

                <?= $this->include('web/layouts/map-body'); ?>
                <script>
                    initMap(<?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>)
                    markerClickable = false;
                    digitObject("<?= esc(json_encode($data['geoJson'])); ?>");
                </script>
                <script>
                    objectMarker("<?= esc($data['id']); ?>", <?= esc($data['lat']); ?>, <?= esc($data['lng']); ?>);
                    map.setZoom(20);
                </script>
            </div>

            <!-- Object Media -->
            <?= $this->include('web/layouts/gallery_video'); ?>
        </div>
    </div>
    <!-- Modal Add Service -->
    <div class="modal fade" id="insertService" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Event Date</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form class="form form-vertical" action="date" method="post" onsubmit="checkRequired(event)" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="event_id" value="<?= esc($data['id']); ?>">
                                <div class="form-group mb-4">
                                    <label for="description" class="form-label">Date</label>
                                    <input type="date" id="name" class="form-control" name="date" required>
                                </div>
                                <button type="submit" class="btn btn-primary me-1 my-3">Save</button>
                                <button type="reset" class="btn btn-light-secondary me-1 my-3">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
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
    $(document).ready(function() {
        $('#table-manage').DataTable({
            order: [],
            columnDefs: [{
                targets: ['_all'],
                className: 'dt-head-center'
            }],
            lengthMenu: [5, 10, 20, 50, 100]
        });
    });
</script>
<?= $this->endSection() ?>