// js file
let baseUrl = "";
let currentUrl = "";
let currentLat = 0,
  currentLng = 0;
let userLat = 0,
  userLng = 0;
let web, map;
let infoWindow = new google.maps.InfoWindow();
let userInfoWindow = new google.maps.InfoWindow();
let directionsService, directionsRenderer;
let userMarker = new google.maps.Marker();
let destinationMarker = new google.maps.Marker();
const villageInfoWindow = new google.maps.InfoWindow();
let routeArray = [],
  circleArray = [],
  markerArray = {};
let bounds = new google.maps.LatLngBounds();
let overlays = [];
let airplaneMarkers = [];
let carMarkers = [];
let digitNegLayers = [];
let digitProvLayers = [];
let digitKabKotaLayers = [];
let digitVillageLayers = [];
let customLabels = [];
let customLabelsCountry = [];
let latVillage = 0;
let lngVillage = 0;

let isCustomRoute = false;
let customMarkers = [];
let customDirectionsRenderer;
let customPolyline;
let confirmRouteControlDiv;

let selectedShape;
let customStyled = [
  {
    elementType: "labels",
    stylers: [
      {
        visibility: "off",
      },
    ],
  },
  {
    featureType: "administrative.land_parcel",
    stylers: [
      {
        visibility: "off",
      },
    ],
  },
  {
    featureType: "administrative.neighborhood",
    stylers: [
      {
        visibility: "off",
      },
    ],
  },
  {
    featureType: "road",
    elementType: "labels",
    stylers: [
      {
        visibility: "on",
      },
    ],
  },
];

/**
 * Sets the base URL for API calls.
 * Purpose: To ensure all AJAX requests use the correct base path.
 * How it works: Assigns the passed url string to the global baseUrl variable.
 */
function setBaseUrl(url) {
  baseUrl = url;
}

// Initialize and add the map
// function initMap(
//   lat = -0.11371891332439286,
//   lng = 100.66784601319584,
//   mobile = false
// ) {
//   directionsService = new google.maps.DirectionsService();
//   const center = new google.maps.LatLng(lat, lng);
//   if (!mobile) {
//     map = new google.maps.Map(document.getElementById("googlemaps"), {
//       zoom: 6,
//       center: center,
//       mapTypeId: "satellite",
//     });
//   } else {
//     map = new google.maps.Map(document.getElementById("googlemaps"), {
//       zoom: 18,
//       center: center,
//       mapTypeControl: false,
//     });
//   }
//   var rendererOptions = {
//     map: map,
//   };
//   map.set("styles", customStyled);
//   directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);

//   // digitCountries();
//   for (let n = 1; n < 4; n++) {
//     const idcoun = n;
//     digitCountries(idcoun);
//   }
//   digitProvinces();
//   digitCities();
// }

/**
 * Initializes the Google Map.
 * Purpose: Sets up the map with default center, zoom, styles, and loads initial layers.
 * How it works: Creates a new google.maps.Map instance, sets styles, and calls functions to load country, province, and city layers.
 */
function initMap(lat = -0.45645247101825404, lng = 100.49283409109306) {
  directionsService = new google.maps.DirectionsService();
  const center = new google.maps.LatLng(lat, lng);
  map = new google.maps.Map(document.getElementById("googlemaps"), {
    zoom: 8,
    center: center,
    mapTypeId: "hybrid",
    // styles: ,
  });
  var rendererOptions = {
    map: map,
  };
  map.set("styles", customStyled);
  directionsRenderer = new google.maps.DirectionsRenderer(rendererOptions);
  for (let n = 1; n < 4; n++) {
    const idcoun = n;
    digitCountries(idcoun);
  }
  digitProvinces();
  digitCities();
  addCustomLabels(map);
  addCustomLabelsCountry(map);
}

/**
 * Pans the map to the village location.
 * Purpose: To focus the map on the main village area.
 * How it works: Uses map.panTo and map.setZoom to change the view.
 */
function goToVillage() {
  // map.setCenter({ lat: -0.11371891332439286, lng: 100.66784601319584 });
  map.panTo({ lat: -0.11371891332439286, lng: 100.66784601319584 });
  map.setZoom(16);
}

/**
 * Fetches and displays country boundaries.
 * Purpose: To visualize countries on the map.
 * How it works: AJAX GET to /api/countries, loads GeoJSON, sets styles, and adds click listeners for InfoWindows.
 */
function digitCountries() {
  $.ajax({
    url: baseUrl + "/api/countries",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      const digit_color = ["#FF8C00", "#FF00FF", "#87CEEB"];
      const country_name = ["Singapore", "Malaysia", "Brunei Darussalam"];
      for (i in data) {
        const village = new google.maps.Data();
        let item = data[i];
        village.loadGeoJson("/map/" + item.geom);
        // village.addGeoJson(data);
        village.setStyle({
          content: country_name[i],
          fillColor: digit_color[i],
          strokeWeight: 0.5,
          strokeColor: "#005000",
          fillOpacity: 0.1,
          clickable: true,
          title: item.name,
          index: 1,
        });
        village.addListener("click", function (event) {
          villageInfoWindow.close();
          infoWindow.close();
          villageInfoWindow.setContent(item.name + " Country");
          villageInfoWindow.setPosition(event.latLng);
          villageInfoWindow.open(map);
        });
        village.setMap(map);
        digitNegLayers.push(village);
      }
    },
  });
}

/**
 * Fetches and displays province boundaries.
 * Purpose: To visualize provinces on the map.
 * How it works: AJAX GET to /api/provinces, loads GeoJSON, sets styles, and adds click listeners.
 */
function digitProvinces() {
  $.ajax({
    url: baseUrl + "/api/provinces",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      for (i in data) {
        const village = new google.maps.Data();
        let item = data[i];
        village.loadGeoJson("/map/" + item.geom);
        // village.addGeoJson(data);
        village.setStyle({
          fillColor: "#ffffff",
          strokeWeight: 0.5,
          strokeColor: "#ffffff",
          fillOpacity: 0,
          clickable: true,
          title: item.name,
          index: 2,
        });
        village.addListener("click", function (event) {
          villageInfoWindow.close();
          infoWindow.close();
          villageInfoWindow.setContent(item.name + " Province");
          villageInfoWindow.setPosition(event.latLng);
          villageInfoWindow.open(map);
        });
        village.setMap(map);
        digitProvLayers.push(village);
      }
    },
  });
}
/**
 * Fetches and displays city boundaries.
 * Purpose: To visualize cities on the map.
 * How it works: AJAX GET to /api/cities, loads GeoJSON, sets styles, and adds click listeners.
 */
function digitCities() {
  $.ajax({
    url: baseUrl + "/api/cities",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      for (i in data) {
        const village = new google.maps.Data();
        let item = data[i];
        village.loadGeoJson("/map/" + item.geom);
        // village.addGeoJson(data);
        village.setStyle({
          fillColor: "#ffffff",
          strokeWeight: 0.5,
          strokeColor: "#ffffff",
          fillOpacity: 0,
          clickable: true,
          title: item.name,
          index: 3,
        });
        village.addListener("click", function (event) {
          villageInfoWindow.close();
          infoWindow.close();
          villageInfoWindow.setContent(item.name);
          villageInfoWindow.setPosition(event.latLng);
          villageInfoWindow.open(map);
        });
        village.setMap(map);
        digitKabKotaLayers.push(village);
      }
    },
  });
}
/**
 * Fetches and displays subdistrict boundaries.
 * Purpose: To visualize subdistricts on the map.
 * How it works: AJAX GET to /api/subdistricts, loads GeoJSON, sets styles, and adds click listeners.
 */
function digitSubdistricts() {
  $.ajax({
    url: baseUrl + "/api/subdistricts",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      for (i in data) {
        const village = new google.maps.Data();
        let item = data[i];
        village.loadGeoJson("/map/" + item.geom);
        // village.addGeoJson(data);
        village.setStyle({
          fillColor: "#02cdfa",
          strokeWeight: 0.5,
          strokeColor: "#005000",
          fillOpacity: 0.2,
          clickable: true,
          title: item.name,
          index: 4,
        });
        village.addListener("click", function (event) {
          villageInfoWindow.close();
          infoWindow.close();
          villageInfoWindow.setContent(item.name + " Subdistrict");
          villageInfoWindow.setPosition(event.latLng);
          villageInfoWindow.open(map);
        });
        village.setMap(map);
      }
    },
  });
}

/**
 * Fetches and displays village boundaries.
 * Purpose: To visualize villages on the map.
 * How it works: AJAX GET to /api/villages, loads GeoJSON, sets styles, and adds click listeners.
 */
function digitVillages() {
  $.ajax({
    url: baseUrl + "/api/villages",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      for (i in data) {
        const village = new google.maps.Data();
        let item = data[i];
        village.loadGeoJson("/map/" + item.geom_file);
        // village.addGeoJson(data);
        village.setStyle({
          fillColor: "#ff4a03",
          strokeWeight: 0.5,
          strokeColor: "#005000",
          fillOpacity: 0.2,
          clickable: true,
          title: item.name,
          index: 5,
        });
        village.addListener("click", function (event) {
          infoWindow.close();
          villageInfoWindow.setContent(item.name + " Village");
          villageInfoWindow.setPosition(event.latLng);
          villageInfoWindow.open(map);
        });
        village.setMap(map);
      }
    },
  });
}

/**
 * Displays tourism village digitizing.
 * Purpose: To show the specific tourism village boundary.
 * How it works: AJAX POST to /api/village, loads GeoJSON, and sets styles.
 */
function digitVillage() {
  const village = new google.maps.Data();
  $.ajax({
    url: baseUrl + "/api/village",
    type: "POST",
    data: {
      village: "1",
    },
    dataType: "json",
    success: function (response) {
      const data = response.data;
      village.loadGeoJson("/map/" + data.geom_file);
      // village.addGeoJson(data);
      village.setStyle({
        fillColor: "#00b300",
        strokeWeight: 0.5,
        strokeColor: "#005000",
        fillOpacity: 0.1,
        clickable: true,
      });
      village.setMap(map);
    },
  });
}

/**
 * Fetches and displays the tourism village boundary.
 * Purpose: To highlight the main tourism village area.
 * How it works: AJAX GET to /api/touristVillage, loads GeoJSON, fits map bounds to it, and adds a marker.
 */
function digitTourismVillage(goToVillage = false) {
  if (currentVillage) {
    currentVillage.setMap(null); // Menghapus polygon sebelumnya
  }
  $.ajax({
    url: baseUrl + "/api/touristVillage",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;

      // Buat instance baru dari google.maps.Data untuk village baru
      currentVillage = new google.maps.Data();
      currentVillage.loadGeoJson(
        "/map/tourism_village/" + data.geom_file,
        null,
        function (features) {
          let bounds = new google.maps.LatLngBounds();

          // Mendapatkan bounds dari semua fitur GeoJSON
          features.forEach(function (feature) {
            feature.getGeometry().forEachLatLng(function (latlng) {
              bounds.extend(latlng);
            });
          });

          // Fokuskan peta ke area village
          const currentUrl = window.location.href;
          if (
            currentUrl === "http://localhost:8080/web" &&
            goToVillage == false
          ) {
            // map.setZoom(6);
          } else if (Object.keys(markerArray).length === 0) {
            map.fitBounds(bounds);
            let listener = google.maps.event.addListener(map, "idle", function () {
              if (map.getZoom() < 15) map.setZoom(15);
              google.maps.event.removeListener(listener);
            });
          } else if (goToVillage) {
            map.fitBounds(bounds);
            let listener = google.maps.event.addListener(map, "idle", function () {
              if (map.getZoom() < 15) map.setZoom(15);
              google.maps.event.removeListener(listener);
            });
          }

          // Mendapatkan pusat dari bounds
          let center = bounds.getCenter();
          latVillage = center.lat();
          lngVillage = center.lng();

          // Set style untuk village polygon
          currentVillage.setStyle({
            fillColor: "#ffffff",
            strokeWeight: 1,
            strokeColor: "#ffffff",
            fillOpacity: 0.2,
            clickable: false,
            title: data.name,
          });

          // Tampilkan info window di tengah village
          villageInfoWindow.setContent(data.name);
          villageInfoWindow.setPosition(center);
          objectMarker("L", -0.10908259406018868, 100.66435044295643);
        }
      );
      //Tambahkan listener untuk klik pada village
      currentVillage.addListener("click", function (event) {
        villageInfoWindow.close();
        villageInfoWindow.setContent(data.name);
        villageInfoWindow.setPosition(event.latLng);
        villageInfoWindow.open(map);
      });
      // Set village polygon pada peta
      currentVillage.setMap(map);
      digitVillageLayers.push(currentVillage);
    },
  });
}

/**
 * Fetches and displays unique attraction boundaries.
 * Purpose: To visualize unique attractions on the map.
 * How it works: AJAX GET to /api/uniqueAttraction, adds GeoJSON to data layer, and sets styles.
 */
function digitUniqueAtt() {
  const village = new google.maps.Data();
  $.ajax({
    url: baseUrl + "/api/uniqueAttraction",
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      console.log(data);
      // village.loadGeoJson("/map/" + data.geom_file);
      village.addGeoJson(data);
      village.setStyle({
        fillColor: "#ff0000",
        strokeWeight: 0.8,
        strokeColor: "#005000",
        fillOpacity: 0.1,
        clickable: true,
      });
      village.setMap(map);
    },
  });
}

/**
 * Displays a generic object from raw JSON data.
 * Purpose: To render a map feature from a JSON string.
 * How it works: Parses the JSON string, adds it to a data layer, sets styles, and adds it to the map.
 */
function digitObject(dataraw) {
  const village = new google.maps.Data();
  dataraw = dataraw.replace(/&quot;/g, '"');
  const data = JSON.parse(dataraw);
  console.log(data);
  // const data = response.data;
  // village.loadGeoJson("/map/" + data.geom_file);
  village.addGeoJson(data);
  village.setStyle({
    fillColor: "#0c14fa",
    strokeWeight: 0.8,
    strokeColor: "#005000",
    fillOpacity: 0.5,
    clickable: true,
  });
  village.setMap(map);
}

/**
 * Removes the user's marker from the map.
 * Purpose: To clear the user's current location indicator.
 * How it works: Sets the userMarker map property to null and resets coordinates.
 */
function clearUser() {
  userLat = 0;
  userLng = 0;
  userMarker.setMap(null);
}

/**
 * Sets the global user location variables.
 * Purpose: To store the user's coordinates for routing and other functions.
 * How it works: Updates userLat, userLng, currentLat, and currentLng variables.
 */
function setUserLoc(lat, lng) {
  userLat = lat;
  userLng = lng;
  currentLat = userLat;
  currentLng = userLng;
}

/**
 * Removes any displayed routes from the map.
 * Purpose: To clear navigation lines and directions.
 * How it works: Iterates through routeArray setting map to null, hides direction panel, and toggles off custom route if active.
 */
function clearRoute() {
  for (i in routeArray) {
    routeArray[i].setMap(null);
  }
  routeArray = [];
  $("#direction-row").hide();
  if (isCustomRoute) {
    toggleCustomRoute();
  }
}

/**
 * Removes any displayed radius circles.
 * Purpose: To clear search radius visualizations.
 * How it works: Iterates through circleArray setting map to null.
 */
function clearRadius() {
  for (i in circleArray) {
    circleArray[i].setMap(null);
  }
  circleArray = [];
}

/**
 * Removes all object markers from the map.
 * Purpose: To clear the map of points of interest.
 * How it works: Iterates through markerArray setting map to null and resets the array.
 */
function clearMarker() {
  for (i in markerArray) {
    markerArray[i].setMap(null);
  }
  markerArray = {};
}

/**
 * Gets the user's current position using Geolocation API.
 * Purpose: To locate the user on the map.
 * How it works: Calls navigator.geolocation.getCurrentPosition, places a marker, centers map, and sets user location variables.
 */
function currentPosition() {
  clearRadius();
  clearRoute();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();

  google.maps.event.clearListeners(map, "click");
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        const pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };

        infoWindow.close();
        clearUser();
        markerOption = {
          position: pos,
          animation: google.maps.Animation.DROP,
          map: map,
        };
        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Around You" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openAround()"><i class="fa-solid fa-compass"></i></a>';
        }
        userMarker.setOptions(markerOption);
        userInfoWindow.setContent(
          "<p class='text-center'><span class='fw-bold'>You are here.</span> <br> lat: " +
            pos.lat +
            "<br>long: " +
            pos.lng +
            "<br>" + 
            nearbyButton +
            "</p>"
        );
        userInfoWindow.open(map, userMarker);
        map.setCenter(pos);
        setUserLoc(pos.lat, pos.lng);

        userMarker.addListener("click", () => {
          userInfoWindow.open(map, userMarker);
        });
      },
      () => {
        handleLocationError(true, userInfoWindow, map.getCenter());
      }
    );
  } else {
    // Browser doesn't support Geolocation
    handleLocationError(false, userInfoWindow, map.getCenter());
  }
}

/**
 * Handles geolocation errors.
 * Purpose: To display an error message if geolocation fails.
 * How it works: Sets InfoWindow content with an error message and opens it on the map.
 */
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}

/**
 * Allows the user to set their position manually by clicking on the map.
 * Purpose: To let users define their location if geolocation is unavailable or incorrect.
 * How it works: Adds a click listener to the map that places the user marker and updates location variables.
 */
function manualPosition() {
  clearRadius();
  clearRoute();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
  clearDigitNeg();
  clearDigitKabKota();
  clearDigitProv();
  // clearDigitVillage();

  if (userLat == 0 && userLng == 0) {
    Swal.fire("Click on Map");
  }
  map.addListener("click", (mapsMouseEvent) => {
    infoWindow.close();
    pos = mapsMouseEvent.latLng;

    clearUser();
    markerOption = {
      position: pos,
      animation: google.maps.Animation.DROP,
      map: map,
    };

    let nearbyButton = "";
    if (!window.location.href.includes("web/aroundYou")) {
      nearbyButton =
        '<a title="Around You" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openAround()"><i class="fa-solid fa-compass"></i></a>';
    }
    userMarker.setOptions(markerOption);
    userInfoWindow.setContent(
      "<p class='text-center'><span class='fw-bold'>You are here.</span> <br> lat: " +
        pos.lat().toFixed(8) +
        "<br>long: " +
        pos.lng().toFixed(8) +
        "<br>" +
        "<br>" +
        nearbyButton +
        "</p>"
    );
    userInfoWindow.open(map, userMarker);

    userMarker.addListener("click", () => {
      userInfoWindow.open(map, userMarker);
    });

    setUserLoc(pos.lat().toFixed(8), pos.lng().toFixed(8));
    // console.log(userLat, userLng);
  });
}

/**
 * Renders a route from the user's location to a destination.
 * Purpose: To show navigation directions.
 * How it works: Uses DirectionsService to calculate a route and DirectionsRenderer to display it. Calls showSteps to list instructions.
 */
function routeTo(lat, lng, routeFromUser = true) {
  clearRadius();
  clearRoute();
  google.maps.event.clearListeners(map, "click");

  let start, end;
  if (routeFromUser) {
    if (userLat == 0 && userLng == 0) {
      return Swal.fire("Determine your position first!");
    }
    setUserLoc(userLat, userLng);
  }
  start = new google.maps.LatLng(currentLat, currentLng);
  end = new google.maps.LatLng(lat, lng);
  let request = {
    origin: start,
    destination: end,
    travelMode: "DRIVING",
  };
  
  if (!directionsService) {
    directionsService = new google.maps.DirectionsService();
  }

  directionsService.route(request, function (result, status) {
    if (status == "OK") {
      const renderer = new google.maps.DirectionsRenderer({
        map: map
      });
      renderer.setDirections(result);
      showSteps(result);
      routeArray.push(renderer);
    }
  });
  boundToRoute(start, end);
}

/**
 * Displays a marker for a loaded object.
 * Purpose: To show points of interest (attractions, homestays, etc.) on the map.
 * How it works: Creates a google.maps.Marker with a specific icon based on ID prefix. Adds a click listener to open the InfoWindow.
 */
