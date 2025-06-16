@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <button class="btn btn-primary m-3 float-end" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
        aria-controls="offcanvasRight" onclick="toggleSelect()">☰</button>


    <div class="container mt-0">
        <div class="row">
            <div
                style="position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center">
                <div id="carouselColumn" class="col-md-12">
                    <div id="mainCarousel" class="carousel slide">
                        <div class="carousel-inner" id="carouselContent">
                            <!-- Item akan di-load secara dinamis -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Carousel -->


            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Playlist</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Control sidebar content goes here -->
                    {{-- <h5>Pilih Kategori</h5> --}}
                    <select id="categorySelect" class="form-control" class="form-select mt-2" onchange="loadPlaylist()">
                        <option value="">Pilih Kategori</option>
                    </select>


                    {{-- <h5>Playlist</h5> --}}
                    <div id="playlistContainer">
                        <div id="playlist" class="d-flex flex-column gap-2 mt-2">
                            <!-- Item playlist akan tampil di sini -->
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <h5>Pilih Kategori</h5>
                <select id="categorySelect" class="form-select mt-2" onchange="loadPlaylist()">
                    <option value="">Pilih Kategori</option>
                </select>

                <h5>Playlist</h5>
                <div id="playlistContainer">
                    <div id="playlist" class="d-flex flex-column gap-2 mt-2">
                        <!-- Item playlist akan tampil di sini -->
                    </div>
                </div>

            </aside> --}}

        </div>
    </div>

@endsection

