<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/dist/angularjs1.6.1/angular.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/dist/bootstrap-table/dist/bootstrap-table.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/dist/sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>