function objectMarker(id, lat, lng, anim = true, attcat = null, login = false) {
  const currentUrl = window.location.href;
  if (!isCustomRoute) {
    google.maps.event.clearListeners(map, "click");
  }
  let pos = new google.maps.LatLng(lat, lng);
  let marker = new google.maps.Marker();

  let icon;
  if (id.substring(0, 1) === "R") {
    icon = baseUrl + "/media/icon/marker_rg.png";
  } else if (id.substring(0, 1) === "C") {
    icon = baseUrl + "/media/icon/marker_cp.png";
  } else if (id.substring(0, 1) === "W") {
    icon = baseUrl + "/media/icon/marker_wp.png";
  } else if (id.substring(0, 1) === "S") {
    icon = baseUrl + "/media/icon/marker_sp.png";
  } else if (id.substring(0, 1) === "E") {
    icon = baseUrl + "/media/icon/marker_ev.png";
  } else if (id.substring(0, 1) === "L") {
    icon = baseUrl + "/media/icon/marker_pr.png";
  } else if (id.substring(0, 1) === "A") {
    if (attcat === "1") {
      icon = baseUrl + "/media/icon/marker_uat.png";
    } else {
      icon = baseUrl + "/media/icon/marker_at.png";
    }
  } else if (id.substring(0, 1) === "V") {
    icon = baseUrl + "/media/icon/marker_sv.png";
  } else if (id.substring(0, 1) === "H") {
    icon = baseUrl + "/media/icon/marker_hs.png";
  }

  markerOption = {
    position: pos,
    icon: icon,
    animation: google.maps.Animation.DROP,
    map: map,
  };
  marker.setOptions(markerOption);
  if (!anim) {
    marker.setAnimation(null);
  }
  // if (currentUrl === "http://localhost:8080/web/uniquexAttraction") {
  // } else {
  // }
  marker.addListener("click", () => {
    infoWindow.close();
    villageInfoWindow.close();
    objectInfoWindow(id, attcat, login);
    infoWindow.open(map, marker);
    map.panTo(marker.getPosition());
  });

  markerArray[id] = marker;
}

/**
 * Displays the InfoWindow for a specific object.
 * Purpose: To show details about a selected marker.
 * How it works: Fetches object details via AJAX based on ID prefix (R, A, H, E, C, W, S, V, L) and populates the InfoWindow content.
 * Redirects:
 * - Rumah Gadang: /web/rumahGadang/{id}
 * - Attraction: /web/attraction/{id}
 * - Homestay: /web/homestay/{id}
 * - Event: /web/event/{id}
 * - Culinary: /web/culinaryPlace/{id}
 * - Worship: /web/worshipPlace/{id}
 * - Souvenir: /web/souvenirPlace/{id}
 */
function objectInfoWindow(id, attcat = null, login = false) {
  let content = "";
  let contentButton = "";
  let contentMobile = "";

  if (id.substring(0, 1) === "R") {
    $.ajax({
      url: baseUrl + "/api/rumahGadang/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let rgid = data.id;
        let name = data.name;
        let lat = data.lat;
        let lng = data.lng;
        let ticket_price =
          data.ticket_price == 0 ? "Free" : "Rp " + data.ticket_price;
        let open = data.open.substring(0, data.open.length - 3);
        let close = data.close.substring(0, data.close.length - 3);

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p> <br>" +
          '<p><i class="fa-solid fa-clock me-2"></i> ' +
          open +
          " - " +
          close +
          " WIB</p>" +
          '<p><i class="fa-solid fa-money-bill me-2"></i> ' +
          ticket_price +
          "</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/rumahGadang/" +
          rgid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + rgid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "</div>";
        contentMobile =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          "</div>";

        if (currentUrl.includes(id)) {
          if (currentUrl.includes("mobile")) {
            infoWindow.setContent(content + contentMobile);
          } else {
            infoWindow.setContent(content);
          }
          infoWindow.open(map, markerArray[rgid]);
        } else {
          infoWindow.setContent(content + contentButton);
        }
      },
    });
  } else if (id.substring(0, 1) === "A") {
    $.ajax({
      url: baseUrl + "/api/attraction/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let rgid = data.id;
        let name = data.name;
        let lat = data.lat;
        let lng = data.lng;
        let ticket_price = data.price;
        let open = data.open.substring(0, data.open.length - 3);
        let close = data.close.substring(0, data.close.length - 3);

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p> <br>" +
          '<p><i class="fa-solid fa-clock me-2"></i> ' +
          open +
          " - " +
          close +
          " WIB</p>" +
          '<p><i class="fa-solid fa-money-bill me-2"></i> ' +
          ticket_price +
          "</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/attraction/" +
          rgid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + rgid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "</div>";
        contentMobile =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          "</div>";

        if (currentUrl.includes(id)) {
          if (currentUrl.includes("mobile")) {
            infoWindow.setContent(content + contentMobile);
          } else {
            infoWindow.setContent(content);
          }
          infoWindow.open(map, markerArray[rgid]);
        } else {
          infoWindow.setContent(content + contentButton);
        }
      },
    });
  } else if (id.substring(0, 1) === "H") {
    $.ajax({
      url: baseUrl + "/api/homestay/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let rgid = data.id;
        let name = data.name;
        let price = data.price;
        let lat = data.lat;
        let lng = data.lng;
        let open = data.open.substring(0, data.open.length - 3);
        let close = data.close.substring(0, data.close.length - 3);

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p>" +
          '<p><i class="fa-solid fa-money-bills me-2"></i> ' +
          price +
          "</p>" +
          '<p><i class="fa-solid fa-clock me-2"></i> ' +
          open +
          " - " +
          close +
          " WIB</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        let bookingButton = "";
        if (login) {
          bookingButton =
            '<a id="btn-booking" class="btn btn-primary mt-1" onclick="iwOpsiBook(`' +
            rgid +
            '`)"><i class="fa-solid fa-bookmark me-3"></i>Booking</a>';
        } else {
          bookingButton =
            '<a id="btn-booking1" class="btn btn-primary mt-1" onclick="iwRedirectToLogin()"><i class="fa-solid fa-bookmark me-3"></i>Booking</a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/homestay/" +
          rgid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + rgid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "<br>" +
          bookingButton +
          "</div>";
        contentMobile =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          "</div>";

        if (currentUrl.includes(id)) {
          if (currentUrl.includes("mobile")) {
            infoWindow.setContent(content + contentMobile);
          } else {
            infoWindow.setContent(content);
          }
          infoWindow.open(map, markerArray[rgid]);
        } else {
          infoWindow.setContent(content + contentButton);
        }
      },
    });
  } else if (id.substring(0, 1) === "E") {
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    $.ajax({
      url: baseUrl + "/api/event/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        console.log(data);
        let evid = data.id;
        let name = data.name;
        let date = data.date;
        let lat = data.lat;
        let lng = data.lng;
        let ticket_price =
          data.ticket_price == 0 ? "Free" : "Rp " + data.ticket_price;
        let category = data.category;
        let date_next = new Date(data.date_next);
        let next =
          date_next.getDate() +
          " " +
          months[date_next.getMonth()] +
          " " +
          date_next.getFullYear();

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p> <br>" +
          '<p><i class="fa-solid fa-money-bill me-2"></i> ' +
          ticket_price +
          "</p>" +
          '<p><i class="fa-solid fa-calendar-days me-2"></i> ' +
          date +
          "</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/event/" +
          evid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + evid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "</div>";
        contentMobile =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          "</div>";

        if (currentUrl.includes(id)) {
          if (currentUrl.includes("mobile")) {
            infoWindow.setContent(content + contentMobile);
          } else {
            infoWindow.setContent(content);
          }
          infoWindow.open(map, markerArray[evid]);
        } else {
          infoWindow.setContent(content + contentButton);
        }
      },
    });
  } else if (id.substring(0, 1) === "C") {
    $.ajax({
      url: baseUrl + "/api/culinaryPlace/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let name = data.name;
        let open = data.open.substring(0, data.open.length - 3);
        let close = data.close.substring(0, data.close.length - 3);
        let rgid = data.id;
        let lat = data.lat;
        let lng = data.lng;

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p>" +
          '<p><i class="fa-solid fa-clock me-2"></i> ' +
          open +
          " - " +
          close +
          " WIB</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/culinaryPlace/" +
          rgid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + rgid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "</div>";

        infoWindow.setContent(content + contentButton);
      },
    });
  } else if (id.substring(0, 1) === "W") {
    $.ajax({
      url: baseUrl + "/api/worshipPlace/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let name = data.name;
        let rgid = data.id;
        let lat = data.lat;
        let lng = data.lng;

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/worshipPlace/" +
          rgid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + rgid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "</div>";
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p>" +
          "</div>";

        infoWindow.setContent(content + contentButton);
      },
    });
  } else if (id.substring(0, 1) === "S") {
    $.ajax({
      url: baseUrl + "/api/souvenirPlace/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let name = data.name;
        let open = data.open.substring(0, data.open.length - 3);
        let close = data.close.substring(0, data.close.length - 3);
        let rgid = data.id;
        let lat = data.lat;
        let lng = data.lng;

        let safeName = name.replace(/'/g, "\\'");
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          safeName +
          "</p>" +
          '<p><i class="fa-solid fa-clock me-2"></i> ' +
          open +
          " - " +
          close +
          " WIB</p>" +
          "</div>";

        let nearbyButton = "";
        if (!window.location.href.includes("web/aroundYou")) {
          nearbyButton =
            '<a title="Nearby" class="btn icon btn-outline-primary mx-1" id="nearbyInfoWindow" onclick="openNearby(`' +
            rgid +
            "`," +
            lat +
            "," +
            lng +
            ')"><i class="fa-solid fa-compass"></i></a>';
        }

        contentButton =
          '<br><div class="text-center">' +
          '<a title="Route" class="btn icon btn-outline-primary mx-1" id="routeInfoWindow" onclick="routeTo(' +
          lat +
          ", " +
          lng +
          ')"><i class="fa-solid fa-road"></i></a>' +
          '<a title="Info" class="btn icon btn-outline-primary mx-1" target="_blank" id="infoInfoWindow" href=' +
          baseUrl +
          "/web/souvenirPlace/" +
          rgid +
          '><i class="fa-solid fa-info"></i></a>' +
          nearbyButton +
          '<a title="Add to Custom Route" class="btn icon btn-outline-primary mx-1" onclick="addMarkerToCustomRoute(' + lat + ', ' + lng + ', \'' + safeName + '\', \'' + rgid + '\')"><i class="fa-solid fa-route"></i></a>' +
          "</div>";

        infoWindow.setContent(content + contentButton);
      },
    });
  } else if (id.substring(0, 1) === "V") {
    $.ajax({
      url: baseUrl + "/api/serviceProvider/" + id,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let name = data.name;

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
          "</p>" +
          "</div>";

        infoWindow.setContent(content);
      },
    });
  } else if (id.substring(0, 1) === "L") {
    $.ajax({
      url: baseUrl + "/api/touristVillage",
      dataType: "json",
      success: function (response) {
        let data = response.data;
        let name = data.name;

        content =
          '<div style="max-width:200px;max-height:300px;" class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
          "</p>" +
          '<p><i class="fa-solid fa-spa"></i> Tourism Village</p>' +
          "</div>";

        infoWindow.setContent(content);
      },
    });
  }
}

/**
 * Adjusts map bounds to fit all object markers.
 * Purpose: To ensure all displayed markers are visible.
 * How it works: Creates a LatLngBounds object, extends it with all marker positions, and calls map.fitBounds.
 */
function boundToObject(firstTime = true) {
  if (Object.keys(markerArray).length > 0) {
    bounds = new google.maps.LatLngBounds();
    for (i in markerArray) {
      bounds.extend(markerArray[i].getPosition());
    }
    if (window.location.href.indexOf("uniqueAttraction") > -1) {
      bounds.extend(
        new google.maps.LatLng(-0.10908259406018868, 100.66435044295643)
      );
    }
    if (firstTime) {
      map.fitBounds(bounds, 80);
      let listener = google.maps.event.addListener(map, "idle", function () {
        if (map.getZoom() < 15) map.setZoom(15);
        google.maps.event.removeListener(listener);
      });
    } else {
      map.panTo(bounds.getCenter());
    }
  } else {
    // let pos = new google.maps.LatLng(-0.4552969270702257, 100.49274351069286);
    // map.panTo(pos);
    digitTourismVillage();
  }
}

/**
 * Adjusts map bounds to fit a route.
 * Purpose: To ensure the entire route is visible.
 * How it works: Extends bounds with start and end points and calls map.panToBounds.
 */
function boundToRoute(start, end) {
  bounds = new google.maps.LatLngBounds();
  bounds.extend(start);
  bounds.extend(end);
  map.panToBounds(bounds, 100);
}

/**
 * Adjusts map bounds to fit a radius circle.
 * Purpose: To ensure the search radius is visible.
 * How it works: Creates a circle object and fits map bounds to its bounds.
 */
function boundToRadius(lat, lng, rad) {
  let userBound = new google.maps.LatLng(lat, lng);
  const radiusCircle = new google.maps.Circle({
    center: userBound,
    radius: Number(rad),
  });
  map.fitBounds(radiusCircle.getBounds());
}

/**
 * Draws a radius circle on the map.
 * Purpose: To visualize the search area.
 * How it works: Creates a google.maps.Circle and adds it to the map.
 */
function drawRadius(position, radius) {
  const radiusCircle = new google.maps.Circle({
    center: position,
    radius: radius,
    map: map,
    strokeColor: "#FF0000",
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: "#FF0000",
    fillOpacity: 0.35,
  });
  circleArray.push(radiusCircle);
  boundToRadius(currentLat, currentLng, radius);
}

/**
 * Updates the radius value display.
 * Purpose: To show the selected radius in meters.
 * How it works: Reads the input value, multiplies by 100, and updates the label text.
 */
function updateRadius(postfix) {
  // userInfoWindow.close();
  document.getElementById("radiusValue" + postfix).innerHTML =
    document.getElementById("inputRadius" + postfix).value * 100 + " m";
  console.log(
    document.getElementById("inputRadius" + postfix).value * 100 + " m"
  );
}

// function updateRadius(postfix) {
//   document.getElementById("radiusValue" + postfix).innerHTML =
//     document.getElementById("inputRadius" + postfix).value * 100 + " m";
// }

/**
 * Performs a radius search for objects.
 * Purpose: To find objects within a specified distance from the user.
 * How it works: Clears map, draws radius, and calls specific API endpoints (Nearby, RG, EV, AT, HS) via AJAX.
 */
function radiusSearch({ postfix = null } = {}) {
  if (userLat == 0 && userLng == 0) {
    document.getElementById("radiusValue" + postfix).innerHTML = "0 m";
    document.getElementById("inputRadius" + postfix).value = 0;
    return Swal.fire("Determine your position first!");
  }

  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let pos = new google.maps.LatLng(currentLat, currentLng);
  console.log(postfix);
  let radiusValue =
    parseFloat(document.getElementById("inputRadius" + postfix).value) * 100;
  map.panTo(pos);

  // find object in radius
  if (postfix === "Nearby") {
    drawRadius(pos, radiusValue);
  } else if (postfix === "RG") {
    $.ajax({
      url: baseUrl + "/api/rumahGadang/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radiusValue,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        drawRadius(pos, radiusValue);
      },
    });
  } else if (postfix === "EV") {
    console.log(currentLat + currentLng + radiusValue);
    $.ajax({
      url: baseUrl + "/api/event/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radiusValue,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        drawRadius(pos, radiusValue);
      },
    });
  } else if (postfix === "AT") {
    $.ajax({
      url: baseUrl + "/api/attraction/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radiusValue,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        drawRadius(pos, radiusValue);
      },
    });
  } else if (postfix === "HS") {
    $.ajax({
      url: baseUrl + "/api/homestay/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radiusValue,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        drawRadius(pos, radiusValue);
      },
    });
  }
}

/**
 * Focuses the map on a specific object.
 * Purpose: To highlight a selected object.
 * How it works: Triggers a click event on the object's marker and pans the map to it.
 */
function focusObject(id) {
  google.maps.event.trigger(markerArray[id], "click");
  map.panTo(markerArray[id].getPosition());
}

/**
 * Displays found objects in a list.
 * Purpose: To show search results in a table.
 * How it works: Iterates through the response data, appends rows to the table, and adds markers to the map.
 */
function displayFoundObject(response) {
  $("#table-data").empty();
  let data = response.data;
  let counter = 1;
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  for (i in data) {
    let item = data[i];
    let row;
    if (item.hasOwnProperty("date_next")) {
      let date_next = new Date(item.date_next);
      let next =
        date_next.getDate() +
        " " +
        months[date_next.getMonth()] +
        " " +
        date_next.getFullYear();
      row =
        "<tr>" +
        "<td>" +
        counter +
        "</td>" +
        '<td class="fw-bold">' +
        item.name +
        '<br><span class="text-muted">' +
        next +
        "</span></td>" +
        "<td>" +
        '<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-primary mx-1" onclick="focusObject(`' +
        item.id +
        '`);">' +
        '<span class="material-symbols-outlined">info</span>' +
        "</a>" +
        "</td>" +
        "</tr>";
    } else {
      row =
        "<tr>" +
        "<td>" +
        counter +
        "</td>" +
        '<td class="fw-bold">' +
        item.name +
        "</td>" +
        "<td>" +
        '<a data-bs-toggle="tooltip" data-bs-placement="bottom" title="More Info" class="btn icon btn-primary mx-1" onclick="focusObject(`' +
        item.id +
        '`);">' +
        '<span class="material-symbols-outlined">info</span>' +
        "</a>" +
        "</td>" +
        "</tr>";
    }
    $("#table-data").append(row);
    objectMarker(item.id, item.lat, item.lng);
    counter++;
  }
}

/**
 * Displays navigation steps.
 * Purpose: To show turn-by-turn directions.
 * How it works: Iterates through the route steps and appends them to a table.
 */
function showSteps(directionResult) {
  $("#direction-row").show();
  $("#table-direction").empty();
  let myRoute = directionResult.routes[0].legs[0];
  for (let i = 0; i < myRoute.steps.length; i++) {
    let distance = myRoute.steps[i].distance.value;
    let instruction = myRoute.steps[i].instructions;
    let row =
      "<tr>" +
      "<td>" +
      distance.toLocaleString("id-ID") +
      "</td>" +
      "<td>" +
      instruction +
      "</td>" +
      "</tr>";
    $("#table-direction").append(row);
  }
}

/**
 * Closes the nearby search section.
 * Purpose: To return to the main list view.
 * How it works: Hides nearby UI elements and shows the default lists.
 */
function closeNearby() {
  $("#direction-row").hide();
  $("#check-nearby-col").hide();
  $("#result-nearby-col").hide();
  $("#result-nearbyyou-col").hide();
  $("#list-rec-col").show();
  $("#list-rg-col").show();
  $("#list-ev-col").show();
}

/**
 * Opens the nearby search section for a specific object.
 * Purpose: To allow searching for amenities around a selected location.
 * How it works: Hides main lists, shows nearby UI, pans map, and sets up the radius input.
 */
function openNearby(id, lat, lng) {
  $("#list-rg-col").hide();
  $("#list-ev-col").hide();
  $("#list-rec-col").hide();
  $("#check-nearby-col").show();

  if (isCustomRoute) {
    toggleCustomRoute();
  }

  currentLat = lat;
  currentLng = lng;
  let pos = new google.maps.LatLng(currentLat, currentLng);
  map.panTo(pos);

  document
    .getElementById("inputRadiusNearby")
    .setAttribute(
      "onchange",
      'updateRadius("Nearby"); checkNearby("' + id + '")'
    );
}

/**
 * Searches for objects around a specific location.
 * Purpose: To find amenities (attractions, homestays, etc.) near a selected object.
 * How it works: Clears map, checks selected checkboxes, calls findNearby for each category, and draws the radius.
 */
function checkNearby(id) {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  objectMarker(id, currentLat, currentLng, false);

  $("#table-uatt").empty();
  $("#table-att").empty();
  $("#table-hs").empty();
  $("#table-cp").empty();
  $("#table-wp").empty();
  $("#table-sp").empty();
  $("#table-uatt").hide();
  $("#table-att").hide();
  $("#table-hs").hide();
  $("#table-cp").hide();
  $("#table-wp").hide();
  $("#table-sp").hide();

  let radiusValue =
    parseFloat(document.getElementById("inputRadiusNearby").value) * 100;
  const checkUATT = document.getElementById("check-uatt").checked;
  const checkATT = document.getElementById("check-att").checked;
  const checkHS = document.getElementById("check-hs").checked;
  const checkCP = document.getElementById("check-cp").checked;
  const checkWP = document.getElementById("check-wp").checked;
  const checkSP = document.getElementById("check-sp").checked;

  if (!checkUATT && !checkATT && !checkHS && !checkCP && !checkWP && !checkSP) {
    document.getElementById("radiusValueNearby").innerHTML = "0 m";
    document.getElementById("inputRadiusNearby").value = 0;
    return Swal.fire("Please choose one object");
  }

  if (checkUATT) {
    findNearby("uatt", radiusValue);
    $("#table-uatt").show();
  }
  if (checkATT) {
    findNearby("att", radiusValue);
    $("#table-att").show();
  }
  if (checkHS) {
    findNearby("hs", radiusValue);
    $("#table-hs").show();
  }
  if (checkCP) {
    findNearby("cp", radiusValue);
    $("#table-cp").show();
  }
  if (checkWP) {
    findNearby("wp", radiusValue);
    $("#table-wp").show();
  }
  if (checkSP) {
    findNearby("sp", radiusValue);
    $("#table-sp").show();
  }
  drawRadius(new google.maps.LatLng(currentLat, currentLng), radiusValue);
  $("#result-nearby-col").show();
}

