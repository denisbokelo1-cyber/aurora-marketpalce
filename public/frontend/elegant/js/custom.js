"use strict";
Dropzone.autoDiscover = false;
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
var is_logged = "";
var appUrl = document.getElementById("app_url").dataset.appUrl;
if (appUrl.charAt(appUrl.length - 1) !== "/") {
    appUrl += "/";
}
// Strip a stray "/public/" segment that can leak in when Apache rewrites the
// request to public/ internally and Laravel detects /public as the base URL.
appUrl = appUrl.replace(/\/public\/(?=$|\?|#)/, "/").replace(/\/public\//g, "/");
$(".loading-state").addClass("d-none");

// Compare list (add to compare) — bind exactly once at module load.
// Previously the helpers + click delegation lived inside the
// livewire:navigated listener and used $(document).off("click.compareAdd",
// ".add-compare").on(...) to clear-and-rebind on every navigation. In
// practice that was leaving stale handlers attached, so after navigating
// across 2–3 pages a single click on a `.add-compare` button was firing
// the POST /product/add-to-compare request and the iziToast success
// message 2–3 times. Binding once with a guard makes navigation
// completely irrelevant — the handler can never be duplicated.
(function ($) {
    if (window.__compareAddBound) return;
    window.__compareAddBound = true;

    function getStoredCompareItems() {
        let compare = [];
        try {
            const rawCompare = localStorage.getItem("compare");
            const parsedCompare = rawCompare ? JSON.parse(rawCompare) : [];
            compare = Array.isArray(parsedCompare) ? parsedCompare : [];
        } catch (error) {
            compare = [];
        }

        const normalizedCompare = [];
        const seenCompareItems = new Set();

        compare.forEach((item) => {
            let product_id = null;
            let product_type = "regular";

            if (item !== null && typeof item === "object") {
                product_id = item.product_id;
                product_type = item.product_type || "regular";
            } else {
                product_id = item;
            }

            product_id =
                product_id === undefined || product_id === null
                    ? ""
                    : String(product_id).trim();
            product_type = String(product_type || "regular").trim();

            if (!product_id) return;

            const compareKey = product_type + ":" + product_id;
            if (seenCompareItems.has(compareKey)) return;

            seenCompareItems.add(compareKey);
            normalizedCompare.push({
                product_id: product_id,
                product_type: product_type,
            });
        });

        localStorage.setItem("compare", JSON.stringify(normalizedCompare));
        return normalizedCompare;
    }

    function saveCompareItems(compare) {
        localStorage.setItem("compare", JSON.stringify(compare));
    }

    function syncCompareItemsWithServer(compare, callback) {
        if (!Array.isArray(compare) || compare.length === 0) {
            saveCompareItems([]);
            if (typeof callback === "function") callback([]);
            return;
        }

        $.ajax({
            type: "POST",
            url: appUrl + "product/add-to-compare",
            data: { product_id: compare },
            success: function (response) {
                const syncedCompare = Array.isArray(
                    response && response.data && response.data.valid_compare_items
                )
                    ? response.data.valid_compare_items
                    : compare;

                saveCompareItems(syncedCompare);
                if (typeof callback === "function") callback(syncedCompare);
            },
            error: function () {
                if (typeof callback === "function") callback(compare);
            },
        });
    }

    // Re-entrancy guard — protects against any stray duplicate listeners
    // that might still be attached from cached/older bundles.
    let compareClickInFlight = false;

    $(document).on("click", ".add-compare", function (e) {
        e.preventDefault();
        if (compareClickInFlight) return;
        compareClickInFlight = true;
        // Release on next tick so legitimate later clicks still work.
        setTimeout(function () { compareClickInFlight = false; }, 400);

        let product_id = $(this).attr("data-product-id");
        let product_type = $(this).attr("data-product-type");
        if (product_type == undefined || product_type == null) {
            product_type = "regular";
        }

        if (product_id == undefined || product_id == null || product_id === "") {
            iziToast.error({
                message: "Invalid product for compare list",
                position: "topRight",
            });
            return;
        }

        let compare_item = {
            product_id: String(product_id).trim(),
            product_type: String(product_type).trim(),
        };
        let compare = getStoredCompareItems();

        const isAlreadyInCompare = (items) =>
            items.find(
                (item) =>
                    item.product_id === compare_item.product_id &&
                    item.product_type === compare_item.product_type
            );

        if (isAlreadyInCompare(compare)) {
            // Re-sync stale local compare cache before deciding duplicate.
            syncCompareItemsWithServer(compare, function (syncedCompare) {
                syncedCompare.push(compare_item);
                saveCompareItems(syncedCompare);
                iziToast.success({
                    message: "Product Added To Compare",
                    position: "topRight",
                });
            });
            return;
        }

        compare.push(compare_item);
        saveCompareItems(compare);
        iziToast.success({
            message: "Product Added To Compare",
            position: "topRight",
        });
    });
})(jQuery);

document.addEventListener("livewire:initialized", () => {
    Livewire.on("validationErrorshow", (message) => {
        let messages = message[0].data;
        $.each(messages, function (key, value) {
            iziToast.error({
                message: value[0],
                position: "topRight",
            });
            return false;
        });
    });
}, { once: true });
// Livewire.on("validationErrorshow", (message) => {
//     let messages = message[0].data;
//     let firstError = Object.values(messages)[0][0]; // Get the first error message

//     iziToast.error({
//         message: firstError,
//         position: "topRight",
//     });
// });
document.addEventListener("livewire:initialized", () => {
    Livewire.on("validationSuccessShow", (message) => {
        let messages = message[0].data;
        $.each(messages, function (key, value) {
            iziToast.success({
                message: value[0],
                position: "topRight",
            });
            return false;
        });
    });
}, { once: true });
document.addEventListener("livewire:initialized", () => {
    Livewire.on("showError", (message) => {
        iziToast.error({
            title: "Error",
            message: message,
            position: "topRight",
        });
        $(".kv-ltr-theme-svg-star").rating();
    });
}, { once: true });
document.addEventListener("livewire:initialized", () => {
    Livewire.on("showSuccess", (message) => {
        iziToast.success({
            title: "Success",
            message: message,
            position: "topRight",
        });
        $(".kv-ltr-theme-svg-star").rating();
    });
}, { once: true });

// Livewire.on("showSuccess", (message) => {
//     iziToast.destroy();
//     iziToast.success({
//         title: "Success",
//         message: message,
//         position: "topRight",
//     });
//     $(".kv-ltr-theme-svg-star").rating();
// });

function product_zoom() {
    $(".zoompro").elevateZoom({
        gallery: "gallery",
        cursor: "pointer",
        galleryActiveClass: "active",
        imageCrossfade: true,
        borderSize: 2,
        loadingIcon: "https://www.elevateweb.co.uk/spinner.gif",
    });
    $(".zoompro_style_2").elevateZoom({
        gallery: "gallery",
        cursor: "pointer",
        zoomType: "inner",
        galleryActiveClass: "active",
        imageCrossfade: true,
        borderSize: 2,
        loadingIcon: "https://www.elevateweb.co.uk/spinner.gif",
    });
}

function FirebaseAuth() {
    $.ajax({
        type: "get",
        url: appUrl + "settings/get-firebase-credentials",
        dataType: "json",
        success: function (response) {
            const firebaseConfig = {
                apiKey: response.apiKey,
                authDomain: response.authDomain,
                projectId: response.projectId,
                databaseURL: response.databaseURL,
                storageBucket: response.storageBucket,
                messagingSenderId: response.messagingSenderId,
                appId: response.appId,
                measurementId: response.measurementId,
            };
            if (firebase.apps.length == 0) {
                firebase.initializeApp(firebaseConfig);
            }
            let coderesult = "";
            $("#send_otp").on("click", function () {
                let code = $("#number").intlTelInput(
                    "getSelectedCountryData"
                ).dialCode;
                let number = $("#number").val();
                let type = $("#type").val();
                if (number == "") {
                    iziToast.error({
                        message: "Please Enter Mobile Number",
                        position: "topRight",
                    });
                    return;
                }
                $("#send_otp").attr("disabled", true).html("Please Wait...");
                const call_api = () => {
                    return new Promise((resolve, reject) => {
                        if (type == "password-recovery") {
                            $.ajax({
                                type: "POST",
                                url: appUrl + "password-recovery/check-number",
                                data: {
                                    mobile: number,
                                },
                                success: function (response) {
                                    if (response.error == true) {
                                        $("#send_otp")
                                            .attr("disabled", false)
                                            .html("Send OTP");
                                        iziToast.error({
                                            message: response.message,
                                            position: "topRight",
                                        });
                                        reject(0);
                                        return;
                                    }
                                    resolve();
                                },
                            });
                        } else {
                            $.ajax({
                                type: "POST",
                                url: appUrl + "register/check-number",
                                data: {
                                    mobile: number,
                                },
                                success: function (response) {
                                    if (
                                        response.allow_modification_error !=
                                        undefined &&
                                        response.allow_modification_error ==
                                        true
                                    ) {
                                        $("#send_otp")
                                            .attr("disabled", false)
                                            .html("Send OTP");
                                        iziToast.error({
                                            message: response.message,
                                            position: "topRight",
                                        });
                                        return;
                                    }
                                    if (response.error == true) {
                                        $("#send_otp")
                                            .attr("disabled", false)
                                            .html("Send OTP");
                                        $.each(
                                            response.message,
                                            function (key, value) {
                                                iziToast.error({
                                                    message: value[0],
                                                    position: "topRight",
                                                });
                                            }
                                        );
                                        reject(0);
                                        return;
                                    }
                                    resolve();
                                },
                            });
                        }
                    });
                };
                call_api()
                    .then(() => {
                        let phoneNumber = "+" + code + number;
                        firebase
                            .auth()
                            .signInWithPhoneNumber(
                                phoneNumber,
                                window.recaptchaVerifier
                            )
                            .then(function (confirmationResult) {
                                window.confirmationResult = confirmationResult;
                                coderesult = confirmationResult;
                                $(".send-otp-box").addClass("d-none");
                                $(".verify-otp-box").removeClass("d-none");
                                iziToast.success({
                                    message: "OTP Sent Successfully",
                                    position: "topRight",
                                });
                            })
                            .catch(function (error) {
                                "#send_otp"
                                    .attr("disabled", false)
                                    .html("Send OTP");
                                iziToast.error({
                                    message: error.message,
                                    position: "topRight",
                                });
                                return;
                            });
                    })
                    .catch((err) => { });
            });
            $("#verify_otp").on("click", function () {
                let code = $("#verificationCode").val();
                if (code == "") {
                    iziToast.error({
                        message: "Please Enter Verification Code",
                        position: "topRight",
                    });
                    return;
                }
                $("#verify_otp").attr("disabled", true).html("Please Wait...");
                coderesult
                    .confirm(code)
                    .then(function (result) {
                        let type = $("#type").val();
                        $(".verify-otp-box").addClass("d-none");
                        if (type == "password-recovery") {
                            $(".reset-password-form").removeClass("d-none");
                        } else {
                            $(".register-form").removeClass("d-none");
                        }
                        iziToast.success({
                            message: "Mobile Number Verified",
                            position: "topRight",
                        });

                        if (type == "password-recovery") {
                            $(".reset-password-form").on(
                                "submit",
                                function (e) {
                                    e.preventDefault();
                                    let number = $("#number").val();
                                    let password = $("#password").val();
                                    let password_confirmation = $(
                                        "#password_confirmation"
                                    ).val();
                                    if (password == "") {
                                        iziToast.error({
                                            message: "Please Enter Password",
                                            position: "topRight",
                                        });
                                        return;
                                    }
                                    if (password != password_confirmation) {
                                        iziToast.error({
                                            message:
                                                "Password and Conform Password Doesn't match",
                                            position: "topRight",
                                        });
                                        return;
                                    }
                                    $("#changePassword")
                                        .attr("disabled", true)
                                        .val("Please Wait...");
                                    $.ajax({
                                        type: "POST",
                                        url:
                                            appUrl +
                                            "password-recovery/set-new-password",
                                        data: {
                                            mobile: number,
                                            new_password: password,
                                            verify_password:
                                                password_confirmation,
                                        },
                                        success: function (response) {
                                            if (response.error == true) {
                                                $("#changePassword")
                                                    .attr("disabled", false)
                                                    .val("Change Password");
                                                $.each(
                                                    response.message,
                                                    function (key, value) {
                                                        iziToast.error({
                                                            message: value[0],
                                                            position:
                                                                "topRight",
                                                        });
                                                        return false;
                                                    }
                                                );
                                                return false;
                                            }
                                            iziToast.success({
                                                message: response.message,
                                                position: "topRight",
                                            });
                                            Livewire.navigate("/login");
                                            return;
                                        },
                                    });
                                }
                            );
                        } else {
                            $(".register-form").on("submit", function (e) {
                                e.preventDefault();
                                let username = $("#username").val();
                                let country_code = $(".selected-dial-code").text();
                                let number = $("#number").val();
                                let email = $("#email").val();
                                let password = $("#password").val();
                                let password_confirmation = $(
                                    "#password_confirmation"
                                ).val();

                                if (username == "") {
                                    iziToast.error({
                                        message: "Please Enter Username",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                if (email == "") {
                                    iziToast.error({
                                        message: "Please Enter Email",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                if (password == "") {
                                    iziToast.error({
                                        message: "Please Enter Password",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                if (password != password_confirmation) {
                                    iziToast.error({
                                        message:
                                            "Password and Conform Password Doesn't match",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                $("#register-form-submit")
                                    .attr("disabled", true)
                                    .val("Please Wait...");

                                $.ajax({
                                    type: "POST",
                                    url: appUrl + "register/submit",
                                    data: {
                                        username,
                                        mobile: number,
                                        email,
                                        country_code,
                                        password,
                                        password_confirmation,
                                    },
                                    success: function (response) {
                                        if (response.error == true) {
                                            $("#register-form-submit")
                                                .attr("disabled", false)
                                                .val("Register");
                                            $.each(
                                                response.message,
                                                function (key, value) {
                                                    iziToast.error({
                                                        message: value[0],
                                                        position: "topRight",
                                                    });
                                                    return false;
                                                }
                                            );
                                            return false;
                                        }
                                        iziToast.success({
                                            message: response.message,
                                            position: "topRight",
                                        });
                                        Livewire.navigate("/");
                                        return;
                                    },
                                });
                            });
                        }
                    })
                    .catch(function (error) {
                        $("#verify_otp")
                            .attr("disabled", false)
                            .html("Verify Code");
                        iziToast.success({
                            message: error.message,
                            position: "topRight",
                        });
                    });
            });
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
                "recaptcha-container"
            );
            recaptchaVerifier.render();
        },
    });
}

function CustomSmsAuth() {
    $("#send_otp").on("click", function () {
        let code = $("#number").intlTelInput("getSelectedCountryData").dialCode;
        let number = $("#number").val();
        let type = $("#type").val();
        if (number == "") {
            iziToast.error({
                message: "Please Enter Mobile Number",
                position: "topRight",
            });
            return;
        }
        $("#send_otp").attr("disabled", true).html("Please Wait...");
        const call_api = () => {
            return new Promise((resolve, reject) => {
                if (type == "password-recovery") {
                    $.ajax({
                        type: "POST",
                        url: appUrl + "password-recovery/check-number",
                        data: {
                            mobile: number,
                        },
                        success: function (response) {
                            if (response.error == true) {
                                "#send_otp"
                                    .attr("disabled", false)
                                    .html("Send OTP");
                                iziToast.error({
                                    message: response.message,
                                    position: "topRight",
                                });
                                reject(0);
                                return;
                            }
                            resolve();
                        },
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: appUrl + "register/check-number",
                        data: {
                            mobile: number,
                        },
                        success: function (response) {
                            if (response.error == true) {
                                "#send_otp"
                                    .attr("disabled", false)
                                    .html("Send OTP");
                                if (Array.isArray(response.message)) {
                                    $.each(
                                        response.message,
                                        function (key, value) {
                                            iziToast.error({
                                                message: value[0],
                                                position: "topRight",
                                            });
                                        }
                                    );
                                } else {
                                    iziToast.error({
                                        message: response.message,
                                        position: "topRight",
                                    });
                                }
                                reject(0);
                                return;
                            }
                            resolve();
                        },
                    });
                }
            });
        };
        call_api()
            .then(() => {
                $.ajax({
                    type: "POST",
                    url: appUrl + "auth/send_otp",
                    data: {
                        code,
                        mobile: number,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.error == false) {
                            $(".send-otp-box").addClass("d-none");
                            $(".verify-otp-box").removeClass("d-none");
                            iziToast.success({
                                message: response.message,
                                position: "topRight",
                            });
                            return;
                        }
                        "#send_otp".attr("disabled", false).html("Send OTP");
                        iziToast.error({
                            message: response.message,
                            position: "topRight",
                        });
                        return;
                    },
                });
            })
            .catch((err) => { });
        $("#verify_otp").on("click", function () {
            let code = $("#verificationCode").val();
            let number = $("#number").val();
            if (code == "") {
                iziToast.error({
                    message: "Please Enter Verification Code",
                    position: "topRight",
                });
                return;
            }
            $("#verify_otp").attr("disabled", true).html("Please Wait...");
            $.ajax({
                type: "post",
                url: appUrl + "auth/verify_otp",
                data: {
                    mobile: number,
                    verification_code: code,
                },
                dataType: "json",
                success: function (response) {
                    if (response.error == false) {
                        let type = $("#type").val();
                        $(".verify-otp-box").addClass("d-none");
                        if (type == "password-recovery") {
                            $(".reset-password-form").removeClass("d-none");
                        } else {
                            $(".register-form").removeClass("d-none");
                        }
                        iziToast.success({
                            message: "Mobile Number Verified",
                            position: "topRight",
                        });
                        if (type == "password-recovery") {
                            $(".reset-password-form").on(
                                "submit",
                                function (e) {
                                    e.preventDefault();
                                    let number = $("#number").val();
                                    let password = $("#password").val();
                                    let password_confirmation = $(
                                        "#password_confirmation"
                                    ).val();
                                    if (password == "") {
                                        iziToast.error({
                                            message: "Please Enter Password",
                                            position: "topRight",
                                        });
                                        return;
                                    }
                                    if (password != password_confirmation) {
                                        iziToast.error({
                                            message:
                                                "Password and Conform Password Doesn't match",
                                            position: "topRight",
                                        });
                                        return;
                                    }
                                    $("#changePassword")
                                        .attr("disabled", true)
                                        .val("Please Wait...");
                                    $.ajax({
                                        type: "POST",
                                        url:
                                            appUrl +
                                            "password-recovery/set-new-password",
                                        data: {
                                            mobile: number,
                                            new_password: password,
                                            verify_password:
                                                password_confirmation,
                                        },
                                        success: function (response) {
                                            if (response.error == true) {
                                                $("#changePassword")
                                                    .attr("disabled", false)
                                                    .val("Change Password");
                                                $.each(
                                                    response.message,
                                                    function (key, value) {
                                                        iziToast.error({
                                                            message: value[0],
                                                            position:
                                                                "topRight",
                                                        });
                                                        return false;
                                                    }
                                                );
                                                return false;
                                            }
                                            iziToast.success({
                                                message: response.message,
                                                position: "topRight",
                                            });
                                            Livewire.navigate("/login");
                                            return;
                                        },
                                    });
                                }
                            );
                            return;
                        } else {
                            $(".register-form").on("submit", function (e) {
                                e.preventDefault();
                                let username = $("#username").val();
                                let country_code = $('.selected-dial-code').text();
                                let number = $("#number").val();
                                let email = $("#email").val();
                                let password = $("#password").val();
                                let password_confirmation = $(
                                    "#password_confirmation"
                                ).val();

                                if (username == "") {
                                    iziToast.error({
                                        message: "Please Enter Username",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                if (email == "") {
                                    iziToast.error({
                                        message: "Please Enter Email",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                if (password == "") {
                                    iziToast.error({
                                        message: "Please Enter Password",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                if (password != password_confirmation) {
                                    iziToast.error({
                                        message:
                                            "Password and Conform Password Doesn't match",
                                        position: "topRight",
                                    });
                                    return;
                                }
                                $("#register-form-submit")
                                    .attr("disabled", true)
                                    .val("Please Wait...");
                                $.ajax({
                                    type: "POST",
                                    url: appUrl + "register/submit",
                                    data: {
                                        username,
                                        mobile: number,
                                        email,
                                        password,
                                        country_code,
                                        password_confirmation,
                                    },
                                    success: function (response) {
                                        if (response.error == true) {
                                            $("#register-form-submit")
                                                .attr("disabled", false)
                                                .val("Register");
                                            $.each(
                                                response.message,
                                                function (key, value) {
                                                    iziToast.error({
                                                        message: value[0],
                                                        position: "topRight",
                                                    });
                                                    return false;
                                                }
                                            );
                                            return false;
                                        }
                                        iziToast.success({
                                            message: response.message,
                                            position: "topRight",
                                        });
                                        Livewire.navigate("/");
                                        return;
                                    },
                                });
                            });
                            return;
                        }
                    }
                    $("#verify_otp")
                        .attr("disabled", false)
                        .html("Verify Code");
                    iziToast.error({
                        message: response.message,
                        position: "topRight",
                    });
                    return;
                },
            });
        });
    });
}

function bootTab_init() {
    const tabLinks = document.querySelectorAll(".product-tabs .tablink");
    const tabContents = document.querySelectorAll(
        ".tab-container .tab-content"
    );
    tabLinks.forEach(function (tabLink) {
        tabLink.addEventListener("click", function (event) {
            event.preventDefault();
            tabLinks.forEach(function (link) {
                link.parentElement.classList.remove("active");
            });
            this.parentElement.classList.add("active");
            const targetTabId = this.getAttribute("rel");
            const targetTab = document.getElementById(targetTabId);

            tabContents.forEach(function (content) {
                content.style.display = "none";
            });
            if (targetTab !== null && targetTab !== undefined) {
                targetTab.style.display = "block";
            }
        });
    });
}

function display_cart(cart) {
    let display = "";
    let currency_symbol = $("#currency").val();
    let current_store_id = $("#current_store_id").val();

    if (cart !== null && cart.length > 0) {
        display += `<div class="block block-cart"><div class="minicart-content"><ul class="m-0 clearfix">`;

        let total = 0;
        let cart_count = 0;
        cart.forEach((e) => {
            if (e.store_id == current_store_id) {
                total += parseFloat(e.variant_price);
                cart_count++;
                display +=
                    '<li class="item d-flex justify-content-center align-items-center">' +
                    '<a class="product-image rounded-3" wire:navigate href="' +
                    appUrl +
                    "products/" +
                    e.slug +
                    '"><img class="blur-up lazyload" data-src="' +
                    e.image +
                    '"src="' +
                    e.image +
                    '" alt="' +
                    e.name +
                    '" title="' +
                    e.name +
                    '" width="120" height="170" />' +
                    '</a><div class="product-details"><a class="product-title" wire:navigate href="' +
                    appUrl +
                    "products/" +
                    e.slug +
                    '">' +
                    e.name +
                    "</a>" +
                    '<div class="variant-cart my-2">' +
                    (e.product_type === "regular"
                        ? e.brand_name
                        : e.product_type) +
                    "</div>" +
                    '<div class="priceRow"><div class="product-price">' +
                    currency_symbol +
                    '<span class="price price-' +
                    e.product_variant_id +
                    '">' +
                    e.final_price +
                    '</span></div></div></div><div class="qtyDetail text-end cart-qtyDetail">' +
                    '<div class="qtyField"><a class="qtyBtn minus" href="#;"><ion-icon name="remove-outline"></ion-icon></a>' +
                    '<input type="number" name="quantity" data-variant-id="' +
                    e.product_variant_id +
                    '" value="' +
                    e.qty +
                    '" max="' +
                    (e.max == 0 ? "Infinity" : e.max) +
                    '" min="' +
                    e.min +
                    '" step="' +
                    e.step +
                    '" data-variant-price="' +
                    e.variant_price +
                    '" class="qty">' +
                    '<a class="qtyBtn plus" href="#;"><ion-icon name="add-outline"></ion-icon></a></div>' +
                    '<a class="remove_from_cart remove pointer" data-variant-id="' +
                    e.product_variant_id +
                    '"><ion-icon class="icon" data-bs-toggle="tooltip" data-bs-placement="top" name="close-outline"></ion-icon></a></div> </li>';
            }
        });
        $(".cart-count").text(cart_count);
        $(".cart_count").text(cart_count);
        if (cart_count != 0) {
            display += `</ul></div>`;
            display += `<div class="minicart-bottom"><div class="subtotal clearfix my-3"><div class="totalInfo clearfix"><span>Total:</span><span class="item product-price sub-total">${currency_symbol}${total}</span></div></div><div class="agree-check customCheckbox"><input id="prTearm" name="tearm" type="checkbox" value="tearm" required /><label for="prTearm"> I agree with the </label><a wire:navigate href="${appUrl}term-and-conditions" class="ms-1 text-link">Terms &amp; conditions</a></div><div class="minicart-action d-flex mt-3"><button class="cart-checkout proceed-to-checkout btn btn-primary w-50 me-1 disabled">Check Out</button> <button class="cart-checkout cart-btn btn btn-secondary w-50 ms-1 disabled">View Cart</button></div></div></div>`;
        } else {
            display +=
                `<div id="display_cart"><div class="cartEmpty-content mt-4"><ion-icon name="cart-outline" class="icon text-muted fs-1"></ion-icon><p class="my-3">No Products in the Cart</p><a wire:navigate href="` +
                appUrl +
                "products" +
                `" class="btn btn-primary">Continue shopping</a></div></div>`;
        }
    } else {
        display +=
            `<div id="display_cart"><div class="cartEmpty-content mt-4"><ion-icon name="cart-outline" class="icon text-muted fs-1"></ion-icon><p class="my-3">No Products in the Cart</p><a wire:navigate href="` +
            appUrl +
            "products" +
            `" class="btn btn-primary">Continue shopping</a></div></div>`;
    }
    $("#display_cart").html(display);
}

function initListner(event, selector, callback) {
    $(document).off(event, selector);
    $(document).on(event, selector, callback);
}

function bindVerticalCategoryMenu() {
    $(".header-vertical-menu .menu-title").off("click");

    initListner("click", ".header-vertical-menu .menu-title", function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        const $menu = $(this).closest(".header-vertical-menu");
        const $content = $menu.find(".vertical-menu-content").first();

        $content.stop(true, true).slideToggle(300);
        $(this).toggleClass("active");
    });
}

function add_cart() {
    initListner("click", ".add_cart", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        let t = $(this);

        // Re-entry guard: after wire:navigate the delegated handler can fire twice if
        // the morph re-injects an inline script that re-binds — the lock makes the
        // second invocation a no-op until the AJAX/localStorage write completes.
        if (t.data("addCartBusy")) {
            return;
        }
        t.data("addCartBusy", true);
        let releaseLock = function () {
            setTimeout(function () { t.data("addCartBusy", false); }, 600);
        };

        let variant_id = t.attr("data-product-variant-id");

        if (!variant_id) {
            iziToast.error({
                message: "Please Select Variant",
                position: "topRight",
            });
            releaseLock();
            return;
        }
        let qty = t
            .closest("#stickycart-form, .product-action")
            .find(".qty")
            .val();
        let product_type = t.attr("data-product-type");
        if (product_type == undefined || product_type == null) {
            product_type = "regular";
        }
        let variant_price = t.attr("data-variant-price");
        let min = t.attr("data-min");
        let name = t.attr("data-name");
        let store_id = t.attr("data-store-id");
        let slug = t.attr("data-slug");
        let brand_name = t.attr("data-brand-name");
        let max = t.attr("data-max");
        let step = t.attr("data-step");
        let image = t.attr("data-image");
        let minQty = parseInt(min);
        if (isNaN(minQty) || minQty < 1) {
            minQty = 1;
        }
        if (qty == null || qty == undefined || qty === "" || parseInt(qty) < minQty) {
            qty = minQty;
        }
        if (is_logged == true) {
            $.ajax({
                type: "POST",
                url: appUrl + "cart/add-to-cart",
                data: {
                    product_variant_id: variant_id,
                    qty: qty,
                    is_saved_for_later: false,
                    product_type: product_type,
                },
                dataType: "json",
                success: function (response) {
                    Livewire.dispatch("refreshComponent");
                    if (response.error != true) {
                        iziToast.success({
                            message: response.message,
                            position: "topRight",
                        });
                        $(".cart-count").text(response.cart_count);
                        if (t.hasClass("buy_now")) {
                            Livewire.navigate(appUrl + "cart");
                        }
                        releaseLock();
                        return false;
                    }
                    iziToast.error({
                        message: response.message,
                        position: "topRight",
                    });
                    releaseLock();
                },
                error: function () { releaseLock(); },
            });
            return;
        }
        let cart_items = {
            product_variant_id: variant_id,
            qty: qty,
            product_type: product_type,
            variant_price: variant_price,
            final_price: qty * parseFloat(variant_price),
            name: name,
            slug: slug,
            brand_name: brand_name,
            min: min,
            max: max,
            step: step,
            image: image,
            store_id: store_id,
        };

        let cart = localStorage.getItem("cart");
        cart = localStorage.getItem("cart") != null ? JSON.parse(cart) : null;

        let max_items = parseInt($("#max_items_allowed_in_cart").val()) || 10;

        if (cart != null && cart != undefined) {
            let existingItemIndex = cart.findIndex(
                (item) =>
                    item.product_variant_id === cart_items.product_variant_id
            );
            if (existingItemIndex !== -1) {
                // Product already in cart → increase quantity instead of blocking
                var oldQty = parseInt(cart[existingItemIndex].qty) || 1;
                var maxQty = parseInt(cart[existingItemIndex].max) || 99;
                var newQty = oldQty + parseInt(qty || 1);
                if (newQty > maxQty) newQty = maxQty;
                cart[existingItemIndex].qty = newQty;
                cart[existingItemIndex].final_price = newQty * parseFloat(cart[existingItemIndex].variant_price || 0);
                localStorage.setItem("cart", JSON.stringify(cart));
                display_cart(cart);
                iziToast.info({
                    message: "Quantité mise à jour dans le panier",
                    position: "topRight",
                });
                releaseLock();
                return;
            } else {
                if (cart.length >= max_items) {
                    iziToast.warning({
                        message: "Maximum " + max_items + " article(s) autorisé(s) !",
                        position: "topRight",
                    });
                    releaseLock();
                    return false;
                }
                cart.push(cart_items);
            }
        } else {
            if (1 > max_items) {
                iziToast.error({
                    message: "Maximum " + max_items + " Item(s) Can Be Added Only!",
                    position: "topRight",
                });
                releaseLock();
                return false;
            }
            cart = [cart_items];
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        display_cart(cart);
                iziToast.success({
                    message: "Produit ajouté au panier avec succès",
                    position: "topRight",
                });
        releaseLock();
        return;
    });
}

function initialize() {
    product_zoom();
    bootTab_init();
    bootstrap_table_initialize();
    add_cart();
}
function bootstrap_table_initialize() {
    $("#user_wallet_transactions").bootstrapTable({
        formatLoadingMessage: function () {
            return '<i class="fa fa-spinner fa-spin fa-fw"></i>';
        },
    });
    $("#wallet_withdrawal_request").bootstrapTable({
        formatLoadingMessage: function () {
            return '<i class="fa fa-spinner fa-spin fa-fw"></i>';
        },
    });
    $("#user_transactions").bootstrapTable({
        formatLoadingMessage: function () {
            return '<i class="fa fa-spinner fa-spin fa-fw"></i>';
        },
    });
    $("#natifications_table").bootstrapTable({
        formatLoadingMessage: function () {
            return '<i class="fa fa-spinner fa-spin fa-fw"></i>';
        },
    });
}
// Debounce gate shared across every qtyBtn click, regardless of how many
// times qnt_incre() is called or how many delegated handlers exist on
// document. The .qty input gets an 'updating' class while AJAX is in
// flight (see below), but that flag is per-input — if a stray duplicate
// handler fires synchronously on the same event, the second invocation
// can read & set state before the first AJAX returns. This timestamp
// gate is global, evaluated SYNCHRONOUSLY on every click, and drops
// anything that arrives within 250ms of the previous accepted click.
window._lastQtyBtnClickTs = window._lastQtyBtnClickTs || 0;
function qnt_incre() {
    $(document).off("click.qtyBtn", ".qtyBtn").on("click.qtyBtn", ".qtyBtn", function (e) {
        var now = Date.now();
        if (now - window._lastQtyBtnClickTs < 250) {
            if (e && typeof e.stopImmediatePropagation === "function") {
                e.stopImmediatePropagation();
            }
            return;
        }
        window._lastQtyBtnClickTs = now;
        let qtyField = $(this).closest(".qtyField"),
            inputField = qtyField.find(".qty");
        if (inputField.hasClass('updating')) return;
        inputField.addClass('updating');
        let oldValue = parseInt(inputField.val()),
            maxVal = parseInt(inputField.attr("max")),
            minVal = parseInt(inputField.attr("min")),
            stepSize = parseInt(inputField.attr("step")),
            newVal;
        // Default step to 1 when admin hasn't set quantity_step_size on the
        // product (DB value is null/0/empty → parseInt yields NaN/0). Without
        // this, oldValue + NaN produces unstable jumps like +3 / +4 and
        // oldValue + 0 makes the buttons silently no-op.
        if (!stepSize || isNaN(stepSize) || stepSize < 1) {
            stepSize = 1;
        }
        if (isNaN(oldValue)) { oldValue = isNaN(minVal) ? 1 : minVal; }
        if ($(this).is(".plus")) {
            newVal = oldValue + stepSize;
            newVal = newVal > maxVal ? maxVal : newVal;
            if (newVal == maxVal) {
                iziToast.error({
                    message:
                        "The Maximum allowable quantity is " +
                        (maxVal == 0 ? 1 : maxVal),
                    position: "topRight",
                });
            }
        } else if ($(this).is(".minus")) {
            newVal = oldValue - stepSize;
            newVal = newVal < minVal ? minVal : newVal;
            if (minVal > 1) {
                if (newVal == minVal) {
                    iziToast.error({
                        message: "The minimum allowable quantity is " + minVal,
                        position: "topRight",
                    });
                }
            }
        }

        inputField.val(newVal);
        if (inputField.hasClass("dlt-qty")) {
            $(".dlt-qty").val(newVal);
        }
        updateCartQty(inputField);
    });
    function updateCartQty(input) {
        let variant_id = input.data("variant-id");
        let variant_price = input.data("variant-price");
        let product_type = input.data("product-type");
        if (product_type == undefined || product_type == null) {
            product_type = "regular";
        }
        let newVal = parseInt(input.val());
        let final_price = input.val() * parseFloat(variant_price);
        let total = 0;
        let currency_symbol = $("#currency").val();
        if (is_logged == false) {
            let cart = localStorage.getItem("cart");
            cart = localStorage.getItem("cart") != null ? JSON.parse(cart) : null;
            if (cart != null && cart != undefined) {
                let existingItemIndex = cart.findIndex(
                    (item) => item.product_variant_id == variant_id
                );
                if (existingItemIndex !== -1) {
                    cart[existingItemIndex].qty = input.val();
                    cart[existingItemIndex].final_price = final_price;
                    $(".price-" + variant_id).html(final_price);
                }
                localStorage.setItem("cart", JSON.stringify(cart));
                cart.forEach((e) => {
                    total += parseFloat(e.final_price);
                    $(".sub-total").html(currency_symbol + total);
                });
            }
            input.removeClass('updating');
            return;
        }
        let qty = input.val();
        if (variant_id) {
            $.ajax({
                type: "POST",
                url: appUrl + "cart/manage-cart",
                data: {
                    variant_id: variant_id,
                    qty: qty,
                    is_saved_for_later: 0,
                    address_id: 0,
                    product_type,
                },
                dataType: "json",
                success: function (response) {
                    input.removeClass('updating');
                    Livewire.dispatch("refreshComponent");
                },
                error: function () {
                    input.removeClass('updating');
                }
            });
        } else {
            input.removeClass('updating');
        }
    }
    //Qty Counter
    $(document).off("change.qtyInput", "input.qty").on("change.qtyInput", "input.qty", function (e) {
        e.preventDefault();
        let input = $(this);
        if (input.hasClass('updating')) return;
        input.addClass('updating');
        let variant_id = $(this).data("variant-id");
        let variant_price = $(this).data("variant-price");
        let product_type = $(this).data("product-type");
        if (product_type == undefined || product_type == null) {
            product_type = "regular";
        }
        let maxVal = parseInt(input.attr("max"));
        let minVal = parseInt(input.attr("min"));
        let newVal = parseInt(input.val());
        let final_price = input.val() * parseFloat(variant_price);
        let total = 0;
        let currency_symbol = $("#currency").val();
        if (newVal > maxVal) {
            input.val(maxVal);
        } else if (newVal < minVal) {
            input.val(minVal);
        }
        if (is_logged == false) {
            let cart = localStorage.getItem("cart");
            cart =
                localStorage.getItem("cart") != null ? JSON.parse(cart) : null;

            if (cart != null && cart != undefined) {
                let existingItemIndex = cart.findIndex(
                    (item) => item.product_variant_id == variant_id
                );
                if (existingItemIndex !== -1) {
                    cart[existingItemIndex].qty = input.val();
                    cart[existingItemIndex].final_price = final_price;
                    $(".price-" + variant_id).html(final_price);
                }
                localStorage.setItem("cart", JSON.stringify(cart));
                cart.forEach((e) => {
                    total += parseFloat(e.final_price);
                    $(".sub-total").html(currency_symbol + total);
                });
            }
            input.removeClass('updating');
            return;
        }
        let qty = input.val();
        if (variant_id) {
            $.ajax({
                type: "POST",
                url: appUrl + "cart/manage-cart",
                data: {
                    variant_id: variant_id,
                    qty: qty,
                    is_saved_for_later: 0,
                    address_id: 0,
                    product_type,
                },
                dataType: "json",
                success: function (response) {
                    input.removeClass('updating');
                    Livewire.dispatch("refreshComponent");
                },
                error: function () {
                    input.removeClass('updating');
                }
            });
        }
    });
}
qnt_incre();
// Star rating destroy on navigate. The full offcanvas/modal teardown lives in
// app.blade.php (window._resetAllOffcanvases) and runs on both
// livewire:navigating and livewire:navigated — duplicating it here just opens
// races between the two handlers, so this listener is now scoped to ratings.
document.addEventListener("livewire:navigating", () => {
    if ($.fn && $.fn.rating) {
        try { $(".kv-ltr-theme-svg-star").rating("destroy"); } catch (e) {}
    }
});

function cleanupOffcanvasBackdrops() {
    if (typeof window._resetAllOffcanvases === "function") {
        window._resetAllOffcanvases();
        return;
    }
    document
        .querySelectorAll(".offcanvas-backdrop")
        .forEach((el) => el.remove());
    if (!document.querySelector(".offcanvas.show, .modal.show")) {
        document.body.classList.remove("offcanvas-open", "modal-open");
        document.body.style.overflow = "";
        document.body.style.paddingRight = "";
    }
}

$(document).on("hidden.bs.offcanvas", function (e) {
    cleanupOffcanvasBackdrops();
});

// Take over offcanvas open clicks in the CAPTURE phase. Bootstrap's own
// bubble-phase `[data-bs-toggle="offcanvas"]` delegate is also on `document`;
// both fire for the same click and bubble-phase stopPropagation can't stop
// sibling handlers on the same node. Capture phase + stopImmediatePropagation
// guarantees only OUR handler runs, so we control the entire show() flow.
//
// Every click does a hard reset of the target before show(): dispose any stale
// instance, scrub leftover .show/.showing/.hiding/aria/visibility, and remove
// orphan backdrops. wire:ignore.self preserves the drawer element across
// Livewire navigation, so without this scrub the next show() can inherit
// post-morph stale state and flicker / fail to open.
if (!window._offcanvasOpenBound) {
    window._offcanvasOpenBound = true;
    document.addEventListener(
        "click",
        function (e) {
            var toggle = e.target && e.target.closest
                ? e.target.closest('[data-bs-toggle="offcanvas"]')
                : null;
            if (!toggle) return;
            if (typeof bootstrap === "undefined" || !bootstrap.Offcanvas) return;
            var selector = toggle.getAttribute("data-bs-target") || toggle.getAttribute("href");
            if (!selector || selector === "#") return;
            // Re-query the target every click — the element gets replaced by
            // _freshenContainer on each open, so any cached reference is stale.
            var target = document.querySelector(selector);
            if (!target) return;
            e.preventDefault();
            e.stopImmediatePropagation();

            var existing = bootstrap.Offcanvas.getInstance(target);
            var isOpen = !!existing &&
                (target.classList.contains("show") || target.classList.contains("showing"));

            if (isOpen) {
                existing.hide();
                return;
            }

            // Open path. Freshen on EVERY click — that guarantees a clean
            // Bootstrap context regardless of any zombie state left over from
            // navigation, transitions, or morph quirks. The freshen helper
            // (defined in app.blade.php) creates a new DOM node with the same
            // attributes (minus stale .show classes / aria-modal / role) and
            // transfers children so Livewire/Alpine bindings on them survive.
            if (existing) {
                try { existing.dispose(); } catch (err) {}
            }
            // Also drop any orphan backdrops + body lock left over from a
            // previous show that was interrupted by navigation.
            document
                .querySelectorAll(".offcanvas-backdrop")
                .forEach(function (b) { b.remove(); });
            document.body.classList.remove("offcanvas-open", "modal-open");
            document.body.style.overflow = "";
            document.body.style.paddingRight = "";

            if (typeof window._freshenContainer === "function") {
                target = window._freshenContainer(target);
            } else {
                // Inline fallback when _freshenContainer is not provided by
                // the layout. Bootstrap's hide() queues a setTimeout that
                // sets style.visibility:'hidden' AFTER the close transition.
                // dispose() runs synchronously and does not cancel that
                // timeout — so on the next open the element still has stale
                // visibility:hidden / aria-modal / role from the previous
                // cycle, and show() adds .show but the drawer never appears.
                // Scrub those before show() so getOrCreateInstance starts
                // from a clean slate.
                target.style.visibility = "";
                target.style.display = "";
                target.classList.remove("show", "showing", "hiding");
                target.removeAttribute("aria-modal");
                target.removeAttribute("role");
                target.removeAttribute("aria-hidden");
            }
            bootstrap.Offcanvas.getOrCreateInstance(target).show();
        },
        true
    );
}
let isEventAttached = false;
let custom_url = "";
let current_url = "";
let store_slug = "";
document.addEventListener("livewire:navigated", () => {
    // URL/store state must refresh on EVERY navigation so filter handlers
    // (which close over these variables) build URLs from the current page.
    $(".loading-state").addClass("d-none");
    bindVerticalCategoryMenu();
    const browserUrl = new URL(window.location.href);
    store_slug =
        browserUrl.searchParams.get("store") || $("#store_slug").val();
    let current_store_id = $("#current_store_id").val();
    if (store_slug == null || store_slug == "" || store_slug == undefined) {
        store_slug = $("#default_store_slug").val();
    }
    custom_url = browserUrl.toString();
    current_url = browserUrl.origin + browserUrl.pathname;
    $("#custom_url").val(custom_url);
    $("#current_url").val(current_url);
    $("#store_slug").val(store_slug);

    if (isEventAttached) return;

    let primaryColor = $("#store-primary-color").val();
    let secondaryColor = $("#store-secondary-color").val();
    let linkActiveColor = $("#store-link-active-color").val();
    let linkHoverColor = $("#store-link-hover-color").val();
    const root = document.documentElement;
    // Set the CSS variables
    root.style.setProperty("--primary-color", primaryColor);
    root.style.setProperty("--secondary-color", secondaryColor);
    root.style.setProperty("--link-active-color", linkActiveColor);
    root.style.setProperty("--link-hover-color", linkHoverColor);

    $(".slider-link").on("click", function (e) {
        let link = $(this).data("link");
        let url = setUrlParameter(link, "store", store_slug);
        Livewire.navigate(url);
    });

    var currency_symbol = $("#currency").val();

    $(".changeLang").on("click", function () {
        let lang = $(this).data("lang-code");
        Livewire.dispatch("changeLang", { lang });
    });
    $(".changeCurrency").on("click", function () {
        let currency = $(this).data("currency-code");
        Livewire.dispatch("changeCurrency", { currency });
    });
    if ($("#user_id").val() >= 1) {
        is_logged = true;
    } else {
        is_logged = false;
    }

    $(document).on("change", "#prTearm", function () {
        if (!$(this).prop("checked")) {
            $(".cart-checkout").addClass("disabled");
        } else {
            $(".cart-checkout").removeClass("disabled");
        }
    });

    function proceedToCheckoutHandler() {
        if (is_logged == false) {
            iziToast.destroy();
            iziToast.error({
                message: "Please Login First",
                position: "topRight",
            });
            setTimeout(() => {
                let url = setUrlParameter(
                    appUrl + "/login",
                    "store",
                    store_slug
                );
                Livewire.navigate(url);
            }, 1500);
            return false;
        }
        let url = setUrlParameter(
            appUrl + "cart/checkout",
            "store",
            store_slug
        );
        Livewire.navigate(url);
        return false;
    }

    $(document)
        .off("click", ".proceed-to-checkout")
        .on("click", ".proceed-to-checkout", proceedToCheckoutHandler);

    function cartBtnHandler() {
        if (is_logged == false) {
            iziToast.destroy();
            iziToast.error({
                message: "Please Login First",
                position: "topRight",
            });
            setTimeout(() => {
                let url = setUrlParameter(
                    appUrl + "/login",
                    "store",
                    store_slug
                );
                Livewire.navigate(url);
            }, 1500);
            return false;
        }
        let url = setUrlParameter(appUrl + "cart/", "store", store_slug);
        Livewire.navigate(url);
        return false;
    }

    $(document)
        .off("click", ".cart-btn")
        .on("click", ".cart-btn", cartBtnHandler);
    Shareon.init();

    // function product_image_swap() {
    //     $(".swatchLbl").on("click", function () {
    //         alert('here1324');
    //         $(this).parent().siblings(".active").removeClass("active");
    //         $(this).parent().addClass("active");
    //     });
    // }
    // product_image_swap();

    function product_image_swap() {
        $(".swatchLbl").on("click", function () {
            // Handle the active class toggle
            $(this).parent().siblings(".active").removeClass("active");
            $(this).parent().addClass("active");

            // Get new image from the selected variant
            var newImage = $(this).attr("data-image");
            // console.log(newImage);
            var newZoomImage = $(this).attr("data-zoom-image");

            // Update the main product image
            if (newImage && newZoomImage) {
                $("#zoompro").attr("src", newImage);
                $("#zoompro").attr("data-zoom-image", newZoomImage);
            }
        });
    }

    product_image_swap();

    if (is_logged == false) {
        //display local cart
        let cart = localStorage.getItem("cart");
        cart = localStorage.getItem("cart") != null ? JSON.parse(cart) : [];
        display_cart(cart);

        // remove from local storage cart
        $(document).on("click", ".remove_from_cart", function () {
            let product_variant_id = $(this).data("variant-id");
            let cart = localStorage.getItem("cart");
            cart = localStorage.getItem("cart") != null ? JSON.parse(cart) : [];
            let item_to_delete = cart.findIndex(
                (item) => item.product_variant_id == product_variant_id
            );
            if (item_to_delete !== -1) {
                cart.splice(item_to_delete, 1);
            }
            localStorage.setItem("cart", JSON.stringify(cart));
            let cart_count = cart.length;
            $(".cart-count").text(cart_count);
            $(".cart_count").text(cart_count);
            display_cart(cart);
        });
    }
    //remove from cart
    window.addEventListener("remove_from_cart", (e) => {
        let variant_id = e.detail.data.variant_id;
        let store_id = e.detail.data.store_id;
        let user_id = e.detail.data.user_id;
        let product_type = e.detail.data.product_type;
        let cart_count = e.detail.data.cart_count;
        $.ajax({
            type: "POST",
            url: appUrl + "cart/remove-from-cart",
            data: {
                user_id: user_id,
                product_variant_id: variant_id,
                product_type: product_type,
                store_id: store_id,
            },
            success: function (response) {
                if (response.error == false) {
                    iziToast.success({
                        message: response.message,
                        position: "topRight",
                    });
                    if (response.data.length >= 1) {
                        cart_count = response.data.cart_items.length;
                    } else {
                        cart_count = "0";
                    }
                    $(".cart-count").text(cart_count);
                    let data = {
                        variant_id: variant_id,
                        product_type: product_type,
                    };
                    Livewire.dispatch("refreshComponent");
                    return;
                }
                iziToast.error({
                    message: response.message,
                    position: "topRight",
                });
            },
        });
    });
    // add to favorite

    // $(".add-favorite").on("click", function () {
    //     let product_id = $(this).data("product-id");
    //     let product_type = $(this).data("product-type");
    //     if (product_type == undefined || product_type == null) {
    //         product_type = "regular";
    //     }
    //     let user_id = $("#user_id").val();
    //     let t = $(this);
    //     if (user_id == null || user_id == "") {
    //         iziToast.error({
    //             message: "Please Login First",
    //             position: "topRight",
    //         });
    //         return;
    //     }
    //     $.ajax({
    //         url: appUrl + "product/add-to-favorite",
    //         method: "POST",
    //         data: {
    //             product_id,
    //             user_id,
    //             product_type,
    //         },
    //         dataType: "json",
    //         success: function (response) {
    //             if (response.error == false) {
    //                 if (t.hasClass("card_fav_btn")) {
    //                     t.addClass("remove-favorite")
    //                         .removeClass("add-favorite")
    //                         .children("ion-icon")
    //                         .attr("name", "heart")
    //                         .addClass("text-danger");
    //                 } else {
    //                     $(".add-favorite")
    //                         .removeClass("d-flex")
    //                         .addClass("d-none");
    //                     $(".remove-favorite")
    //                         .removeClass("d-none")
    //                         .addClass("d-flex");
    //                 }
    //                 $(".wishlist-count").text(response["wishlist_count"]);
    //                 iziToast.success({
    //                     message:
    //                         "An item has been successfully added to your wishlist.",
    //                     position: "topRight",
    //                 });
    //             }
    //         },
    //     });
    // });

    $(document).on("click", ".add-favorite", function (e) {
        e.preventDefault();

        let product_id = $(this).data("product-id");
        let product_type = $(this).data("product-type") || "regular";
        let user_id = $("#user_id").val();
        let t = $(this);

        if (t.data("isProcessing")) {
            return;
        }

        if (!user_id) {
            iziToast.destroy();
            iziToast.error({
                message: "Please Login First",
                position: "topRight",
            });
            return;
        }

        t.data("isProcessing", true);

        $.ajax({
            url: appUrl + "product/add-to-favorite",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { product_id, user_id, product_type },
            dataType: "json",
            success: function (response) {
                if (!response.error) {
                    if (t.hasClass("card_fav_btn")) {
                        t.removeClass("add-favorite").addClass("remove-favorite");
                        t.children("i")
                            .removeClass("anm-heart-l")
                            .addClass("anm-heart text-danger");
                        t.attr("title", "Remove From Wishlist")
                            .tooltip("dispose")
                            .tooltip();
                    } else {
                        t.addClass("d-none").removeClass("d-flex");
                        t.siblings(".remove-favorite").removeClass("d-none").addClass("d-flex");
                    }

                    $(".wishlist-count").text(response["wishlist_count"]);

                    iziToast.success({
                        message: "Item added to wishlist successfully.",
                        position: "topRight",
                    });
                }
            },
            complete: function () {
                t.data("isProcessing", false);
            },
            error: function () {
                t.data("isProcessing", false);
            },
        });
    });

    // remove from favorite

    $(document).on("click", ".remove-favorite", function (e) {
        e.preventDefault();

        let productId = $(this).attr("data-product-id");
        let productType = $(this).attr("data-product-type") || "regular";
        let user_id = $("#user_id").val();
        let t = $(this);

        if (t.data("isProcessing")) {
            return;
        }

        t.data("isProcessing", true);

        Swal.fire({
            title: "Do you Really want to Remove This from Wishlist?",
            showCancelButton: true,
            confirmButtonText: "Yes Remove",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: appUrl + "product/remove-from-favorite",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { productId, user_id, productType },
                    dataType: "json",
                    success: function (response) {
                        if (!response.error) {
                            if (t.hasClass("card_fav_btn")) {
                                t.addClass("add-favorite")
                                    .removeClass("remove-favorite")
                                    .children("i")
                                    .removeClass("anm-heart text-danger")
                                    .addClass("anm-heart-l");
                            } else {
                                t.addClass("d-none").removeClass("d-flex");
                                t.siblings(".add-favorite").removeClass("d-none").addClass("d-flex");
                            }

                            $(".wishlist-count").text(response["wishlist_count"]);
                            $(".favorite_count").text(response["wishlist_count"] + " items");
                            Livewire.dispatch("refreshComponent");

                            iziToast.success({
                                message:
                                    "The item has been removed from your wishlist.",
                                position: "topRight",
                            });
                        }
                    },
                    complete: function () {
                        t.data("isProcessing", false);
                    },
                    error: function () {
                        t.data("isProcessing", false);
                    },
                });
            } else {
                t.data("isProcessing", false);
            }
        });
    });

    window.addEventListener("quickview", (event) => {
        setTimeout(() => {
            var $stars = $(".kv-ltr-theme-svg-star");
            if ($stars.length > 0) {
                $stars.each(function () {
                    var $input = $(this);
                    $input.prevAll(".rating-container").remove();
                    $.removeData(this, "rating");
                    $input
                        .removeClass("rating rating-input")
                        .addClass("rating-loading");
                });
                $stars.rating({
                    hoverOnClear: false,
                    theme: "krajee-svg",
                });
            }
            attributes();
            add_cart();
            Shareon.init();
        }, 1000);
    });

    // Compare list helpers + click handler are bound exactly once at module
    // load (see the IIFE near the top of this file, after the `appUrl` setup).
    // Re-binding inside this livewire:navigated listener — even with
    // .off("click.compareAdd", ".add-compare") — was leaving stacked handlers
    // in practice, so a single click was firing the AJAX request and toast
    // 2–3 times after navigating between pages.

    $(".star-rating").on("rating:change", function (event, value, caption) {
        Livewire.dispatch("updateRating", { update_rating: value });
    });

    function attributes() {
        $(".attributes").on("change", function (e) {
            e.preventDefault();
            let prices = [];
            let variant_ids = [];
            let variant_prices = [];
            let variant = [];
            let variants = [];
            let attributes_length = [];
            let selected_attributes = [];
            let is_variant_available = false;
            let price = "";
            $(".variants").each(function () {
                prices = {
                    price: $(this).data("price"),
                    spacial_price: $(this).data("special_price"),
                };
                variant_ids.push($(this).data("id"));
                variant_prices.push(prices);
                variant = $(this).val().split(",");
                variants.push(variant);
            });
            attributes_length = variant.length;
            $(this).parent().siblings().children().prop("checked", false);
            $(".attributes").each(function (i, e) {
                if ($(this).prop("checked")) {
                    selected_attributes.push($(this).val());
                    var selected_variant_id = "";
                    if (selected_attributes.length == attributes_length) {
                        prices = [];
                        var selected_variant_id = "";
                        $.each(variants, function (i, e) {
                            if (arrays_equal(selected_attributes, e)) {
                                is_variant_available = true;
                                prices.push(variant_prices[i]);
                                selected_variant_id = variant_ids[i];
                            }
                        });
                        if (is_variant_available) {
                            $("#add_cart").attr(
                                "data-product-variant-id",
                                selected_variant_id
                            );
                            $(".modal_add_cart").attr(
                                "data-product-variant-id",
                                selected_variant_id
                            );
                            $(".dlt-add-cart").attr(
                                "data-product-variant-id",
                                selected_variant_id
                            );
                            if (
                                prices[0].spacial_price < prices[0].price &&
                                prices[0].spacial_price != 0
                            ) {
                                price = parseFloat(prices[0].spacial_price);
                                $(".add_cart").attr(
                                    "data-variant-price",
                                    prices[0].spacial_price
                                );
                                $(".product_price").html(
                                    currency_symbol + price.toFixed(2)
                                );
                            } else {
                                price = parseFloat(prices[0].price);
                                $(".add_cart").attr(
                                    "data-variant-price",
                                    prices[0].price
                                );
                                $(".product_price").html(
                                    currency_symbol + price.toFixed(2)
                                );
                            }
                            $(".add_cart").removeAttr("disabled");
                        } else {
                            price = "No variant Available!";
                            $(".product_price").html(price);
                            $(".add_cart").attr("disabled", "true");
                        }
                    }
                }
            });
        });
    }
    attributes();

    initialize();
    // Star rating init is handled by the dedicated livewire:navigated
    // listener below — running it here too caused duplicate containers.

    function goBack() {
        parent.history.back();
    }
    function cart_sync() {
        let cart = localStorage.getItem("cart");
        cart = localStorage.getItem("cart") != null ? JSON.parse(cart) : "";
        if (cart != "" && cart != undefined) {
            let product_variant_id = [];
            let qty = [];
            let product_type = [];
            let store_id = [];
            cart.forEach((e) => {
                product_variant_id.push(e.product_variant_id);
                qty.push(e.qty);
                product_type.push(e.product_type);
                store_id.push(e.store_id);
            });
            $.ajax({
                type: "POST",
                url: appUrl + "cart/cart-sync",
                data: {
                    product_variant_id: product_variant_id,
                    qty: qty,
                    product_type: product_type,
                    store_id: store_id,
                    is_saved_for_later: false,
                },
                dataType: "json",
                success: function (response) {
                    if (response.error == false) {
                        Livewire.dispatch("refreshComponent");
                        $(".cart-count").text(response.cart_count);
                        localStorage.removeItem("cart");
                        iziToast.success({
                            message: response.message,
                            position: "topRight",
                        });
                        return;
                    }
                    localStorage.removeItem("cart");
                    iziToast.error({
                        message: response.message,
                        position: "topRight",
                    });
                    return;
                },
            });
            return;
        }
        return;
    }
    if (is_logged == true) {
        cart_sync();
    }

    initListner("click", ".select-store", function (e) {
        e.preventDefault();
        let store_id = $(this).data("store-id");
        let store_name = $(this).data("store-name");
        let store_image = $(this).data("store-image");
        let store_slug = $(this).data("store-slug");

        if (!store_id || !store_slug) {
            iziToast.error({
                message: "Unable to switch store",
                position: "topRight",
            });
            return;
        }

        const currentStoreId = $("#current_store_id").val();
        const urlStoreSlug = new URL(window.location.href).searchParams.get("store");

        if (currentStoreId && currentStoreId == store_id && urlStoreSlug == store_slug) {
            return;
        }

        $("#current_store_id").val(store_id);
        $("#store_slug").val(store_slug);
        $(".select-store").removeClass("store-active");
        $('.select-store[data-store-id="' + store_id + '"]').addClass("store-active");

        const targetUrl = new URL(window.location.href);
        targetUrl.searchParams.set("store", store_slug);
        Livewire.navigate(targetUrl.toString());
    });

    $(document).on("click", ".store-show", function () {
        $(".stores-main").addClass("sticky-stores-active");
        $(".store-show")
            .children("ion-icon")
            .attr("name", "chevron-forward-outline");
        $(this).removeClass("store-show");
        $(this).addClass("store-hide");
    });

    $(document).on("click", ".store-hide", function () {
        $(".stores-main").removeClass("sticky-stores-active");
        $(".store-hide")
            .children("ion-icon")
            .attr("name", "chevron-back-outline");
        $(this).removeClass("store-hide");
        $(this).addClass("store-show");
    });

    function setUrlParameter(url, paramName, paramValue) {
        paramName = paramName.replace(/\s+/g, "-");
        if (paramValue == null || paramValue == "") {
            return url
                .replace(
                    new RegExp("[?&]" + paramName + "=[^&#]*(#.*)?$"),
                    "$1"
                )
                .replace(new RegExp("([?&])" + paramName + "=[^&]*&"), "$1");
        }
        var pattern = new RegExp("\\b(" + paramName + "=).*?(&|#|$)");
        if (url.search(pattern) >= 0) {
            return url.replace(pattern, "$1" + paramValue + "$2");
        }
        url = url.replace(/[?#]$/, "");
        return (
            url +
            (url.indexOf("?") > 0 ? "&" : "?") +
            paramName +
            "=" +
            paramValue
        );
    }

    $(document).on("change", "#SortBy", function (e) {
        e.preventDefault();
        var sort = $(this).val();
        let link = setUrlParameter(location.href, "sort", sort);
        Livewire.navigate(link);
    });
    $(document).on("click", ".list_view", function (e) {
        e.preventDefault();
        var list_view = $(this).data("value");
        let link = setUrlParameter(location.href, "mode", list_view);
        Livewire.navigate(link);
    });

    $(document).on("change", "#perPage", function (e) {
        e.preventDefault();
        var perPage = $(this).val();
        let link = setUrlParameter(location.href, "perPage", perPage);
        Livewire.navigate(link);
    });

    $(document).on("click", ".bySearch", function (e) {
        e.preventDefault();
        let search = $(".search_text").val();
        let search_text = search.split(" ").join("_");
        let link = setUrlParameter(appUrl + "products/", "search", search_text);
        if (search != "") {
            Livewire.navigate(link);
        }
    });
    $(document).on("click", ".quick-view-modal", function (e) {
        e.preventDefault();
        let product_id = $(this).data("product-id");
        let product_type = $(this).data("product-type");
        if (product_type == undefined || product_type == null) {
            product_type = "regular";
        }
        if (product_id != null && product_id != undefined) {
            // Reset the qty input BEFORE dispatching the new product.
            // Livewire/Alpine's morph deliberately preserves user-edited
            // input values across re-renders so form input isn't lost
            // mid-typing. That's the wrong behaviour here: when switching
            // from product A (qty=5) to product B, morph keeps "5" and
            // the next click starts at 6. Wiping the value first means
            // morph has no user-edit to preserve, so the new product's
            // hardcoded value="1" actually takes effect.
            $('#quickview_modal .qty').val(1).removeClass('updating');
            Livewire.dispatch("quick_view", {
                id: product_id,
                product_type: product_type,
            });
        }
    });

    // Delegated bindings — direct bindings to the drawer/modal are lost when
    // we freshen those elements on Livewire navigation (see app.blade.php).
    $(document).off("shown.bs.offcanvas.searchFocus", "#search-drawer")
        .on("shown.bs.offcanvas.searchFocus", "#search-drawer", function () {
            $(".searchInput").trigger("focus");
        });

    $(document).off("hidden.bs.modal.quickview", "#quickview_modal")
        .on("hidden.bs.modal.quickview", "#quickview_modal", function () {
            // Reset qty on modal close as well — covers the path where
            // the user closes the modal first and then opens a different
            // product later (still need a clean slate for the morph).
            $('#quickview_modal .qty').val(1).removeClass('updating');
            Livewire.dispatch("clear_quickview_modal");
        });

    function getUrlParameter(sParam, custom_url = "") {
        sParam = sParam.replace(/\s+/g, "-");
        if (custom_url != "") {
            if (custom_url.indexOf("?") > -1) {
                var sPageURL = custom_url.substring(
                    custom_url.indexOf("?") + 1
                );
            } else {
                return undefined;
            }
        } else {
            var sPageURL = window.location.search.substring(1);
        }

        var sURLVariables = sPageURL.split("&"),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split("=");

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined
                    ? true
                    : decodeURIComponent(sParameterName[1]);
            }
        }
    }

    function buildUrlParameterValue(
        paramName,
        paramValue,
        action,
        custom_url = ""
    ) {
        if (custom_url != "") {
            var param = getUrlParameter(paramName, custom_url);
        } else {
            var param = getUrlParameter(paramName);
        }
        if (action == "add") {
            if (param == undefined) {
                param = paramValue;
            } else {
                param += "|" + paramValue;
            }
            return param;
        } else if (action == "remove") {
            if (param != undefined) {
                param = param.split("|");
                param.splice($.inArray(paramValue, param), 1);
                return param.join("|");
            } else {
                return "";
            }
        }
    }

    $(document).on("change", ".product-filter", function (e) {
        e.preventDefault();
        var attribute_name = $(this).data("attribute");
        attribute_name = "filter-" + attribute_name;
        var get_param = getUrlParameter(attribute_name);
        var current_param_value = $(this).val();
        if (get_param == undefined) {
            get_param = "";
        }
        if (this.checked) {
            var param = buildUrlParameterValue(
                attribute_name,
                current_param_value,
                "add",
                custom_url
            );
        } else {
            var param = buildUrlParameterValue(
                attribute_name,
                current_param_value,
                "remove",
                custom_url
            );
        }
        custom_url = setUrlParameter(custom_url, attribute_name, param);
    });

    initListner("click", ".product-filter-btn", function (e) {
        e.preventDefault();
        Livewire.navigate(custom_url);
    });

    $(document).on("click", ".logout", function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: appUrl + "login/logout",
            data: "",
            dataType: "json",
            success: function (response) {
                iziToast.destroy();
                iziToast.success({
                    message: response.message,
                    position: "topRight",
                });
                location.reload();
                return;
            },
        });
    });
    $(document).on("change", ".brand", function (e) {
        e.preventDefault();
        let t = $(this).val();
        let u = $(this)
            .parent()
            .siblings()
            .children(".brand")
            .prop("checked", false)
            .val();
        var param = buildUrlParameterValue("brand", u, "remove", custom_url);
        custom_url = setUrlParameter(custom_url, "brand", param);
        if (this.checked) {
            var param = buildUrlParameterValue("brand", t, "add", custom_url);
        } else {
            var param = buildUrlParameterValue(
                "brand",
                t,
                "remove",
                custom_url
            );
        }
        custom_url = setUrlParameter(custom_url, "brand", param);
    });

    // price slider
    function price_slider() {
        let min_price = $("#min-price").val();
        let max_price = $("#max-price").val();
        let selected_min_price = $("#selected_min_price").val();
        let selected_max_price = $("#selected_max_price").val();
        $("#slider-range").slider({
            range: true,
            min: parseInt(min_price),
            max: parseInt(max_price),
            values: [selected_min_price, selected_max_price],
            slide: function (event, ui) {
                $("#amount").val(
                    currency_symbol +
                    ui.values[0] +
                    " - " +
                    currency_symbol +
                    ui.values[1]
                );
                $("#min-price").val(ui.values[0]);
                $("#max-price").val(ui.values[1]);
            },
        });
        $("#amount").val(
            currency_symbol +
            $("#slider-range").slider("values", 0) +
            " - " +
            currency_symbol +
            $("#slider-range").slider("values", 1)
        );
    }
    price_slider();

    initListner("click", ".price-filter-btn", function (e) {
        e.preventDefault();
        let min_price = $("#min-price").val();
        let max_price = $("#max-price").val();

        custom_url = setUrlParameter(custom_url, "min_price", min_price);
        custom_url = setUrlParameter(custom_url, "max_price", max_price);
        Livewire.navigate(custom_url);
    });

    initListner("click", ".show_tabs", function () {
        $(".filter-widget .widget-title").each(function () {
            $(this).next().slideUp("300");
            $(this).removeClass("active");
        });
        $(this).addClass("d-none");
        $(".close_tabs").removeClass("d-none");
    });
    initListner("click", ".close_tabs", function () {
        $(".filter-widget .widget-title").each(function () {
            $(this).next().slideDown("300");
            $(this).addClass("active");
        });
        $(this).addClass("d-none");
        $(".show_tabs").removeClass("d-none");
    });
    window.addEventListener("toast_fire", (e) => {
        if (e.detail.data.type == "success") {
            iziToast.success({
                message: e.detail.data.message,
                position: "topRight",
            });
            return;
        }
        iziToast.error({
            message: e.detail.data.message,
            position: "topRight",
        });
    });

    $(document).off("click", ".add_address").on("click", ".add_address", function () {
        let name = $("#name").val();
        $(".add_address").html("Add Address");
        let type = $("#type").val();
        let mobile = $("#mobile").val();
        let alternate_mobile = $("#alternate_mobile").val();
        let address = $("#form_address").val();
        let landmark = $("#landmark").val();
        let city_list = $("#city_list").val();
        let postcode = $("#postcode").val();
        let state = $("#state").val();
        let country = $("#country_list").val();
        let latitude = $("#latitude").val();
        let longitude = $("#longitude").val();
        let address_id = $("#edit_address_id").val();
        $.ajax({
            type: "POST",
            url: appUrl + "addresses/add_address",
            data: {
                name: name,
                type: type,
                mobile: mobile,
                alternate_mobile: alternate_mobile,
                address: address,
                landmark: landmark,
                city: city_list,
                pincode: postcode,
                state: state,
                country: country,
                latitude: latitude,
                longitude: longitude,
                address_id: address_id,
            },
            success: function (response) {
                if (response.error == true) {
                    $.each(response.message, function (key, value) {
                        iziToast.error({
                            message: value[0],
                            position: "topRight",
                        });
                        return false;
                    });
                    return false;
                }
                iziToast.success({
                    message: response.message,
                    position: "topRight",
                });
                Livewire.dispatch("refreshComponent");
                $("#addNewModal").modal("hide");
            },
        });
    });
    $("#addNewModal").on("hidden.bs.modal", function () {
        $("#name").val("");
        $("#type").val("");
        $("#mobile").val("");
        $("#alternate_mobile").val("");
        $("#form_address").val("");
        $("#landmark").val("");
        $("#city_list").val("");
        $("#postcode").val("");
        $("#state").val("");
        $("#country_list").val("");
        $("#latitude").val("");
        $("#longitude").val("");
        $("#edit_address_id").val("");
    });
    $(".edit-address-btn").on("click", function () {
        var addressId = $(this).data("address-id");
        $("#edit_address_id").val(addressId);
        $.ajax({
            url: appUrl + "my-account/addresses/edit_address",
            method: "GET",
            data: { address_id: addressId },
            success: function (response) {
                var country = new Option(response.country, false, false, false);
                $("#country_list").append(country).trigger("change");

                var city = new Option(response.city, false, false, false);
                $("#city_list").append(city).trigger("change");

                $("#name").val(response.name);
                $("#type").val(response.type);
                $("#mobile").val(response.mobile);
                $("#alternate_mobile").val(response.alternate_mobile);
                $("#form_address").val(response.address);
                $("#landmark").val(response.landmark);
                $("#postcode").val(response.pincode);
                $("#state").val(response.state);
                $("#latitude").val(response.latitude);
                $("#longitude").val(response.longitude);
                $(".add_address").html("Update Address");
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });

    $(document).on("click", ".delete_address", function (e) {
        e.preventDefault();
        let address_id = $(this).attr("data-address-id");
        Swal.fire({
            title: "Do you Really want to Remove This Address?",
            showCancelButton: true,
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch("deleteAddress", { address_id });
            }
            iziToast.success({
                message: "Address Deleted Successfully",
                position: "topRight",
            });
        });
    });

    $(".city_list").select2({
        ajax: {
            url: appUrl + "my-account/get_Cities",
            type: "GET",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
        dropdownParent: $(".city_list_div"),
        minimumInputLength: 1,
        placeholder: "Search for City",
    });
    // Call the function for each select element
    initializeSelect2(
        "#country_list",
        "my-account/get_Countries",
        "Search for countries",
        $(".country_list_div")
    );
    initializeSelect2(
        "#edit-country_list",
        "my-account/get_Countries",
        "Search for countries",
        $(".edit-country_list_div")
    );
    initializeSelect2(
        "#city_list",
        "my-account/get_Cities",
        "Search for City",
        $(".city_list_div")
    );
    initializeSelect2(
        "#edit-city_list",
        "my-account/get_Cities",
        "Search for City",
        $(".edit-city_list_div")
    );

    // user wallet transaction table
    let $table = $("#user_wallet_transactions");
    let $refreshButton = $("#tableRefresh");

    $refreshButton.on("click", function () {
        $table.bootstrapTable("refresh");
    });

    let $searchInput = $("#searchInput");

    $searchInput.on("input", function () {
        let searchText = $(this).val();
        $table.bootstrapTable("searchText", searchText);
    });

    $(function () {
        $("#toolbar")
            .find("select")
            .change(function () {
                $table.bootstrapTable("destroy").bootstrapTable({
                    exportDataType: $(this).val(),
                    exportTypes: [
                        "json",
                        "xml",
                        "csv",
                        "txt",
                        "sql",
                        "excel",
                        "pdf",
                    ],
                    columns: [
                        {
                            field: "state",
                            checkbox: true,
                            visible: $(this).val() === "selected",
                        },
                        {
                            field: "id",
                            title: "ID",
                        },
                        {
                            field: "name",
                            title: "Item Name",
                        },
                        {
                            field: "price",
                            title: "Item Price",
                        },
                    ],
                });
            })
            .trigger("change");
    });

    // edit profile
    initListner("submit", "#edit-profile-form", (e) => {
        e.preventDefault();

        let formData = new FormData();
        if ($("#city_list").val() == null) {
            iziToast.error({
                message: "Please Select City",
                position: "topRight",
            });
            return;
        }
        if ($("#country_list").val() == null) {
            iziToast.error({
                message: "Please Select Country",
                position: "topRight",
            });
            return;
        }
        let image = "";
        if ($("#profile_upload").val() != "") {
            image = $("#profile_upload")[0].files[0];
        }
        formData.append("username", $("#edit-username").val());
        formData.append("city", $("#city_list").val());
        formData.append("country", $("#country_list").val());
        formData.append("address", $("#edit-streetaddress").val());
        formData.append("zipcode", $("#edit-zipcode").val());
        formData.append("profile_upload", image);
        $.ajax({
            type: "POST",
            url: appUrl + "my-account/profile_update",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error == false) {
                    Livewire.dispatch("refreshComponent");
                    $("#editProfileModal").modal("hide");
                    iziToast.success({
                        message: response.message,
                        position: "topRight",
                    });
                    return;
                }
                $.each(response.message, function (key, value) {
                    iziToast.error({
                        message: value[0],
                        position: "topRight",
                    });
                    return false;
                });
                return false;
            },
        });
    });

    $(".check-product-deliverability").on("click", function () {
        let product_deliverability_type = $(
            "#product_deliverability_type"
        ).val();
        let product_id = $("#product_id").val();
        let city = $("#city_list").val();
        let pincode = $("#pincode").val();
        let product_type = $("#product_type").val();
        if (product_deliverability_type == "city_wise_deliverability") {
            if (city == undefined || city == null || city == "") {
                iziToast.error({
                    message:
                        "Please Choose City to Verify the Product Deliverability",
                    position: "topRight",
                });
                return;
            }
        } else {
            if (pincode == undefined || pincode == null || pincode == "") {
                iziToast.error({
                    message:
                        "Please Enter Pincode to Verify the Product Deliverability",
                    position: "topRight",
                });
                return;
            }
        }
        $.ajax({
            type: "POST",
            url: appUrl + "check-product-deliverability",
            data: {
                product_id,
                city,
                pincode,
                product_type,
            },
            dataType: "json",
            success: function (response) {
                if (response.error == true) {
                    $.each(response.message, function (key, value) {
                        iziToast.error({
                            message: value[0],
                            position: "topRight",
                        });
                        return false;
                    });
                }
                if (response[0].is_deliverable == false) {
                    $(".deliverability-res")
                        .removeClass("text-success")
                        .addClass("text-danger")
                        .html("Sorry, but the product cannot be delivered.");
                    return false;
                }
                $(".deliverability-res")
                    .removeClass("text-danger")
                    .addClass("text-success")
                    .html(
                        "The product is deliverable, and the delivery charges will be added during checkout."
                    );
                return false;
            },
        });
    });

    $(".AddNewTicket").on("click", function () {
        let ticket_id = $(this).data("ticket-id");
        let user_id = $("#user_id").val();
        $("#ticket_id").val(ticket_id);

        $.ajax({
            type: "post",
            url: appUrl + "my-account/support/get-ticket",
            data: {
                ticket_id,
                user_id,
            },
            success: function (response) {
                if (response.error == false) {
                    $("#ticket_type").val(response.data.ticket_type_id);
                    $("#ticket_email").val(response.data.email);
                    $("#ticket_description").val(response.data.description);
                    $("#ticket_subject").val(response.data.subject);
                    $(".add_ticket_btn").html("Update Ticket");
                    $(".add_new_ticket").html("Update Ticket");
                }
            },
        });
    });
    $("#AddNewTicket").on("hidden.bs.modal", function () {
        $("#ticket_id").val("");
        $("#ticket_type").val("");
        $("#ticket_email").val("");
        $("#ticket_description").val("");
        $("#ticket_subject").val("");
        $(".add_ticket_btn").html("Add");
        $(".add_new_ticket").html("Add Ticket");
    });

    $(".add_ticket_btn").on("click", function () {
        let ticket_type = $("#ticket_type").val();
        let ticket_email = $("#ticket_email").val();
        let ticket_description = $("#ticket_description").val();
        let ticket_subject = $("#ticket_subject").val();
        let ticket_id = $("#ticket_id").val();

        $.ajax({
            type: "post",
            url: appUrl + "my-account/support/add-ticket",
            data: {
                ticket_type,
                ticket_email,
                ticket_description,
                ticket_subject,
                ticket_id,
            },
            success: function (response) {
                if (response.error == false) {
                    Livewire.dispatch("refreshComponent");
                    $("#AddNewTicket").modal("hide");
                    iziToast.success({
                        message: response.message,
                        position: "topRight",
                    });
                    return;
                }
                $.each(response.message, function (key, value) {
                    iziToast.error({
                        message: value[0],
                        position: "topRight",
                    });
                    return false;
                });
                return false;
            },
        });
    });

    // change password
    $(document).on("click", ".change_password", () => {
        let current_password = $("#current_password").val();
        let new_password = $("#new_password").val();
        let verify_password = $("#verify_password").val();

        $.ajax({
            type: "POST",
            url: appUrl + "my-account/change-password",
            data: {
                current_password: current_password,
                new_password: new_password,
                verify_password: verify_password,
            },
            success: function (response) {
                if (response.error == false) {
                    Livewire.dispatch("refreshComponent");
                    $("#editLoginModal").modal("hide");
                    iziToast.success({
                        message: response.message,
                        position: "topRight",
                    });
                    return;
                }
                if (typeof response.message === "string") {
                    iziToast.error({
                        message: response.message,
                        position: "topRight",
                    });
                } else {
                    $.each(response.message, function (key, value) {
                        iziToast.error({
                            message: value[0],
                            position: "topRight",
                        });
                        return false;
                    });
                }
                return false;
            },
        });
    });

    $(".update_order_item_status").on("click", function () {
        let order_status = $(this).data("status");
        let order_item_id = $(this).data("item-id");
        let confirm_title = "";
        let confirm_btn = "";
        if (order_status == "cancelled") {
            confirm_title =
                "Are you sure you want to cancel this ordered item?";
            confirm_btn = "Yes";
        } else if (order_status == "returned") {
            confirm_title = "Are you sure you want to return the ordered item?";
            confirm_btn = "Yes Return";
        }
        Swal.fire({
            title: confirm_title,
            showCancelButton: true,
            confirmButtonText: confirm_btn,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: appUrl + "orders/update-order-item-status",
                    data: {
                        order_status,
                        order_item_id,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.error == false) {
                            iziToast.success({
                                message: response.message,
                                position: "topRight",
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1500);

                            Livewire.dispatch("refreshComponent");
                            return false;
                        } else {
                            iziToast.error({
                                message: response.message,
                                position: "topRight",
                            });
                        }
                    },
                });
            }
        });
    });

    $(".chat-btn-popup").on("click", function () {
        $("#chat-iframe").toggleClass("chat-iframe-show");
    });

    $(function () {
        var $numberInput = $("#number");
        if ($numberInput.length) {
            var configuredCountry = ($numberInput.data("default-country") || "").toString().toLowerCase();
            var preferred = ["in", "ae", "qa", "om", "bh", "kw", "ma"];
            if (configuredCountry && preferred.indexOf(configuredCountry) === -1) {
                preferred.unshift(configuredCountry);
            }
            $numberInput.intlTelInput({
                allowExtensions: !0,
                formatOnDisplay: !0,
                autoFormat: !0,
                autoHideDialCode: !0,
                autoPlaceholder: !0,
                defaultCountry: configuredCountry || "in",
                ipinfoToken: "yolo",
                nationalMode: !1,
                numberType: "MOBILE",
                preferredCountries: preferred,
                preventInvalidNumbers: !0,
                separateDialCode: !0,
                initialCountry: configuredCountry || "auto",
                geoIpLookup: function (e) {
                    $.get("https://ipinfo.io", function () { }, "jsonp").always(
                        function (t) {
                            var a = t && t.country ? t.country : "";
                            e(a);
                        }
                    );
                },
                utilsScript:
                    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
            });
        }
    });
    let authentication_method = $("#authentication_method").val();
    if (authentication_method == "firebase") {
        FirebaseAuth();
    } else if (authentication_method == "sms") {
        CustomSmsAuth();
    }

    let store = setUrlParameter(custom_url, "store", store_slug);
    let split_url = custom_url.split("?");
    const urlParams = new URLSearchParams("?".concat(split_url[1]));
    const store_exsist = urlParams.get("store");
    if (store_exsist == null) {
        Livewire.navigate(store);
    }

    isEventAttached = true;
});

// Re-initialize star rating plugin on every Livewire navigation.
// livewire:navigating destroys all ratings, but the one-time init block
// only binds them once — so product/combo card stars disappear after
// navigating away and back. This keeps them rendered every time.
//
// Why the cleanup loop: when navigating back via wire:navigate, Livewire
// can restore the body from its snapshot cache. That cached HTML still
// contains the .rating-container <div> the plugin injected last time,
// but the jQuery data('rating') pointer that owns it is gone (jQuery
// stores it in an in-memory cache, not the DOM). Without cleanup, the
// plugin inserts a SECOND container before the input, and we end up with
// duplicate stars stacked on multiple lines.
document.addEventListener("livewire:navigated", function () {
    var $stars = $(".kv-ltr-theme-svg-star");
    if (!$stars.length) return;
    $stars.each(function () {
        var $input = $(this);
        $input.prevAll(".rating-container").remove();
        $.removeData(this, "rating");
        $input
            .removeClass("rating rating-input")
            .addClass("rating-loading");
    });
    $stars.rating({
        hoverOnClear: false,
        theme: "krajee-svg",
    });
});

// Re-initialize price slider on every Livewire navigation — the slider
// DOM is fresh after wire:navigate and needs jQuery UI re-init, otherwise
// the range bar and #amount input render empty on product/combo listings.
document.addEventListener("livewire:navigated", function () {
    if (!$("#slider-range").length) return;
    var currency_symbol = $("#currency").val();
    var min_price = $("#min-price").val();
    var max_price = $("#max-price").val();
    var selected_min_price = $("#selected_min_price").val();
    var selected_max_price = $("#selected_max_price").val();
    if ($("#slider-range").hasClass("ui-slider")) {
        $("#slider-range").slider("destroy");
    }
    $("#slider-range").slider({
        range: true,
        min: parseInt(min_price),
        max: parseInt(max_price),
        values: [selected_min_price, selected_max_price],
        slide: function (event, ui) {
            $("#amount").val(
                currency_symbol +
                ui.values[0] +
                " - " +
                currency_symbol +
                ui.values[1]
            );
            $("#min-price").val(ui.values[0]);
            $("#max-price").val(ui.values[1]);
        },
    });
    $("#amount").val(
        currency_symbol +
        $("#slider-range").slider("values", 0) +
        " - " +
        currency_symbol +
        $("#slider-range").slider("values", 1)
    );
});

// Re-initialize select2 for city/country on every navigation,
// independent of isEventAttached, so navigating back to the address
// page always has working dropdowns.
document.addEventListener("livewire:navigated", function () {
    if ($("#city_list").length) {
        if ($("#city_list").hasClass("select2-hidden-accessible")) {
            $("#city_list").select2("destroy");
        }
        initializeSelect2(
            "#city_list",
            "my-account/get_Cities",
            "Search for City",
            $(".city_list_div")
        );
    }
    if ($("#country_list").length) {
        if ($("#country_list").hasClass("select2-hidden-accessible")) {
            $("#country_list").select2("destroy");
        }
        initializeSelect2(
            "#country_list",
            "my-account/get_Countries",
            "Search for countries",
            $(".country_list_div")
        );
    }
});

$(function () {
    var $pswp = $(".pswp")[0],
        image = [],
        getItems = function () {
            var items = [];
            $(".lightboximages a").each(function () {
                var $href = $(this).attr("href"),
                    $size = $(this).data("size").split("x"),
                    item = {
                        src: $href,
                        w: $size[0],
                        h: $size[1],
                    };
                items.push(item);
            });
            return items;
        };
    var items = getItems();

    $.each(items, function (index, value) {
        image[index] = new Image();
        image[index].src = value["src"];
    });
    $(".prlightbox").on("click", function (event) {
        event.preventDefault();

        var $index = $(".active-thumb").parent().attr("data-slick-index");
        $index++;
        $index = $index - 1;

        var options = {
            index: $index,
            bgOpacity: 0.7,
            showHideOpacity: true,
        };
        var lightBox = new PhotoSwipe(
            $pswp,
            PhotoSwipeUI_Default,
            items,
            options
        );
        lightBox.init();
    });
});
$(".messages").animate({ scrollTop: $(document).height() }, "fast");

$("#profile-img").on("click", function () {
    $("#status-options").toggleClass("active");
});

$(".expand-button").on("click", function () {
    $("#profile").toggleClass("expanded");
    $("#contacts").toggleClass("expanded");
});

$("#status-options ul li").on("click", function () {
    $("#profile-img").removeClass();
    $("#status-online").removeClass("active");
    $("#status-away").removeClass("active");
    $("#status-busy").removeClass("active");
    $("#status-offline").removeClass("active");
    $(this).addClass("active");

    if ($("#status-online").hasClass("active")) {
        $("#profile-img").addClass("online");
    } else if ($("#status-away").hasClass("active")) {
        $("#profile-img").addClass("away");
    } else if ($("#status-busy").hasClass("active")) {
        $("#profile-img").addClass("busy");
    } else if ($("#status-offline").hasClass("active")) {
        $("#profile-img").addClass("offline");
    } else {
        $("#profile-img").removeClass();
    }

    $("#status-options").removeClass("active");
});

function newMessage() {
    let message = $(".message-input input").val();
    if ($.trim(message) == "") {
        return false;
    }
    $(
        '<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' +
        message +
        "</p></li>"
    ).appendTo($(".messages ul"));
    $(".message-input input").val(null);
    $(".contact.active .preview").html("<span>You: </span>" + message);
    $(".messages").animate({ scrollTop: $(document).height() }, "fast");
}

$(".submit").on("click", function () {
    newMessage();
});

$(window).on("keydown", function (e) {
    if (e.which == 13) {
        newMessage();
        return false;
    }
});

function initializeSelect2(selector, url, placeholder, dropdownParent) {
    $(selector).select2({
        ajax: {
            url: appUrl + url,
            type: "GET",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
        dropdownParent: dropdownParent,
        minimumInputLength: 1,
        placeholder: placeholder,
    });
}

$(".delete_rating").on("click", function () {
    $(".review_rating").rating("clear");
    $("#review_image").val("");
    $("#message").val("");
});

$(document).on("click", ".eye-icon", function () {
    let inputField = $(this).siblings("input");
    if (inputField.prop("type") == "text") {
        $(this).attr("name", "eye-off-outline");
        inputField.attr("type", "password");
        return;
    }
    $(this).attr("name", "eye-outline");
    inputField.attr("type", "text");
    return;
});


$(document).on("click", ".clear-rating", () => {
    $(".star-rating").rating("reset");
});
$(document).on("click", ".clear-rating", () => {
    $(".star-rating").rating("reset");
});

function arrays_equal(e, t) {
    if (!Array.isArray(e) || !Array.isArray(t) || e.length !== t.length)
        return !1;
    const a = e.concat().sort(),
        r = t.concat().sort();
    for (let e = 0; e < a.length; e++) if (a[e] !== r[e]) return !1;
    return !0;
}
$("#editLoginModal").on("hidden.bs.modal", function () {
    $(this).find('input[type="password"]').val("");
});

Livewire.on("cart-updated", ({ message }) => {
    // alert(message);
    iziToast.error({
        message: message,
        position: "topRight",
    });
});

$('#send_bank_receipt_form').on('submit', function (e) {
    e.preventDefault();
    console.log('here in form submit');

    var formdata = new FormData(this);

    var csrfToken = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;
    formdata.append("_token", csrfToken);

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formdata,

        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (result) {
            if (result.error == false) {
                iziToast.success({
                    message:
                        '<span style="text-transform:capitalize">' +
                        result.message +
                        "</span>",
                    position: "topRight",
                });
            }
            location.reload();
        },
        error: function () {
            iziToast.error({
                message:
                    '<span style="text-transform:capitalize">An error occurred while sending the message.</span>',
                position: "topRight",
            });
        }

    });

});

if (window.location.href.includes("my-account/support")) {
    var ticket_id = '';
    // Support Ticket chat
    $(document).on("click", ".view_ticket", function (e, row) {
        e.preventDefault();
        var scrolled = 0;
        $(".ticket_msg").data("max-loaded", false);
        ticket_id = $(this).data("ticket-id");

        var date_created = $(this).data("date_created");
        var subject = $(this).data("subject");
        var status = $(this).data("status");

        var ticket_type = $(this).data("ticket_type");
        $('input[name="ticket_id"]').val(ticket_id);

        $("#date_created").html(date_created);
        $("#subject").html(subject);
        $(".change_ticket_status").data("ticket_id", ticket_id);

        if (status == 1) {
            $('#status').html('<label class="badge bg-warning ml-2">PENDING</label>');
        } else if (status == 2) {
            $('#status').html('<label class="badge  bg-danger ml-2">OPENED</label>');
        } else if (status == 3) {
            $('#status').html('<label class="badge bg-success ml-2">RESOLVED</label>');
        } else if (status == 4) {
            $('#status').html('<label class="badge bg-dark ml-2">CLOSED</label>');
        } else if (status == 5) {
            $('#status').html('<label class="badge bg-primary ml-2">REOPENED</label>');
        }

        $('#ticket_type_chat').text(ticket_type);
        $('#subject_chat').text(subject);
        $('#date_created').html(date_created);
        $(".ticket_msg").html("");
        $(".ticket_msg").data("limit", 5);
        $(".ticket_msg").data("offset", 0);
        load_messages($(".ticket_msg"), ticket_id);
    });

    function load_messages(element, ticket_id) {
        var limit = element.data("limit");
        var offset = element.data("offset");
        element.data("offset", limit + offset);
        var max_loaded = element.data("max-loaded");
        if (max_loaded == false) {
            var loader =
                '<div class="loader text-center"><img src="' +
                appUrl +
                'assets/img/pre-loader.gif" alt="Loading. please wait.. ." title="Loading. please wait.. ."></div>';
            $.ajax({
                type: "get",
                data:
                    "ticket_id=" +
                    ticket_id +
                    "&limit=" +
                    limit +
                    "&offset=" +
                    offset,
                url: appUrl + "my-account/support/get-ticket-message",
                beforeSend: function () {
                    $(".ticket_msg").prepend(loader);
                },
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {

                    if (result.error == false) {
                        if (result.error == false && result.data.length > 0) {
                            var messages_html = "";
                            var is_left = "";
                            var i = 1;
                            result.data.reverse().forEach((messages) => {
                                var atch_html = "";
                                is_left =
                                    messages.user_type == "admin" ? "left justify-content-start align-items-start" : "right justify-content-end align-items-end";
                                if (messages.attachments.length > 0) {
                                    messages.attachments.forEach((atch) => {
                                        atch_html +=
                                            "<div class='image-upload-section d-flex " +
                                            (is_left === "left" ? "justify-content-start" : "justify-content-end") +
                                            "'>" + // Align based on `is_left`
                                            "<div class='col-md-12 col-sm-12 shadow mb-4 rounded text-center grow image'>" +
                                            "<a href='" + atch.media + "' target='_blank'>" +
                                            "<img src='" +
                                            atch.media +
                                            "' alt='Attachment Image' class='img-fluid rounded' style='max-width: 100%; height: 100px; object-fit: contain;' />" +
                                            "</a>" +
                                            "</div>" +
                                            "</div>";
                                        i++;
                                    });
                                }
                                messages_html +=
                                    "<div class='d-flex " + (messages.attachments.length > 0 ? '' : 'direct-chat-msg') + " flex-column " + is_left + "'>" +
                                    "<div class='direct-chat-infos clearfix text-black-50'>" +
                                    "<span class='direct-chat-name float-" + is_left + "' id='name'>" + " " + messages.name + " " + "</span>" +
                                    "<span class='direct-chat-timestamp float-" + is_left + "' id='last_updated'>" + messages.updated_at + " " + "</span>" +
                                    "</div>" +
                                    "<div class='direct-chat-text float-" + is_left + "' id='message'>" + messages.message +
                                    "</br>" +
                                    atch_html +
                                    "</div>" +
                                    "</div>";
                            });
                            $(".ticket_msg").prepend(messages_html);
                            $(".ticket_msg").find(".loader").remove();
                            $(element).animate({
                                scrollTop: $(element).offset().top,
                            });
                        }
                    } else {
                        element.data("offset", offset);
                        element.data("max-loaded", true);
                        $(".ticket_msg").find(".loader").remove();
                        $(".ticket_msg").prepend(
                            '<div class="text-center"> <p>You have reached the top most message!</p></div>'
                        );
                    }
                    $("#element").scrollTop(20); // Scroll alittle way down, to allow user to scroll more
                    $(element).animate({
                        scrollTop: $(element).offset().top,
                    });
                    return false;
                },
            });
        }
    }

    // Dropzone configuration
    let myDropzone = new Dropzone("#myAlbumTicket", {
        url: appUrl + "my-account/support/send-message",
        autoProcessQueue: false,
        paramName: "attachments",
        addRemoveLinks: true,
        parallelUploads: 10,
        uploadMultiple: true,
        maxFiles: 3,
        dictMaxFilesExceeded: 'Only 3 files are allowed at once',
        dictRemoveFile: 'x',
    });


    $('#ticket_send_msg_form').on('submit', function (e) {
        e.preventDefault();

        var formdata = new FormData(this);

        var csrfToken = document.head.querySelector(
            'meta[name="csrf-token"]'
        ).content;
        formdata.append("_token", csrfToken);

        var ticket_id = $('#ticket_id').val();
        var message = $("#message_input").val();
        let drop_file_count = myDropzone.files.length;

        if (message.length > 0 || drop_file_count > 0) {
            // Append ticket_id and other necessary data to Dropzone's formData
            myDropzone.on('sending', function (file, xhr, formData) {
                formData.append('ticket_id', ticket_id);
                formData.append('user_id', $('#user_id').val());
                formData.append('user_type', $('#user_type').val());
                formData.append('message', message); // Include message if present
                formData.append("_token", csrfToken);
            });

            if (drop_file_count > 0) {
                // Process Dropzone queue for file uploads
                myDropzone.processQueue();
            } else {
                // No files, proceed with regular AJAX for text message
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formdata,

                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (result) {
                        var token = $('meta[name="csrf-token"]').attr("content");
                        $("#submit_btn").html("Send").attr("disabled", false);
                        if (result.error == false) {
                            $(".product-image-container").remove();
                            if (result.data.id > 0) {
                                var messages = result.data;
                                var message_html = "";
                                var i = 1;
                                var atch_html = "";
                                var is_left =
                                    messages.user_type == "admin" ? "left justify-content-start align-items-start" : "right justify-content-end align-items-end";

                                if (messages.attachments.length > 0) {
                                    messages.attachments.forEach((atch) => {
                                        atch_html +=
                                            "<div class='image-upload-section d-flex " +
                                            (is_left === "left" ? "justify-content-start" : "justify-content-end") +
                                            "'>" + // Align based on `is_left`
                                            "<div class='col-md-12 col-sm-12 shadow mb-4 rounded text-center grow image'>" +
                                            "<a href='" + atch.media + "' target='_blank'>" +
                                            "<img src='" +
                                            atch.media +
                                            "' alt='Attachment Image' class='img-fluid rounded' style='max-width: 100%; height: 100px; object-fit: contain;' />" +
                                            "</a>" +
                                            "</div>" +
                                            "</div>";
                                        i++;
                                    });
                                }
                                message_html +=
                                    "<div class='d-flex " + (messages.attachments.length > 0 ? '' : 'direct-chat-msg') + " flex-column " +
                                    is_left +
                                    "'>" +
                                    "<div class='direct-chat-infos clearfix text-black-50'>" +
                                    "<span class='direct-chat-name float-" +
                                    is_left +
                                    "' id='name'>" +
                                    " " +
                                    messages.name +
                                    " " +
                                    "</span>" +
                                    "<span class='direct-chat-timestamp float-" +
                                    is_left +
                                    "' id='last_updated'>" +
                                    messages.updated_at +
                                    " " +
                                    "</span>" +
                                    "</div>" +
                                    "<div class='direct-chat-text float-" +
                                    is_left +
                                    "' id='message'>" +
                                    messages.message +
                                    "</br>" +
                                    atch_html +
                                    "</div>" +
                                    "</div>";
                                $(".ticket_msg").append(message_html);
                                $("#message_input").val("");
                                $("#element").scrollTop($("#element")[0].scrollHeight);
                                $('input[name="attachments[]"]').val("");
                            } else {
                                // Handle the case when result.data.id is not greater than 0 (e.g., invalid data)
                                iziToast.error({
                                    message:
                                        '<span style="text-transform:capitalize">' +
                                        result.data.message +
                                        "</span>",
                                });
                            }
                        } else {
                            // Handle the error case
                            $("#element").data("max-loaded", true);
                            iziToast.error({
                                message:
                                    '<span style="text-transform:capitalize">' +
                                    result.error_message +
                                    "</span> ",
                            });
                            return false;
                        }
                        iziToast.success({
                            message:
                                '<span style="text-transform:capitalize">' +
                                result.message +
                                "</span> ",
                        });
                    },
                    error: function () {
                        $('#submit_btn').html('Send').attr('disabled', false);

                        iziToast.error({
                            message:
                                '<span style="text-transform:capitalize">An error occurred while sending the message.</span>',
                        });
                    }
                });
            }
        } else {


            iziToast.error({
                message:
                    '<span style="text-transform:capitalize">Please enter a message or attach a file.</span>',
            });
        }

        return false;
    });

    $(function () {
        var scrolled = 0;
        if ($("#element").length) {
            $("#element").scrollTop($("#element")[0].scrollHeight);
            $("#element").scroll(function () {
                if ($("#element").scrollTop() == 0) {

                    load_messages($(".ticket_msg"), ticket_id);
                }
            });
            $("#element").bind("mousewheel", function (e) {
                if (e.originalEvent.wheelDelta / 120 > 0) {
                    if ($(".ticket_msg")[0].scrollHeight < 370 && scrolled == 0) {

                        load_messages($(".ticket_msg"), ticket_id);
                        scrolled = 1;
                    }
                }
            });
        }
    });


    $(document).ready(function () {

        // Handle duplicate file prevention
        myDropzone.on("addedfile", function (file) {
            let i = 0;
            if (this.files.length) {
                for (let _i = 0, _len = this.files.length; _i < _len - 1; _i++) {
                    if (
                        this.files[_i].name === file.name &&
                        this.files[_i].size === file.size &&
                        this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString()
                    ) {
                        this.removeFile(file);
                    } else if (this.files[4] != null) {
                        this.removeFile(file);
                    }
                    i++;
                }
            }
        });

        // Handle successful file upload
        myDropzone.on('successmultiple', function (file, response) {
            let data = typeof response === 'string' ? JSON.parse(response) : response;

            if (data.error == false && data.data.id > 0) {
                var messages = data.data;
                var message_html = "";

                var i = 1;
                var atch_html = "";
                var is_left = messages.user_type == "admin" ? "left justify-content-start align-items-start" : "right justify-content-end align-items-end";

                if (messages.attachments.length > 0) {
                    messages.attachments.forEach((atch) => {
                        atch_html +=
                            "<div class='image-upload-section d-flex " +
                            (is_left === "left" ? "justify-content-start" : "justify-content-end") +
                            "'>" + // Align based on `is_left`
                            "<div class='col-md-12 col-sm-12 shadow mb-4 rounded text-center grow image'>" +
                            "<a href='" + atch.media + "' target='_blank'>" +
                            "<img src='" +
                            atch.media +
                            "' alt='Attachment Image' class='img-fluid rounded' style='max-width: 100%; height: 100px; object-fit: contain;' />" +
                            "</a>" +
                            "</div>" +
                            "</div>";
                        i++;
                    });
                }
                message_html +=
                    "<div class='d-flex " + (messages.attachments.length > 0 ? '' : 'direct-chat-msg') + " flex-column " + is_left + "'>" +
                    "<div class='direct-chat-infos clearfix text-black-50'>" +
                    "<span class='direct-chat-name float-" + is_left + "' id='name'>" + " " + messages.name + " " + "</span>" +
                    "<span class='direct-chat-timestamp float-" + is_left + "' id='last_updated'>" + messages.updated_at + " " + "</span>" +
                    "</div>" +
                    "<div class='direct-chat-text float-" + is_left + "' id='message'>" + messages.message +
                    "</br>" +
                    atch_html +
                    "</div>" +
                    "</div>";

                $('.ticket_msg').append(message_html);
                $("#message_input").val('');
                $("#element").scrollTop($("#element")[0].scrollHeight);

                iziToast.success({
                    message:
                        '<span style="text-transform:capitalize">' +
                        data.message +
                        "</span> ",
                });
            } else {

                iziToast.error({
                    message:
                        '<span style="text-transform:capitalize">' + data.message + '</span>',
                });
            }

            closeDropZone();
            myDropzone.removeAllFiles(true);
        });

        // Handle Dropzone errors
        myDropzone.on('error', function (file, errorMessage) {

            iziToast.error({
                message:
                    '<span style="text-transform:capitalize">File upload failed: ' + errorMessage + '</span>',
            });
            myDropzone.removeFile(file);
        });

        // Show/hide Dropzone
        $(document).on("dragenter", "#chat-box-content", function (e) {
            showDropZone();
        });

        $(document).on("click", ".btn-attech", function () {

            showDropZone();
        });

        window.closeDropZone = function () {
            $('#chat-box-content').show();
            $('#chat-dropbox').addClass("d-none");
            myDropzone.removeAllFiles(true);
        };

        window.showDropZone = function () {
            $('#chat-dropbox').removeClass("d-none");
            $('#chat-box-content').hide();
        };
    });

    $(document).ready(function () {
        $('#message_input').on('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                $('#ticket_send_msg_form').submit();
            }
        });
    });
}
