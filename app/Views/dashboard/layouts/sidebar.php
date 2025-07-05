<?php
$uri = service('uri')->getSegments();
$uri1 = $uri[1] ?? 'index';
$uri2 = $uri[2] ?? '';
$uri3 = $uri[3] ?? '';
?>

<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <!-- Sidebar Header -->
        <?= $this->include('web/layouts/sidebar_header'); ?>

        <!-- Sidebar -->
        <div class="sidebar-menu">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center avatar avatar-xl me-3" id="avatar-sidebar">
                    <img src="<?= base_url('images/logo.png'); ?>" alt="" srcset="" style="object-fit: cover; max-height: 90px; max-width: 90px;">
                </div>
                <?php if (logged_in()) : ?>
                    <div class="p-2 text-center">
                        <?php if (!empty(user()->first_name)) : ?>
                            Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-dark mb-0">@<?= user()->username; ?></span>
                        <?php else : ?>
                            Hello, <span class="fw-bold">@<?= user()->username; ?></span>
                        <?php endif; ?>
                        <?php if (in_groups(['owner'])) : ?>
                            <br><span id="homestayName"></span>
                            <script>
                                getHSName('<?= user()->id; ?>');
                            </script>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <?php endif; ?>
                <ul class="menu">
                    <li class="sidebar-item">
                        <a href="<?= base_url('web'); ?>" class="sidebar-link">
                            <i class="fa-solid fa-house"></i><span class="text-dark fw-bold"> Home</span>
                        </a>
                    </li>

                    <!-- Manage Village -->
                    <!-- <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'villages') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/villages'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-map-location-dot"></i><span class="text-dark fw-bold"> Village</span>
                            </a>
                        </li>
                    <?php endif; ?> -->

                    <?php if (in_groups(['admin'])) :
                    ?>
                         <li class="sidebar-item has-sub">
                            <a href="" class="sidebar-link">
                                <i class="fa-solid fa-map-location-dot"></i><span>Village</span>
                            </a>
                            <ul class="submenu <?= ($uri1 == 'villages' || $uri1 == 'announcement') ? 'active' : '' ?>">
                                <!-- List Package -->
                                <li class="submenu-item <?= ($uri1 == 'villages') ? 'active' : '' ?>" id="pa-list">
                                    <a href="<?= base_url('dashboard/villages'); ?>"><i class="fa-solid fa-map-location-dot"></i> Data Village</a>
                                </li>
                                <!-- List Package type-->
                                <li class="submenu-item <?= ($uri1 == 'announcement') ? 'active' : '' ?>" id="pa-list">
                                    <a href="<?= base_url('dashboard/announcement'); ?>"><i class="fa-solid fa-scroll"></i> Announcement</a>
                                </li>                              
                            </ul>
                        </li>
                    <?php endif;
                    ?>

                    <!-- Manage Users -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'users') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/users'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-users"></i><span class="text-dark fw-bold"> Users</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Homestay -->
                    <?php if (in_groups(['owner'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'homestay') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/homestay'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-bed"></i><span class="text-dark fw-bold"> Homestay</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($uri1 == 'homestayUnit') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/homestayUnit'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-door-open"></i><span class="text-dark fw-bold"> Unit</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($uri1 == 'additionalAmenities') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/additionalAmenities'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-list-ol"></i><span class="text-dark fw-bold"> Additional Amenitites</span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($uri1 == 'reservation') ? 'active' : '' ?>">
                            <a href="<?= base_url('dashboard/reservation'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-book"></i><span class="text-dark fw-bold"> Reservation</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Attraction -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'attraction') ? 'active' : '' ?> has-sub">
                            <a href="<?= base_url('dashboard/attraction'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-signs-post"></i><span class="text-dark fw-bold"> Attraction</span>
                            </a>
                            <ul class="submenu <?= ($uri1 == 'attraction') ? 'active' : '' ?><?= ($uri1 == 'facilityAttraction') ? 'active' : '' ?>">
                                <!-- Manage Attraction -->
                                <li class="submenu-item" id="mg-sp">
                                    <a href="<?= base_url('dashboard/attraction'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                                </li>
                                <!-- Manage Attraction Facility -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/attraction/facility'); ?>"><i class="fa-solid fa-hand-holding me-3"></i>Attraction Facility</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Homestay -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'homestay') ? 'active' : '' ?><?= ($uri1 == 'facilityHomestay') ? 'active' : '' ?><?= ($uri1 == 'facilityUnit') ? 'active' : '' ?> has-sub">
                            <a href="<?= base_url('dashboard/homestay/manage'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-bed"></i><span class="text-dark fw-bold"> Homestay</span>
                            </a>
                            <ul class="submenu <?= ($uri1 == 'homestay') ? 'active' : '' ?><?= ($uri1 == 'facilityHomestay') ? 'active' : '' ?><?= ($uri1 == 'facilityUnit') ? 'active' : '' ?>">
                                <!-- Manage Homestay -->
                                <li class="submenu-item" id="mg-sp">
                                    <a href="<?= base_url('dashboard/homestay/manage'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                                </li>
                                <!-- Manage Homestay Facility -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/facilityHomestay'); ?>"><i class="fa-solid fa-hand-holding me-3"></i>Homestay Facility</a>
                                </li>
                                <!-- Manage Homestay Unit Facility -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/facilityUnit'); ?>"><i class="fa-solid fa-hand-holding me-3"></i>Unit Facility</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Souvenir Place -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'souvenirPlace') ? 'active' : '' ?><?= ($uri1 == 'facilitySouvenirPlace') ? 'active' : '' ?> has-sub">
                            <a href="" class="sidebar-link">
                                <i class="fa-solid fa-bag-shopping"></i><span class="text-dark fw-bold"> Souvenir Place</span>
                            </a>
                            <ul class="submenu <?= ($uri1 == 'souvenirPlace') ? 'active' : '' ?><?= ($uri1 == 'facilitySouvenirPlace') ? 'active' : '' ?>">
                                <!-- Manage Souvenir Place -->
                                <li class="submenu-item" id="mg-sp">
                                    <a href="<?= base_url('dashboard/souvenirPlace'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                                </li>
                                <!-- Manage Souvenir Facility -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/facilitySouvenirPlace'); ?>"><i class="fa-solid fa-hand-holding me-3"></i>Souvenir Place Facility</a>
                                </li>
                                <!-- Manage Product -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/souvenirPlace/product'); ?>"><i class="fa-solid fa-tag me-3"></i>Product</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Culinary Place -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'culinaryPlace') ? 'active' : '' ?><?= ($uri1 == 'facilityCulinaryPlace') ? 'active' : '' ?> has-sub">
                            <a href="" class="sidebar-link">
                                <i class="fa-solid fa-mortar-pestle"></i><span class="text-dark fw-bold"> Culinary Place</span>
                            </a>
                            <ul class="submenu <?= ($uri1 == 'culinaryPlace') ? 'active' : '' ?><?= ($uri1 == 'facilityCulinaryPlace') ? 'active' : '' ?>">
                                <!-- Manage Souvenir Place -->
                                <li class="submenu-item" id="mg-sp">
                                    <a href="<?= base_url('dashboard/culinaryPlace'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                                </li>
                                <!-- Manage Culinary Facility -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/facilityCulinaryPlace'); ?>"><i class="fa-solid fa-hand-holding me-3"></i>Culinary Place Facility</a>
                                </li>
                                <!-- Manage Product -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/culinaryPlace/product'); ?>"><i class="fa-solid fa-tag me-3"></i>Product</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- Manage Worship Place -->
                    <?php if (in_groups(['admin'])) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'worshipPlace') ? 'active' : '' ?><?= ($uri1 == 'facilityWorshipPlace') ? 'active' : '' ?> has-sub">
                            <a href="" class="sidebar-link">
                                <i class="fa-solid fa-place-of-worship"></i><span class="text-dark fw-bold"> Worship Place</span>
                            </a>
                            <ul class="submenu <?= ($uri1 == 'worshipPlace') ? 'active' : '' ?><?= ($uri1 == 'facilityWorshipPlace') ? 'active' : '' ?>">
                                <!-- Manage Worship Place -->
                                <li class="submenu-item" id="mg-sp">
                                    <a href="<?= base_url('dashboard/worshipPlace'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                                </li>
                                <!-- Manage Worship Facility -->
                                <li class="submenu-item" id="mg-p">
                                    <a href="<?= base_url('dashboard/facilityWorshipPlace'); ?>"><i class="fa-solid fa-hand-holding me-3"></i>Worship Place Facility</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </div>
    </div>
</div>