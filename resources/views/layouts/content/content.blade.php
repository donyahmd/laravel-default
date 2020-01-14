<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('title', 'unknown_page')
        <small>@yield('description', 'unknown_description')</small>
    </h1>

    <!-- =============================================== -->
    @include('layouts.content.breadcrumb')
    <!-- =============================================== -->

</section>

<!-- Main content -->
<section class="content">

    <!-- =============================================== -->
    @include('layouts.content.error')
    <!-- =============================================== -->

    <!-- =============================================== -->
    @yield('content', 'content')
    <!-- =============================================== -->

</section>
<!-- /.content -->
