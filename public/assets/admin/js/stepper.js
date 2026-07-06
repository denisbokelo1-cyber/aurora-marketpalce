$(document).ready(function () {
    var current_fs, next_fs, previous_fs;

    // No BACK button on first screen
    if ($(".show").hasClass("first-screen")) {
        $(".prev").css({ display: "none" });
    }

    // Previous button
    $(".prev").click(function () {
        current_act = $(".step0.active");

        previous_act = $(".step0.active").prevAll(":not(.d-none)");

        current_fs = $(".card2.show");

        previous_fs = $(".card2.show").prevAll(":not(.d-none)").first();

        $(current_fs).removeClass("show");
        $(previous_fs).addClass("show");

        $(current_act).removeClass("active");
        $(previous_act).addClass("active");

        $(".prev").css({ display: "block" });

        if ($(".show").hasClass("first-screen")) {
            $(".prev").css({ display: "none" });
        }

        current_fs.animate(
            {},
            {
                step: function () {
                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });

                    previous_fs.css({
                        display: "block",
                    });
                },
            }
        );
    });
});

// Next button
$(".next-button").click(function () {
    const currentStep = $(this).data("step"); // Update with the actual current step

    var res = validateStep(currentStep);

    if (res != false) {
        current_fs = $(this).parent();
        next_fs = $(this).parent().nextAll(":not(.d-none)").first();

        $(".prev").css({ display: "block" });

        $(current_fs).removeClass("show");
        $(next_fs).addClass("show");

        $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");

        current_fs.animate(
            {},
            {
                step: function () {
                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });

                    next_fs.css({
                        display: "block",
                    });
                },
            }
        );
    }
});

// store stepper

$(document).on("click", ".store-next-button", function () {
    const currentStep = $(this).data("step");

    var res = validateStoreStep(currentStep);

    if (res != false) {
        current_fs = $(this).parent();

        next_fs = $(this).parent().next();

        $(".prev").css({ display: "block" });

        $(current_fs).removeClass("show");
        $(next_fs).addClass("show");

        $("#store_progressbar li")
            .eq($(".card2").index(next_fs))
            .addClass("active");

        current_fs.animate(
            {},
            {
                step: function () {
                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });

                    next_fs.css({
                        display: "block",
                    });
                },
            }
        );
    }
});

$(document).on("click", ".combo-next-button", function () {
    const currentStep = $(this).data("step");

    var res = validateComboStep(currentStep);

    if (res != false) {
        current_fs = $(this).parent();

        next_fs = $(this).parent().nextAll(":not(.d-none)").first();

        $(".prev").css({ display: "block" });

        $(current_fs).removeClass("show");
        $(next_fs).addClass("show");

        $("#progressbar li").eq($(".card2").index(next_fs)).addClass("active");

        current_fs.animate(
            {},
            {
                step: function () {
                    current_fs.css({
                        display: "none",
                        position: "relative",
                    });

                    next_fs.css({
                        display: "block",
                    });
                },
            }
        );
    }
});

// validate function for add combo product

