<!DOCTYPE html>
<html lang="en">
    <head>
        @include('Admin.layouts.head')
    </head>
<body>
    <div class="container">
        <!-- Sidebar -->
        @include('Admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            @include('Admin.layouts.header')
            <!-- Content -->
            @yield('content')
        </div>
        
    </div>
    <!-- Modal -->
    @yield('modal')
</body>
<footer>
    @include('Admin.layouts.footer')
</footer>
</html>