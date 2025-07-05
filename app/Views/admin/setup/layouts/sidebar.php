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
                <div class="p-2 text-center">
                    Hellooo, <span class="fw-bold">Admin</span> <br> <span class="text-muted mb-0">@<?= user()->username; ?></span>
                </div>
                <ul class="menu">
                    <li class="sidebar-item active">
                        <a href="#" class="sidebar-link">
                            <i class="fa-solid fa-gear"></i><span> Setup</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>