function validateComboStep(step = "") {
    // Define validation rules for each step
    var product_type = $('input[name="product_type_in_combo"]:checked').val();
    const validationRules = {
        step1: {
            seller_id: "Please select a seller.",
        },
        step2: {
            // Assuming product_type is defined elsewhere
            // Adding condition to dynamically set validation rule based on product_type
            ...(product_type === "digital_product"
                ? { "digital_product_id[]": "Please select a digital product." }
                : {
                    "physical_product_variant_id[]":
                        "Please select a physical product.",
                }),
            short_description: "Please enter a short description.",
            title: "Please enter a product name.",
        },
        step7: {
            image: "Please select a product image.",
        },
    };

    $(".has_similar_product").change(function () {
        // If the checkbox is checked (turned on), show the dropdown, otherwise hide it
        if ($(this).prop("checked")) {
            validationRules["step2"]["similar_product_id[]"] =
                "Please Select Simillar Product.";
        }
    });
    $(".has_similar_product").trigger("change");

    // Get validation rules for the current step
    const currentStepRules = validationRules[step];

    // Check individual fields for the current step
    for (const fieldName in currentStepRules) {
        if (fieldName == "category_id") {
            var fieldValue = $("#product_category_tree_view_html").jstree(
                "get_selected"
            );
        } else {
            var fieldValue = $(`[name='${fieldName}']`).val();
        }

        if (
            fieldValue == "" ||
            fieldValue == undefined ||
            fieldValue.length == 0
        ) {
            var result = displayValidationError(currentStepRules[fieldName]);
        }
    }

    if (step == "step6") {
        var product_type = $("#combo_type").val();

        if (product_type == "combo_product") {
            var simple_stock_management_status = $(
                ".simple_stock_management_status"
            ).is(":checked");
            var product_sku = $(`[name='product_sku`).val();
            var product_total_stock = $(`[name='product_total_stock`).val();
            const simplePrice = $('[name="simple_price"]').val();
            const simpleSpecialPrice = $('[name="simple_special_price"]').val();

            if (simpleSpecialPrice == "" || simpleSpecialPrice == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError(
                    "Please enter Special Price."
                );
            }
            if (simplePrice == "" || simplePrice == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError("Please enter Price.");
            }

            if (parseFloat(simpleSpecialPrice) >= parseFloat(simplePrice)) {
                // Handle special price greater than or equal to price
                var result = displayValidationError(
                    "Special price should be less than price."
                );
            }

            if (
                simple_stock_management_status == "true" ||
                simple_stock_management_status == true
            ) {
                if (
                    product_sku == "" ||
                    product_sku == undefined ||
                    product_sku == null
                ) {
                    var result = displayValidationError("Please enter SKU.");
                }
                if (
                    product_total_stock == "" ||
                    product_total_stock == undefined ||
                    product_total_stock == null
                ) {
                    var result = displayValidationError(
                        "Please enter total stock."
                    );
                }
            }
        }

        if (product_type == "digital_product") {
            const simplePrice = $('[name="simple_price"]').val();
            const simpleSpecialPrice = $('[name="simple_special_price"]').val();
            var download_allowed = $("#download_allowed").is(":checked");

            if (simpleSpecialPrice == "" || simpleSpecialPrice == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError(
                    "Please enter Special Price."
                );
            }
            if (simplePrice == "" || simplePrice == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError("Please enter Price.");
            }
            if (parseFloat(simpleSpecialPrice) >= parseFloat(simplePrice)) {
                // Handle special price greater than or equal to price
                var result = displayValidationError(
                    "Special price should be less than price."
                );
            }

            if (download_allowed == true || download_allowed == "true") {
                var download_link_type = $('[name="download_link_type"]').val();
                if (download_link_type == "self_hosted") {
                    var pro_input_zip = $('[name="pro_input_zip"]').val();
                    if (pro_input_zip == "" || pro_input_zip == undefined) {
                        var result = displayValidationError(
                            "Please select file."
                        );
                    }
                }
                if (download_link_type == "add_link") {
                    var download_link = $('[name="download_link"]').val();
                    if (download_link == "" || download_link == undefined) {
                        var result = displayValidationError(
                            "Please enter file link."
                        );
                    }
                }
            }
        }
    }
    if (step == "step7") {
        var video_type = $(`[name='video_type`).val();

        if (video_type == "self_hosted") {
            var pro_input_video = $(`[name='pro_input_video`).val();
            if (pro_input_video == "" || pro_input_video == undefined) {
                var result = displayValidationError("Please select video.");
            }
        }
        if (video_type == "youtube" || video_type == "vimeo") {
            var pro_input_video = $(`[name='video`).val();
            if (pro_input_video == "" || pro_input_video == undefined) {
                var result = displayValidationError("Please enter video link.");
            }
        }
    }
    return result;
}

//validate function for add product form stepper

