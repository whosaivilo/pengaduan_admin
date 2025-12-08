{{--
  =>  Template Name    : DarkPan - Bootstrap 5 Admin Template

  =>  Template Link    : https://htmlcodex.com/bootstrap-5-admin-template

  =>  Template License : https://htmlcodex.com/license (or read the LICENSE.txt file)

  =>  Template Author  : HTML Codex

  =>  Author Website   : https://htmlcodex.com

  =>  About HTML Codex : HTML Codex is one of the top creators and publishers of Free HTML templates, HTML landing pages, HTML email templates and HTML snippets in the world. Read more at ( https://htmlcodex.com/about-us ) --}}

 {{-- => FREE HTML TEMPLATE LICENSE BY HTML Codex
 All free HTML templates by HTML Codex are licensed under a Creative Commons Attribution 4.0 International License which means you are not allowed to remove the author’s credit link/attribution link/backlink.
 When you download or use our free HTML templates, it will attribute the following conditions.
 => YOU ARE ALLOWED
      1. You are allowed to use for your personal and commercial purposes.
      2. You are allowed to modify/customize however you like.
      3. You are allowed to convert/port for use for any CMS.
      4. You are allowed to share/distribute under the HTML Codex brand name.
      5. You are allowed to put a screenshot or a link on your blog posts or any other websites.

 => YOU ARE NOT ALLOWED
      1. You are not allowed to remove the author’s credit link/attribution link/backlink without purchasing Credit Removal License ( https://htmlcodex.com/credit-removal ).
      2. You are not allowed to sell, resale, rent, lease, license, or sub-license.
      3. You are not allowed to upload on your template websites or template collection websites or any other third party websites without our permission.
 This license can be terminated if you breach any of these conditions.

 Please contact us (https://htmlcodex.com/contact) if you have any query.

 => PURCHASE CREDIT REMOVAL LICENSE ( https://htmlcodex.com/credit-removal )
  --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title_page', 'Dashboard')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">



    {{-- CSS Start --}}
    @include('layouts.css')
    {{-- CSS End --}}

</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        @include('layouts.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('layouts.navbar')
            <!-- Navbar End -->

            {{-- Tampilkan Flash Data di bagian atas halaman (Wajib Tugas) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- Main Content Wrapper --}}
            <div class="container-fluid pt-3 pb-4">
                @yield('content')
            </div>

            <div class="container-fluid px-4">
                @include('layouts.footer')
            </div>
        </div>
        <!-- Content End -->
    </div>

    {{-- js start --}}
    <!-- JavaScript Libraries -->
    @include('layouts.js')
    {{-- js end --}}
</body>

</html>
