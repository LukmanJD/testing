<?= $this->extend('maps/main'); ?>

<?= $this->section('content') ?>

<?= $this->include('maps/map-body'); ?>
<script>currentUrl = "mobile";</script>
<?php

if (isset($data)):
    foreach ($data as $item): ?>
        <script>currentUrl = currentUrl + "<?= esc($item['id']); ?>"</script>
        <script>objectMarker("<?= esc($item['id']); ?>", <?= esc($item['lat']); ?>, <?= esc($item['lng']); ?>, true, "<?= esc($item['attraction_category']); ?>")</script>
<?php
    endforeach;?>
    <script>boundToObject();</script>
<?php
endif;

?>

<?= $this->endSection() ?>