@push('script-home')
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const playlistContainer = document.getElementById("playlistContainer");

            const playlistColumn = document.getElementById("playlistColumn");

            const carouselColumn = document.getElementById("carouselColumn");

            document.getElementById("togglePlaylistBtn").addEventListener("click", function() {
                if (playlistContainer.style.display === "none") {
                    // Tampilkan Playlist
                    playlistContainer.style.display = "block";
                    this.textContent = "Sembunyikan Playlist";

                    // Kembalikan ukuran carousel
                    carouselColumn.classList.remove("col-md-12");

                    carouselColumn.classList.add("col-md-8");

                    playlistColumn.classList.remove("d-none");

                } else {
                    // Sembunyikan Playlist
                    playlistContainer.style.display = "none";
                    this.textContent = "Tampilkan Playlist";

                    // Perluas ukuran carousel
                    carouselColumn.classList.remove("col-md-8");

                    carouselColumn.classList.add("col-md-12");

                    playlistColumn.classList.add("d-none");

                }
            });

            // Kode yang lain sesuai yang Anda punya...
        });
    </script> --}}

    <script>
        let playlists = {};
        // let playlists = {};

        document.addEventListener("DOMContentLoaded", function() {
            // Loading daftar kategori
            fetch('{{ url('api/categoris') }}')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('categorySelect');
                    let penyakitId = null;

                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.nama;

                        select.appendChild(option);

                        // Cek apakah nama nya Penyakit Lain
                        if (category.nama === "Penyakit Lain-lainnya") {
                            penyakitId = category.id;
                        }
                    });

                    // Setelah daftar kategori dan playlist terload, tampilakan penyakit lain
                    fetch('{{ url('api/playlist') }}')
                        .then(response => response.json())
                        .then(data => {
                            playlists = data.reduce((grouped, item) => {
                                const category = `category_${item.category_id}`;

                                if (!grouped[category]) {
                                    grouped[category] = [];
                                }

                                grouped[category].push({
                                    type: item.type,
                                    src: 'storage/' + item.video,
                                    judul: item.judul,
                                    deskripsi: item.deskripsi,
                                    thumb: item.thumbnail ? 'storage/' + item.thumbnail :
                                        "{{ asset('images/images.jpg') }}"
                                });

                                return grouped;
                            }, {});

                            // Setelah playlists siap, tampilkan penyakit lain
                            if (penyakitId) {
                                select.value = penyakitId;
                                loadPlaylist();
                            }
                        })
                        .catch(error => console.error('Gagal memuat playlist!', error));

                })
                .catch(error => console.error('Gagal memuat kategori!', error));

        });


        // sisanya sesuai yang Anda punya...


        function toggleSelect() {
            const select = document.getElementById("categorySelect");

            select.style.display = 'block';

        }

        function loadCarouselWithAllItems(items) {
            const carousel = document.querySelector("#carouselContent").closest('.carousel');
            const carouselContent = document.getElementById("carouselContent");

            // Bersihkan dahulu
            carouselContent.innerHTML = "";

            items.forEach((item, index) => {
                const newItem = document.createElement("div");

                newItem.className = "carousel-item";

                if (index === 0) newItem.classList.add("active");

                // Media (Video/Foto) di tengah
                if (item.type === 'video') {
                    const video = document.createElement("video");

                    video.className = "d-block w-100";

                    video.controls = true;

                    video.autoplay = (index === 0);

                    video.innerHTML = `
                <source src="${item.src}" type="video/mp4">
                Browser Anda tidak mendukung video.
            `;

                    // Saat video mulai diputar -> pause carousel
                    video.addEventListener("play", () => {
                        if (carousel) {
                            new bootstrap.Carousel(carousel).pause();
                        }
                    });

                    // Saat video diberhentikan -> resume carousel
                    video.addEventListener("pause", () => {
                        if (carousel) {
                            new bootstrap.Carousel(carousel).pause();
                        }
                    });

                    // Saat video selesai -> pindah ke slide selanjutnya
                    video.addEventListener("ended", () => {
                        if (carousel) {
                            new bootstrap.Carousel(carousel).next();
                        }
                    });

                    newItem.appendChild(video);
                } else {
                    // Gambar
                    const img = document.createElement("img");

                    img.src = item.src;

                    img.className = "d-block w-100";

                    newItem.appendChild(img);
                }

                carouselContent.appendChild(newItem);
            });

            // Setelah diberi item, inisialisasi carousel
            const carouselInit = new bootstrap.Carousel(carousel, {
                interval: false,
                ride: false,
                wrap: true
            });

            // Mainkan video saat slide berganti
            carousel.addEventListener('slid.bs.carousel', (event) => {
                // Hentikan dahulu video yang tengah berjalan
                const previous = event.from;
                const prevVideo = carouselContent.children[previous]?.querySelector("video");

                if (prevVideo && !prevVideo.paused) {
                    prevVideo.pause();
                }

                // Mainkan video yang aktif
                const active = event.to;
                const activeVideo = carouselContent.children[active]?.querySelector("video");

                if (activeVideo) {
                    activeVideo.play().catch((err) => console.error(err)); // kadang autoplay diblock browser
                } else {
                    // Kalau bukan video (gambar), maka pindah setelah 10 menit
                    setTimeout(function() {
                        new bootstrap.Carousel(carousel).next();
                    }, 10000);
                }
            });

            // Jika slide pertama bukan video, juga diberi timeout
            if (items.length > 0 && items[0].type !== 'video') {
                setTimeout(function() {
                    new bootstrap.Carousel(carousel).next();
                }, 10000);
            }
        }





        function loadPlaylist() {
            const categoryId = document.getElementById("categorySelect").value;

            const playlist = document.getElementById("playlist");

            playlist.innerHTML = ""; // Bersihkan dahulu

            const categoryKey = `category_${categoryId}`;

            if (!categoryId || !playlists[categoryKey]) return;

            // Tampilkan daftar media di sebelah
            playlists[categoryKey].forEach((item, index) => {
                console.log(item.thumb)
                // Wrapper untuk thumbnail + judul
                const wrapper = document.createElement("div");

                wrapper.className = "d-flex align-items-center mb-2";

                let thumb;

                if (item.type === "video") {
                    thumb = document.createElement("img");

                    thumb.src = item.thumb;

                    thumb.className = "img-fluid playlist-thumbnail me-2";

                    thumb.alt = item.title ? item.title : "thumbnail video";

                } else {
                    thumb = document.createElement("img");

                    thumb.src = item.src;

                    thumb.className = "img-fluid playlist-thumbnail me-2";

                    thumb.alt = item.title ? item.title : "thumbnail foto";

                }

                // Judul video
                const title = document.createElement("span");

                // title.textContent = item.judul ? item.judul : "Tanpa judul";

                title.className = "playlist-title";

                // Tambahan event click
                wrapper.addEventListener("click", () => {
                    // Pindah ke slide yang sesuai
                    new bootstrap.Carousel(
                        document.querySelector("#carouselContent").closest('.carousel')
                    ).to(index);
                });

                wrapper.appendChild(thumb);
                wrapper.appendChild(title);
                playlist.appendChild(wrapper);
            });

            // Langsung tampil di carousel
            loadCarouselWithAllItems(playlists[categoryKey]);

        }
    </script>
@endpush