/**
 * Searches for objects around the user's current location.
 * Purpose: To find amenities near the user.
 * How it works: Similar to checkNearby, but uses the user's current coordinates.
 */
function checkAround() {
  if (userLat == 0 && userLng == 0) {
    document.getElementById("radiusValueNearby").innerHTML = "0 m";
    document.getElementById("inputRadiusNearby").value = 0;
    return Swal.fire("Determine your position first!");
  }
  clearRadius();
  clearRoute();
  clearMarker();
  // clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  $("#table-uatt").empty();
  $("#table-att").empty();
  $("#table-hs").empty();
  $("#table-cp").empty();
  $("#table-wp").empty();
  $("#table-sp").empty();

  $("#table-uatt").hide();
  $("#table-att").hide();
  $("#table-hs").hide();
  $("#table-cp").hide();
  $("#table-wp").hide();
  $("#table-sp").hide();

  let radiusValue =
    parseFloat(document.getElementById("inputRadiusNearby").value) * 100;
  const checkuATT = document.getElementById("check-uatt").checked;
  const checkATT = document.getElementById("check-att").checked;
  const checkHS = document.getElementById("check-hs").checked;
  const checkCP = document.getElementById("check-cp").checked;
  const checkWP = document.getElementById("check-wp").checked;
  const checkSP = document.getElementById("check-sp").checked;

  if (!checkuATT && !checkATT && !checkHS && !checkCP && !checkWP && !checkSP) {
    document.getElementById("radiusValueNearby").innerHTML = "0 m";
    document.getElementById("inputRadiusNearby").value = 0;
    return Swal.fire("Please choose one object");
  }

  if (checkuATT) {
    findNearby("uatt", radiusValue);
    $("#table-uatt").show();
  }
  if (checkATT) {
    findNearby("att", radiusValue);
    $("#table-att").show();
  }
  if (checkHS) {
    findNearby("hs", radiusValue);
    $("#table-hs").show();
  }
  if (checkCP) {
    findNearby("cp", radiusValue);
    $("#table-cp").show();
  }
  if (checkWP) {
    findNearby("wp", radiusValue);
    $("#table-wp").show();
  }
  if (checkSP) {
    findNearby("sp", radiusValue);
    $("#table-sp").show();
  }
  drawRadius(new google.maps.LatLng(currentLat, currentLng), radiusValue);
  $("#result-nearby-col").show();
}

// function checkAround() {
//   if (userLat == 0 && userLng == 0) {
//     document.getElementById("radiusValueNearby").innerHTML = "0 m";
//     document.getElementById("inputRadiusNearby").value = 0;
//     return Swal.fire("Determine your position first!");
//   }

//   clearRadius();
//   clearRoute();
//   clearMarker();
//   destinationMarker.setMap(null);
//   google.maps.event.clearListeners(map, "click");

//   $("#table-uatt").empty();
//   $("#table-att").empty();
//   $("#table-hs").empty();
//   $("#table-cp").empty();
//   $("#table-wp").empty();
//   $("#table-sp").empty();

//   $("#table-uatt").hide();
//   $("#table-att").hide();
//   $("#table-hs").hide();
//   $("#table-cp").hide();
//   $("#table-wp").hide();
//   $("#table-sp").hide();

//   let pos = new google.maps.LatLng(currentLat, currentLng);
//   let radiusValue =
//     parseFloat(document.getElementById("inputRadiusNearby").value) * 100;
//   map.panTo(pos);

//   const checkuATT = document.getElementById("check-uatt").checked;
//   const checkATT = document.getElementById("check-att").checked;
//   const checkHS = document.getElementById("check-hs").checked;
//   const checkCP = document.getElementById("check-cp").checked;
//   const checkWP = document.getElementById("check-wp").checked;
//   const checkSP = document.getElementById("check-sp").checked;

//   if (!checkuATT && !checkATT && !checkHS && !checkCP && !checkWP && !checkSP) {
//     document.getElementById("radiusValueNearby").innerHTML = "0 m";
//     document.getElementById("inputRadiusNearby").value = 0;
//     return Swal.fire("Please choose one object");
//   }

//   if (checkuATT) {
//     findNearby("uatt", radiusValue);
//     $("#table-uatt").show();
//   }
//   if (checkATT) {
//     findNearby("att", radiusValue);
//     $("#table-att").show();
//   }
//   if (checkHS) {
//     findNearby("hs", radiusValue);
//     $("#table-hs").show();
//   }
//   if (checkCP) {
//     findNearby("cp", radiusValue);
//     $("#table-cp").show();
//   }
//   if (checkWP) {
//     findNearby("wp", radiusValue);
//     $("#table-wp").show();
//   }
//   if (checkSP) {
//     findNearby("sp", radiusValue);
//     $("#table-sp").show();
//   }
//   drawRadius(new google.maps.LatLng(currentLat, currentLng), radiusValue);
//   $("#result-nearby-col").show();
// }

/**
 * Fetches nearby objects by category.
 * Purpose: To retrieve data for nearby search.
 * How it works: Sends an AJAX POST request to the appropriate API endpoint based on the category.
 */
