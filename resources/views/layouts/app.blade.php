@props(['header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config(key: 'eSima', default: 'eSima | Sistem Management Arsip') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    /* Sidebar Styles */
    .app-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 250px;
        background: #2f3542;
        padding: 1rem;
        overflow-y: auto;
    }

    /* Main Content Styles */
    .main-content {
        margin-left: 250px;
        padding: 2rem;
    }

    /* Card Styles */
    .card {
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .counter-icon {
        padding: 1.2rem;
        border-radius: 50%;
        text-align: center;
        margin-bottom: 1rem;
    }

    .bg-primary-gradient {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .bg-success-gradient {
        background: linear-gradient(45deg, #1cc88a, #13855c);
    }

    .bg-info-gradient {
        background: linear-gradient(45deg, #36b9cc, #258391);
    }

    .bg-warning-gradient {
        background: linear-gradient(45deg, #f6c23e, #dda20a);
    }

    /* Table Styles */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Utility Classes */
    .box-shadow-primary {
        box-shadow: 0 0 10px rgba(78, 115, 223, 0.3);
    }

    .box-shadow-success {
        box-shadow: 0 0 10px rgba(28, 200, 138, 0.3);
    }

    .box-shadow-info {
        box-shadow: 0 0 10px rgba(54, 185, 204, 0.3);
    }

    .box-shadow-warning {
        box-shadow: 0 0 10px rgba(246, 194, 62, 0.3);
    }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="app-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    
    <!-- Initialize Bootstrap components -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enable Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
            
            // Enable Bootstrap collapse
            var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'));
            var collapseList = collapseElementList.map(function (collapseEl) {
                return new bootstrap.Collapse(collapseEl, {
                    toggle: false
                });
            });
            
            // Handle sidebar dropdown toggle
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    // Close other open dropdowns
                    var openDropdowns = document.querySelectorAll('.collapse.show');
                    openDropdowns.forEach(function(dropdown) {
                        if (dropdown.id !== this.getAttribute('href').substring(1)) {
                            var bsCollapse = bootstrap.Collapse.getInstance(dropdown);
                            if (bsCollapse) {
                                bsCollapse.hide();
                            }
                        }
                    }.bind(this));
                });
            });
        });
    </script>
</body>

</html>
