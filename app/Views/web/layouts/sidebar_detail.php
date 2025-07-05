<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <?= $this->include('web/layouts/sidebar_header'); ?>
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <?php if (url_is('*homestay*')) : ?>
                    <div class="d-flex justify-content-center">Welcome to</div>
                    <div class="d-flex justify-content-center fw-bold"><?= esc($title); ?></div>
                    <hr class="hr" />
                <?php else : ?>
                    <div class="d-flex justify-content-center avatar avatar-xl" id="avatar-sidebar">
                        <img src="<?= base_url('media/photos/pesona_sumpu.png'); ?>" alt="" srcset="">
                    </div>
                <?php endif; ?>
                <?php if (logged_in()) : ?>
                    <div class="p-2 text-center">
                        <?php if (!empty(user()->first_name)): ?>
                            <?php if (in_groups(['owner', 'admin'])) : ?>
                                Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span><br>
                            <?php else : ?>
                                Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span><br>
                                <span class="fw-bold">Your Coin : <?= number_format(user()->total_coin); ?></span>
                            <?php endif; ?>

                        <?php else: ?>
                            <?php if (in_groups(['owner', 'admin'])) : ?>
                                Hello, <span class="fw-bold">@<?= user()->username; ?></span><br>
                            <?php else : ?>
                                Hello, <span class="fw-bold">@<?= user()->username; ?></span><br>
                                <span class="fw-bold">Your Coin : <?= number_format(user()->total_coin); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <?php endif; ?>
                <ul class="menu">
                    <li class="sidebar-item">
                        <a href="" onclick="self.close()" class="sidebar-link">
                            <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">arrow_back</span> <span>Back to Home</span>
                        </a>
                    </li>
                    <?php if (url_is('*homestay*')) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'homestay') ? 'active' : '' ?>">
                            <a href="<?= base_url('web/homestay'); ?><?= esc('/' . $homestay_id); ?>" class="sidebar-link">
                                <i class="fa-solid fa-bed"></i><span> Homestay</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($uri1 == 'homestayUnit') ? 'active' : '' ?>">
                            <a href="<?= base_url('web/homestayUnit/'); ?><?= esc('/' . $homestay_id); ?>" class="sidebar-link">
                                <i class="fa-solid fa-door-open"></i><span> Unit</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($uri1 == 'homestayAdditionalAmenities') ? 'active' : '' ?>">
                            <a href="<?= base_url('web/homestayAdditionalAmenities'); ?><?= esc('/' . $homestay_id); ?>" class="sidebar-link">
                                <i class="fa-solid fa-list-ol"></i><span> Additional Amenities</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>