function findNearby(category, radius) {
  let pos = new google.maps.LatLng(currentLat, currentLng);
  if (category === "uatt") {
    $.ajax({
      url: baseUrl + "/api/attraction/findByRadius",
      type: "POST",
      data: {
        category: "1",
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  } else if (category === "att") {
    $.ajax({
      url: baseUrl + "/api/attraction/findByRadius",
      type: "POST",
      data: {
        category: "2",
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  } else if (category === "hs") {
    $.ajax({
      url: baseUrl + "/api/homestay/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  } else if (category === "cp") {
    $.ajax({
      url: baseUrl + "/api/culinaryPlace/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  } else if (category === "wp") {
    $.ajax({
      url: baseUrl + "/api/worshipPlace/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  } else if (category === "sp") {
    $.ajax({
      url: baseUrl + "/api/souvenirPlace/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  } else if (category === "sv") {
    $.ajax({
      url: baseUrl + "/api/serviceProvider/findByRadius",
      type: "POST",
      data: {
        lat: currentLat,
        long: currentLng,
        radius: radius,
      },
      dataType: "json",
      success: function (response) {
        displayNearbyResult(category, response);
      },
    });
  }
}

/**
 * Displays nearby search results.
 * Purpose: To render the results of findNearby in the UI.
 * How it works: Appends a table to the result container and adds rows for each found item. Adds markers to the map.
 */
function displayNearbyResult(category, response) {
  let data = response.data;
  let headerName;
  if (category === "uatt") {
    headerName = "Unique Attraction";
  } else if (category === "att") {
    headerName = "Ordinary Attraction";
  } else if (category === "hs") {
    headerName = "Homestay";
  } else if (category === "cp") {
    headerName = "Culinary";
  } else if (category === "wp") {
    headerName = "Worship";
  } else if (category === "sp") {
    headerName = "Souvenir";
  } else if (category === "sv") {
    headerName = "Service";
  }

  let table =
    "<thead><tr>" +
    '<th style="width: 50%;">' +
    headerName +
    " Name</th>" +
    '<th style="width: 50%;">Action</th>' +
    "</tr></thead>" +
    '<tbody id="data-' +
    category +
    '">' +
    "</tbody>";
  $("#table-" + category).append(table);

  for (i in data) {
    let item = data[i];
    let row =
      "<tr>" +
      '<td class="fw-bold">' +
      item.name +
      "</td>" +
      "<td>" +
      '<a title="Route" class="btn icon btn-primary mx-1" onclick="routeTo(' +
      item.lat +
      ", " +
      item.lng +
      ', false)"><i class="fa-solid fa-road"></i></a>' +
      '<a title="Info" class="btn icon btn-primary mx-1" onclick="infoModal(`' +
      item.id +
      '`)"><i class="fa-solid fa-info"></i></a>' +
      '<a title="Location" class="btn icon btn-primary mx-1" onclick="focusObject(`' +
      item.id +
      '`);"><i class="fa-solid fa-location-dot"></i></a>' +
      "</td>" +
      "</tr>";
    $("#data-" + category).append(row);
    if (category === "uatt" || category === "att") {
      objectMarker(item.id, item.lat, item.lng, true, item.attraction_category);
    } else {
      objectMarker(item.id, item.lat, item.lng);
    }
  }
}

/**
 * Opens a modal (new tab) with object details.
 * Purpose: To show full information about an object.
 * How it works: Opens a new window with the detail URL.
 * Redirects:
 * - Culinary: /web/culinaryPlace/{id}
 * - Homestay: /web/homestay/{id}
 * - Attraction: /web/attraction/{id}
 * - Worship: /web/worshipPlace/{id}
 * - Souvenir: /web/souvenirPlace/{id}
 * - Service: /web/serviceProvider/{id}
 */
function infoModal(id) {
  let title, content;
  if (id.substring(0, 1) === "C") {
    window.open(baseUrl + "/web/culinaryPlace/" + id, "_blank");
  } else if (id.substring(0, 1) === "H") {
    window.open(baseUrl + "/web/homestay/" + id, "_blank");
  } else if (id.substring(0, 1) === "A") {
    window.open(baseUrl + "/web/attraction/" + id, "_blank");
  } else if (id.substring(0, 1) === "W") {
    window.open(baseUrl + "/web/worshipPlace/" + id, "_blank");
  } else if (id.substring(0, 1) === "S") {
    window.open(baseUrl + "/web/souvenirPlace/" + id, "_blank");
  } else if (id.substring(0, 1) === "V") {
    window.open(baseUrl + "/web/serviceProvider/" + id, "_blank");
  }
}

/**
 * Finds objects by name.
 * Purpose: To search for specific objects (RG, EV, AT, HS).
 * How it works: Sends an AJAX POST request with the name query to the corresponding API.
 */
function findByName(category) {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let name;
  if (category === "RG") {
    name = document.getElementById("nameRG").value;
    $.ajax({
      url: baseUrl + "/api/rumahGadang/findByName",
      type: "POST",
      data: {
        name: name,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (category === "EV") {
    name = document.getElementById("nameEV").value;
    $.ajax({
      url: baseUrl + "/api/event/findByName",
      type: "POST",
      data: {
        name: name,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (category === "AT") {
    name = document.getElementById("nameAT").value;
    $.ajax({
      url: baseUrl + "/api/attraction/findByName",
      type: "POST",
      data: {
        name: name,
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (category === "HS") {
    name = document.getElementById("nameHS").value;
    $.ajax({
      url: baseUrl + "/api/homestay/findByName",
      type: "POST",
      data: {
        name: name,
      },
      dataType: "json",
      success: function (response) {
        console.log(response);
        displayFoundObject(response);
        boundToObject();
      },
    });
  }
}

/**
 * Fetches Rumah Gadang facilities.
 * Purpose: To populate a select dropdown with facilities.
 * How it works: AJAX GET to /api/facility.
 */
function getFacility() {
  let facility;
  $("#facilitySelect").empty();
  $.ajax({
    url: baseUrl + "/api/facility",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        facility =
          '<option value="' + item.id + '">' + item.facility + "</option>";
        $("#facilitySelect").append(facility);
      }
    },
  });
}
/**
 * Fetches Attraction facilities.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/attractionFacility.
 */
function getATFacility() {
  let facility;
  $("#atfacilitySelect").empty();
  $.ajax({
    url: baseUrl + "/api/attractionFacility",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        facility = '<option value="' + item.id + '">' + item.name + "</option>";
        $("#atfacilitySelect").append(facility);
      }
    },
  });
}
/**
 * Fetches Homestay facilities.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/homestayFacility.
 */
function getHSFacility() {
  let facility;
  $("#hsfacilitySelect").empty();
  $.ajax({
    url: baseUrl + "/api/homestayFacility",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        facility = '<option value="' + item.id + '">' + item.name + "</option>";
        $("#hsfacilitySelect").append(facility);
      }
    },
  });
}

/**
 * Finds Attractions by facility.
 * Purpose: To filter attractions.
 * How it works: AJAX POST to /api/attraction/findByFacility.
 */
function findByFacility() {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let facility = document.getElementById("atfacilitySelect").value;
  $.ajax({
    url: baseUrl + "/api/attraction/findByFacility",
    type: "POST",
    data: {
      facility: facility,
    },
    dataType: "json",
    success: function (response) {
      displayFoundObject(response);
      boundToObject();
    },
  });
}
/**
 * Finds Homestays by facility.
 * Purpose: To filter homestays.
 * How it works: AJAX POST to /api/homestay/findByFacility.
 */
function findByFacilityHS() {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let facility = document.getElementById("hsfacilitySelect").value;
  $.ajax({
    url: baseUrl + "/api/homestay/findByFacility",
    type: "POST",
    data: {
      facility: facility,
    },
    dataType: "json",
    success: function (response) {
      displayFoundObject(response);
      boundToObject();
    },
  });
}

/**
 * Sets the star rating value.
 * Purpose: To handle UI interaction for rating input.
 * How it works: Updates the visual state of stars and sets the hidden input value.
 */
function setStar(star) {
  switch (star) {
    case "star-1":
      $("#star-1").addClass("star-checked");
      $("#star-2,#star-3,#star-4,#star-5").removeClass("star-checked");
      document.getElementById("rating").setAttribute("value", "1");
      break;
    case "star-2":
      $("#star-1,#star-2").addClass("star-checked");
      $("#star-3,#star-4,#star-5").removeClass("star-checked");
      document.getElementById("rating").setAttribute("value", "2");
      break;
    case "star-3":
      $("#star-1,#star-2,#star-3").addClass("star-checked");
      $("#star-4,#star-5").removeClass("star-checked");
      document.getElementById("rating").setAttribute("value", "3");
      break;
    case "star-4":
      $("#star-1,#star-2,#star-3,#star-4").addClass("star-checked");
      $("#star-5").removeClass("star-checked");
      document.getElementById("rating").setAttribute("value", "4");
      break;
    case "star-5":
      $("#star-1,#star-2,#star-3,#star-4,#star-5").addClass("star-checked");
      document.getElementById("rating").setAttribute("value", "5");
      break;
  }
}
/**
 * Sets the rating star value (alternative).
 * Purpose: To handle UI interaction for another rating input.
 * How it works: Updates visual state and hidden input.
 */
function setRatingStar(star) {
  switch (star) {
    case "rstar-1":
      $("#rstar-1").addClass("star-checked");
      $("#rstar-2,#rstar-3,#rstar-4,#rstar-5").removeClass("star-checked");
      document.getElementById("rating_star").setAttribute("value", "1");
      break;
    case "rstar-2":
      $("#rstar-1,#rstar-2").addClass("star-checked");
      $("#rstar-3,#rstar-4,#rstar-5").removeClass("star-checked");
      document.getElementById("rating_star").setAttribute("value", "2");
      break;
    case "rstar-3":
      $("#rstar-1,#rstar-2,#rstar-3").addClass("star-checked");
      $("#rstar-4,#rstar-5").removeClass("star-checked");
      document.getElementById("rating_star").setAttribute("value", "3");
      break;
    case "rstar-4":
      $("#rstar-1,#rstar-2,#rstar-3,#rstar-4").addClass("star-checked");
      $("#rstar-5").removeClass("star-checked");
      document.getElementById("rating_star").setAttribute("value", "4");
      break;
    case "rstar-5":
      $("#rstar-1,#rstar-2,#rstar-3,#rstar-4,#rstar-5").addClass(
        "star-checked"
      );
      document.getElementById("rating_star").setAttribute("value", "5");
      break;
  }
}

/**
 * Finds objects by rating.
 * Purpose: To filter objects (RG, EV, HS) by star rating.
 * How it works: AJAX POST to the corresponding API endpoint.
 */
function findByRating(category) {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let rating = document.getElementById("rating").value;
  if (category === "RG") {
    $.ajax({
      url: baseUrl + "/api/rumahGadang/findByRating",
      type: "POST",
      data: {
        rating: rating,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (category === "EV") {
    $.ajax({
      url: baseUrl + "/api/event/findByRating",
      type: "POST",
      data: {
        rating: rating,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (category === "HS") {
    $.ajax({
      url: baseUrl + "/api/homestay/findByRating",
      type: "POST",
      data: {
        rating: rating,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  }
}

/**
 * Finds Homestays by unit availability.
 * Purpose: To filter homestays.
 * How it works: AJAX POST to /api/homestay/findByUnit.
 */
function findByUnit() {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let unit = document.getElementById("unitHSSelect").value;
  $.ajax({
    url: baseUrl + "/api/homestay/findByUnit",
    type: "POST",
    data: {
      unit: unit,
    },
    dataType: "json",
    success: function (response) {
      displayFoundObject(response);
      boundToObject();
    },
  });
}
/**
 * Finds objects by category.
 * Purpose: To filter objects (RG, EV, HS) by category.
 * How it works: AJAX POST to the corresponding API endpoint.
 */
function findByCategory(object) {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  if (object === "RG") {
    let category = document.getElementById("categoryRGSelect").value;
    $.ajax({
      url: baseUrl + "/api/rumahGadang/findByCategory",
      type: "POST",
      data: {
        category: category,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (object === "EV") {
    let category = document.getElementById("categoryEVSelect").value;
    $.ajax({
      url: baseUrl + "/api/event/findByCategory",
      type: "POST",
      data: {
        category: category,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  } else if (object === "HS") {
    let category = document.getElementById("categoryHSSelect").value;
    $.ajax({
      url: baseUrl + "/api/homestay/findByCategory",
      type: "POST",
      data: {
        category: category,
      },
      dataType: "json",
      success: function (response) {
        displayFoundObject(response);
        boundToObject();
      },
    });
  }
}

/**
 * Fetches Event categories.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/event/category.
 */
function getCategory() {
  let category;
  $("#categoryEVSelect").empty();
  $.ajax({
    url: baseUrl + "/api/event/category",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        category =
          '<option value="' + item.id + '">' + item.category + "</option>";
        $("#categoryEVSelect").append(category);
      }
    },
  });
}

/**
 * Finds Events by date.
 * Purpose: To filter events.
 * How it works: AJAX POST to /api/event/findByDate.
 */
function findByDate() {
  clearRadius();
  clearRoute();
  clearMarker();
  clearUser();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");
  closeNearby();

  let eventDate = document.getElementById("eventDate").value;
  $.ajax({
    url: baseUrl + "/api/event/findByDate",
    type: "POST",
    data: {
      date: eventDate,
    },
    dataType: "json",
    success: function (response) {
      displayFoundObject(response);
      boundToObject();
    },
  });
}

/**
 * Adds a compass control to the map.
 * Purpose: To show orientation.
 * How it works: Creates a DOM element with a compass image and pushes it to map controls.
 */
function setCompass() {
  const compass = document.createElement("div");
  compass.setAttribute("id", "compass");
  const compassDiv = document.createElement("div");
  compass.appendChild(compassDiv);
  const compassImg = document.createElement("img");
  compassImg.src = baseUrl + "/media/icon/compass.png";
  compassDiv.appendChild(compassImg);

  map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(compass);
}

/**
 * Creates and adds a legend to the map.
 * Purpose: To explain map icons.
 * How it works: Iterates through an icons object, creates HTML elements, and adds them to the map controls.
 */
function getLegend() {
  const icons = {
    my: {
      name: "Malaysia",
      icon: baseUrl + "/media/icon/my.png",
    },
    sg: {
      name: "Singapore",
      icon: baseUrl + "/media/icon/sg.png",
    },
    brd: {
      name: "Brunei Darussalam",
      icon: baseUrl + "/media/icon/brd.png",
    },
    uAtt: {
      name: "Unique Attraction",
      icon: baseUrl + "/media/icon/marker_uat.png",
    },
    oAtt: {
      name: "Ordinary Attraction",
      icon: baseUrl + "/media/icon/marker_at.png",
    },
    hs: {
      name: "Homestay",
      icon: baseUrl + "/media/icon/marker_hs.png",
    },
    cp: {
      name: "Culinary Place",
      icon: baseUrl + "/media/icon/marker_cp.png",
    },
    wp: {
      name: "Worship Place",
      icon: baseUrl + "/media/icon/marker_wp.png",
    },
    sp: {
      name: "Souvenir Place",
      icon: baseUrl + "/media/icon/marker_sp.png",
    },
  };

  const title = '<p class="fw-bold fs-6">Legend</p>';
  $("#legend").append(title);

  for (key in icons) {
    const type = icons[key];
    const name = type.name;
    const icon = type.icon;
    const div = '<div><img src="' + icon + '"> ' + name + "</div>";

    $("#legend").append(div);
  }
  map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);
}

/**
 * Toggles the visibility of the legend.
 * Purpose: To show/hide the legend.
 * How it works: Toggles the display style of the #legend element.
 */
function viewLegend() {
  if ($("#legend").is(":hidden")) {
    $("#legend").show();
  } else {
    $("#legend").hide();
  }
}

/**
 * Creates and adds a traffic legend to the map.
 * Purpose: To explain traffic colors.
 * How it works: Similar to getLegend but for traffic.
 */
function getLegendTraffic() {
  const icons = {
    green: {
      name: "No Traffic Jam",
      icon: baseUrl + "/media/icon/traffic_green.png",
    },
    yellow: {
      name: "Light Traffic Jam",
      icon: baseUrl + "/media/icon/traffic_yellow.png",
    },
    medred: {
      name: "Heavy Traffic Jam",
      icon: baseUrl + "/media/icon/traffic_medred.png",
    },
    red: {
      name: "Severe Traffic Jam",
      icon: baseUrl + "/media/icon/traffic_red.png",
    },
  };

  const title = '<p class="fw-bold fs-6">Traffic Legend</p>';
  $("#legend_t").append(title);

  for (key in icons) {
    const type = icons[key];
    const name = type.name;
    const icon = type.icon;
    const div = '<div><img src="' + icon + '"> ' + name + "</div>";

    $("#legend_t").append(div);
  }
  map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(legend_t);
}

/**
 * Toggles the visibility of the traffic legend.
 * Purpose: To show/hide the traffic legend.
 * How it works: Toggles the display style of #legend_t.
 */
function viewLegendTraffic() {
  if ($("#legend_t").is(":hidden")) {
    $("#legend_t").show();
  } else {
    $("#legend_t").hide();
  }
}

let trafficVisible = false;

const trafficLayer = new google.maps.TrafficLayer();

/**
 * Toggles the traffic layer on the map.
 * Purpose: To show/hide real-time traffic info.
 * How it works: Sets the trafficLayer map property to map or null.
 */
function showTraffic() {
  if (trafficVisible) {
    trafficLayer.setMap(null); // Remove traffic layer from the map
    $("#legend_t").show();
  } else {
    trafficLayer.setMap(map); // Add traffic layer to the map
    $("#legend_t").hide();
  }
  trafficVisible = !trafficVisible;
}

/**
 * Populates the object select list based on category.
 * Purpose: To dynamically load objects for forms (e.g., visit history).
 * How it works: Checks selected category and makes AJAX call to fetch corresponding objects.
 */
function getObjectByCategory() {
  const category = document.getElementById("category").value;
  $("#object").empty();
  if (category === "None") {
    object = '<option value="None">Select Category First</option>';
    $("#object").append(object);
    return Swal.fire({
      icon: "warning",
      title: "Please Choose a Object Category!",
    });
  }
  if (category === "1") {
    $.ajax({
      url: baseUrl + "/api/rumahGadang",
      dataType: "json",
      success: function (response) {
        let data = response.data;
        for (i in data) {
          let item = data[i];
          object = '<option value="' + item.id + '">' + item.name + "</option>";
          $("#object").append(object);
        }
      },
    });
  } else if (category === "2") {
    $.ajax({
      url: baseUrl + "/api/event",
      dataType: "json",
      success: function (response) {
        let data = response.data;
        for (i in data) {
          let item = data[i];
          object = '<option value="' + item.id + '">' + item.name + "</option>";
          $("#object").append(object);
        }
      },
    });
  }
}

/**
 * Validates star rating input.
 * Purpose: To ensure a rating is selected before submission.
 * How it works: Checks if value is "0" and prevents default action if so.
 */
function checkStar(event) {
  const star = document.getElementById("rating").value;
  if (star == "0") {
    event.preventDefault();
    Swal.fire("Please put rating star");
  }
}
/**
 * Validates rating star input (alternative).
 * Purpose: To ensure a rating is selected.
 * How it works: Checks if value is "0".
 */
function checkRatingStar(event) {
  const star = document.getElementById("rating_star").value;
  if (star == "0") {
    event.preventDefault();
    Swal.fire("Please put rating star");
  }
}

/**
 * Validates form category and object selection.
 * Purpose: To ensure valid selections.
 * How it works: Checks if values are "None".
 */
function checkForm(event) {
  const category = document.getElementById("category").value;
  const object = document.getElementById("object").value;
  if (category === "None" || object === "None") {
    event.preventDefault();
    Swal.fire("Please select the correct Category and Object");
  }
}

/**
 * Previews an uploaded image.
 * Purpose: To show the user what they selected.
 * How it works: Uses FileReader to read the file and set the src of the preview image.
 */
function showPreview(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      $("#avatar-preview").attr("src", e.target.result).width(300).height(300);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

/**
 * Fetches recommendation list.
 * Purpose: To populate a select dropdown for recommendations.
 * How it works: AJAX GET to /api/recommendationList.
 */
function getRecommendation(id, recom) {
  let recommendation;
  $("#recommendationSelect" + id).empty();
  $.ajax({
    url: baseUrl + "/api/recommendationList",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        if (item.id == recom) {
          recommendation =
            '<option value="' +
            item.id +
            '" selected>' +
            item.name +
            "</option>";
        } else {
          recommendation =
            '<option value="' + item.id + '">' + item.name + "</option>";
        }
        $("#recommendationSelect" + id).append(recommendation);
      }
    },
  });
}

/**
 * Toggles edit mode for recommendation.
 * Purpose: To enable/disable the change listener for updating recommendations.
 * How it works: Toggles button visibility and attaches/removes event listener.
 */
function changeRecom(status = null) {
  if (status === "edit") {
    $("#recomBtnEdit").hide();
    $("#recomBtnExit").show();
    console.log("entering edit mode");
    $(".recomSelect").on("change", updateRecom);
  } else {
    $("#recomBtnEdit").show();
    $("#recomBtnExit").hide();
    console.log("exiting edit mode");
    $(".recomSelect").off("change", updateRecom);
  }
}

/**
 * Updates the recommendation via AJAX.
 * Purpose: To save the selected recommendation.
 * How it works: Sends POST request to /api/recommendation.
 */
function updateRecom() {
  let recom = $(this).find("option:selected").val();
  let id = $(this).attr("id");
  $.ajax({
    url: baseUrl + "/api/recommendation",
    type: "POST",
    data: {
      id: id,
      recom: recom,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === 201) {
        console.log("Success update recommendation @" + id + ":" + recom);
        Swal.fire("Success updating Rumah Gadang ID @" + id);
      }
    },
  });
}

/**
 * Pans map to coordinates from input fields.
 * Purpose: To locate a point entered manually.
 * How it works: Reads lat/lng inputs, creates a marker, and pans map.
 */
function findCoords(object) {
  clearMarker();
  google.maps.event.clearListeners(map, "click");

  const lat = Number(document.getElementById("latitude").value);
  const lng = Number(document.getElementById("longitude").value);

  if (lat === 0 || lng === 0 || isNaN(lat) || isNaN(lng)) {
    return Swal.fire("Please input Lat and Long");
  }

  let pos = new google.maps.LatLng(lat, lng);
  let marker = new google.maps.Marker();
  markerOption = {
    position: pos,
    animation: google.maps.Animation.DROP,
    map: map,
  };
  marker.setOptions(markerOption);
  markerArray[1] = marker;
  map.panTo(pos);
}

/**
 * Clears the selection in Drawing Manager.
 * Purpose: To deselect a shape.
 * How it works: Sets editable to false and clears selectedShape variable.
 */
function clearSelection() {
  if (selectedShape) {
    selectedShape.setEditable(false);
    selectedShape = null;
  }
}

/**
 * Sets a shape as selected.
 * Purpose: To make a shape editable.
 * How it works: Clears previous selection, sets new selection, and enables editing.
 */
function setSelection(shape) {
  clearSelection();
  selectedShape = shape;
  shape.setEditable(true);
}

/**
 * Deletes the selected shape.
 * Purpose: To remove a drawn polygon.
 * How it works: Clears inputs, markers, sets shape map to null, and resets drawing manager options.
 */
function deleteSelectedShape() {
  if (selectedShape) {
    document.getElementById("latitude").value = "";
    document.getElementById("longitude").value = "";
    document.getElementById("geo-json").value = "";
    document.getElementById("lat").value = "";
    document.getElementById("lng").value = "";
    clearMarker();
    selectedShape.setMap(null);
    // To show:
    drawingManager.setOptions({
      drawingMode: google.maps.drawing.OverlayType.POLYGON,
      drawingControl: true,
    });
  }
}

/**
 * Initializes the Google Maps Drawing Manager.
 * Purpose: To allow drawing polygons on the map.
 * How it works: Sets up DrawingManager options and event listeners for overlaycomplete, click, etc.
 */
function initDrawingManager(edit = false) {
  // The DrawingManager is deprecated. We are commenting out this function
  // to prevent fatal JavaScript errors.
  console.warn("DrawingManager is deprecated and has been disabled.");
  // If you need drawing functionality, you must implement it manually
  // using google.maps.Polygon and map click events.
}

/**
 * Saves the selected shape as GeoJSON.
 * Purpose: To convert the drawn polygon into a format suitable for storage.
 * How it works: Converts shape paths to GeoJSON and updates hidden input fields.
 */
function saveSelection(shape) {
  const paths = shape.getPath().getArray();
  let bounds = new google.maps.LatLngBounds();
  for (let i = 0; i < paths.length; i++) {
    bounds.extend(paths[i]);
  }
  let pos = bounds.getCenter();
  map.panTo(pos);

  clearMarker();
  let marker = new google.maps.Marker();
  markerOption = {
    position: pos,
    animation: google.maps.Animation.DROP,
    map: map,
  };
  marker.setOptions(markerOption);
  markerArray["newRG"] = marker;

  document.getElementById("latitude").value = pos.lat().toFixed(8);
  document.getElementById("longitude").value = pos.lng().toFixed(8);
  document.getElementById("lat").value = pos.lat().toFixed(8);
  document.getElementById("lng").value = pos.lng().toFixed(8);

  const dataLayer = new google.maps.Data();
  dataLayer.add(
    new google.maps.Data.Feature({
      geometry: new google.maps.Data.Polygon([shape.getPath().getArray()]),
    })
  );
  dataLayer.toGeoJson(function (object) {
    document.getElementById("geo-json").value = JSON.stringify(
      object.features[0].geometry
    );
  });
}

/**
 * Fetches list of users/owners.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/owner.
 */
function getListUsers(owner) {
  console.log(owner);
  let users;
  $("#ownerSelect").empty();
  $.ajax({
    url: baseUrl + "/api/owner",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        if (!item.first_name) {
          item.first_name = "";
        }
        if (!item.last_name) {
          item.last_name = "";
        }
        if (item.id == owner) {
          users =
            '<option value="' +
            item.id +
            '" selected>' +
            item.first_name +
            " " +
            item.last_name +
            " (" +
            item.username +
            ")</option>";
        } else {
          users =
            '<option value="' +
            item.id +
            '">' +
            item.first_name +
            " " +
            item.last_name +
            " (@" +
            item.username +
            ")</option>";
        }
        $("#ownerSelect").append(users);
      }
    },
  });
}
/**
 * Fetches list of villages.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/selectVillage.
 */
function getListVillage() {
  $("#catSelect").empty();
  let cats;
  $.ajax({
    url: baseUrl + "/api/selectVillage",
    dataType: "json",
    success: function (response) {
      cats =
        '<option value="" selected disabled>--- Choose Village ---</option>';
      $("#catSelect").append(cats);
      let data = response.data;
      for (i in data) {
        let item = data[i];
        cats = '<option value="' + item.id + '">' + item.name + "</option>";
        $("#catSelect").append(cats);
      }
    },
  });
}
// Variabel untuk menyimpan referensi village
let currentVillage = null;

/**
 * Fetches and displays village geometry.
 * Purpose: To show a specific village on the map and populate a form.
 * How it works: AJAX GET to /api/village/{id}, loads GeoJSON, and dynamically builds a form.
 */
function getVillageGeom(id_village) {
  // Jika ada polygon village yang sudah ada, hapus dari peta
  if (currentVillage) {
    currentVillage.setMap(null); // Menghapus polygon sebelumnya
  }

  $.ajax({
    url: baseUrl + "/api/village/" + id_village,
    type: "GET",
    dataType: "json",
    success: function (response) {
      const data = response.data;

      // Buat instance baru dari google.maps.Data untuk village baru
      currentVillage = new google.maps.Data();
      currentVillage.loadGeoJson(
        "/map/tourism_village/" + data.geom_file,
        null,
        function (features) {
          let bounds = new google.maps.LatLngBounds();

          // Mendapatkan bounds dari semua fitur GeoJSON
          features.forEach(function (feature) {
            feature.getGeometry().forEachLatLng(function (latlng) {
              bounds.extend(latlng);
            });
          });

          // Fokuskan peta ke area village
          map.fitBounds(bounds);

          // Mendapatkan pusat dari bounds
          let center = bounds.getCenter();

          // Set style untuk village polygon
          currentVillage.setStyle({
            fillColor: "#f3fa32",
            strokeWeight: 0.5,
            strokeColor: "#005000",
            fillOpacity: 0.2,
            clickable: true,
            title: data.name,
          });

          // Tampilkan info window di tengah village
          villageInfoWindow.setContent(data.name);
          villageInfoWindow.setPosition(center);
          villageInfoWindow.open(map);

          // Tambahkan listener untuk klik pada village
          currentVillage.addListener("click", function (event) {
            villageInfoWindow.close();
            villageInfoWindow.setContent(data.name);
            villageInfoWindow.setPosition(event.latLng);
            villageInfoWindow.open(map);
          });
        }
      );

      // Set village polygon pada peta
      currentVillage.setMap(map);
    },
  });
  let vform;
  vform =
    '<div class="card-body">' +
    '<form class="form form-vertical mx-4 mt-3" action="" method="post" id="uploadForm" enctype="multipart/form-data">' +
    '<div class="form-body">' +
    '<input type="hidden" name="id_village" value="' +
    id_village +
    '" required>' +
    '<div class="form-group mb-4">' +
    '<label for="address" class="form-label">Address</label>' +
    '<textarea class="form-control" id="address" name="address" rows="2" required></textarea>' +
    "</div>" +
    '<div class="form-group mb-4">' +
    '<label for="description" class="form-label">Description</label>' +
    '<textarea class="form-control" id="description" name="description" rows="4" required></textarea>' +
    "</div>" +
    '<div class="row">' +
    '<div class="form-group col-md-4 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">Open</label>' +
    '<div class="input-group">' +
    '<input type="time" id="capacity" class="form-control" name="open" placeholder="Capacity" aria-label="Ticket Price" aria-describedby="ticket-price" value="" required>' +
    '<span class="input-group-text">WIB</span>' +
    "</div>" +
    "</div>" +
    '<div class="form-group col-md-2 col-12 mb-4">' +
    "</div>" +
    '<div class="form-group col-md-4 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">Ticket Price</label>' +
    '<div class="input-group">' +
    '<span class="input-group-text">Rp.</span>' +
    '<input type="number" id="capacity" class="form-control" name="ticket_price" placeholder="Ticket Price" aria-label="Ticket Price" aria-describedby="ticket-price" value="">' +
    "</div>" +
    "</div>" +
    "</div>" +
    '<div class="row">' +
    '<div class="form-group col-md-4 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">Close</label>' +
    '<div class="input-group">' +
    '<input type="time" id="capacity" class="form-control" name="close" placeholder="Capacity" aria-label="Ticket Price" aria-describedby="ticket-price" value="" required>' +
    '<span class="input-group-text">WIB</span>' +
    "</div>" +
    "</div>" +
    "</div>" +
    '<div class="row mt-3">' +
    '<div class="form-group col-md-6 col-12 mb-4">' +
    '<label for="email" class="mb-2">Email</label>' +
    '<input type="email" id="email" class="form-control" name="email" placeholder="Email" aria-label="Ticket Price" aria-describedby="ticket-price" value="">' +
    "</div>" +
    "</div>" +
    '<div class="row mt-3">' +
    '<div class="form-group col-md-3 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">Facebook</label>' +
    '<div class="input-group">' +
    '<span class="input-group-text">@</span>' +
    '<input type="text" id="capacity" class="form-control" name="facebook" placeholder="Facebook" aria-label="Ticket Price" aria-describedby="ticket-price" value="">' +
    "</div>" +
    "</div>" +
    '<div class="form-group col-md-3 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">Instagram</label>' +
    '<div class="input-group">' +
    '<span class="input-group-text">@</span>' +
    '<input type="text" id="capacity" class="form-control" name="instagram" placeholder="Instagram" aria-label="Ticket Price" aria-describedby="ticket-price" value="">' +
    "</div>" +
    "</div>" +
    '<div class="form-group col-md-3 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">Youtube</label>' +
    '<div class="input-group">' +
    '<span class="input-group-text">@</span>' +
    '<input type="text" id="capacity" class="form-control" name="youtube" placeholder="Youtube" aria-label="Ticket Price" aria-describedby="ticket-price" value="">' +
    "</div>" +
    "</div>" +
    '<div class="form-group col-md-3 col-12 mb-4">' +
    '<label for="capacity" class="mb-2">TikTok</label>' +
    '<div class="input-group">' +
    '<span class="input-group-text">@</span>' +
    '<input type="text" id="capacity" class="form-control" name="tiktok" placeholder="TikTok" aria-label="Ticket Price" aria-describedby="ticket-price" value="">' +
    "</div>" +
    "</div>" +
    "</div>" +
    '<div class="row mt-3 mb-4">' +
    '<div class="form-group col-md-6 col-12 mb-4">' +
    '<label for="gallery" class="form-label">Photos</label>' +
    '<input class="form-control" accept="image/*" type="file" name="gallery[]" id="gallery" multiple>' +
    "</div>" +
    '<div class="form-group col-md-6 col-12 mb-4">' +
    '<label for="video" class="form-label">Video</label>' +
    '<input class="form-control" accept="video/*, .mkv" type="file" name="video" id="video">' +
    "</div>" +
    "</div>" +
    '<button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>' +
    '<button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>' +
    "</div>" +
    "</form>" +
    "</div>";
  $("#village-form").empty();
  $("#village-form").append(vform);

  FilePond.registerPlugin(
    FilePondPluginFileValidateSize,
    FilePondPluginFileValidateType,
    FilePondPluginImageExifOrientation,
    FilePondPluginImagePreview,
    FilePondPluginImageResize,
    FilePondPluginMediaPreview
  );

  // Get a reference to the file input element
  const photo = document.querySelector('input[id="gallery"]');
  const video = document.querySelector('input[id="video"]');

  // Create a FilePond instance
  const pond = FilePond.create(photo, {
    maxFileSize: "1920MB",
    maxTotalFileSize: "1920MB",
    imageResizeTargetHeight: 720,
    imageResizeUpscale: false,
    credits: false,
  });
  const vidPond = FilePond.create(video, {
    maxFileSize: "1920MB",
    maxTotalFileSize: "1920MB",
    credits: false,
  });

  let uploadedPhotos = 0;

  pond.setOptions({
    server: {
      timeout: 3600000,
      process: {
        url: "/upload/photo",
        onload: (response) => {
          console.log("processed:", response);
          uploadedPhotos++;
          console.log(uploadedPhotos);
          return response;
        },
        onerror: (response) => {
          console.log("error:", response);
          return response;
        },
      },
      revert: {
        url: "/upload/photo",
        onload: (response) => {
          console.log("reverted:", response);
          uploadedPhotos--;
          console.log(uploadedPhotos);
          return response;
        },
        onerror: (response) => {
          console.log("error:", response);
          return response;
        },
      },
    },
  });

  vidPond.setOptions({
    server: {
      timeout: 86400000,
      process: {
        url: "/upload/video",
        onload: (response) => {
          console.log("processed:", response);
          return response;
        },
        onerror: (response) => {
          console.log("error:", response);
          return response;
        },
      },
      revert: {
        url: "/upload/video",
        onload: (response) => {
          console.log("reverted:", response);
          return response;
        },
        onerror: (response) => {
          console.log("error:", response);
          return response;
        },
      },
    },
  });
  document
    .getElementById("uploadForm")
    .addEventListener("submit", function (e) {
      e.preventDefault(); // Mencegah form dikirim langsung

      // Validasi jumlah file yang diupload
      if (uploadedPhotos < 4) {
        Swal.fire("You must upload a minimum of 4 photos!");
      } else {
        // alert("Form valid dan bisa dikirim!");
        // Lakukan pengiriman form secara manual jika validasi berhasil
        // Misalnya dengan AJAX, atau submit form di sini jika diperlukan
        this.submit(); // Uncomment jika ingin melanjutkan pengiriman
      }
    });
}

/**
 * Fetches Attraction categories.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/aTTCat.
 */
function getListATTCat(cat_id) {
  let cats;
  $("#catSelect").empty();
  $.ajax({
    url: baseUrl + "/api/aTTCat",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      console.log(data);
      for (i in data) {
        let item = data[i];
        if (item.id == cat_id) {
          cats =
            '<option value="' +
            item.id +
            '" selected>' +
            item.name +
            "</option>";
        } else {
          cats = '<option value="' + item.id + '">' + item.name + "</option>";
        }
        $("#catSelect").append(cats);
      }
    },
  });
}

/**
 * Fetches Worship Place categories.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/wPCat.
 */
function getListWPCat(cat_id) {
  let cats;
  $("#catSelect").empty();
  $.ajax({
    url: baseUrl + "/api/wPCat",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      console.log(data);
      for (i in data) {
        let item = data[i];
        if (item.id == cat_id) {
          cats =
            '<option value="' +
            item.id +
            '" selected>' +
            item.name +
            "</option>";
        } else {
          cats = '<option value="' + item.id + '">' + item.name + "</option>";
        }
        $("#catSelect").append(cats);
      }
    },
  });
}
/**
 * Fetches Homestay Unit Facilities.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/homestayUnitFac.
 */
function getListFHU(homestay_id, unit_type, unit_number) {
  $("#proSelect").empty();
  $.ajax({
    url:
      baseUrl +
      "/api/homestayUnitFac/" +
      homestay_id +
      "/" +
      unit_type +
      "/" +
      unit_number,
    dataType: "json",
    success: function (response) {
      let data = response.data;
      $("#proSelect").append(
        '<option value="" selected disabled>Choose Facility</option>'
      );
      for (i in data) {
        let item = data[i];
        cats = '<option value="' + item.id + '">' + item.name + "</option>";
        $("#proSelect").append(cats);
      }
    },
  });
}
/**
 * Fetches Souvenir Products.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/proList.
 */
function getListSPP(cat_id, sp_id) {
  let cats;
  $("#proSelect").empty();
  $.ajax({
    url: baseUrl + "/api/proList/" + sp_id,
    dataType: "json",
    success: function (response) {
      let data = response.data;
      console.log(data);
      if (!cat_id) {
        $("#proSelect").append(
          "<option disabled selected>Choose Product</option>"
        );
      }
      if (data) {
        for (i in data) {
          let item = data[i];
          if (item.id == cat_id) {
            cats =
              '<option value="' +
              item.id +
              '" selected>' +
              item.name +
              "</option>";
          } else {
            cats = '<option value="' + item.id + '">' + item.name + "</option>";
          }
          $("#proSelect").append(cats);
        }
      }
    },
  });
}
/**
 * Fetches Culinary Products.
 * Purpose: To populate a select dropdown.
 * How it works: AJAX GET to /api/culList.
 */
function getListCPP(cat_id, sp_id) {
  let cats;
  $("#proSelect").empty();
  $.ajax({
    url: baseUrl + "/api/culList/" + sp_id,
    dataType: "json",
    success: function (response) {
      let data = response.data;
      console.log(data);
      if (!cat_id) {
        $("#proSelect").append(
          "<option disabled selected>Choose Product</option>"
        );
      }
      if (data) {
        for (i in data) {
          let item = data[i];
          if (item.id == cat_id) {
            cats =
              '<option value="' +
              item.id +
              '" selected>' +
              item.name +
              "</option>";
          } else {
            cats = '<option value="' + item.id + '">' + item.name + "</option>";
          }
          $("#proSelect").append(cats);
        }
      }
    },
  });
}

/**
 * Draws a polygon from GeoJSON input.
 * Purpose: To visualize existing geometry in edit mode.
 * How it works: Parses GeoJSON string from input and creates a google.maps.Polygon.
 */
function drawGeom() {
  const geoJSON = $("#geo-json").val();
  if (geoJSON !== "") {
    const geoObj = JSON.parse(geoJSON);
    const coords = geoObj.coordinates[0];
    let polygonCoords = [];
    for (i in coords) {
      polygonCoords.push({ lat: coords[i][1], lng: coords[i][0] });
    }
    const polygon = new google.maps.Polygon({
      paths: polygonCoords,
      fillColor: "blue",
      strokeColor: "blue",
      editable: true,
    });
    polygon.setMap(map);
    return polygon;
  }
}
/**
 * Deletes a unit facility.
 * Purpose: To remove a facility from a unit.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deleteUnitFacility(
  homestay_id = null,
  unit_type = null,
  unit_number = null,
  facility_id = null,
  name = null,
  user = false
) {
  Swal.fire({
    title: "Delete Unit Facility?",
    text: "You are about to remove " + name,
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/dashboard/homestayUnit/facility/delete/" +
          homestay_id +
          "/" +
          unit_type +
          "/" +
          unit_number +
          "/" +
          facility_id,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire(
              "Deleted!",
              "Successfully remove " + name,
              "success"
            ).then((result) => {
              if (result.isConfirmed) {
                document.location.reload();
              }
            });
          } else {
            Swal.fire("Failed", "Delete " + name + " failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes an event date.
 * Purpose: To remove a date from an event.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deleteEventDate(event_id = null, date = null) {
  Swal.fire({
    title: "Delete Date?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: baseUrl + "/dashboard/event/" + event_id + "/date/" + date,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes a package day.
 * Purpose: To remove a day from a package.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deletePackageDay(homestay_id = null, package_id = null, day = null) {
  Swal.fire({
    title: "Delete Package Day?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/dashboard/packageDay/delete/" +
          homestay_id +
          "/" +
          package_id +
          "/" +
          day,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes a custom package day.
 * Purpose: To remove a day from a custom package.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deleteCustomPackageDay(
  homestay_id = null,
  package_id = null,
  day = null
) {
  console.log(homestay_id + package_id + day);
  Swal.fire({
    title: "Delete Package Day?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/web/packageDay/delete/" +
          homestay_id +
          "/" +
          package_id +
          "/" +
          day,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes a package detail (activity).
 * Purpose: To remove an activity from a package day.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deletePackageDetail(
  homestay_id = null,
  package_id = null,
  day = null,
  activity = null
) {
  Swal.fire({
    title: "Delete Activity?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/dashboard/packageDetail/delete/" +
          homestay_id +
          "/" +
          package_id +
          "/" +
          day +
          "/" +
          activity,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes a custom package detail.
 * Purpose: To remove an activity from a custom package day.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deletePackageDetailC(
  homestay_id = null,
  package_id = null,
  day = null,
  activity = null
) {
  Swal.fire({
    title: "Delete Activity?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/web/packageDetail/delete/" +
          homestay_id +
          "/" +
          package_id +
          "/" +
          day +
          "/" +
          activity,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes a package service.
 * Purpose: To remove a service from a package.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deletePackageService(
  homestay_id = null,
  package_id = null,
  package_service_id = null
) {
  Swal.fire({
    title: "Delete Service?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/dashboard/packageService/delete/" +
          homestay_id +
          "/" +
          package_id +
          "/" +
          package_service_id,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}
/**
 * Deletes a custom package service.
 * Purpose: To remove a service from a custom package.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deletePackageServiceC(
  homestay_id = null,
  package_id = null,
  package_service_id = null
) {
  Swal.fire({
    title: "Delete Service?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/web/packageService/delete/" +
          homestay_id +
          "/" +
          package_id +
          "/" +
          package_service_id,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}

/**
 * Generic delete function for various objects.
 * Purpose: To handle deletion of different entity types based on ID prefix.
 * How it works: Determines the API endpoint based on ID, sends AJAX DELETE request, and reloads page on success.
 */
function deleteObject(id = null, name = null, user = false) {
  if (id === null) {
    return Swal.fire("ID cannot be null");
  }

  let content, apiUri, urlok, contentParam, homestay_id;
  let souvenirPlaceId, souvenirProductId;
  let culinaryPlaceId, culinaryProductId;
  let worshipPlaceId;

  if (id.substring(0, 1) === "R") {
    content = "Reservation";
    apiUri = "reservation/";
  } else if (id.substring(0, 1) === "H") {
    content = "Homestay";
    apiUri = "homestay/";
  } else if (id.substring(0, 1) === "B") {
    id = id.substring(1, 3);
    content = "Homestay Facility";
  } else if (id.substring(0, 1) === "K") {
    id = id.substring(1, 3);
    content = "Souvenir Place Facility";
  } else if (id.substring(0, 1) === "M") {
    id = id.substring(1, 3);
    content = "Culinary Place Facility";
  } else if (id.substring(0, 1) === "N") {
    id = id.substring(1, 3);
    content = "Worship Place Facility";
  } else if (id.substring(0, 1) === "D") {
    id = id.substring(1, 3);
    content = "Homestay Unit Facility";
  } else if (id.substring(0, 1) === "I") {
    id = id.substring(1, 3);
    content = "Homestay Unit";
  } else if (id.substring(0, 1) === "G") {
    homestay_id = id.substring(3, 6);
    id = id.substring(1, 3);
    content = "Homestay Additional Amenities";
  } else if (id.substring(0, 1) === "F") {
    id = id.substring(1, 3);
    content = "Unit Facility";
  } else if (id.substring(0, 1) === "V") {
    content = "Service Provider";
    apiUri = "serviceProvider/";
  } else if (id.substring(0, 1) === "J") {
    id = id.substring(1, 3);
    content = "Service";
  } else if (id.substring(0, 1) === "S") {
    content = "Souvenir Place";
    apiUri = "souvenirPlace/";
  } else if (id.substring(0, 1) === "Y") {
    souvenirPlaceId = id.substring(1, 3);
    souvenirProductId = id.substring(3, 5);
    content = "Product";
    contentParam = "Product Souvenir";
  } else if (id.substring(0, 1) === "Z") {
    id = id.substring(1, 3);
    content = "Souvenir Product";
  } else if (id.substring(0, 1) === "C") {
    content = "Culinary Place";
    apiUri = "culinaryPlace/";
  } else if (id.substring(0, 1) === "U") {
    souvenirPlaceId = id.substring(1, 3);
    souvenirProductId = id.substring(3, 5);
    content = "Product";
    contentParam = "Product Culinary";
  } else if (id.substring(0, 1) === "X") {
    id = id.substring(1, 3);
    content = "Culinary Product";
  } else if (id.substring(0, 1) === "A") {
    content = "Attraction";
    apiUri = "attraction/";
  } else if (id.substring(0, 1) === "T") {
    id = id.substring(1, 3);
    content = "Attraction Facility";
  } else if (id.substring(0, 1) === "Q") {
    id = id.substring(1, 3);
    content = "Attraction Ticket";
  } else if (id.substring(0, 1) === "W") {
    content = "Worship Place";
    apiUri = "worshipPlace/";
  } else if (id.substring(0, 1) === "E") {
    content = "Event";
    apiUri = "event/";
  } else if (id.substring(0, 1) === "P") {
    homestay_id = id.substring(4, 7);
    id = id.substring(0, 4);
    content = "Package";
    apiUri = "package/";
  } else if (user === true) {
    content = "User";
    apiUri = "user/";
  } else if (id.substring(0, 1) === "L") {
    id = id.substring(0, 5);
    content = "Announcement";
    apiUri = "announcement/";
  } else {
    content = "Facility";
    apiUri = "facility/";
  }

  urlok = baseUrl + "/api/" + apiUri + id;
  if (content === "Service") {
    urlok = "/dashboard/serviceProvider/service/delete/" + id;
  }
  if (content === "Souvenir Product") {
    urlok = "/dashboard/souvenirPlace/product/delete/" + id;
  }
  if (content === "Culinary Product") {
    urlok = "/dashboard/culinaryPlace/product/delete/" + id;
  }
  if (content === "Attraction Facility") {
    urlok = "/dashboard/attraction/facility/delete/" + id;
  }
  if (content === "Attraction Ticket") {
    urlok = "/dashboard/attraction/ticket/delete/" + id;
  }
  if (content === "Homestay Facility") {
    urlok = "/dashboard/facilityHomestay/delete/" + id;
  }
  if (content === "Souvenir Place Facility") {
    urlok = "/dashboard/facilitySouvenirPlace/delete/" + id;
  }
  if (content === "Culinary Place Facility") {
    urlok = "/dashboard/facilityCulinaryPlace/delete/" + id;
  }
  if (content === "Worship Place Facility") {
    urlok = "/dashboard/facilityWorshipPlace/delete/" + id;
  }
  if (content === "Homestay Unit") {
    urlok = "/dashboard/homestayUnit/delete/" + id;
  }
  if (content === "Homestay Unit Facility") {
    urlok = "/dashboard/facilityUnit/delete/" + id;
  }
  if (content === "Homestay Additional Amenities") {
    urlok = "/dashboard/additionalAmenities/delete/" + homestay_id + "/" + id;
  }
  if (content === "Reservation") {
    if (user === true) {
      urlok = "/web/reservation/delete/" + id;
    } else {
      urlok = "/dashboard/reservation/delete/" + id;
    }
  }
  if (content === "Package") {
    urlok = "/dashboard/tourismPackage/delete/" + homestay_id + "/" + id;
  }
  if (contentParam === "Product Souvenir") {
    urlok =
      "/dashboard/souvenirPlace/" +
      souvenirPlaceId +
      "/product/" +
      souvenirProductId +
      "/delete";
  }
  if (contentParam === "Product Culinary") {
    urlok =
      "/dashboard/culinaryPlace/" +
      souvenirPlaceId +
      "/product/" +
      souvenirProductId +
      "/delete";
  }
  if (content === "Announcement") {
    urlok = baseUrl + "/dashboard/announcement/delete/" + id;
  }

  Swal.fire({
    title: "Delete " + content + "?",
    text: "You are about to remove " + name,
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: urlok,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire(
              "Deleted!",
              "Successfully remove " + name,
              "success"
            ).then((result) => {
              if (result.isConfirmed) {
                document.location.reload();
              }
            });
          } else {
            Swal.fire("Failed", "Delete " + name + " failed!", "warning");
          }
        },
      });
    }
  });
}

/// Android API ///

/**
 * Sets user position (API/Android).
 * Purpose: To update user location from external source.
 * How it works: Updates marker and global variables.
 */
function userPositionAPI(lat = null, lng = null) {
  clearRadius();
  clearRoute();

  infoWindow.close();
  let pos = new google.maps.LatLng(lat, lng);

  clearUser();
  markerOption = {
    position: pos,
    map: map,
  };
  userMarker.setOptions(markerOption);

  setUserLoc(pos.lat().toFixed(8), pos.lng().toFixed(8));
}

/**
 * Pans map to user position.
 * Purpose: To center map on user.
 * How it works: Uses map.panTo with user coordinates.
 */
function panToUser() {
  if (userLat == 0 && userLng == 0) {
    return Swal.fire("Determine your position first!");
  }
  let pos = new google.maps.LatLng(userLat, userLng);
  map.panTo(pos);
}

/**
 * Finds Rumah Gadang (Mobile).
 * Purpose: Mobile-specific search by name.
 * How it works: AJAX POST to /api/rumahGadang/findByName.
 */
function findRG(name = null) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/rumahGadang/findByName",
    type: "POST",
    data: {
      name: name,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Rumah Gadang by Rating (Mobile).
 * Purpose: Mobile-specific search by rating.
 * How it works: AJAX POST to /api/rumahGadang/findByRating.
 */
function findByRatingRG(rating) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/rumahGadang/findByRating",
    type: "POST",
    data: {
      rating: rating,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Rumah Gadang by Facility (Mobile).
 * Purpose: Mobile-specific search by facility.
 * How it works: AJAX POST to /api/rumahGadang/findByFacility.
 */
function findByFacilityRG(facility) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/rumahGadang/findByFacility",
    type: "POST",
    data: {
      facility: facility,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Rumah Gadang by Category (Mobile).
 * Purpose: Mobile-specific search by category.
 * How it works: AJAX POST to /api/rumahGadang/findByCategory.
 */
function findByCategoryRG(category) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/rumahGadang/findByCategory",
    type: "POST",
    data: {
      category: category,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Event by Name (Mobile).
 * Purpose: Mobile-specific search by name.
 * How it works: AJAX POST to /api/event/findByName.
 */
function findEV(name = null) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/event/findByName",
    type: "POST",
    data: {
      name: name,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Event by Rating (Mobile).
 * Purpose: Mobile-specific search by rating.
 * How it works: AJAX POST to /api/event/findByRating.
 */
function findByRatingEV(rating) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/event/findByRating",
    type: "POST",
    data: {
      rating: rating,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Event by Category (Mobile).
 * Purpose: Mobile-specific search by category.
 * How it works: AJAX POST to /api/event/findByCategory.
 */
function findByCategoryEV(category) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  currentUrl = "mobile";
  $.ajax({
    url: baseUrl + "/api/event/findByCategory",
    type: "POST",
    data: {
      category: category,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Finds Event by Date (Mobile).
 * Purpose: Mobile-specific search by date.
 * How it works: AJAX POST to /api/event/findByDate.
 */
function findByDateEV(eventDate) {
  clearRadius();
  clearRoute();
  clearMarker();
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  $.ajax({
    url: baseUrl + "/api/event/findByDate",
    type: "POST",
    data: {
      date: eventDate,
    },
    dataType: "json",
    success: function (response) {
      let data = response.data;
      for (i in data) {
        let item = data[i];
        currentUrl = currentUrl + item.id;
        objectMarker(item.id, item.lat, item.lng);
      }
      boundToObject();
    },
  });
}

/**
 * Fetches Homestay Name by User ID.
 * Purpose: To display the homestay name associated with a user.
 * How it works: AJAX GET to /api/getHomestayNameByUser.
 */
function getHSName(id) {
  $.ajax({
    url: baseUrl + "/api/getHomestayNameByUser/" + id,
    type: "GET",
    dataType: "json",
    success: function (response) {
      let data = response.data;
      console.log(data);
      document.getElementById("homestayName").innerHTML = data;
    },
  });
}
/**
 * Fetches objects for Tourism Package.
 * Purpose: To populate a select dropdown for package details.
 * How it works: AJAX GET to /dashboard/packageDetail/getObject.
 */
function getListObject(homestay_id, package_id, day) {
  $("#ownerSelect").empty();
  $.ajax({
    url:
      baseUrl +
      "/dashboard/packageDetail/getObject/" +
      homestay_id +
      "/" +
      package_id +
      "/" +
      day,
    dataType: "json",
    success: function (response) {
      $("#activitySelect" + day).append(
        '<option value="" selected disabled>Choose Object</option>'
      );
      let data = response.data;
      for (i in data) {
        let item = data[i];
        if (item.price_for_package) {
          if (item.price_for_package === "Rp 0/person") {
            item.price_for_package = "Free";
          }
          objs =
            '<option value="' +
            item.id_object +
            '">[' +
            item.activity_type +
            "] " +
            item.object_name +
            " (" +
            item.price_for_package +
            ")" +
            "</option>";
        } else {
          objs =
            '<option value="' +
            item.id_object +
            '">[' +
            item.activity_type +
            "] " +
            item.object_name +
            "</option>";
        }
        $("#activitySelect" + day).append(objs);
      }
    },
  });
}
/**
 * Fetches objects for Custom Tourism Package.
 * Purpose: To populate a select dropdown for custom package details.
 * How it works: AJAX GET to /web/packageDetail/getObject.
 */
function getListObjectC(homestay_id, package_id, day, date) {
  $("#ownerSelect").empty();
  $.ajax({
    url:
      baseUrl +
      "/web/packageDetail/getObject/" +
      homestay_id +
      "/" +
      package_id +
      "/" +
      day +
      "/" +
      date,
    dataType: "json",
    success: function (response) {
      $("#activitySelect" + day).append(
        '<option value="" selected disabled>Choose Object</option>'
      );
      let data = response.data;
      for (i in data) {
        let item = data[i];
        if (item.price_for_package) {
          if (item.price_for_package === "Rp 0/person") {
            item.price_for_package = "Free";
          }
          objs =
            '<option value="' +
            item.id_object +
            '">[' +
            item.activity_type +
            "] " +
            item.object_name +
            " (" +
            item.price_for_package +
            ")" +
            "</option>";
        } else {
          objs =
            '<option value="' +
            item.id_object +
            '">[' +
            item.activity_type +
            "] " +
            item.object_name +
            "</option>";
        }
        $("#activitySelect" + day).append(objs);
      }
    },
  });
}
/**
 * Fetches services for Tourism Package.
 * Purpose: To populate a select dropdown for package services.
 * How it works: AJAX GET to /dashboard/packageService.
 */
function getListPackageService(homestay_id = null, package_id = null) {
  $("#ownerSelect").empty();
  $.ajax({
    url:
      baseUrl + "/dashboard/packageService/" + homestay_id + "/" + package_id,
    dataType: "json",
    success: function (response) {
      $("#serviceSelect").append(
        '<option value="" selected disabled>Choose Service</option>'
      );
      let data = response.data;
      for (i in data) {
        let item = data[i];
        objs =
          '<option value="' +
          item.id +
          '">' +
          item.name +
          " (" +
          item.price +
          ")</option>";
        $("#serviceSelect").append(objs);
      }
    },
  });
}
/**
 * Fetches services for Custom Tourism Package.
 * Purpose: To populate a select dropdown for custom package services.
 * How it works: AJAX GET to /web/packageService.
 */
function getListPackageServiceC(homestay_id = null, package_id = null) {
  $("#serviceSelect").empty();
  $.ajax({
    url: baseUrl + "/web/packageService/" + homestay_id + "/" + package_id,
    dataType: "json",
    success: function (response) {
      $("#serviceSelect").append(
        '<option value="" selected disabled>Choose Service</option>'
      );
      let data = response.data;
      for (i in data) {
        let item = data[i];
        objs =
          '<option value="' +
          item.id +
          '">' +
          item.name +
          " (" +
          item.price +
          ")</option>";
        $("#serviceSelect").append(objs);
      }
    },
  });
}

/**
 * Fetches additional amenities.
 * Purpose: To populate a select dropdown for additional amenities.
 * How it works: AJAX GET to /web/getAdditionalAmenities.
 */
function getListAdditionalAmenities(reservation_id = null, homestay_id = null) {
  $("#serviceSelect").empty();
  $.ajax({
    url:
      baseUrl +
      "/web/getAdditionalAmenities/" +
      homestay_id +
      "/" +
      reservation_id,
    dataType: "json",
    success: function (response) {
      $("#serviceSelect").append(
        '<option value="" selected disabled>Choose Additional Amenities</option>'
      );
      let data = response.data;
      for (i in data) {
        let item = data[i];
        if (item.category === "1") {
          category = "Facility";
        } else {
          category = "Service";
        }
        objs =
          '<option value="' +
          item.additional_amenities_id +
          item.is_order_count_per_day +
          item.is_order_count_per_person +
          item.is_order_count_per_room +
          item.real_price +
          '" data-available_stock="' +
          item.available_stock +
          '">[' +
          category +
          "]" +
          item.name +
          " (" +
          item.price +
          ")</option>";
        $("#serviceSelect").append(objs);
      }
    },
  });
}

/**
 * Generates input fields for ordering amenities.
 * Purpose: To create dynamic form fields based on amenity type (per day, per person, etc.).
 * How it works: Parses the ID string to determine requirements and appends HTML to #additionalAmenitiesOrderFields.
 */
function getOrderField(
  id = null,
  homestay_id = null,
  total_day = null,
  total_people = null,
  total_room = null
) {
  console.log(id);
  additional_amenities_id = id.substring(0, 2);
  is_order_count_per_day = id.substring(2, 3);
  is_order_count_per_person = id.substring(3, 4);
  is_order_count_per_room = id.substring(4, 5);
  price = id.substring(5);

  let selectInput = document.getElementById("serviceSelect");
  let available_stock = selectInput.options[
    selectInput.selectedIndex
  ].getAttribute("data-available_stock");

  console.log(available_stock);

  $("#additionalAmenitiesOrderFields").empty();
  objs = "";
  if (available_stock !== "undefined") {
    objs =
      objs +
      '<span>(Available stock : </span><span id="available_stock">' +
      available_stock +
      "</span><span>)</span>";
  }
  if (
    is_order_count_per_day === "1" ||
    is_order_count_per_person === "1" ||
    is_order_count_per_room === "1"
  ) {
    if (is_order_count_per_day === "1") {
      objs =
        objs +
        ' <div class="form-group mb-4">' +
        '<label for="address" class="mb-2">Day Order</label>' +
        '<input type="number" class="form-control" id="dayOrder" name="day_order" min="1" onchange="getTotalOrder(' +
        price +
        ')" required>' +
        "</div>";
    }
    if (is_order_count_per_person === "1") {
      objs =
        objs +
        ' <div class="form-group mb-4">' +
        '<label for="address" class="mb-2">Person Order</label>' +
        '<input type="number" class="form-control" id="personOrder" name="person_order" min="1" onchange="getTotalOrder(' +
        price +
        ')" required>' +
        "</div>";
    }
    if (is_order_count_per_room === "1") {
      objs =
        objs +
        ' <div class="form-group mb-4">' +
        '<label for="address" class="mb-2">Room Order</label>' +
        '<input type="number" class="form-control" id="roomOrder" name="room_order" min="1" onchange="getTotalOrder(' +
        price +
        ')" required>' +
        "</div>";
    }
    objs =
      objs +
      ' <div class="form-group mb-4">' +
      '<label for="address" class="mb-2">Total Order</label>' +
      '<input type="number" class="form-control" id="totalOrder" name="total_order" readonly required>' +
      "</div>";
  } else {
    objs =
      objs +
      ' <div class="form-group mb-4">' +
      '<label for="address" class="mb-2">Total Order</label>' +
      '<input type="number" class="form-control" id="totalOrder" name="total_order" min="1" onchange="getTotalPrice(' +
      price +
      ')" required>' +
      "</div>";
  }
  objs =
    objs +
    '<div class="form-group mb-4">' +
    '<label for="address" class="mb-2">Total Price</label>' +
    '<div class="input-group">' +
    '<span class="input-group-text">Rp</span>' +
    '<input type="number" class="form-control" id="totalPrice" name="total_price" readonly required>' +
    "</div>" +
    "</div>";
  $("#additionalAmenitiesOrderFields").append(objs);
  if (
    is_order_count_per_day === "1" ||
    is_order_count_per_person === "1" ||
    is_order_count_per_room === "1"
  ) {
    total_order = 1;
    if (is_order_count_per_day === "1") {
      document.getElementById("dayOrder").setAttribute("value", total_day);
      document.getElementById("dayOrder").setAttribute("max", total_day);
      total_order = total_order * total_day;
    }
    if (is_order_count_per_person === "1") {
      document
        .getElementById("personOrder")
        .setAttribute("value", total_people);
      document.getElementById("personOrder").setAttribute("max", total_people);
      total_order = total_order * total_people;
    }
    if (is_order_count_per_room === "1") {
      document.getElementById("roomOrder").setAttribute("value", total_room);
      document.getElementById("roomOrder").setAttribute("max", total_room);
      total_order = total_order * total_room;
    }
    document.getElementById("totalOrder").setAttribute("value", total_order);
    total_price = total_order * price;
    console.log(price);
    document.getElementById("totalPrice").setAttribute("value", total_price);
  }
}

/**
 * Calculates total order quantity and price.
 * Purpose: To update totals when individual order fields change.
 * How it works: Multiplies day, person, and room orders to get total order, then multiplies by price.
 */
function getTotalOrder(price = null) {
  const day_order = document.getElementById("dayOrder");
  const person_order = document.getElementById("personOrder");
  const room_order = document.getElementById("roomOrder");

  total_order =
    (day_order ? day_order.value : 1) *
    (person_order ? person_order.value : 1) *
    (room_order ? room_order.value : 1);

  document.getElementById("totalOrder").setAttribute("value", total_order);
  document
    .getElementById("totalPrice")
    .setAttribute("value", total_order * price);
}

/**
 * Calculates total price based on total order.
 * Purpose: To update total price when total order changes directly.
 * How it works: Multiplies total order by price.
 */
function getTotalPrice(price = null) {
  const total_order = document.getElementById("totalOrder");

  document
    .getElementById("totalPrice")
    .setAttribute("value", total_order.value * price);
}

/**
 * Fetches available units based on type and date.
 * Purpose: To show available homestay units for reservation.
 * How it works: AJAX GET to /web/reservation/unit, then populates the #units-available container.
 */
function getUnitType(homestay_id = null) {
  const unitType = document.getElementById("unit_type");
  const dayOfStay = document.getElementById("day_of_stay");
  const checkInInput = document.getElementById("check_in");
  if (
    dayOfStay.value != 0 &&
    checkInInput.value !== "" &&
    unitType.value !== ""
  ) {
    const checkOutInput = document.getElementById("check_out");
    const checkInTimeInput = document.getElementById("check_in_time");
    if (unitType.value === "3") {
      var checkInDate = new Date(checkInInput.value);
      checkInDate.setDate(
        checkInDate.getDate() + parseInt(dayOfStay.value) - 1
      );
      let coyear = checkInDate.getFullYear();
      let comonth = checkInDate.getMonth() + 1;
      if (comonth < 10) {
        comonth = "0" + comonth;
      }
      let codaydate = checkInDate.getDate();
      if (codaydate < 10) {
        codaydate = "0" + codaydate;
      }

      let checkOutVal = coyear + "-" + comonth + "-" + codaydate + "T23:59";
      checkOutInput.value = checkOutVal;
      checkInTimeInput.value = "06:00";
      console.log("oke");
    } else {
      var checkInDate = new Date(checkInInput.value);
      checkInDate.setDate(checkInDate.getDate() + parseInt(dayOfStay.value));
      let coyear = checkInDate.getFullYear();
      let comonth = checkInDate.getMonth() + 1;
      if (comonth < 10) {
        comonth = "0" + comonth;
      }
      let codaydate = checkInDate.getDate();
      if (codaydate < 10) {
        codaydate = "0" + codaydate;
      }

      let checkOutVal = coyear + "-" + comonth + "-" + codaydate + "T12:00";
      checkOutInput.value = checkOutVal;
      checkInTimeInput.value = "14:00";
    }
    $("#units-available").empty();
    $.ajax({
      url:
        baseUrl +
        "/web/reservation/unit/" +
        homestay_id +
        "/" +
        unitType.value +
        "/" +
        checkInInput.value +
        "/" +
        dayOfStay.value,
      dataType: "json",
      success: function (response) {
        let data = response.data;
        if (data === "Empty") {
          Swal.fire({
            icon: "error",
            title: "Full Booked",
            text: "There are no units available on this date!",
          });
          checkInInput.value = "";
          if (checkInInput._flatpickr) {
            checkInInput._flatpickr.clear();
          }
          $("#units-available").empty();
          objs = "<center><span>There are no units available</span></center>";
          $("#units-available").append(objs);
        } else {
          for (i in data) {
            let item = data[i];
            let rupiahFormat = new Intl.NumberFormat("id-ID", {
              style: "currency",
              currency: "IDR",
            }).format(item.price);

            if (item.unit_type == "1") {
              item.type = "Room";
            } else if (item.unit_type == "2") {
              item.type = "Villa";
            } else {
              item.type = "Hall";
            }

            if (response) {
              ratings =
                '<i name="rating" class="fas fa-star text-warning" aria-hidden="true"></i>';
              ratingr =
                '<i name="rating" class="far fa-star" aria-hidden="true"></i>';
              ratings_tot = "";
              ratingr_tot = "";
              for (
                let index = 0;
                index < parseInt(item.avg_rating, 10);
                index++
              ) {
                ratings_tot = ratings_tot + ratings;
              }
              for (
                let index = 0;
                index < 5 - parseInt(item.avg_rating, 10);
                index++
              ) {
                ratingr_tot = ratingr_tot + ratingr;
              }
              objs =
                '<div class="row">' +
                '<div class="col-md-1 col-12 d-flex align-items-center justify-content-center">' +
                '<div class="form-check ">' +
                '<input class="form-check-input" type="checkbox" value="' +
                item.unit_number +
                '" name="unit_number[]" id="flexCheckDefault">' +
                '<label class="form-check-label" for="flexCheckDefault">' +
                "</label>" +
                "</div>" +
                "</div>" +
                '<div class="col-md-11 col-12">' +
                '<div class="card border mb-3">' +
                '<div class="row g-0">' +
                '<div class="col-md-4 d-flex align-items-center justify-content-center">' +
                '<img width="500px" src="/media/photos/' +
                item.url +
                '" class="img-fluid rounded-start" alt="..." style="object-fit: cover; height: 185px;">' +
                "</div>" +
                '<div class="col-md-8">' +
                '<div class="card-body">' +
                '<div class="row">' +
                '<div class="col">' +
                '<h5 class="card-title">' +
                item.name +
                "</h5>" +
                "</div>" +
                '<div class="col">' +
                '<a title="Detail Homestay Unit" class="btn icon btn-outline-info btn-sm mb-1 me-1 float-end" target="_blank" href="/web/homestayUnit/' +
                item.homestay_id +
                "/detail/" +
                item.unit_type +
                item.unit_number +
                '">' +
                '<i class="fa-solid fa-circle-info"></i>' +
                "</a>" +
                "</div>" +
                "</div>" +
                ratings_tot +
                ratingr_tot +
                '<p class="card-text text-truncate">' +
                item.type +
                ", Capacity : " +
                item.capacity +
                " people</p>" +
                '<p class="card-text"><small class="text-dark">' +
                rupiahFormat +
                "/day</small></p>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
            } else {
              objs =
                "<center><span>There are no units available</span></center>";
            }
            $("#units-available").append(objs);
          }
        }
        console.log(data);
      },
    });
  }
  $("#units-available").show();
}
/**
 * Creates a marker for a route waypoint.
 * Purpose: To show a point on a route.
 * How it works: Similar to objectMarker but simplified for routing purposes.
 */
function objectMarkerRoute(id, lat, lng, anim = true) {
  google.maps.event.clearListeners(map, "click");
  let pos = new google.maps.LatLng(lat, lng);
  let marker = new google.maps.Marker();

  let icon;
  if (id.substring(0, 1) === "R") {
    icon = baseUrl + "/media/icon/marker_rg.png";
  } else if (id.substring(0, 1) === "C") {
    icon = baseUrl + "/media/icon/marker_cp.png";
  } else if (id.substring(0, 1) === "W") {
    icon = baseUrl + "/media/icon/marker_wp.png";
  } else if (id.substring(0, 1) === "S") {
    icon = baseUrl + "/media/icon/marker_sp.png";
  } else if (id.substring(0, 1) === "E") {
    icon = baseUrl + "/media/icon/marker_ev.png";
  } else if (id.substring(0, 1) === "L") {
    icon = baseUrl + "/media/icon/marker_lh.png";
  } else if (id.substring(0, 1) === "A") {
    icon = baseUrl + "/media/icon/marker_at.png";
  } else if (id.substring(0, 1) === "V") {
    icon = baseUrl + "/media/icon/marker_sv.png";
  } else if (id.substring(0, 1) === "H") {
    icon = baseUrl + "/media/icon/marker_hs.png";
  }

  markerOption = {
    position: pos,
    icon: icon,
    animation: google.maps.Animation.DROP,
    map: map,
  };
  marker.setOptions(markerOption);
  if (!anim) {
    marker.setAnimation(null);
  }
  marker.addListener("click", () => {
    infoWindow.close();
    objectInfoWindow(id);
    infoWindow.open(map, marker);
  });
  markerArray[id] = marker;
}
/**
 * Draws a route between two sets of coordinates.
 * Purpose: To show a path between two specific points.
 * How it works: Uses DirectionsService to calculate and DirectionsRenderer to display the route.
 */
function routeBetweenObjects(startLat, startLng, endLat, endLng) {
  clearRadius();
  clearRoute();
  google.maps.event.clearListeners(map, "click");

  // Create LatLng objects for the start and end coordinates
  const start = new google.maps.LatLng(startLat, startLng);
  const end = new google.maps.LatLng(endLat, endLng);

  let request = {
    origin: start,
    destination: end,
    travelMode: "DRIVING",
  };

  if (!directionsService) {
    directionsService = new google.maps.DirectionsService();
  }

  directionsService.route(request, function (result, status) {
    if (status == "OK") {
      const renderer = new google.maps.DirectionsRenderer({
        map: map,
        suppressMarkers: false
      });
      renderer.setDirections(result);
      showSteps(result);
      routeArray.push(renderer);
    }
  });

  boundToRoute(start, end);
}

/**
 * Deletes an additional amenity.
 * Purpose: To remove an amenity from a reservation.
 * How it works: AJAX DELETE request. Reloads page on success.
 */
function deleteAdditionalAmenities(
  homestay_id = null,
  additional_amenities_id = null,
  reservation_id = null
) {
  console.log(homestay_id + additional_amenities_id + reservation_id);
  Swal.fire({
    title: "Delete Additional Amenities?",
    icon: "warning",
    showCancelButton: true,
    denyButtonText: "Delete",
    confirmButtonColor: "#dc3545",
    cancelButtonColor: "#343a40",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url:
          baseUrl +
          "/web/additionalAmenities/delete/" +
          homestay_id +
          "/" +
          additional_amenities_id +
          "/" +
          reservation_id,
        type: "DELETE",
        dataType: "json",
        success: function (response) {
          if (response.status === 200) {
            Swal.fire("Deleted!", "Successfully removed", "success").then(
              (result) => {
                if (result.isConfirmed) {
                  document.location.reload();
                }
              }
            );
          } else {
            Swal.fire("Failed", "Delete failed!", "warning");
          }
        },
      });
    }
  });
}

/**
 * Displays all objects on the map.
 * Purpose: To show all points of interest in Explore mode.
 * How it works: Clears map, checks all category checkboxes, and calls checkObject.
 */
function allObject() {
  clearRadius();
  clearRoute();
  clearMarker();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
  objectMarker("L", -0.10908259406018868, 100.66435044295643);
  $("#table-uAttraction").show();
  $("#table-Attraction").show();
  // $("#table-Homestay").show();
  $("#table-Culinary").show();
  $("#table-Souvenir").show();
  $("#table-Worship").show();
  $("#result-explore-col").show();
  // displayFoundObject(response);
  // boundToObject();
  const checkuAttraction = document.getElementById("checkuAttraction");
  checkuAttraction.checked = true;
  const checkAttraction = document.getElementById("checkAttraction");
  checkAttraction.checked = true;
  // const checkHomestay = document.getElementById("checkHomestay");
  // checkHomestay.checked = true;
  const checkCulinary = document.getElementById("checkCulinary");
  checkCulinary.checked = true;
  const checkSouvenir = document.getElementById("checkSouvenir");
  checkSouvenir.checked = true;
  const checkWorship = document.getElementById("checkWorship");
  checkWorship.checked = true;
  checkObject();

  // $.ajax({
  //   url: baseUrl + "/web/allObject",
  //   dataType: "json",
  //   success: function (response) {
  //     displayFoundObject(response);
  //     boundToObject();
  //     const checkHomestay = document.getElementById("checkHomestay");
  //     checkHomestay.checked = true;
  //     const checkCulinary = document.getElementById("checkCulinary");
  //     checkCulinary.checked = true;
  //     const checkSouvenir = document.getElementById("checkSouvenir");
  //     checkSouvenir.checked = true;
  //     const checkWorship = document.getElementById("checkWorship");
  //     checkWorship.checked = true;
  //   },
  // });
}

/**
 * Displays all homestays.
 * Purpose: To show only homestays on the map.
 * How it works: Clears map, hides other tables, calls findAll for Homestay.
 */
function allHomestay(login = false) {
  clearRadius();
  clearRoute();
  clearMarker();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
  objectMarker("L", -0.10908259406018868, 100.66435044295643);
  $("#table-uAttraction").empty().hide();
  $("#table-Attraction").empty().hide();
  $("#table-Homestay").empty().hide();
  $("#table-Culinary").empty().hide();
  $("#table-Souvenir").empty().hide();
  $("#table-Worship").empty().hide();
  // checkObject();
  findAll("Homestay", login);
  $("#result-explore-col").show();
  $("#table-Homestay").show();
}

/**
 * Filters displayed objects based on checkboxes.
 * Purpose: To update the map based on user selection in Explore mode.
 * How it works: Checks status of each checkbox and calls findAll for checked categories.
 */
function checkObject() {
  // Bersihkan peta dan tabel
  clearRadius();
  clearRoute();
  clearMarker();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
  // initMap5();
  objectMarker("L", -0.10908259406018868, 100.66435044295643);
  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  // Sembunyikan semua tabel
  $("#table-uAttraction").empty().hide();
  $("#table-Attraction").empty().hide();
  $("#table-Homestay").empty().hide();
  $("#table-Culinary").empty().hide();
  $("#table-Souvenir").empty().hide();
  $("#table-Worship").empty().hide();

  // Koordinat posisi default (misal pusat peta)
  let pos = new google.maps.LatLng(currentLat, currentLng);

  // Periksa status setiap checkbox

  if (document.getElementById("checkuAttraction").checked) {
    findAll("uAttraction");
    $("#table-uAttraction").show();
  }
  if (document.getElementById("checkAttraction").checked) {
    findAll("Attraction");
    $("#table-Attraction").show();
  }
  // if (document.getElementById("checkHomestay").checked) {
  //   findAll("Homestay");
  //   $("#table-Homestay").show();
  // }
  if (document.getElementById("checkCulinary").checked) {
    findAll("Culinary");
    $("#table-Culinary").show();
  }
  if (document.getElementById("checkSouvenir").checked) {
    findAll("Souvenir");
    $("#table-Souvenir").show();
  }
  if (document.getElementById("checkWorship").checked) {
    findAll("Worship");
    $("#table-Worship").show();
  }

  // Atur bound ke objek yang ditemukan
  boundToObject();

  // Tampilkan kolom hasil pencarian
  if (
    document.getElementById("checkuAttraction").checked ||
    document.getElementById("checkAttraction").checked ||
    // document.getElementById("checkHomestay").checked ||
    document.getElementById("checkCulinary").checked ||
    document.getElementById("checkSouvenir").checked ||
    document.getElementById("checkWorship").checked
  ) {
    $("#result-explore-col").show();
  } else {
    $("#result-explore-col").hide();
  }
}

/**
 * Fetches all objects of a category.
 * Purpose: To retrieve data for Explore mode.
 * How it works: AJAX POST to /api/{category}/findAll.
 */
function findAll(category, login = false) {
  // let pos = new google.maps.LatLng(currentLat, currentLng);
  if (category === "uAttraction") {
    $.ajax({
      url: baseUrl + "/api/attraction/findAll",
      type: "POST",
      data: {
        category: "1",
      },
      dataType: "json",
      success: function (response) {
        displayExploreResult(category, response);
        boundToObject();
      },
    });
  } else if (category === "Attraction") {
    $.ajax({
      url: baseUrl + "/api/attraction/findAll",
      type: "POST",
      data: {
        category: "2",
      },
      dataType: "json",
      success: function (response) {
        displayExploreResult(category, response);
        boundToObject();
      },
    });
  } else if (category === "Culinary") {
    $.ajax({
      url: baseUrl + "/api/culinaryPlace/findAll",
      type: "POST",
      data: {},
      dataType: "json",
      success: function (response) {
        displayExploreResult(category, response);
        boundToObject();
      },
    });
  } else if (category === "Homestay") {
    $.ajax({
      url: baseUrl + "/api/homestay/findAll",
      type: "POST",
      data: {},
      dataType: "json",
      success: function (response) {
        displayExploreResult(category, response, login);
        boundToObject();
      },
    });
  } else if (category === "Souvenir") {
    $.ajax({
      url: baseUrl + "/api/souvenirPlace/findAll",
      type: "POST",
      data: {},
      dataType: "json",
      success: function (response) {
        displayExploreResult(category, response);
        boundToObject();
      },
    });
  } else if (category === "Worship") {
    $.ajax({
      url: baseUrl + "/api/worshipPlace/findAll",
      type: "POST",
      data: {},
      dataType: "json",
      success: function (response) {
        displayExploreResult(category, response);
        boundToObject();
      },
    });
  }

  function displayExploreResult(category, response, login = false) {
    let data = response.data;
    let headerName;
    if (category === "Attraction") {
      headerName = "Ordinary Attraction";
    } else if (category === "uAttraction") {
      headerName = "Unique Attraction";
    } else if (category === "Culinary") {
      headerName = "Culinary Place";
    } else if (category === "Homestay") {
      headerName = "Homestay";
    } else if (category === "Souvenir") {
      headerName = "Souvenir Place";
    } else if (category === "Worship") {
      headerName = "Worship Place";
    }

    let table =
      "<thead><tr>" +
      '<th style="width: 70%;">' +
      headerName +
      " Name</th>" +
      '<th style="width: 30%;">Action</th>' +
      "</tr></thead>" +
      '<tbody id="data-' +
      category +
      '">' +
      "</tbody>";
    $("#table-" + category).append(table);

    for (i in data) {
      let item = data[i];
      let row =
        "<tr>" +
        "<td>" +
        item.name +
        "</td>" +
        "<td><center>" +
        '<a title="Location" class="btn-sm icon btn-primary" onclick="focusObject(`' +
        item.id +
        '`);"><i class="fa-solid fa-map-location-dot"></i></a>' +
        "</center></td>" +
        "</tr>";
      $("#data-" + category).append(row);
      if (category === "uAttraction" || category === "Attraction") {
        objectMarker(
          item.id,
          item.lat,
          item.lng,
          true,
          item.attraction_category
        );
      } else {
        objectMarker(item.id, item.lat, item.lng, true, null, login);
      }
    }
  }
}

/**
 * Toggles map layers (Country, Province, City, Village).
 * Purpose: To show/hide administrative boundaries based on checkboxes.
 * How it works: Checks checkbox status and calls digit* or clearDigit* functions.
 */
function checkLayer() {
  // Bersihkan peta dan tabel
  clearRadius();
  clearRoute();
  clearMarker();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();

  // initMap();
  objectMarker("L", -0.10908259406018868, 100.66435044295643);

  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  // Koordinat posisi default (misal pusat peta)
  // let pos = new google.maps.LatLng(currentLat, currentLng);

  // Periksa status setiap checkbox

  if (document.getElementById("checkCountry").checked) {
    // clearAllAll();
    clearDigitNeg();
    for (let n = 1; n < 4; n++) {
      const idcoun = n;
      digitCountries(idcoun);
    }
  } else {
    // clearAllAll();
    clearDigitNeg();
  }

  if (document.getElementById("checkProvince").checked) {
    // clearAllAll();
    clearDigitProv();
    for (let p = 1; p < 11; p++) {
      const idprov = p;
      digitProvinces(idprov);
    }
  } else {
    // clearAllAll();
    clearDigitProv();
  }

  if (document.getElementById("checkCity").checked) {
    // digitKabKota(nameprov);
    // nameprovv = "Sumatera_Barat";
    // digitKabKota(nameprovv);
    clearDigitKabKota();
    digitCities();
  } else {
    // clearAllAll();
    clearDigitKabKota();
  }

  if (document.getElementById("checkVillage").checked) {
    // clearAllAll();
    clearDigitVillage();
    digitTourismVillage();
  } else {
    // clearAllAll();
    clearDigitVillage();
  }
}

/**
 * Clears country layers.
 * Purpose: To remove country boundaries from map.
 * How it works: Iterates through digitNegLayers setting map to null.
 */
function clearDigitNeg() {
  digitNegLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitNegLayers = [];
}

/**
 * Clears province layers.
 * Purpose: To remove province boundaries from map.
 * How it works: Iterates through digitProvLayers setting map to null.
 */
function clearDigitProv() {
  digitProvLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitProvLayers = [];
}

/**
 * Clears city layers.
 * Purpose: To remove city boundaries from map.
 * How it works: Iterates through digitKabKotaLayers setting map to null.
 */
function clearDigitKabKota() {
  digitKabKotaLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitKabKotaLayers = [];
}

/**
 * Clears village layers.
 * Purpose: To remove village boundaries from map.
 * How it works: Iterates through digitVillageLayers setting map to null.
 */
function clearDigitVillage() {
  digitVillageLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitVillageLayers = [];
}

/**
 * Resets map and layers to default state.
 * Purpose: To initialize the Explore mode view.
 * How it works: Clears everything, loads all layers, checks all layer checkboxes, and shows result column.
 */
function clickLayer() {
  clearRadius();
  clearRoute();
  clearMarker();
  // clearAllDigitasi();
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
  clearDigitNeg();
  clearDigitProv();
  clearDigitKabKota();
  // clearDigitKec();
  // clearDigitNagari1();
  clearDigitVillage();
  $("#list-object-col").hide();

  let buttons = document.querySelectorAll(".day-route-btn");
  let dayDetails = document.querySelectorAll(".div-day-detail");
  let allActivityRows = document.querySelectorAll('[id^="activity-row-"]');

  buttons.forEach(function (button) {
    button.style.backgroundColor = ""; // reset to default background color
    button.style.color = ""; // reset to default text color
  });

  dayDetails.forEach(function (detailDiv) {
    detailDiv.style.border = ""; // reset div border
  });

  allActivityRows.forEach(function (activityRow) {
    activityRow.style.visibility = "hidden"; // Sembunyikan semua activity row
    activityRow.style.display = "none"; // Pastikan elemen tidak terlihat
  });

  // initMap5();
  // objectMarker("L", -0.45645247101825404, 100.49283409109306);

  destinationMarker.setMap(null);
  google.maps.event.clearListeners(map, "click");

  // let pos = new google.maps.LatLng(-0.54145013, 100.48094882);
  // map.panTo(pos);

  for (let n = 1; n < 4; n++) {
    const idcoun = n;
    digitCountries(idcoun);
  }
  digitProvinces();
  digitCities();
  objectMarker("L", -0.10908259406018868, 100.66435044295643);

  const checkCountry = document.getElementById("checkCountry");
  checkCountry.checked = true;
  const checkProvince = document.getElementById("checkProvince");
  checkProvince.checked = true;
  const checkCity = document.getElementById("checkCity");
  checkCity.checked = true;
  const checkVillage = document.getElementById("checkVillage");
  checkVillage.checked = true;

  Promise.all(promises).then(() => {
    boundToObject();
    $("#result-explore-col").show();
  });
}

/**
 * Animations for flight/car route to Lembah Harau.
 * Purpose: To visualize how to reach the destination from major cities.
 * How it works: Uses markers with custom icons (plane, car) and animates their position along a path. Adds text overlays.
 */
function howToReachLembahHarau() {
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
  clearMarker();
  clearRoute();
  clearRadius();

  objectMarker("L", -0.10908259406018868, 100.66435044295643);

  const clearHtro = document.getElementById("clearHtro");
  clearHtro.checked = true;

  // 1.192689, 103.910130

  // Coordinates
  const singapore = { lat: 1.192689, lng: 103.91013 }; // Singapore
  const malaysia = { lat: 3.1503614007038454, lng: 101.97940881384584 }; // Kuala Lumpur
  const jakarta = { lat: -6.516948, lng: 106.930035 }; // Jakarta
  const padang = { lat: -0.9478502987473912, lng: 100.3628232695202 }; // Padang
  const bandaAceh = { lat: 5.537368838813003, lng: 95.50780215398227 }; // Banda Aceh
  const nagari = { lat: latVillage, lng: lngVillage }; // Nagari Tuo Pariangan

  // Animate flight
  function animateFlight(map, fromLatLng, toLatLng) {
    const airplaneIcon = {
      url: baseUrl + "/media/icon/airplane-icon.png", // Airplane icon path
      scaledSize: new google.maps.Size(60, 60), // Icon size
      anchor: new google.maps.Point(25, 25), // Center the icon
    };

    const airplaneMarker = new google.maps.Marker({
      position: fromLatLng,
      map: map,
      icon: airplaneIcon,
      title: "Flight",
    });

    airplaneMarkers.push(airplaneMarker); // Store marker for later clearing

    let step = 0;
    const totalSteps = 100; // Number of animation steps
    const interval = setInterval(() => {
      if (step <= totalSteps) {
        const lat =
          fromLatLng.lat +
          (toLatLng.lat - fromLatLng.lat) * (step / totalSteps);
        const lng =
          fromLatLng.lng +
          (toLatLng.lng - fromLatLng.lng) * (step / totalSteps);
        const newPosition = { lat, lng };
        airplaneMarker.setPosition(newPosition);
        step++;
      } else {
        clearInterval(interval); // Stop animation when complete
      }
    }, 50); // Animation speed (50ms per step)
  }

  // Animate car
  function animateCar(map, fromLatLng, toLatLng) {
    const carIcon = {
      url: baseUrl + "/media/icon/car2.png", // Airplane icon path
      scaledSize: new google.maps.Size(50, 50), // Icon size
      anchor: new google.maps.Point(20, 20), // Center the icon
    };

    const carMarker = new google.maps.Marker({
      position: fromLatLng,
      map: map,
      icon: carIcon,
      title: "Car Journey",
      zIndex: 1000,
    });
    carMarkers.push(carMarker); // Store marker for later clearing

    let step = 0;
    const totalSteps = 100;
    const interval = setInterval(() => {
      if (step <= totalSteps) {
        const lat =
          fromLatLng.lat +
          (toLatLng.lat - fromLatLng.lat) * (step / totalSteps);
        const lng =
          fromLatLng.lng +
          (toLatLng.lng - fromLatLng.lng) * (step / totalSteps);
        const newPosition = { lat, lng };
        carMarker.setPosition(newPosition);
        step++;
      } else {
        clearInterval(interval);
      }
    }, 50);
  }

  // Add text overlays
  function createTextOverlay(map, position, steps) {
    const overlay = new google.maps.OverlayView();

    overlay.onAdd = function () {
      const div = document.createElement("div");
      div.style.position = "absolute";
      div.style.fontSize = "14px";
      div.style.fontWeight = "bold";
      div.style.color = "#4a2f13";
      div.style.backgroundColor = "#ffe6cc";
      div.style.padding = "10px";
      div.style.borderRadius = "5px";
      div.style.boxShadow = "0 2px 6px rgba(0, 0, 0, 0.3)";
      div.style.zIndex = "9999";
      div.innerHTML = steps;

      const panes = this.getPanes();
      panes.overlayLayer.appendChild(div);

      this.draw = function () {
        const projection = this.getProjection();
        const positionPixel = projection.fromLatLngToDivPixel(position);
        div.style.left = `${positionPixel.x}px`;
        div.style.top = `${positionPixel.y}px`;
      };

      overlay.div = div; // Simpan referensi ke elemen DOM
    };

    overlay.onRemove = function () {
      if (overlay.div) {
        overlay.div.parentNode.removeChild(overlay.div);
        overlay.div = null;
      }
    };

    overlay.setMap(map);
    overlays.push(overlay); // Simpan overlay dalam array
    return overlay;
  }

  // Map animations
  animateFlight(map, singapore, padang);
  animateFlight(map, malaysia, padang);
  animateCar(map, bandaAceh, nagari);
  animateFlight(map, jakarta, padang);

  setTimeout(() => {
    animateCar(map, padang, nagari);
  }, 6000); // Delay of 6 seconds before car animation

  // Add overlays
  createTextOverlay(
    map,
    singapore,
    `
    <div style="display: flex; align-items: center;">
      
      <div>
        <b>From Singapore <img src="${baseUrl}/media/icon/sg.svg" alt="Singapore Flag" style="width: 24px; height: 16px; margin-right: 4px;">(SIN):</b><br>
        1. Take a flight from Singapore (SIN) to Padang (PDG), Indonesia.<br>
        2. Rent a car to Lembah Harau.
      </div>
    </div>
  `
  );

  createTextOverlay(
    map,
    malaysia,
    `
    <div style="display: flex; align-items: center;">
      
      <div>
        <b>From Kuala Lumpur <img src="${baseUrl}/media/icon/my.svg" alt="Malaysia Flag" style="width: 24px; height: 16px; margin-right: 4px;">(KUL):</b><br>
        1. Take a flight from Kuala Lumpur (KUL) to Padang (PDG), Indonesia.<br>
        2. Rent a car to Lembah Harau.
      </div>
    </div>
  `
  );

  createTextOverlay(
    map,
    jakarta,
    `
    <div style="display: flex; align-items: center;">
      
      <div>
        <b>From Jakarta <img src="${baseUrl}/media/icon/id.svg" alt="Indonesia Flag" style="width: 24px; height: 16px; margin-right: 4px;">:</b><br>
        1. Take a domestic flight to Padang (PDG), Indonesia.<br>
        2. Rent a car to Lembah Harau.
      </div>
    </div>
  `
  );

  createTextOverlay(
    map,
    bandaAceh,
    `
    <div style="display: flex; align-items: center;">      
      <div>
        <b>From anywhere in Sumatra <img src="${baseUrl}/media/icon/id.svg" alt="Indonesia Flag" style="width: 24px; height: 16px; margin-right: 4px;">:</b><br>
        1. Travel by land directly to Lembah Harau.<br>
        2. Alternatively, fly to Padang (PDG) and rent a car to Lembah Harau.
      </div>
    </div>
  `
  );

  map.setZoom(6);
}

/**
 * Clears airplane markers.
 * Purpose: To remove flight animations.
 * How it works: Iterates through airplaneMarkers setting map to null.
 */
function clearAirplaneMarkers() {
  airplaneMarkers.forEach((marker) => marker.setMap(null));
  airplaneMarkers.length = 0; // Clear the array
}

/**
 * Clears car markers.
 * Purpose: To remove car animations.
 * How it works: Iterates through carMarkers setting map to null.
 */
function clearCarMarkers() {
  carMarkers.forEach((marker) => marker.setMap(null));
  carMarkers.length = 0; // Clear the array
}

/**
 * Clears text overlays.
 * Purpose: To remove route instructions.
 * How it works: Iterates through overlays setting map to null.
 */
function clearOverlay() {
  overlays.forEach((overlay) => {
    overlay.setMap(null); // Remove overlay from the map
  });
  overlays = []; // Clear the array
}

/**
 * Toggles map labels.
 * Purpose: To show/hide default map labels vs custom labels.
 * How it works: Sets map styles based on checkbox state and toggles custom label visibility.
 */
function checkLabel() {
  const checkBox = document.getElementById("check-label");
  isLabelChecked = checkBox.checked; // Update status global

  const defaultStyled = [
    { elementType: "labels", stylers: [{ visibility: "on" }] },
    {
      featureType: "poi",
      elementType: "labels",
      stylers: [{ visibility: "off" }],
    },
    {
      featureType: "administrative.land_parcel",
      stylers: [{ visibility: "off" }],
    },
    {
      featureType: "administrative.neighborhood",
      stylers: [{ visibility: "off" }],
    },
    {
      featureType: "road",
      elementType: "labels",
      stylers: [{ visibility: "on" }],
    },
  ];

  const hideLabels = [
    { elementType: "labels", stylers: [{ visibility: "off" }] },
  ];

  if (isLabelChecked) {
    // Tampilkan label default
    map.setOptions({ styles: defaultStyled });
    customLabels.forEach((label) => label.setMap(null));
    customLabelsCountry.forEach((label) => label.setMap(null));
    customLabels = [];
    customLabelsCountry = [];
  } else {
    // Sembunyikan label default
    map.setOptions({ styles: hideLabels });
    addCustomLabels(map);
    addCustomLabelsCountry(map);
  }
}

/**
 * Toggles terrain map type.
 * Purpose: To switch between hybrid and terrain views.
 * How it works: Sets mapTypeId based on checkbox state.
 */
function checkTerrain() {
  const checkBox = document.getElementById("check-terrain");
  isTerrainChecked = checkBox.checked; // Update status global

  if (isTerrainChecked) {
    map.setMapTypeId("terrain");
  } else {
    map.setMapTypeId("hybrid");
  }

  // Terapkan ulang gaya label jika checkbox label aktif
  if (isLabelChecked) {
    checkLabel();
  }
}

/**
 * Adds custom city labels to the map.
 * Purpose: To show labels for major cities when default labels are hidden.
 * How it works: Creates OverlayView objects for specific locations and adds them to the map.
 */
function addCustomLabels(map) {
  const locations = [
    { position: { lat: -6.2088, lng: 106.8456 }, name: "JAKARTA" },
    { position: { lat: -0.9446, lng: 100.3714 }, name: "PADANG" },
    { position: { lat: 1.047, lng: 104.0305 }, name: "BATAM" },
  ];

  locations.forEach((location) => {
    const label = new google.maps.OverlayView();
    label.onAdd = function () {
      const div = document.createElement("div");
      div.style.position = "absolute";
      div.style.padding = "5px 10px";
      div.style.fontFamily = "Product Sans, Arial, sans-serif"; // Alternatif mendekati Google Sans
      div.style.fontSize = "13px";
      div.style.fontWeight = "800"; // Berat font normal seperti label Maps
      div.style.color = "#fff"; // Warna teks putih
      div.style.webkitTextFillColor = "#fff"; // Stroke hitam pada teks
      div.style.webkitTextStroke = "1px #000"; // Stroke hitam pada teks
      // div.style.letterSpacing = "-0.0325em"; // Simulasi semi-condensed 87.5%
      div.style.textAlign = "center"; // Posisi teks rata tengah
      div.style.zIndex = "999";
      div.innerHTML = location.name;

      const panes = this.getPanes();
      panes.overlayLayer.appendChild(div);

      this.div = div;
    };

    label.draw = function () {
      const projection = this.getProjection();
      const position = projection.fromLatLngToDivPixel(location.position);
      if (this.div) {
        const width = this.div.offsetWidth; // Lebar elemen label
        const height = this.div.offsetHeight; // Tinggi elemen label

        this.div.style.left = `${position.x - width / 2}px`; // Pusatkan secara horizontal
        this.div.style.top = `${position.y - height / 2}px`; // Pusatkan secara vertikal
      }
    };

    label.onRemove = function () {
      if (this.div) {
        this.div.parentNode.removeChild(this.div);
        this.div = null;
      }
    };

    label.setMap(map);
    customLabels.push(label); // Simpan label ke array
  });
}

/**
 * Adds custom country labels to the map.
 * Purpose: To show labels for countries when default labels are hidden.
 * How it works: Similar to addCustomLabels but for countries.
 */
function addCustomLabelsCountry(map) {
  const locations = [
    { position: { lat: 3.440052, lng: 101.957396 }, name: "MALAYSIA" },
    { position: { lat: 1.3521, lng: 103.8198 }, name: "SINGAPORE" },
    { position: { lat: 4.9031, lng: 114.9398 }, name: "BRUNEI" },
    { position: { lat: -1.377737, lng: 113.217183 }, name: "INDONESIA" },
  ];

  locations.forEach((location) => {
    const label = new google.maps.OverlayView();
    label.onAdd = function () {
      const div = document.createElement("div");
      div.style.position = "absolute";
      div.style.padding = "5px 10px";
      div.style.fontFamily = "Product Sans, Arial, sans-serif"; // Alternatif mendekati Google Sans
      div.style.fontSize = "18px";
      div.style.fontWeight = "800"; // Berat font normal seperti label Maps
      div.style.color = "#fff"; // Warna teks putih
      div.style.webkitTextFillColor = "#fff"; // Stroke hitam pada teks
      div.style.webkitTextStroke = "1px #000"; // Stroke hitam pada teks
      // div.style.letterSpacing = "-0.0325em"; // Simulasi semi-condensed 87.5%
      div.style.textAlign = "center"; // Posisi teks rata tengah
      div.style.zIndex = "999";
      div.innerHTML = location.name;

      const panes = this.getPanes();
      panes.overlayLayer.appendChild(div);

      this.div = div;
    };

    label.draw = function () {
      const projection = this.getProjection();
      const position = projection.fromLatLngToDivPixel(location.position);
      if (this.div) {
        const width = this.div.offsetWidth; // Lebar elemen label
        const height = this.div.offsetHeight; // Tinggi elemen label

        this.div.style.left = `${position.x - width / 2}px`; // Pusatkan secara horizontal
        this.div.style.top = `${position.y - height / 2}px`; // Pusatkan secara vertikal
      }
    };

    label.onRemove = function () {
      if (this.div) {
        this.div.parentNode.removeChild(this.div);
        this.div = null;
      }
    };

    label.setMap(map);
    customLabelsCountry.push(label); // Simpan label ke array
  });
}

/**
 * Clears How To Reach objects.
 * Purpose: To reset the map after viewing route animations.
 * How it works: Calls clear functions for markers and overlays.
 */
function clearHtro() {
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
}

/**
 * Fetches and displays current weather.
 * Purpose: To show weather info for Harau.
 * How it works: Fetches data from OpenWeatherMap API and updates the DOM.
 */
function weatherNow() {
  const apiKey = "8253305683d95339ac1253f3c16aa325";
  const cityName = "Harau";

  const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${cityName}&appid=${apiKey}&units=metric`;

  async function fetchWeather() {
    try {
      const response = await fetch(apiUrl);
      const data = await response.json();

      // Ambil data cuaca dari API
      const weatherDescription = data.weather[0].description;
      const temperature = data.main.temp;
      const humidity = data.main.humidity;
      const weatherIcon = data.weather[0].icon;
      const windSpeed = data.wind.speed;

      const capitalizeWords = (str) => {
        return str.replace(/\b\w/g, (char) => char.toUpperCase());
      };
      const capitalizedWeatherDescription = capitalizeWords(weatherDescription);

      document.getElementById("weather-info").innerHTML = `
    <span style="margin-right: 10px;">${cityName}, ID</span>
    <img src="http://openweathermap.org/img/wn/${weatherIcon}.png" alt="Weather Icon" style="margin-right: 10px; filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));" />
    <span style="margin-right: 10px;">${temperature}°C</span>
    <span style="margin-right: 10px;">${capitalizedWeatherDescription}</span>
    <span style="margin-right: 10px;">Humidity: ${humidity}%</span>
    <span style="margin-right: 10px;">Wind: ${windSpeed} m/s</span>
`;
    } catch (error) {
      console.error("Error fetching weather data:", error);
      document.getElementById("weather-info").innerHTML =
        "Failed to fetch weather data.";
    }
  }

  window.onload = fetchWeather;
}

/**
 * Shows booking options (Personal or Event).
 * Purpose: To let the user choose the type of reservation.
 * How it works: Displays a SweetAlert with two buttons.
 * Redirects:
 * - Personal: /web/reservation/{id}
 * - Event: /web/reservationEvent/{id}
 */
function iwOpsiBook(id) {
  Swal.fire({
    title: "Select Booking Options",
    text: "Please choose one of the booking options below:",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "Personal",
    confirmButtonColor: "#3085d6",
    cancelButtonText: "Event",
    cancelButtonColor: "#039e00",
  }).then((result) => {
    if (result.isConfirmed) {
      window.open(baseUrl + "/web/reservation/" + id);
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      window.open(baseUrl + "/web/reservationEvent/" + id);
    }
  });
}

/**
 * Redirects unauthenticated users to login.
 * Purpose: To enforce login for booking.
 * How it works: Displays a warning SweetAlert, then redirects.
 * Redirects: /login
 */
function iwRedirectToLogin() {
  Swal.fire({
    icon: "warning",
    title: "You are not logged in as User",
    text: "Please log in to proceed.",
    confirmButtonText: "OK",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = baseUrl + "/login";
    } else {
    }
  });
}
/**
 * Opens the 'Around You' search interface.
 * Purpose: To switch the sidebar to nearby search mode.
 * How it works: Hides other columns and shows #check-nearbyyou-col.
 */
function openAround() {
  $("#list-rg-col").hide();
  $("#list-ev-col").hide();
  $("#list-rec-col").hide();
  $("#check-nearbyyou-col").show();
  if (isCustomRoute) {
    toggleCustomRoute();
  }
}

/**
 * Validates the selected event date.
 * Purpose: To ensure the selected date matches the event's schedule.
 * How it works: AJAX GET to /api/event/{id}, compares input value with available dates.
 */
function checkEventDate(event_id) {
  const dateInput = document.getElementById("reservationDate");
  if (!dateInput || dateInput.value === "") return;

  $.ajax({
    url: baseUrl + "/api/event/" + event_id,
    dataType: "json",
    success: function (response) {
      let data = response.data;
      let rawDates = data.dates || [data.date];
      let availableDates = rawDates.map(date => date.substring(0, 10));

      if (!availableDates.includes(dateInput.value)) {
        Swal.fire({
          icon: "error",
          title: "Unavailable",
          text: "This event is not available on the selected date!",
        });
        dateInput.value = "";
        if (dateInput._flatpickr) {
          dateInput._flatpickr.clear();
        }
      }
    },
  });
}

/**
 * Initializes Flatpickr on an input.
 * Purpose: To attach a date picker to a form field.
 * How it works: Calls flatpickr() with specific options.
 */
function initFlatpickr(id, enableDates = [], minDate = "today") {
  if (typeof flatpickr !== "undefined") {
    flatpickr("#" + id, {
      enable: enableDates.length > 0 ? enableDates : undefined,
      minDate: minDate,
      dateFormat: "Y-m-d",
      disableMobile: true,
      allowInput: false,
    });
  }
}

/**
 * Initializes date picker for Event reservation.
 * Purpose: To enable only valid event dates in the calendar.
 * How it works: AJAX GET to /api/event/{id}, then initializes flatpickr with enabled dates.
 */
function initEventDate(event_id) {
  const dateInput = document.getElementById("reservationDate");
  if (!dateInput) return;

  $.ajax({
    url: baseUrl + "/api/event/" + event_id,
    dataType: "json",
    success: function (response) {
      let data = response.data;
      let rawDates = data.dates || [data.date];
      let availableDates = rawDates.map((date) => date.substring(0, 10));

      if (typeof flatpickr !== "undefined") {
        flatpickr(dateInput, {
          enable: availableDates,
          dateFormat: "Y-m-d",
          minDate: "today",
          disableMobile: true,
          allowInput: false,
        });
      }
    },
  });
}

/**
 * Initializes date picker for Homestay reservation.
 * Purpose: To disable already booked dates.
 * How it works: AJAX GET to /web/reservation/bookedDates/{id}, then initializes flatpickr with disabled dates.
 */
function initHomestayReservationDate(homestay_id) {
  const dateInput = document.getElementById("check_in");
  if (!dateInput) return;

  $.ajax({
    url: baseUrl + "/web/reservation/bookedDates/" + homestay_id,
    dataType: "json",
    success: function (response) {
      let disableDates = Array.isArray(response) ? response.map((item) => item.date) : [];

      if (typeof flatpickr !== "undefined") {
        flatpickr(dateInput, {
          minDate: "today",
          dateFormat: "Y-m-d",
          disableMobile: true,
          allowInput: false,
          disable: disableDates,
          onChange: function (selectedDates, dateStr, instance) {
             if (typeof getCheckOut2 === 'function') {
                 getCheckOut2();
             }
          },
        });
      }
    },
  });
}

/**
 * Initializes date picker for generic event reservation.
 * Purpose: To setup calendar with specific constraints.
 * How it works: Calls flatpickr with disable/minDate options.
 */
function initEventReservationDate(id, disableDates = [], minDate = "today") {
  if (typeof flatpickr !== "undefined") {
    flatpickr("#" + id, {
      disable: disableDates,
      minDate: minDate,
      dateFormat: "Y-m-d",
      disableMobile: true,
      allowInput: false,
      onChange: function (selectedDates, dateStr, instance) {
        if (typeof getCheckOut2 === "function") {
          getCheckOut2();
        }
      },
    });
  }
}

/**
 * Adds a marker to the custom route from InfoWindow.
 * Purpose: To allow users to add points of interest to their route.
 * How it works: Checks if custom route mode is active, then calls addCustomMarker.
 */
function addMarkerToCustomRoute(lat, lng, name = null, id = null) {
    if (!isCustomRoute) {
        Swal.fire({
            icon: 'info',
            title: 'Mode not active',
            text: 'Please start "Create Custom Route" mode first to add waypoints.'
        });
        return;
    }

    addCustomMarker(new google.maps.LatLng(lat, lng), name, id);
    infoWindow.close();
}

/**
 * Toggles the Custom Route creation mode.
 * Purpose: To enter or exit the route builder interface.
 * How it works:
 * - If active: Hides UI, clears route, restores original map state.
 * - If inactive: Shows UI, clears map, enables map click listener for adding points.
 */
function toggleCustomRoute() {
    if (isCustomRoute) {
        isCustomRoute = false;
        $("#custom-route-col").hide();
        $("#custom-route-floating-wrapper").hide();
        $("#list-rg-col").show();
        $("#list-ev-col").show();
        $("#list-rec-col").show();
        $("#confirm-custom-route-btn").hide();
        
        if (customDirectionsRenderer) {
            customDirectionsRenderer.setMap(null);
        }
        if (customPolyline) {
            customPolyline.setMap(null);
        }
        clearCustomRoute();
        
        // Restore markers visibility
        for (const key in markerArray) {
            markerArray[key].setMap(map);
        }
        
        // Restore Nearby Result Column if it has content
        if ($("#result-nearby-col").find("tbody tr").length > 0) {
             $("#result-nearby-col").show();
             $("#check-nearby-col").show();
        }

        return;
    }

    let hasOtherMarkers = false;
    for (const key in markerArray) {
        if (key !== 'L') {
            hasOtherMarkers = true;
            break;
        }
    }

    if (!hasOtherMarkers) {
        allObject();
    }

    isCustomRoute = true;
    
    // Clear existing click listeners to avoid conflicts with manualPosition
    google.maps.event.clearListeners(map, "click");
    
    digitTourismVillage(false);
    
    const customRouteHTML = `
            <div class="col-12 mb-4" id="custom-route-col" style="display: none;">
                <div class="card text-dark">
                    <div class="card-header">
                        <h5 class="card-title text-center">Custom Route</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-danger" onclick="clearCustomRoute()">Clear Route</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 table-lg text-dark">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Coords</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="custom-route-list">
                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <button id="confirm-custom-route-btn" class="btn btn-success" onclick="confirmCustomRoute()">Confirm Route</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

    let $container = $("#custom-route-col");
    if ($container.length === 0) {
        $container = $(customRouteHTML);
    } else {
        $container.addClass("mb-4");
    }

    if ($("#list-rg-col").length) {
        $container.insertAfter("#list-rg-col");
    } else if ($("#list-rec-col").length) {
        $container.insertAfter("#list-rec-col");
    } else if ($("#list-ev-col").length) {
        $container.insertAfter("#list-ev-col");
    } else {
        if ($("#custom-route-floating-wrapper").length === 0) {
            $("body").append('<div id="custom-route-floating-wrapper" style="position: fixed; top: 100px; right: 20px; width: 350px; z-index: 9999; max-height: 80vh; overflow-y: auto;"></div>');
        }
        $container.appendTo("#custom-route-floating-wrapper");
        $container.removeClass("col-12 mb-4");
    }

    if (userLat != 0 && userLng != 0) {
        addCustomMarker(new google.maps.LatLng(userLat, userLng), "User Location");
    }

    $("#custom-route-col").show();
    $("#custom-route-floating-wrapper").show();
    $container.show();
    $("#check-nearby-col").hide();
    $("#result-nearby-col").hide();
    $("#result-nearbyyou-col").hide();
    $("#result-explore-col").hide();
    $("#list-rg-col").hide();
    $("#list-ev-col").hide();
    $("#list-rec-col").hide();

    if ($("#confirm-custom-route-btn").length === 0) {
        const btnHtml = '<div class="d-grid gap-2 mt-3"><button id="confirm-custom-route-btn" class="btn btn-success" onclick="confirmCustomRoute()">Confirm Route</button></div>';
        if ($("#custom-route-col .card-body").length) {
            $("#custom-route-col .card-body").append(btnHtml);
        } else {
            $("#custom-route-col").append(btnHtml);
        }
    }
    $("#confirm-custom-route-btn").show();
    

    map.addListener("click", (event) => {
        addCustomMarker(event.latLng);
    });
    
    Swal.fire({
        icon: 'info',
        title: 'Custom Route Mode',
        text: 'Click on the map to add waypoints for your route.'
    });
}

/**
 * Adds a waypoint marker to the custom route.
 * Purpose: To visually represent a stop in the custom route.
 * How it works: Creates a google.maps.Marker, adds to array, and updates the list.
 */
function addCustomMarker(latLng, name = null, id = null) {
    const marker = new google.maps.Marker({
        position: latLng,
        map: map,
        label: (customMarkers.length + 1).toString()
    });
    marker.customName = name;
    marker.customId = id;
    customMarkers.push(marker);
    updateCustomRouteList();
}

/**
 * Clears the custom route.
 * Purpose: To reset the route builder.
 * How it works: Removes all custom markers and route lines from the map and resets arrays.
 */
function clearCustomRoute() {
    for (let m of customMarkers) {
        m.setMap(null);
    }
    customMarkers = [];
    if (customDirectionsRenderer) {
        customDirectionsRenderer.setMap(null);
    }
    if (customPolyline) {
        customPolyline.setMap(null);
    }
    updateCustomRouteList();
}

/**
 * Updates the list of custom route waypoints.
 * Purpose: To show the current sequence of points in the UI.
 * How it works: Rebuilds the HTML table based on customMarkers array.
 */
function updateCustomRouteList() {
    const list = $("#custom-route-list");
    list.empty();
    customMarkers.forEach((marker, index) => {
        const lat = marker.getPosition().lat().toFixed(5);
        const lng = marker.getPosition().lng().toFixed(5);
        const displayName = marker.customName ? marker.customName : `${lat}, ${lng}`;
        let infoBtn = '';
        if (marker.customId) {
            infoBtn = `<button class="btn btn-sm btn-info mx-1" onclick="infoModal('${marker.customId}')"><i class="fa-solid fa-info"></i></button>`;
        }
        
        let upBtn = '';
        let downBtn = '';
        if (index > 0) {
            upBtn = `<button class="btn btn-sm btn-secondary mx-1" onclick="moveCustomMarkerUp(${index})"><i class="fa-solid fa-arrow-up"></i></button>`;
        }
        if (index < customMarkers.length - 1) {
            downBtn = `<button class="btn btn-sm btn-secondary mx-1" onclick="moveCustomMarkerDown(${index})"><i class="fa-solid fa-arrow-down"></i></button>`;
        }

        const row = `
            <tr>
                <td>${index + 1}</td>
                <td>${displayName}</td>
                <td>${infoBtn}${upBtn}${downBtn}<button class="btn btn-sm btn-danger" onclick="removeCustomMarker(${index})"><i class="fa-solid fa-trash"></i></button></td>
            </tr>
        `;
        list.append(row);
    });
}

/**
 * Removes a waypoint from the custom route.
 * Purpose: To delete a specific point.
 * How it works: Removes marker from map, splices array, re-labels remaining markers, updates list.
 */
function removeCustomMarker(index) {
    customMarkers[index].setMap(null);
    customMarkers.splice(index, 1);
    // Re-label markers
    customMarkers.forEach((m, i) => m.setLabel((i + 1).toString()));
    updateCustomRouteList();
}

/**
 * Moves a waypoint up in the sequence.
 * Purpose: To reorder the route.
 * How it works: Swaps array elements and updates list.
 */
function moveCustomMarkerUp(index) {
    if (index > 0) {
        const temp = customMarkers[index];
        customMarkers[index] = customMarkers[index - 1];
        customMarkers[index - 1] = temp;
        
        // Update labels
        customMarkers.forEach((m, i) => m.setLabel((i + 1).toString()));
        
        updateCustomRouteList();
    }
}

/**
 * Moves a waypoint down in the sequence.
 * Purpose: To reorder the route.
 * How it works: Swaps array elements and updates list.
 */
function moveCustomMarkerDown(index) {
    if (index < customMarkers.length - 1) {
        const temp = customMarkers[index];
        customMarkers[index] = customMarkers[index + 1];
        customMarkers[index + 1] = temp;
        
        // Update labels
        customMarkers.forEach((m, i) => m.setLabel((i + 1).toString()));
        
        updateCustomRouteList();
    }
}

/**
 * Confirms and calculates the custom route.
 * Purpose: To generate the path connecting the selected waypoints.
 * How it works:
 * 1. Validates point count (min 2).
 * 2. Hides markers.
 * 3. Sends DirectionsRequest (origin, dest, waypoints) to Google API.
 * 4. Renders route or shows error.
 */
function confirmCustomRoute() {
    if (customMarkers.length < 2) {
        return Swal.fire({
            icon: 'warning',
            title: 'Not enough points',
            text: 'Please add at least 2 points to create a route.'
        });
    }

    google.maps.event.clearListeners(map, "click");
    for (const key in markerArray) {
        markerArray[key].setMap(null);
    }
    
    $("#confirm-custom-route-btn").hide();

    const origin = customMarkers[0].getPosition();
    const destination = customMarkers[customMarkers.length - 1].getPosition();
    const waypoints = [];
    for (let i = 1; i < customMarkers.length - 1; i++) {
        waypoints.push({
            location: customMarkers[i].getPosition(),
            stopover: true
        });
    }

    const request = {
        origin: origin,
        destination: destination,
        waypoints: waypoints,
        travelMode: google.maps.TravelMode.DRIVING
    };

    if (!directionsService) {
        directionsService = new google.maps.DirectionsService();
    }

    directionsService.route(request, function(result, status) {
        if (status === 'OK') {
            if (!customDirectionsRenderer) {
                customDirectionsRenderer = new google.maps.DirectionsRenderer({
                    map: map,
                    suppressMarkers: true,
                    polylineOptions: {
                        strokeColor: "#0000FF",
                        strokeOpacity: 0.7,
                        strokeWeight: 5
                    }
                });
            } else {
                customDirectionsRenderer.setMap(map);
            }
            customDirectionsRenderer.setDirections(result);
        } else {
            console.error("Directions request failed. Status:", status);
            let errorMsg = 'Could not calculate route: ' + status;
            if (status === 'REQUEST_DENIED') {
                errorMsg = 'Routing failed.';
            }
            Swal.fire({
                icon: 'error',
                title: 'Routing Failed',
                text: errorMsg
            });
        }
    });

    let bounds = new google.maps.LatLngBounds();
    customMarkers.forEach(marker => bounds.extend(marker.getPosition()));
    map.fitBounds(bounds);
}
