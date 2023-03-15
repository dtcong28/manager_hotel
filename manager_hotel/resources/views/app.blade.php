<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="description" content="Responsive Admin Template" />
    <meta name="author" content="SmartUniversity" />
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Included in every pages -->

    <!--bootstrap -->
    <link href="{{ asset('backend') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Material Design Lite CSS -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/material/material.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/material_style.css">
    <!-- data tables -->
    <link href="{{ asset('backend') }}/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <!-- animation -->
    <link href="{{ asset('backend') }}/assets/css/pages/animate_page.css" rel="stylesheet">
    <!-- Template Styles -->
    <link href="{{ asset('backend') }}/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/theme-color.css" rel="stylesheet" type="text/css" />

    <!-- End included in every pages -->

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="{{ asset('backend') }}/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('backend') }}/assets/img/favicon.ico"/>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<!-- END HEAD -->

@inertia

<!-- Included in every pages -->

<!-- start js include path -->
<script src="{{ asset('backend') }}/assets/plugins/jquery/jquery.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/popper/popper.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/jquery-blockui/jquery.blockui.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- bootstrap -->
{{--<script src="{{ asset('backend') }}/assets/plugins/bootstrap/js/bootstrap.min.js" ></script>--}}

{{--<!-- Common js-->--}}
{{--<script src="{{ asset('backend') }}/assets/js/app.js" ></script>--}}
{{--<script src="{{ asset('backend') }}/assets/js/layout.js" ></script>--}}
{{--<script src="{{ asset('backend') }}/assets/js/theme-color.js" ></script>--}}

{{--<!-- data tables -->--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/datatables/jquery.dataTables.min.js" ></script>--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap4.min.js" ></script>--}}
{{--<script src="{{ asset('backend') }}/assets/js/pages/table/table_data.js" ></script>--}}

{{--<!-- material -->--}}
{{--<script src="{{ asset('backend') }}/assets/plugins/material/material.min.js"></script>--}}
{{--<script src="{{ asset('backend') }}/assets/js/pages/material_select/getmdl-select.js" ></script>--}}
{{--<script  src="{{ asset('backend') }}/assets/plugins/material-datetimepicker/moment-with-locales.min.js"></script>--}}
{{--<script  src="{{ asset('backend') }}/assets/plugins/material-datetimepicker/bootstrap-material-datetimepicker.js"></script>--}}
{{--<script  src="{{ asset('backend') }}/assets/plugins/material-datetimepicker/datetimepicker.js"></script>--}}
{{--<!-- animation -->--}}
{{--<script src="{{ asset('backend') }}/assets/js/pages/ui/animations.js" ></script>--}}

<!-- End included in every pages -->

</html>