function validateStep(step = "") {
    // Define validation rules for each step
    const validationRules = {
        step1: {
            category_id: "Please select a category.",
            seller_id: "Please select a seller.",
        },
        step2: {
            short_description: "Please enter a short description.",
            pro_input_name: "Please enter a product name.",
        },
        step6: {
            type: "Please select product type.",
        },
        step7: {
            pro_input_image: "Please select product image.",
        },
    };

    // Get validation rules for the current step
    const currentStepRules = validationRules[step];

    // Check individual fields for the current step
    for (const fieldName in currentStepRules) {
        if (fieldName == "category_id") {
            var fieldValue = $("#product_category_tree_view_html").jstree(
                "get_selected"
            );
        } else {
            var fieldValue = $(`[name='${fieldName}']`).val();
        }

        if (
            fieldValue == "" ||
            fieldValue == undefined ||
            fieldValue.length == 0
        ) {
            var result = displayValidationError(currentStepRules[fieldName]);
        }
    }
    if (step == "step5") {
        var deliverable_type = $(`[name='deliverable_type']`).val();
        var selected_zones = $(`[name='deliverable_zones[]']`).val();
        // console.log(selected_zones);
        if (deliverable_type == "2" || deliverable_type == "3") {
            if (!selected_zones || selected_zones.length === 0) {
                var result = displayValidationError(
                    "Please select valid zones."
                );
            }
        }
    }
    if (step == "step6") {
        var product_type = $(`[name='type`).val();
        if (product_type == "" || product_type == undefined) {
            var result = displayValidationError("Please select product type.");
        }
        if (product_type == "simple_product") {
            var simple_stock_management_status = $(
                ".simple_stock_management_status"
            ).is(":checked");
            var product_sku = $(`[name='product_sku`).val();
            var product_total_stock = $(`[name='product_total_stock`).val();
            const simplePrice = $('[name="simple_price"]').val();
            const simpleSpecialPrice = $('[name="simple_special_price"]').val();

            if (simplePrice == "" || simplePrice == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError("Please enter Price.");
            }

            if (
                isNaN(parseFloat(simplePrice)) ||
                isNaN(parseFloat(simpleSpecialPrice))
            ) {
                // Handle invalid numeric values
                var result = displayValidationError(
                    "Please enter Special Price."
                );
            }
            if (parseFloat(simpleSpecialPrice) >= parseFloat(simplePrice)) {
                // Handle special price greater than or equal to price
                var result = displayValidationError(
                    "Special price should be less than price."
                );
            }

            if (
                simple_stock_management_status == "true" ||
                simple_stock_management_status == true
            ) {
                if (
                    product_sku == "" ||
                    product_sku == undefined ||
                    product_sku == null
                ) {
                    var result = displayValidationError("Please enter SKU.");
                }
                if (
                    product_total_stock == "" ||
                    product_total_stock == undefined ||
                    product_total_stock == null
                ) {
                    var result = displayValidationError(
                        "Please enter total stock."
                    );
                }
            }
        }

        if (product_type == "variable_product") {
            var variant_stock_status = $(".variant_stock_status").is(
                ":checked"
            );
            var stock_level_type = $("#stock_level_type").val();
            var variant_price = $(`[name='variant_price[]`).val();

            var is_image_selected = false;

            $(`[name^='variant_images']`).each(function () {
                if ($(this).val() !== "" && $(this).val() !== undefined) {
                    is_image_selected = true;
                }
            });

            if (!is_image_selected) {
                displayValidationError("Please choose a variant image.");
            }

            var variant_special_price = $(
                `[name='variant_special_price[]`
            ).val();

            if (variant_price == "" || variant_price == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError("Please enter Price.");
            }

            if (
                variant_special_price == "" ||
                variant_special_price == undefined
            ) {
                // Handle invalid numeric values
                var result = displayValidationError(
                    "Please enter Special Price."
                );
            }

            if (
                parseFloat(variant_special_price) >= parseFloat(variant_price)
            ) {
                // Handle special price greater than or equal to price
                var result = displayValidationError(
                    "Special price should be less than price."
                );
            }

            if (
                variant_stock_status == "true" ||
                variant_stock_status == true
            ) {
                if (
                    stock_level_type == "" ||
                    stock_level_type == undefined ||
                    stock_level_type == null
                ) {
                    var result = displayValidationError(
                        "Please select stock management type."
                    );
                }

                if (stock_level_type == "product_level") {
                    var sku_variant_type = $('[name="sku_variant_type"]').val();
                    var total_stock_variant_type = $(
                        '[name="total_stock_variant_type"]'
                    ).val();

                    if (
                        sku_variant_type == "" ||
                        sku_variant_type == undefined ||
                        sku_variant_type == null
                    ) {
                        var result =
                            displayValidationError("Please enter SKU.");
                    }
                    if (
                        total_stock_variant_type == "" ||
                        total_stock_variant_type == undefined ||
                        total_stock_variant_type == null
                    ) {
                        var result = displayValidationError(
                            "Please enter total stock."
                        );
                    }
                }

                if (stock_level_type == "variable_level") {
                    var variant_sku = $(`[name='variant_sku[]`).val();
                    var variant_total_stock = $(
                        `[name='variant_total_stock[]`
                    ).val();

                    if (
                        variant_sku == "" ||
                        variant_sku == undefined ||
                        variant_sku == null
                    ) {
                        var result =
                            displayValidationError("Please enter SKU.");
                    }
                    if (
                        variant_total_stock == "" ||
                        variant_total_stock == undefined ||
                        variant_total_stock == null
                    ) {
                        var result = displayValidationError(
                            "Please enter total stock."
                        );
                    }
                }
            }
        }

        if (product_type == "digital_product") {
            const simplePrice = $('[name="simple_price"]').val();
            const simpleSpecialPrice = $('[name="simple_special_price"]').val();
            var download_allowed = $("#download_allowed").is(":checked");

            if (simplePrice == "" || simplePrice == undefined) {
                // Handle invalid numeric values
                var result = displayValidationError("Please enter Price.");
            }
            if (
                isNaN(parseFloat(simplePrice)) ||
                isNaN(parseFloat(simpleSpecialPrice))
            ) {
                // Handle invalid numeric values
                var result = displayValidationError(
                    "Invalid numeric values for price or special price."
                );
            }
            if (parseFloat(simpleSpecialPrice) >= parseFloat(simplePrice)) {
                // Handle special price greater than or equal to price
                var result = displayValidationError(
                    "Special price should be less than price."
                );
            }

            if (download_allowed == true || download_allowed == "true") {
                var download_link_type = $('[name="download_link_type"]').val();
                if (download_link_type == "self_hosted") {
                    var pro_input_zip = $('[name="pro_input_zip"]').val();
                    if (pro_input_zip == "" || pro_input_zip == undefined) {
                        var result = displayValidationError(
                            "Please select file."
                        );
                    }
                }
                if (download_link_type == "add_link") {
                    var download_link = $('[name="download_link"]').val();
                    if (download_link == "" || download_link == undefined) {
                        var result = displayValidationError(
                            "Please enter file link."
                        );
                    }
                }
            }
        }
    }
    if (step == "step7") {
        var video_type = $(`[name='video_type`).val();

        if (video_type == "self_hosted") {
            var pro_input_video = $(`[name='pro_input_video`).val();
            if (pro_input_video == "" || pro_input_video == undefined) {
                var result = displayValidationError("Please select video.");
            }
        }
        if (video_type == "youtube" || video_type == "vimeo") {
            var pro_input_video = $(`[name='video`).val();
            if (pro_input_video == "" || pro_input_video == undefined) {
                var result = displayValidationError("Please enter video link.");
            }
        }
    }
    return result;
}

