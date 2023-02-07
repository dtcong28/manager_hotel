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
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css" />
    <!-- icons -->
    <link href="{{ asset('backend') }}/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!--bootstrap -->
    <link href="{{ asset('backend') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/plugins/summernote/summernote.css" rel="stylesheet">
    <!-- morris chart -->
    <link href="{{ asset('backend') }}/assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- Material Design Lite CSS -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/material/material.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/material_style.css">
    <!-- animation -->
    <link href="{{ asset('backend') }}/assets/css/pages/animate_page.css" rel="stylesheet">
    <!-- Template Styles -->
    <link href="{{ asset('backend') }}/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend') }}/assets/css/theme-color.css" rel="stylesheet" type="text/css" />
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('backend') }}/assets/img/favicon.ico" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<!-- END HEAD -->
<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white dark-sidebar-color logo-dark">

@inertia

<!-- start js include path -->
<script src="{{ asset('backend') }}/assets/plugins/jquery/jquery.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/popper/popper.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/jquery-blockui/jquery.blockui.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- bootstrap -->
<script src="{{ asset('backend') }}/assets/plugins/bootstrap/js/bootstrap.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/sparkline/jquery.sparkline.min.js" ></script>
<script src="{{ asset('backend') }}/assets/js/pages/sparkline/sparkline-data.js" ></script>
<!-- Common js-->
<script src="{{ asset('backend') }}/assets/js/app.js" ></script>
<script src="{{ asset('backend') }}/assets/js/layout.js" ></script>
<script src="{{ asset('backend') }}/assets/js/theme-color.js" ></script>
<!-- material -->
<script src="{{ asset('backend') }}/assets/plugins/material/material.min.js"></script>
<!-- animation -->
<script src="{{ asset('backend') }}/assets/js/pages/ui/animations.js" ></script>
<!-- morris chart -->
<script src="{{ asset('backend') }}/assets/plugins/morris/morris.min.js" ></script>
<script src="{{ asset('backend') }}/assets/plugins/morris/raphael-min.js" ></script>
<script src="{{ asset('backend') }}/assets/js/pages/chart/morris/morris_home_data.js" ></script>
<!-- end js include path -->
</body>
</html>
