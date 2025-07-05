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

let selectedShape,
  drawingManager = new google.maps.drawing.DrawingManager();
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

function initMap(lat = -0.45645247101825404, lng = 100.49283409109306) {
  directionsService = new google.maps.DirectionsService();
  const center = new google.maps.LatLng(lat, lng);
  map = new google.maps.Map(document.getElementById("googlemaps"), {
    zoom: 6,
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

function goToVillage() {
  // map.setCenter({ lat: -0.11371891332439286, lng: 100.66784601319584 });
  map.panTo({ lat: -0.11371891332439286, lng: 100.66784601319584 });
  map.setZoom(16);
}

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

// Display tourism village digitizing
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
          } else {
            map.fitBounds(bounds);
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

// Remove user location
function clearUser() {
  userLat = 0;
  userLng = 0;
  userMarker.setMap(null);
}

// Set current location based on user location
function setUserLoc(lat, lng) {
  userLat = lat;
  userLng = lng;
  currentLat = userLat;
  currentLng = userLng;
}

// Remove any route shown
function clearRoute() {
  for (i in routeArray) {
    routeArray[i].setMap(null);
  }
  routeArray = [];
  $("#direction-row").hide();
}

// Remove any radius shown
function clearRadius() {
  for (i in circleArray) {
    circleArray[i].setMap(null);
  }
  circleArray = [];
}

// Remove any marker shown
function clearMarker() {
  for (i in markerArray) {
    markerArray[i].setMap(null);
  }
  markerArray = {};
}

// Get user's current position
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

// Error handler for geolocation
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(
    browserHasGeolocation
      ? "Error: The Geolocation service failed."
      : "Error: Your browser doesn't support geolocation."
  );
  infoWindow.open(map);
}

// User set position on map
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

// Render route on selected object
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
  directionsService.route(request, function (result, status) {
    if (status == "OK") {
      directionsRenderer.setDirections(result);
      showSteps(result);
      directionsRenderer.setMap(map);
      routeArray.push(directionsRenderer);
    }
  });
  boundToRoute(start, end);
}

// Display marker for loaded object
function objectMarker(id, lat, lng, anim = true, attcat = null, login = false) {
  const currentUrl = window.location.href;
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
  });

  markerArray[id] = marker;
}

// Display info window for loaded object
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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
          "</div>";
        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

        content =
          '<div class="text-center">' +
          '<p class="fw-bold fs-6">' +
          name +
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

// Render map to contains all object marker
function boundToObject(firstTime = true) {
  if (Object.keys(markerArray).length > 0) {
    bounds = new google.maps.LatLngBounds();
    for (i in markerArray) {
      bounds.extend(markerArray[i].getPosition());
    }
    if (firstTime) {
      map.fitBounds(bounds, 80);
    } else {
      map.panTo(bounds.getCenter());
    }
  } else {
    // let pos = new google.maps.LatLng(-0.4552969270702257, 100.49274351069286);
    // map.panTo(pos);
    digitTourismVillage();
  }
}

// Render map to contains route and its markers
function boundToRoute(start, end) {
  bounds = new google.maps.LatLngBounds();
  bounds.extend(start);
  bounds.extend(end);
  map.panToBounds(bounds, 100);
}

// Add user position to map bound
function boundToRadius(lat, lng, rad) {
  let userBound = new google.maps.LatLng(lat, lng);
  const radiusCircle = new google.maps.Circle({
    center: userBound,
    radius: Number(rad),
  });
  map.fitBounds(radiusCircle.getBounds());
}

// Draw radius circle
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

// Update radiusValue on search by radius
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

// Render search by radius
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

// pan to selected object
function focusObject(id) {
  google.maps.event.trigger(markerArray[id], "click");
  map.panTo(markerArray[id].getPosition());
}

// display objects by feature used
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

// display steps of direction to selected route
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

// close nearby search section
function closeNearby() {
  $("#direction-row").hide();
  $("#check-nearby-col").hide();
  $("#result-nearby-col").hide();
  $("#result-nearbyyou-col").hide();
  $("#list-rec-col").show();
  $("#list-rg-col").show();
  $("#list-ev-col").show();
}

