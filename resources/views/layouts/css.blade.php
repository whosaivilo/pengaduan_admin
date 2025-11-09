{{-- Start CSS --}}
<!-- Font Awesome 6.5.2 (CDN Resmi) -->

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-pZ8pZKz0+KJ2Wf4ZlV+M8zO4qvQvcp4u8hK2sVY8LtAbKXhyI4ZXHjpmF0y70M2zKfWUJ2s7UXZtQy1C1N8X5A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
{{-- End CSS --}}


<!-- Include Font Awesome (FA5 compatible) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- Floating WhatsApp -->
<a href="https://wa.me/6281234567890?text=Halo%20Admin" target="_blank" class="floating-whatsapp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- CSS -->
<style>
.floating-whatsapp {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    padding: 15px;
    font-size: 24px;
    z-index: 100;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.floating-whatsapp:hover {
    background-color: #1ebe57;
}
</style>