//validate function for add store form stepper

function validateStoreStep(step = "") {
    // Define validation rules for each step
    const validationRules = {
        step1: {
            background_color: "Please Choose Background Color.",
            active_color: "Please Choose Active Color.",
            hover_color: "Please Choose Hover Color.",
            secondary_color: "Please Choose Secondary Color.",
            primary_color: "Please Choose Primary Color.",
            description: "Please Enter Description.",
            name: "Please Enter Name.",
        },
        step2: {
            image: "Please Choose Image.",
            banner_image: "Please Choose Banner Image.",
        },
        step3: {
            banner_image_for_most_selling_product:
                "Please Choose Banner Image.",
            stack_image: "Please Choose Stack Image.",
            login_image: "Please Choose Login Page Image.",
            half_store_logo: "Please Choose Half Logo Image.",
        },
        step4: {
            store_style: "Please Select Store Style.",
            product_style: "Please Select Product Style.",
        },
        step5: {
            category_section_title: "Please Enter Category Section Title.",
            category_style: "Please Select Category Style.",
            category_card_style: "Please Select Category Card Style.",
        },
        step6: {
            brand_style: "Please Select Brand Style.",
        },
        step7: {
            // offers_style: "Please Select Offers Style.",
            offer_slider_style: "Please Select Offer Sliders Style.",
        },
    };

    // Get validation rules for the current step
    const currentStepRules = validationRules[step];

    for (const fieldName in currentStepRules) {
        var fieldValue = $(`[name='${fieldName}']`).val();

        if (
            fieldValue == "" ||
            fieldValue == undefined ||
            fieldValue.length == 0
        ) {
            var result = displayValidationError(currentStepRules[fieldName]);
        }
    }

    return result;
}

