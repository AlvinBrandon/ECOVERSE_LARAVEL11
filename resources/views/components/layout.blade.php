<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
@props(['bodyClass'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png">
    <title>
        Ecoverse 
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>
<body class="{{ $bodyClass }}">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-navbars.navs.guest signup="register" signin="login" />
            </div>
        </div>
    </div>

    <!-- Check if this is a page with sidebar by looking for g-sidenav-show class -->
    @if(str_contains($bodyClass ?? '', 'g-sidenav-show'))
        <!-- For pages with sidebar, wrap content with proper margin compensation -->
        <div class="main-content-wrapper">
            {{ $slot }}
        </div>
        
        <!-- Add responsive CSS for mobile -->
        <style>
            /* Main content wrapper for sidebar compensation */
            .main-content-wrapper {
                transition: margin-left 0.3s ease;
            }
            
            /* When sidebar is pinned (normal state) */
            .g-sidenav-show .main-content-wrapper {
                margin-left: 280px;
            }
            
            /* When sidebar is hidden/collapsed */
            .g-sidenav-hidden .main-content-wrapper {
                margin-left: 0;
            }
            
            /* Responsive behavior */
            @media (max-width: 1199.98px) {
                .main-content-wrapper {
                    margin-left: 0 !important;
                }
            }
            
            /* Mobile devices */
            @media (max-width: 767.98px) {
                .main-content-wrapper {
                    margin-left: 0 !important;
                    padding-top: 1rem;
                }
            }
            
            /* Extra margin compensation for Material Dashboard styles */
            .g-sidenav-show.bg-gray-200 .main-content-wrapper {
                margin-left: 280px;
            }
        </style>
    @else
        <!-- For pages without sidebar, render content normally -->
        {{ $slot }}
    @endif

    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
    @stack('js')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>
    // ...existing code...

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- ...existing navbar code... -->
    <button id="darkModeToggle" class="btn btn-outline-secondary ms-auto" type="button">
        🌙 Dark Mode
    </button>
</nav>

<style>
    body.dark-mode {
        background-color: #181a1b !important;
        color: #e0e0e0 !important;
    }
    .dark-mode .navbar,
    .dark-mode .card,
    .dark-mode .modal-content {
        background-color: #23272b !important;
        color: #e0e0e0 !important;
    }
    .dark-mode table {
        background-color: #23272b !important;
        color: #e0e0e0 !important;
    }
    .dark-mode .btn {
        border-color: #444 !important;
        background-color: #333 !important;
        color: #e0e0e0 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('darkModeToggle');
        const body = document.body;
        if (localStorage.getItem('darkMode') === 'enabled') {
            body.classList.add('dark-mode');
        }
        toggle.addEventListener('click', function () {
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('darkMode', 'enabled');
            } else {
                localStorage.setItem('darkMode', 'disabled');
            }
        });
    });
</script>

</body>
</html>
