@props(['bodyClass'])

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Golden Red</title>

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- Google Material Icons -->

  <!-- DataTables + Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <!-- Estilos personalizados -->
  <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


  @stack('styles')
</head>

<body class="{{ $bodyClass }}">
  {{ $slot }}

  <!-- jQuery sin defer -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Core JS -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}" defer></script>
  <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.0') }}" defer></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Scrollbar personalizado -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
      }
    });
  </script>

  @stack('scripts')
</body>

</html>