function displayStoreValidationError(messages) {
    Object.values(messages).forEach((message) => {
        iziToast.error({
            title: "Error",
            message: message,
            position: "topRight",
        });
    });

    return false;
}

function displayValidationError(message) {
    iziToast.error({
        title: "Error",
        message: message,
        position: "topRight",
    });
    return false;
}
// affiliate marketing stepper
let currentAffiliateFormStep = 1;

function updateStepperUI(step) {
    // Show only the current step page
    document.querySelectorAll('.step-page').forEach(p => p.classList.add('d-none'));
    const currentPage = document.getElementById(`page${step}`);
    if (currentPage) currentPage.classList.remove('d-none');

    // Update stepper UI
    document.querySelectorAll('.affiliate_step').forEach((el, index) => {
        el.classList.remove('active', 'completed', 'primary');
        const circle = el.querySelector('.circle');
        circle.innerHTML = '';

        const stepIndex = index + 1;
        if (stepIndex < step) {
            el.classList.add('completed');
            circle.innerHTML = '✓';
        }
        if (stepIndex === step) {
            el.classList.add('active', 'primary');
        }
    });
}
function validateAffiliateStep(step) {
    let errors = [];
    let firstInvalidField = null;
    let stepToGo = step;

    // URL regex (simple version)
    const urlPattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;

    if (step === 1) {
        const fullName = document.getElementById('full_name');
        const email = document.getElementById('email');
        const mobile = document.getElementById('mobile');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const address = document.getElementById('address');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Remove previous highlights
        const fields = [fullName, email, mobile, address];
        if (password && confirmPassword) {
            fields.push(password, confirmPassword);
        }

        fields.forEach(el => {
            if (el) el.classList.remove('is-invalid');
        });

        if (!fullName.value.trim()) {
            errors.push('Full Name is required');
            fullName.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = fullName;
        }
        if (!email.value.trim()) {
            errors.push('Email is required');
            email.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = email;
        } else if (!emailPattern.test(email.value.trim())) {
            errors.push('Please enter a valid email address');
            email.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = email;
        }
        if (!mobile.value.trim()) {
            errors.push('Mobile is required');
            mobile.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = mobile;
        }
        if (password && !password.value.trim()) {
            errors.push('Password is required');
            password.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = password;
        }
        if (confirmPassword && !confirmPassword.value.trim()) {
            errors.push('Confirm Password is required');
            confirmPassword.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = confirmPassword;
        }
        if (
            password && confirmPassword &&
            password.value && confirmPassword.value &&
            password.value !== confirmPassword.value
        ) {
            errors.push('Password and Confirm Password do not match');
            password.classList.add('is-invalid');
            confirmPassword.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = confirmPassword;
        }
        if (!address.value.trim()) {
            errors.push('Address is required');
            address.classList.add('is-invalid');
            if (!firstInvalidField) firstInvalidField = address;
        }
    }
    if (step === 2) {
        // Step 2: Website and Mobile App
        const website = document.getElementById('website_url');
        const app = document.getElementById('application_url');
        const urlPattern = /^(https?:\/\/)[^\s/$.?#].[^\s]*$/i;

        if (website) website.classList.remove('is-invalid');
        if (app) app.classList.remove('is-invalid');

        // Website validation
        if (!website || !website.value || !website.value.trim()) {
            errors.push('Website is required');
            if (website) website.classList.add('is-invalid');
            if (!firstInvalidField && website) firstInvalidField = website;
        } else if (!urlPattern.test(website.value.trim())) {
            errors.push('Please enter a valid Website URL');
            if (website) website.classList.add('is-invalid');
            if (!firstInvalidField && website) firstInvalidField = website;
        }

        // App validation
        if (!app || !app.value || !app.value.trim()) {
            errors.push('Mobile App is required');
            if (app) app.classList.add('is-invalid');
            if (!firstInvalidField && app) firstInvalidField = app;
        } else if (!urlPattern.test(app.value.trim())) {
            errors.push('Please enter a valid Mobile App URL');
            if (app) app.classList.add('is-invalid');
            if (!firstInvalidField && app) firstInvalidField = app;
        }
        stepToGo = 2;
    }
    if (step === 3) {
        const statusChecked = document.querySelector('input[name="status"]:checked');
        if (!statusChecked) {
            errors.push('Status is required');
            stepToGo = 3;
        }
    }

    if (errors.length > 0) {
        errors.forEach(msg => {
            iziToast.error({ title: 'Error', message: msg, position: 'topRight' });
        });
        // Go to the step with the error
        if (stepToGo !== step) goToStep(stepToGo);
        // Focus the first invalid field
        if (firstInvalidField) firstInvalidField.focus();
        return false;
    }
    return true;
}
function nextStep(step) {
    // Validate current step before moving
    if (!validateAffiliateStep(currentAffiliateFormStep)) {
        return; // Stop if validation fails
    }
    currentAffiliateFormStep = step;
    updateStepperUI(step);
}

function prevStep(step) {
    currentAffiliateFormStep = step;
    updateStepperUI(step);
}

function goToStep(step) {
    // Only allow forward navigation if current step is valid
    if (step > currentAffiliateFormStep) {
        if (!validateAffiliateStep(currentAffiliateFormStep)) {
            return; // Stop if validation fails
        }
    }
    currentAffiliateFormStep = step;
    updateStepperUI(step);
}


window.onload = () => updateStepperUI(currentAffiliateFormStep);

// form submit 

// $(document).ready(function () {
//     $('#add_affiliate_user_form').on('submit', function (e) {
//         e.preventDefault();

//         if (!validateAffiliateStep(3)) return;

//         var $form = $(this);
//         var formData = new FormData(this);
//         var submitButton = $(".submit_button");
//         $.ajax({
//             url: $(this).attr("action"),
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             headers: {
//                 'X-CSRF-TOKEN': $('input[name="_token"]').val()
//             },
//             beforeSend: function () {
//                 submitButton.prop("disabled", true).text("Please wait...");
//             },
//             success: function (response) {
//                 if (response.success) {
//                     iziToast.success({ title: 'Success', message: 'Affiliate user added successfully!', position: 'topRight' });
//                     // Optionally redirect or reset form
//                     submitButton.prop("disabled", false).text("Add User");
//                     setTimeout(function () {
//                         // Redirect to the appropriate URL
//                         window.location.href = '/admin/manage_affiliate_users';
//                     }, 2000);
//                 } else {
//                     iziToast.error({ title: 'Error', message: response.message || 'Something went wrong', position: 'topRight' });
//                 }
//             },
//             error: function (xhr) {
//                 if (xhr.status === 422) {
//                     var errors = xhr.responseJSON.errors;
//                     let stepToGo = 1;
//                     let firstInvalidField = null;

//                     // Remove previous highlights
//                     $('#add_affiliate_user_form .is-invalid').removeClass('is-invalid');
//                     $('.affiliate_step').removeClass('step-error');

//                     // Helper: map field to step
//                     function fieldToStep(field) {
//                         if (['website_url', 'application_url'].includes(field)) return 2;
//                         if (field === 'status') return 3;
//                         return 1;
//                     }

//                     let stepsWithError = new Set();

//                     if (Array.isArray(errors)) {
//                         errors.forEach(function (msg) {
//                             iziToast.error({ title: 'Error', message: msg, position: 'topRight' });
//                         });
//                     } else {
//                         $.each(errors, function (field, messages) {
//                             $.each(messages, function (i, msg) {
//                                 iziToast.error({ title: 'Error', message: msg, position: 'topRight' });
//                             });
//                             // Highlight all fields with errors
//                             var $input = $('[name="' + field + '"]');
//                             $input.addClass('is-invalid');
//                             if (!firstInvalidField && $input.length) firstInvalidField = $input;
//                             // Track which step has error
//                             stepsWithError.add(fieldToStep(field));
//                             // Decide which step to go to (lowest step with error)
//                             if (fieldToStep(field) < stepToGo) stepToGo = fieldToStep(field);
//                         });
//                     }

//                     // Highlight step indicators with error
//                     stepsWithError.forEach(function (stepNum) {
//                         $('.affiliate_step').eq(stepNum - 1).addClass('step-error');
//                     });

//                     goToStep(stepToGo);
//                     if (firstInvalidField) firstInvalidField.focus();
//                     submitButton.prop("disabled", false).text("Add User");
//                 } else {
//                     iziToast.error({ title: 'Error', message: 'Server error. Please try again.', position: 'topRight' });
//                 }
//             }
//         });
//     });
// });

$(document).ready(function () {
    $('#add_affiliate_user_form').on('submit', function (e) {
        e.preventDefault();
        var selfRegister = ($('.self_register').val() || 'self_register');

        if (selfRegister !== 'self_register' && !validateAffiliateStep(3)) return;

        var $form = $(this);
        var formData = new FormData(this);
        var submitButton = $(".submit_button");
        var formMode = $form.find('input[name="form_mode"]').val() || 'add'; 
        var buttonText = formMode === 'update' ? "Update User" : "Add User";
        if (selfRegister == 'self_register') {
            successMsg = 'Affiliate user registered successfully. Please wait for admin approval.';
        } else {
            successMsg = formMode === 'update'
                ? 'Affiliate user updated successfully!'
                : 'Affiliate user added successfully!';
        }
        $.ajax({
            url: $form.attr("action"),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            beforeSend: function () {
                submitButton.prop("disabled", true).text("Please wait...");
            },
            success: function (response) {
                if (response.success) {
                    iziToast.success({ title: 'Success', message: response.message || successMsg, position: 'topRight' });
                    submitButton.prop("disabled", false).text(buttonText);
                    setTimeout(function () {
                        window.location.href = '/admin/manage_affiliate_users';
                    }, 2000);
                } else {
                    iziToast.error({ title: 'Error', message: response.message || 'Something went wrong', position: 'topRight' });
                    submitButton.prop("disabled", false).text(buttonText);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    let stepToGo = 1;
                    let firstInvalidField = null;

                    $('#add_affiliate_user_form .is-invalid').removeClass('is-invalid');
                    $('.affiliate_step').removeClass('step-error');

                    function fieldToStep(field) {
                        if (['website_url', 'application_url'].includes(field)) return 2;
                        if (field === 'status') return 3;
                        return 1;
                    }

                    let stepsWithError = new Set();

                    if (Array.isArray(errors)) {
                        errors.forEach(function (msg) {
                            iziToast.error({ title: 'Error', message: msg, position: 'topRight' });
                        });
                    } else {
                        $.each(errors, function (field, messages) {
                            $.each(messages, function (i, msg) {
                                iziToast.error({ title: 'Error', message: msg, position: 'topRight' });
                            });
                            var $input = $('[name="' + field + '"]');
                            $input.addClass('is-invalid');
                            if (!firstInvalidField && $input.length) firstInvalidField = $input;
                            stepsWithError.add(fieldToStep(field));
                            if (fieldToStep(field) < stepToGo) stepToGo = fieldToStep(field);
                        });
                    }

                    stepsWithError.forEach(function (stepNum) {
                        $('.affiliate_step').eq(stepNum - 1).addClass('step-error');
                    });

                    goToStep(stepToGo);
                    if (firstInvalidField) firstInvalidField.focus();
                    submitButton.prop("disabled", false).text(buttonText);
                } else {
                    iziToast.error({ title: 'Error', message: 'Server error. Please try again.', position: 'topRight' });
                    submitButton.prop("disabled", false).text(buttonText);
                }
            }
        });
    });
});