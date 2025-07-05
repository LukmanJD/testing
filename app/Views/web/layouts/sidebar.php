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
                        <?php if (!empty(user()->first_name)): ?>
                            <?php if (in_groups(['owner', 'admin'])) : ?>
                                Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span><br>
                            <?php else : ?>
                                Hello, <span class="fw-bold"><?= user()->first_name; ?><?= (!empty(user()->last_name)) ? ' ' . user()->last_name : ''; ?></span> <br>
                                <span class="text-muted mb-0">@<?= user()->username; ?></span><br>
                                <span class="fw-bold">Your Coin : <?= (user()->total_coin !== null) ? number_format(user()->total_coin) : number_format(0); ?></span>
                            <?php endif; ?>

                        <?php else: ?>
                            <?php if (in_groups(['owner', 'admin'])) : ?>
                                Hello, <span class="fw-bold">@<?= user()->username; ?></span><br>
                            <?php else : ?>
                                Hello, <span class="fw-bold">@<?= user()->username; ?></span><br>
                                <span class="fw-bold">Your Coin : <?= (user()->total_coin !== null) ? number_format(user()->total_coin) : number_format(0); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="p-2 d-flex justify-content-center">Hello, Visitor</div>
                <?php endif; ?>
                <ul class="menu">
                    <!-- Home -->
                    <li class="sidebar-item <?= ($uri1 == 'index') ? 'active' : '' ?>">
                        <a href="/web" class="sidebar-link">
                            <i class="fa-solid fa-house"></i><span class="text-dark fw-bold">Home</span>
                        </a>
                    </li>

                    <!-- Attraction -->
                    <li class="sidebar-item <?= ($uri1 == 'uniqueAttraction') ? 'active' : '' ?>">
                        <a href="/web/uniqueAttraction" class="sidebar-link">
                            <i class="fa-solid fa-star"></i><span class="text-dark fw-bold">Unique Attraction</span>
                        </a>
                    </li>

                    <!-- Attraction -->
                    <li class="sidebar-item <?= ($uri1 == 'attraction') ? 'active' : '' ?>">
                        <a href="/web/attraction" class="sidebar-link">
                            <i class="fa-solid fa-signs-post"></i><span class="text-dark fw-bold">Ordinary Attraction</span>
                        </a>
                    </li>

                    <!-- Arround You -->
                    <li class="sidebar-item <?= ($uri1 == 'aroundYou') ? 'active' : '' ?>">
                        <a href="/web/aroundYou" class="sidebar-link">
                            <i class="fa-solid fa-compass"></i><span class="text-dark fw-bold">Around You</span>
                        </a>
                    </li>

                    <!-- Homestay -->
                    <li class="sidebar-item <?= ($uri1 == 'homestay') ? 'active' : '' ?> has-sub">
                        <a href="" class="sidebar-link">
                            <i class="fa-solid fa-bed"></i></i><span class="text-dark fw-bold">Homestay</span>
                        </a>
                        <ul class="submenu <?= ($uri1 == 'homestay') ? 'active' : '' ?>">
                            <!-- List Homestay -->
                            <li class="submenu-item" id="rg-list">
                                <a href="<?= base_url('/web/homestay'); ?>"><i class="fa-solid fa-list me-3"></i>List</a>
                            </li>
                            <!-- Homestay Around You -->
                            <li class="submenu-item" id="rg-around-you">
                                <a data-bs-toggle="collapse" href="#searchRadiusRG" role="button" aria-expanded="false" aria-controls="searchRadiusRG"><i class="fa-solid fa-compass me-3"></i>Homestay Around You</a>
                                <div class="collapse mb-3" id="searchRadiusRG">
                                    <label for="inputRadiusRG" class="form-label">Radius: </label>
                                    <label id="radiusValueHS" class="form-label">0 m</label>
                                    <input type="range" class="form-range" min="0" max="20" value="0" id="inputRadiusHS" name="inputRadius" onchange="updateRadius('HS'); radiusSearch({postfix: 'HS'});">
                                </div>
                            </li>
                            <li class="submenu-item has-sub" id="rg-search">
                                <a data-bs-toggle="collapse" href="#subsubmenu-rg" role="button" aria-expanded="false" aria-controls="subsubmenu-rg" class="collapse"><i class="fa-solid fa-magnifying-glass me-3"></i>Search</a>
                                <ul class="subsubmenu collapse" id="subsubmenu-rg">
                                    <!-- Homestay by Name -->
                                    <li class="submenu-item submenu-marker" id="rg-by-name">
                                        <a data-bs-toggle="collapse" href="#searchNameRG" role="button" aria-expanded="false" aria-controls="searchNameRG"><i class="fa-solid fa-arrow-down-a-z me-3"></i>By Name</a>
                                        <div class="collapse mb-3" id="searchNameRG">
                                            <div class="d-grid gap-2">
                                                <input type="text" name="nameRG" id="nameHS" class="form-control" placeholder="Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByName('HS')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Homestay by Rating -->
                                    <li class="submenu-item submenu-marker" id="rg-by-rating">
                                        <a data-bs-toggle="collapse" href="#searchRatingRG" role="button" aria-expanded="false" aria-controls="searchRatingRG"><i class="fa-regular fa-star me-3"></i>By Rating</a>
                                        <div class="collapse mb-3" id="searchRatingRG">
                                            <div class="d-grid gap-2">
                                                <div class="star-containter">
                                                    <i class="fa-solid fa-star" id="star-1" onclick="setStar('star-1');"></i>
                                                    <i class="fa-solid fa-star" id="star-2" onclick="setStar('star-2');"></i>
                                                    <i class="fa-solid fa-star" id="star-3" onclick="setStar('star-3');"></i>
                                                    <i class="fa-solid fa-star" id="star-4" onclick="setStar('star-4');"></i>
                                                    <i class="fa-solid fa-star" id="star-5" onclick="setStar('star-5');"></i>
                                                    <input type="hidden" id="rating" value="0">
                                                </div>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByRating('HS')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Homestay by Facility -->
                                    <li class="submenu-item submenu-marker" id="rg-by-facility">
                                        <a data-bs-toggle="collapse" href="#searchFacilityRG" role="button" aria-expanded="false" aria-controls="searchFacilityRG"><i class="fa-solid fa-house-circle-check me-3"></i>By Facility</a>
                                        <div class="collapse mb-3" id="searchFacilityRG">
                                            <div class="d-grid">
                                                <script>
                                                    getHSFacility();
                                                </script>
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="hsfacilitySelect">
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByFacilityHS()">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Homestay by Type -->
                                    <li class="submenu-item submenu-marker" id="rg-by-unit">
                                        <a data-bs-toggle="collapse" href="#searchUnitRG" role="button" aria-expanded="false" aria-controls="searchUnitRG"><i class="fa-solid fa-bed me-3"></i>By Unit Available</a>
                                        <div class="collapse mb-3" id="searchUnitRG">
                                            <div class="d-grid">
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="unitHSSelect">
                                                        <option value="1">Room</option>
                                                        <option value="2">Vila</option>
                                                        <option value="3">Hall</option>
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByUnit()">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Homestay by Category -->
                                    <li class="submenu-item submenu-marker" id="rg-by-category">
                                        <a data-bs-toggle="collapse" href="#searchCategoryRG" role="button" aria-expanded="false" aria-controls="searchCategoryRG"><i class="fa-solid fa-bed me-3"></i>By Category</a>
                                        <div class="collapse mb-3" id="searchCategoryRG">
                                            <div class="d-grid">
                                                <fieldset class="form-group">
                                                    <select class="form-select" id="categoryHSSelect">
                                                        <option value="1">Non Syariah</option>
                                                        <option value="2">Syariah</option>
                                                    </select>
                                                </fieldset>
                                                <button class="btn btn-outline-primary" type="submit" id="button-addon2" onclick="findByCategory('HS')">
                                                    <span class="material-icons" style="font-size: 1.5rem; vertical-align: bottom">search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php if (in_groups('user')) : ?>
                        <li class="sidebar-item <?= ($uri1 == 'reservation') ? 'active' : '' ?>">
                            <a href="<?= base_url('web/reservation'); ?>" class="sidebar-link">
                                <i class="fa-solid fa-book"></i><span class="text-dark fw-bold">Reservation</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (in_groups(['owner', 'admin'])) : ?>
                        <li class="sidebar-item">
                            <?php if (in_groups(['owner'])) : ?>
                                <a href="<?= base_url('dashboard/homestay'); ?>" class="sidebar-link">
                                <?php elseif (in_groups(['admin'])) : ?>
                                    <a href="<?= base_url('dashboard/villages'); ?>" class="sidebar-link">
                                    <?php endif; ?>
                                    <i class="bi bi-grid-fill"></i><span class="text-dark fw-bold">Dashboard</span>
                                    </a>
                        </li>
                    <?php endif; ?>

                    <li class="sidebar-item">
                        <div class="d-flex justify-content-around" id="socials">
                            <!-- <a href="https://www.instagram.com/pokdarwis.pariangan/" class="sidebar-link" target="_blank">
                                <i class="fa-brands fa-instagram"></i><span>Instagram</span>
                            </a>
                            <a href="https://www.tiktok.com/@pokdarwis.pariangan" class="sidebar-link" target="_blank">
                                <i class="fa-brands fa-tiktok"></i><span>TikTok</span>
                            </a> -->
                        </div>
                    </li>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            let socs = '';
                            $("#socials").empty();
                            // console.log('Fungsi ini dijalankan saat halaman dimuat.');
                            $.ajax({
                                url: baseUrl + "/api/socials/",
                                type: "GET",
                                dataType: "json",
                                success: function(response) {
                                    const data = response.data;
                                    if (data.instagram) {
                                        socs = socs + '<a href="https://www.instagram.com/' + data.instagram + '" class="sidebar-link" target="_blank"> <i class = "fa-brands fa-instagram" title="Intagram"></i></a>'
                                    }
                                    if (data.facebook) {
                                        socs = socs + '<a href="https://www.facebook.com/' + data.facebook + '" class="sidebar-link" target="_blank"> <i class = "fa-brands fa-facebook" title="Facebook"></i></a>'
                                    }
                                    if (data.youtube) {
                                        socs = socs + '<a href="https://www.youtube.com/' + data.youtube + '" class="sidebar-link" target="_blank"> <i class = "fa-brands fa-youtube" title="Youtube"></i></a>'
                                    }
                                    if (data.tiktok) {
                                        socs = socs + '<a href="https://www.tiktok.com/' + data.tiktok + '" class="sidebar-link" target="_blank"> <i class = "fa-brands fa-tiktok" title="Tiktok"></i></a>'
                                    }
                                    // console.log(data);
                                    $("#socials").append(socs);
                                },
                            });
                        });
                        // window.onload = function() {
                        // };
                    </script>
                </ul>

            </div>
        </div>
    </div>
</div>