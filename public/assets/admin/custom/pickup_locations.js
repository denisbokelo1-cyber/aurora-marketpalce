$(document).ready(function () {
    let map;
    let marker;

    // Initialize map when modal is shown
    $("#add_pickup_location").on("shown.bs.modal", function () {
        if (!map) {
            let defaultLat = 20.5937;
            let defaultLng = 78.9629;
            let defaultZoom = 5;

            map = L.map("pickup_map").setView(
                [defaultLat, defaultLng],
                defaultZoom,
            );

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution:
                    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
            }).addTo(map);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let userLat = position.coords.latitude;
                    let userLng = position.coords.longitude;
                    map.setView([userLat, userLng], 13);

                    if (marker) {
                        marker.setLatLng([userLat, userLng]);
                    } else {
                        marker = L.marker([userLat, userLng], {
                            draggable: true,
                        }).addTo(map);

                        marker.on("dragend", function (e) {
                            let position = marker.getLatLng();
                            updatePickupCoordinates(position.lat, position.lng);
                        });
                    }

                    updatePickupCoordinates(userLat, userLng);
                });
            }

            map.on("click", function (e) {
                let lat = e.latlng.lat;
                let lng = e.latlng.lng;

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {
                        draggable: true,
                    }).addTo(map);

                    marker.on("dragend", function (e) {
                        let position = marker.getLatLng();
                        updatePickupCoordinates(position.lat, position.lng);
                    });
                }

                updatePickupCoordinates(lat, lng);
            });
        } else {
            setTimeout(function () {
                map.invalidateSize();
            }, 100);
        }
    });

    function updatePickupCoordinates(lat, lng) {
        document.getElementById("latitude").value = lat.toFixed(8);
        document.getElementById("longitude").value = lng.toFixed(8);
    }

    $("#add_pickup_location").on("hidden.bs.modal", function () {
        document.getElementById("latitude").value = "";
        document.getElementById("longitude").value = "";

        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }
    });
});

// Delete action events
window.actionEvents = window.actionEvents || {};
window.actionEvents["click .delete-pickup-location"] = function (
    e,
    value,
    row,
    index,
) {
    e.preventDefault();
    const pickupLocationId = row.id;

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/seller/pickup_locations/${pickupLocationId}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content",
                    ),
                },
                success: function (response) {
                    if (!response.error) {
                        Swal.fire("Deleted!", response.message, "success");
                        $("#seller_pickup_location_table").bootstrapTable(
                            "refresh",
                        );
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function (xhr) {
                    Swal.fire("Error!", "Something went wrong!", "error");
                },
            });
        }
    });
};
