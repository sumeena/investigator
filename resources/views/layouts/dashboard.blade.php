<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
      data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard|Admin</title>

    <meta name="description" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('html/assets/img/favicon/favicon.ico') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('html/assets/vendor/fonts/boxicons.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('html/assets/vendor/css/core.css') }}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{ asset('html/assets/vendor/css/theme-default.css') }}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('html/assets/css/demo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('html/assets/css/custom.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('html/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>

    <link rel="stylesheet" href="{{ asset('html/assets/vendor/libs/apex-charts/apex-charts.css') }}"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
    <!-- Page CSS -->

    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('html/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('html/assets/js/config.js') }}"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('dashboard.leftbar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('dashboard.navbar')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                @yield('content')
                <!-- / Content -->

                <!-- Footer -->
                @include('dashboard.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('html/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('html/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('html/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('html/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('html/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('html/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('html/assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('html/assets/js/dashboards-analytics.js') }}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="//buttons.github.io/buttons.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function () {
        $('.multipleselect').selectpicker();
    });
</script>
<script type="text/javascript">

    function toggleInsurance() {
        $(".dl-insurance").each(function () {
            // get data index from attribute
            let licenseIndex = $(this).data('license-index');
            let toggleInput  = $('.upload-insurance-file[data-license-index="' + licenseIndex + '"]');

            if ($(this).is(":checked")) {
                toggleInput.show();
            } else {
                toggleInput.hide();
            }
        });

        // table header show/hide
        if ($('.dl-insurance:checked').length > 0) {
            $(".td-upload-insurance-file").show();
        } else {
            $(".td-upload-insurance-file").hide();
        }
    }

    function toggleBonded() {
        $(".dl-bounded").each(function () {
            // get data index from attribute
            let licenseIndex = $(this).data('license-index');
            let toggleInput  = $('.upload-bounded-file[data-license-index="' + licenseIndex + '"]');

            if ($(this).is(":checked")) {
                toggleInput.show();
            } else {
                toggleInput.hide();
            }
        });

        // table header show/hide
        if ($('.dl-bounded:checked').length > 0) {
            $(".td-upload-bounded-file").show();
        } else {
            $(".td-upload-bounded-file").hide();
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        toggleInsurance();
        toggleBonded();

        let licensesRowLength = $('.licensing tbody tr').length;
        $(".licensing_row").click(function () {
            // get options from select and remove selected attribute
            let selectOptions = $(".investigator_profile_state").html();
            $('.licensing tr:last').after(`<tr><td><select class="form-select investigator_profile_state" name="licenses[${licensesRowLength}][state]">${selectOptions}</select></td> <td><input type="text" class="form-control" name="licenses[${licensesRowLength}][license_number]"> </td><td><input class="form-control" type="date" name="licenses[${licensesRowLength}][expiration_date]"></td><td><input class="form-check-input dl-insurance" type="checkbox" value="1" name="licenses[${licensesRowLength}][is_insurance]" data-license-index="${licensesRowLength}"></td><td class="upload-insurance-file" data-license-index="${licensesRowLength}"><input
             class="form-control investigator_insurance_picture" type="file" accept=".png, .jpg, .jpeg" name="licenses[${licensesRowLength}][insurance_file]"></td><td><input class="form-check-input dl-bounded" type="checkbox" value="1" name="licenses[${licensesRowLength}][is_bonded]" data-license-index="${licensesRowLength}"></td><td class="upload-bounded-file" data-license-index="${licensesRowLength}"><input class="form-control investigator_bonded_picture" type="file" accept=".png, .jpg, .jpeg" name="licenses[${licensesRowLength}][bonded_file]"></td><td><button type="button" class="btn btn-primary licensing_row_remove">Remove</button></td></tr>`);

            $('select[name="licenses[' + licensesRowLength + '][state]"] option:selected').removeAttr('selected');

            toggleInsurance();
            toggleBonded();

            licensesRowLength++;
        });

        let workVehicleRowLength = $('.workvehicle tbody tr').length + 1;
        $(".workvehicle_row").click(function () {
            $('.workvehicle tr:last').after(`<tr><td><input type="text" class="form-control investigator_profile_vechile_year" name="work_vehicles[${workVehicleRowLength}][year]"></td> <td><input type="text" class="form-control investigator_profile_vechile_make" name="work_vehicles[${workVehicleRowLength}][make]"></td><td><input class="form-control investigator_profile_vechile_model" type="text" name="work_vehicles[${workVehicleRowLength}][model]"></td><td><input class="form-control" type="text"  name="work_vehicles[${workVehicleRowLength}][insurance_company]"></td><td><input class="form-control" type="text" name="work_vehicles[${workVehicleRowLength}][policy_number]"></td><td><input class="form-control" type="date" name="work_vehicles[${workVehicleRowLength}][expiration_date]"></td><td><input class="form-control investigator_profile_picture" type="file" name="work_vehicles[${workVehicleRowLength}][picture]"></td><td><input class="form-control investigator_profile_proof_of_insurance" type="file" name="work_vehicles[${workVehicleRowLength}][proof_of_insurance]"></td><td><button type="button" class="btn btn-primary workvehicle_row_remove">Remove</button></td></tr>`);

            workVehicleRowLength++;
        });

        let hrContactRowLength = $('.hr_contact tbody tr').length + 1;
        $(".hr_contact_row").click(function () {
            $('.hr_contact tr:last').after(`<tr><td><input type="text" class="form-control" name="contact[${hrContactRowLength}][contact_title]"></td><td><input class="form-control" type="text" name="contact[${hrContactRowLength}][contact_name]"></td><td><input class="form-control" type="text"  name="contact[${hrContactRowLength}][contact_phone]"></td><td><input class="form-control" type="text" name="contact[${hrContactRowLength}][contact_email]"></td><td><button type="button" class="btn btn-primary hr_contact_row_remove">Remove</button></td></tr>`);
            hrContactRowLength++;
        });


        let languagesRowLength = $('.languages tbody tr').length + 1;
        $(".languages_row").click(function () {
            let selectOptions = $(".language-select").html();
            $('.languages tr:last').after(`<tr><td><select id="defaultSelect" class="form-select" name="languages[${languagesRowLength}][language]">${selectOptions}</select></td><td><select id="defaultSelect" class="form-select" name="languages[${languagesRowLength}][fluency]"><option value="">--select--</option><option value="1">Beginner to Conversational</option><option value="2">Moderate to Fluent</option></select></td><td><select id="defaultSelect" class="form-select" name="languages[${languagesRowLength}][writing_fluency]"><option value="">--select--</option><option value="1">Conversational</option><option value="2">Fluent</option></select></td><td><button type="button" class="btn btn-primary languages_row_remove">Remove</button></td></tr>`);

            $('select[name="languages[' + languagesRowLength + '][language]"] option:selected').removeAttr('selected');

            languagesRowLength++;
        });

        $(".licensing").on('click', '.licensing_row_remove', function () {
            $(this).closest('tr').remove();
            licensesRowLength--;
        });

        $(".workvehicle").on('click', '.workvehicle_row_remove', function () {
            $(this).closest('tr').remove();
            workVehicleRowLength--;
        });

        $(".hr_contact").on('click', '.hr_contact_row_remove', function () {
            $(this).closest('tr').remove();
            hrContactRowLength--;
        });

        $(".languages").on('click', '.languages_row_remove', function () {
            $(this).closest('tr').remove();
            languagesRowLength--;
        });

        const dlInsurance = $(".dl-insurance");
        const dlBounded   = $(".dl-bounded");

        $(document).on('change', dlInsurance, function () {
            toggleInsurance();
        });

        $(document).on('change', dlBounded, function () {
            toggleBonded();
        });

    });
</script>

@stack('scripts')
</body>
</html>