// open nearby search section
function openNearby(id, lat, lng) {
  $("#list-rg-col").hide();
  $("#list-ev-col").hide();
  $("#list-rec-col").hide();
  $("#check-nearby-col").show();

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

// Search Result Object Around
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

// Fetch object nearby by category
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

// Add nearby object to corresponding table
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

// Show modal for object
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

// Find object by name
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

// Get list of Rumah Gadang facilities
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

// Find Attraction by Facility
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
// Find Homestay by Facility
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

// Set star by user input
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

// Find object by Rating
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

// Find object by Category
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

// Get list of Event category
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

// // Find object by Date
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

// Create compass
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

// Create legend
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

// toggle legend element
function viewLegend() {
  if ($("#legend").is(":hidden")) {
    $("#legend").show();
  } else {
    $("#legend").hide();
  }
}

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

function viewLegendTraffic() {
  if ($("#legend_t").is(":hidden")) {
    $("#legend_t").show();
  } else {
    $("#legend_t").hide();
  }
}

let trafficVisible = false;

const trafficLayer = new google.maps.TrafficLayer();

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

// list object for new visit history
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

// Validate if star rating picked yet
function checkStar(event) {
  const star = document.getElementById("rating").value;
  if (star == "0") {
    event.preventDefault();
    Swal.fire("Please put rating star");
  }
}
function checkRatingStar(event) {
  const star = document.getElementById("rating_star").value;
  if (star == "0") {
    event.preventDefault();
    Swal.fire("Please put rating star");
  }
}

// Check if Category and Object is chose correctly
function checkForm(event) {
  const category = document.getElementById("category").value;
  const object = document.getElementById("object").value;
  if (category === "None" || object === "None") {
    event.preventDefault();
    Swal.fire("Please select the correct Category and Object");
  }
}

// Update preview of uploaded photo profile
function showPreview(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      $("#avatar-preview").attr("src", e.target.result).width(300).height(300);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

// Get list of Recommendation
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

// Update option onclick function for updating Recommendation
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

// Update recommendation based on input User
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

// Set map to coordinate put by user
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

// Unselect shape on drawing map
function clearSelection() {
  if (selectedShape) {
    selectedShape.setEditable(false);
    selectedShape = null;
  }
}

// Make selected shape editable on maps
function setSelection(shape) {
  clearSelection();
  selectedShape = shape;
  shape.setEditable(true);
}

// Remove selected shape on maps
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

// Initialize drawing manager on maps
function initDrawingManager(edit = false) {
  const drawingManagerOpts = {
    drawingMode: google.maps.drawing.OverlayType.POLYGON,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [google.maps.drawing.OverlayType.POLYGON],
    },
    polygonOptions: {
      fillColor: "blue",
      strokeColor: "blue",
      editable: true,
    },
    map: map,
  };
  drawingManager.setOptions(drawingManagerOpts);
  let newShape;

  if (!edit) {
    google.maps.event.addListener(
      drawingManager,
      "overlaycomplete",
      function (event) {
        drawingManager.setOptions({
          drawingControl: false,
          drawingMode: null,
        });
        newShape = event.overlay;
        newShape.type = event.type;
        setSelection(newShape);
        saveSelection(newShape);

        google.maps.event.addListener(newShape, "click", function () {
          setSelection(newShape);
        });
        google.maps.event.addListener(newShape.getPath(), "insert_at", () => {
          saveSelection(newShape);
        });
        google.maps.event.addListener(newShape.getPath(), "remove_at", () => {
          saveSelection(newShape);
        });
        google.maps.event.addListener(newShape.getPath(), "set_at", () => {
          saveSelection(newShape);
        });
      }
    );
  } else {
    drawingManager.setOptions({
      drawingControl: false,
      drawingMode: null,
    });

    newShape = drawGeom();
    newShape.type = "polygon";
    setSelection(newShape);

    const paths = newShape.getPath().getArray();
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

    google.maps.event.addListener(newShape, "click", function () {
      setSelection(newShape);
    });
    google.maps.event.addListener(newShape.getPath(), "insert_at", () => {
      saveSelection(newShape);
    });
    google.maps.event.addListener(newShape.getPath(), "remove_at", () => {
      saveSelection(newShape);
    });
    google.maps.event.addListener(newShape.getPath(), "set_at", () => {
      saveSelection(newShape);
    });
  }

  google.maps.event.addListener(map, "click", clearSelection);
  google.maps.event.addDomListener(
    document.getElementById("clear-drawing"),
    "click",
    deleteSelectedShape
  );
}

// Get geoJSON of selected shape on map
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

// Get list of users
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
// Get list of Village
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

// Get list of Worship Place Category
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
// Get list of Homestay Unit Facility
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
// Get list of Souvenir Product
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
// Get list of Culinary Product
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

// Draw current GeoJSON on drawing manager
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
//Delete Unit Facility
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
//Delete Event Date
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
//Delete Package Day
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
//Delete Package Detail
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
//Delete Package Service
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

// Delete selected object
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

// Get user's current position
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

// Pan map to user position
function panToUser() {
  if (userLat == 0 && userLng == 0) {
    return Swal.fire("Determine your position first!");
  }
  let pos = new google.maps.LatLng(userLat, userLng);
  map.panTo(pos);
}

// Find RG on mobile
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

// Find RG by Rating on Mobile
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

// Find object by Facility on Mobile
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

// Find RG by Category on Mobile
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

// Find EV on mobile
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

// Find EV by Rating on Mobile
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

// Find EV by Category on Mobile
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

// // Find EV by Date
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

// Get Homestay Name

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
// Get List Object for Tourism Package
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
// Get List Service for Tourism Package
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

function getTotalPrice(price = null) {
  const total_order = document.getElementById("totalOrder");

  document
    .getElementById("totalPrice")
    .setAttribute("value", total_order.value * price);
}

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
// route between two sets of coordinates
function routeBetweenObjects(startLat, startLng, endLat, endLng) {
  clearRadius();
  clearRoute();
  initMap();
  google.maps.event.clearListeners(map, "click");

  // Create LatLng objects for the start and end coordinates
  const start = new google.maps.LatLng(startLat, startLng);
  const end = new google.maps.LatLng(endLat, endLng);

  let request = {
    origin: start,
    destination: end,
    travelMode: "DRIVING",
  };

  directionsService.route(request, function (result, status) {
    if (status == "OK") {
      directionsRenderer.setDirections(result);
      showSteps(result);
      directionsRenderer.setMap(map);
      routeArray.push(directionsRenderer);
    }
  });

  boundToRoute(start, end);
}

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

function clearDigitNeg() {
  digitNegLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitNegLayers = [];
}

function clearDigitProv() {
  digitProvLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitProvLayers = [];
}

function clearDigitKabKota() {
  digitKabKotaLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitKabKotaLayers = [];
}

function clearDigitVillage() {
  digitVillageLayers.forEach((layer) => {
    layer.setMap(null);
  });
  digitVillageLayers = [];
}

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
        2. Rent a car to Nagari Tuo Pariangan.
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
        2. Rent a car to Nagari Tuo Pariangan.
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
        2. Rent a car to Nagari Tuo Pariangan.
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
        1. Travel by land directly to Nagari Tuo Pariangan.<br>
        2. Alternatively, fly to Padang (PDG) and rent a car to Nagari Tuo Pariangan.
      </div>
    </div>
  `
  );

  map.setZoom(6);
}

function clearAirplaneMarkers() {
  airplaneMarkers.forEach((marker) => marker.setMap(null));
  airplaneMarkers.length = 0; // Clear the array
}

// Clear all car markers
function clearCarMarkers() {
  carMarkers.forEach((marker) => marker.setMap(null));
  carMarkers.length = 0; // Clear the array
}

function clearOverlay() {
  overlays.forEach((overlay) => {
    overlay.setMap(null); // Remove overlay from the map
  });
  overlays = []; // Clear the array
}

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

function clearHtro() {
  clearAirplaneMarkers();
  clearCarMarkers();
  clearOverlay();
}

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
function openAround() {
  $("#list-rg-col").hide();
  $("#list-ev-col").hide();
  $("#list-rec-col").hide();
  $("#check-nearbyyou-col").show();
}
