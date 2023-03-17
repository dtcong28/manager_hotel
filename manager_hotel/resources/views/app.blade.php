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

    <link href="{{ asset('backend') }}/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />

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

</html>
