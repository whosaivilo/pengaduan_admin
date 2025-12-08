<div class="bg-secondary rounded-top p-4">
    <div class="row">

        {{-- Bagian Kiri: Copyright --}}
        <div class="col-12 col-sm-6 text-center text-sm-start">
            &copy; <a href="#">Project Bina Desa</a>. All Rights Reserved.
        </div>

        {{-- Bagian Kanan: Kredit Template --}}
        <div class="col-12 col-sm-6 text-center text-sm-end">
            Designed By
            <a href="https://htmlcodex.com" target="_blank">HTML Codex</a>
        </div>

        <hr class="my-3">

        {{-- Identitas Pengembang --}}
        <div class="col-12 text-center mt-3">

            {{-- Foto Pengembang --}}
            <img src="{{ asset('assets/img/foto.jpg') }}"
                 alt="Foto Pengembang"
                 style="width:100px; height:100px; object-fit:cover; border-radius:50%; margin-bottom:10px;">

            <h5 class="mt-2 mb-1">Theresa Olivia</h5>
            <p class="mb-1">NIM: 2457301144 • Sistem Informasi</p>

            {{-- Social Icons --}}
            <div class="d-flex justify-content-center gap-3 mt-2">

                <a href="https://www.linkedin.com/in/theresa-olivia-848608330/"
                   target="_blank">
                    <img src="{{ asset('assets/img/linkedin.png') }}"
                         alt="LinkedIn"
                         style="width:28px;">
                </a>

                <a href="https://github.com/whosaivilo"
                   target="_blank">
                    <img src="{{ asset('assets/img/github-sign.png') }}"
                         alt="GitHub"
                         style="width:28px; filter: invert(1);">
                </a>

                <a href="https://instagram.com/theresaolivia_"
                   target="_blank">
                    <img src="{{ asset('assets/img/instagram.png') }}"
                         alt="Instagram"
                         style="width:28px;">
                </a>

            </div>
        </div>

    </div>
</div>
