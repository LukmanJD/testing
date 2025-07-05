<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Tourism Village</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="media/icon/favicon.svg" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Quicksand:wght@600;700&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet" />
    <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/landing-page/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/landing-page/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('css/web.css'); ?>">

    <!-- Third Party CSS and JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/de7d18ea4d.js" crossorigin="anonymous"></script>

    <!-- Google Maps API and Custom JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8B04MTIk7abJDVESr6SUF6f3Hgt1DPAY&libraries=drawing"></script>
    <script src="<?= base_url('js/web.js'); ?>"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #home {
            height: 65vh;
            /* Mengatur tinggi elemen agar sesuai dengan tinggi viewport */
        }

        .card {
            height: 100%;
            /* Mengatur kartu agar memenuhi elemen parent */
            border: none;
            /* Opsional: Hilangkan border jika tidak diperlukan */
        }

        .owl-carousel-item {
            position: relative;
            width: 100%;
            /* Make sure it takes the full width */
            height: 620px;
            /* Set a fixed height or adjust as needed */
            overflow: hidden;
            /* Hide overflow when the image zooms */
        }

        .owl-carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* This ensures the image covers the entire div without distortion */
        }
    </style>
</head>

<body class="text-dark">

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-lg-0 px-4 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="/" class="navbar-brand p-0">
            <img class="img-fluid me-3" src="media/icon/logo.svg" alt="Icon" />
            <h1 class="m-0 text-primary">Tourism Village</h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse py-4 py-lg-0" id="navbarCollapse">
            <div class="navbar-nav ms-auto">

                <a href="#home" class="nav-item nav-link active">Home</a>
                <?php if ($village != null) : ?>
                    <a href="/web" class="nav-item nav-link">Explore</a>
                    <a href="#about" class="nav-item nav-link">About</a>
                    <a href="#award" class="nav-item nav-link">Award</a>
                <?php endif; ?>
            </div>
            <?php if (!logged_in()) : ?>
                <a href="<?= base_url('login'); ?>" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->

    <?php if ($village != null) : ?>
        <!-- Header Start -->
        <div class="container-fluid bg-dark p-0 mb-5" id="home">
            <div class="row g-0 flex-column-reverse flex-lg-row">
                <div class="col-lg-6 p-0 wow fadeIn" data-wow-delay="0.1s">
                    <div class="header-bg h-100 d-flex flex-column justify-content-center p-5" style="background: linear-gradient(rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)), url(media/photos/<?= $gallery[array_rand($gallery)]; ?>) center center no-repeat; background-size: cover;">
                        <h2 class="display-6 text-light mb-2">
                            Welcome to
                        </h2>
                        <h1 class="display-4 text-light mb-5">
                            <?= $village['name']; ?>
                        </h1>
                        <div class="d-flex align-items-center pt-4 animated slideInDown">
                            <a href="/web" class="btn btn-primary py-sm-3 px-3 px-sm-5 me-5">Explore</a>
                            <button type="button" class="btn-play" data-bs-toggle="modal" data-src="<?= base_url('media/videos/' . $village['video_url']); ?>" data-bs-target="#videoModal">
                                <span></span>
                            </button>
                            <h6 class="text-white m-0 ms-4 d-none d-sm-block">Watch Video</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="owl-carousel header-carousel">
                        <?php foreach ($gallery as $item) : ?>
                            <div class="owl-carousel-item">
                                <img class="img-fluid" src="media/photos/<?= $item; ?>" alt="" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->

        <!-- Video Modal Start -->
        <div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Video</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- 16:9 aspect ratio -->
                        <div class="ratio ratio-16x9">
                            <video src="" class="embed-responsive-item" id="video" controls autoplay>Sorry, your browser doesn't support embedded videos</video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Video Modal End -->

        <!-- About Start -->
        <div class="container-xxl py-5 my-5" id="about">
            <div class="container">
                <div class="row p-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <p><span class="text-primary me-2">#</span>Welcome To <span>
                                <?= $village['name']; ?>
                            </span></p>
                        <h1 class="display-5 mb-4">
                            Why You Should Visit
                            <span class="text-primary">
                                <?= $village['name']; ?>
                            </span>
                        </h1>
                        <p class="mb-4">
                            <?= $village['description']; ?>
                        </p>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('at');">
                                <i class="far fa-check-circle text-primary me-3"></i>Attraction
                            </a>
                        </h5>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('hs');">
                                <i class="far fa-check-circle text-primary me-3"></i>Homestay
                            </a>
                        </h5>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('ev');">
                                <i class="far fa-check-circle text-primary me-3"></i>Event
                            </a>
                        </h5>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('cp');">
                                <i class="far fa-check-circle text-primary me-3"></i>Culinary Place
                            </a>
                        </h5>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('wp');">
                                <i class="far fa-check-circle text-primary me-3"></i>Worship Place
                            </a>
                        </h5>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('sp');">
                                <i class="far fa-check-circle text-primary me-3"></i>Souvenir Place
                            </a>
                        </h5>
                        <h5 class="mb-3">
                            <a href="#map" class="text-reset" onclick="showMap('sv');">
                                <i class="far fa-check-circle text-primary me-3"></i>Service Provider
                            </a>
                        </h5>
                        <a class="btn btn-primary py-3 px-5 mt-3" href="/web">Explore</a>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="img-border  ">
                            <img class="img-fluid" src="media/photos/<?= $gallery[array_rand($gallery)]; ?>" alt="" />
                        </div>
                    </div>
                </div>
                <div class="row p-5" id="map">
                    <div class="mb-3">
                        <a class="btn btn-outline-danger float-end" onclick="closeMap();"><i class="fa-solid fa-xmark"></i></a>
                    </div>
                    <div class="col-lg-6 wow fadeInUp googlemaps" data-wow-delay="0.5s" id="googlemaps">
                        <script>
                            initMap();
                            digitTourismVillage();
                        </script>
                        <div id="legend"></div>
                        <script>
                            $('#legend').hide();
                            getLegend();
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Award Start -->
        <div class="container-xxl bg-primary facts my-5 py-5 wow fadeInUp" data-wow-delay="0.1s" id="award">
            <div class="container py-5">
                <div class="row g-4">
                    <center>
                        <div class="col-md-12 col-lg-6 text-center wow fadeIn" data-wow-delay="0.1s">
                            <img src="media/photos/landing-page/trophy.png" alt="" style="filter: invert(100%); max-width: 4em" class="mb-3">
                            <!-- <h1 class="text-white mb-2" data-toggle="counter-up">50</h1> -->
                            <p class="text-white mb-0">UNESCO GLOBAL GEOPARK</p>
                        </div>
                    </center>

                    <!-- <div class="col-md-6 col-lg-6 text-center wow fadeIn" data-wow-delay="0.3s">
                    <img src="media/photos/landing-page/rumah-gadang.png" alt="" style="filter: invert(100%); max-width: 5em">
                    <h1 class="text-white mb-2" data-toggle="counter-up">70</h1>
                    <p class="text-white mb-0">Rumah Gadang</p>
                </div> -->
                </div>
            </div>
        </div>
        <!-- Award End -->

        <!--  CHSE Start  -->
        <div class="container-xxl btn-primary py-5 wow fadeInUp" data-wow-delay="0.1s" id="award">
            <div class="container-fluid text-center mt-3">
                <div class="row text-white">
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 container-strech mb-3">
                        <div class="mask-group-1 d-flex flex-row align-items-center justify-content-evenly text-center">
                            <strong class="">CLEANLINESS</strong>
                            <img class="" src="https://chse.kemenparekraf.go.id/themes/chse-front/assets/landing/img/icons/clean.png">
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 container-strech mb-3">
                        <div class="mask-group-2 d-flex flex-row align-items-center justify-content-evenly text-center">
                            <strong class="">HEALTH</strong>
                            <img class="" src="https://chse.kemenparekraf.go.id/themes/chse-front/assets/landing/img/icons/health.png">
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 container-strech mb-3">
                        <div class="mask-group-3 d-flex flex-row align-items-center justify-content-evenly text-center">
                            <strong class="">SAFETY</strong>
                            <img class="" src="https://chse.kemenparekraf.go.id/themes/chse-front/assets/landing/img/icons/safety.png">
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 col-lg-3 container-strech mb-3">
                        <div class="mask-group-1 d-flex flex-row align-items-center justify-content-space text-center">
                            <strong class="">ENVIRONMENT SUSTAINABILITY</strong>
                            <img class="" src="https://chse.kemenparekraf.go.id/themes/chse-front/assets/landing/img/icons/env.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  CHSE End  -->
    <?php else: ?>
        <div class="container-fluid bg-dark p-0 mb-5" id="home">
            <div class="card">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h3 class="text-center">The app has not been set up</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <!-- Footer Start -->
    <div class="container-fluid footer bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <?php if ($village != null) : ?>
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-9 col-md-6">
                        <h5 class="text-light mb-4">Address</h5>
                        <p class="mb-2">
                            <i class="fa fa-map-marker-alt me-3"></i> <?= $village['address']; ?>
                        </p>
                        <?php if ($village['phone']) : ?>
                            <p class="mb-2">
                                <i class="fa fa-phone-alt me-3"></i><?= $village['phone']; ?>
                            </p>
                        <?php endif; ?>
                        <p class="mb-2">
                            <i class="fa fa-envelope me-3"></i><?= $village['email']; ?>
                        </p>
                        <div class="d-flex pt-2">
                            <?php if ($village['instagram']) : ?>
                                <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/<?= $village['instagram']; ?>"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if ($village['facebook']) : ?>
                                <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/<?= $village['facebook']; ?>"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($village['youtube']) : ?>
                                <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/<?= $village['youtube']; ?>"><i class="fa-brands fa-youtube"></i></a>
                            <?php endif; ?>
                            <?php if ($village['tiktok']) : ?>
                                <a class="btn btn-outline-light btn-social" href="https://www.tiktok.com/<?= $village['tiktok']; ?>"><i class="fa-brands fa-tiktok"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-light mb-4">Links</h5>
                        <a class="btn btn-link" href="#home">Home</a>
                        <a class="btn btn-link" href="/web">Explore</a>
                        <a class="btn btn-link" href="#about">About</a>
                        <a class="btn btn-link" href="#award">Award</a>
                        <a class="btn btn-link" href="<?= base_url('login'); ?>">Login</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Lukman Juned Dharma</a>, All
                        Right Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/lightbox/js/lightbox.min.js"></script>

    <script>
        window.onload = function() {
            // Get the current title
            let title = document.title;

            // Split the title based on the ' - ' separator
            let parts = title.split(" - ");

            $.ajax({
                url: baseUrl + "/api/touristVillage/",
                dataType: "json",
                success: function(response) {
                    let data = response.data;
                    let name = data.name;

                    parts[1] = name;
                    document.title = parts.join(" - ");

                },
            });
        };
    </script>

    <!-- Template Javascript -->
    <script src="<?= base_url('js/landing-page.js'); ?>"></script>
    <script>
        $('#map').hide();

        function closeMap() {
            $('#map').hide();
        }
    </script>
    <script>
        function showMap(category = null) {
            if ($('#map').hide()) {
                $('#map').show();
            }

            let URI = "<?= base_url('api') ?>";
            clearMarker();
            clearRadius();
            clearRoute();
            if (category == 'rg') {
                URI = URI + '/rumahGadang'
            } else if (category == 'at') {
                URI = URI + '/attraction'
            } else if (category == 'hs') {
                URI = URI + '/homestay'
            } else if (category == 'ev') {
                URI = URI + '/event'
            } else if (category == 'cp') {
                URI = URI + '/culinaryPlace'
            } else if (category == 'wp') {
                URI = URI + '/worshipPlace'
            } else if (category == 'sp') {
                URI = URI + '/souvenirPlace'
            } else if (category == 'sv') {
                URI = URI + '/serviceProvider'
            }

            currentUrl = '';
            $.ajax({
                url: URI,
                dataType: 'json',
                success: function(response) {
                    let data = response.data
                    for (i in data) {
                        let item = data[i];
                        currentUrl = currentUrl + item.id;
                        if (item.id.substring(0, 1) === "A") {
                            objectMarker(item.id, item.lat, item.lng, true, item.attraction_category);
                        } else {
                            objectMarker(item.id, item.lat, item.lng);
                        }
                    }
                    boundToObject();

                }
            })
        }
    </script>
</body>

</html>