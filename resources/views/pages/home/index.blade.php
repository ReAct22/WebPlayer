@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <!-- Hamburger Menu -->
    <div class="hamburger">
        <button class="btn btn-outline-dark" onclick="toggleSelect()">☰</button>
        <select id="categorySelect" class="form-select mt-2" onchange="loadPlaylist()">
            <option value="">Pilih Kategori</option>
        </select>
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Carousel -->
            <div class="col-md-8">
                <div id="mainCarousel" class="carousel slide">
                    <div class="carousel-inner" id="carouselContent">
                        <!-- Item akan di-load secara dinamis -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>
            </div>

            <!-- Playlist Thumbnail -->
            <div class="col-md-4">
                <h5>Playlist</h5>
                <div id="playlist" class="d-flex flex-column gap-2 mt-2">
                    <!-- Item playlist akan tampil di sini -->
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script-home')
<script>
    let playlists = {};

    document.addEventListener("DOMContentLoaded", function() {
        // Loading daftar kategori
        fetch('{{ url('api/categoris') }}')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('categorySelect');
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.nama;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Gagal memuat kategori!', error));

        // Loading playlist
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
                        deskripsi: item.deskripsi
                    });

                    return grouped;
                }, {});
            })
            .catch(error => console.error('Gagal memuat playlist!', error));

    });

    function toggleSelect(){
        const select = document.getElementById("categorySelect");

        select.style.display = select.style.display === "block" ? "none" : "block";

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

            // Judul di atas
            if (item.judul) {
                const title = document.createElement("h5");

                title.textContent = item.judul;

                title.className = "media-title mb-2";

                newItem.appendChild(title);
            }

            // Media (Video/Foto) di tengah
            if (item.type === 'video') {
                const video = document.createElement("video");

                video.className = "d-block w-100";

                video.controls = true;

                video.autoplay = (index === 0);
                // video.muted = true;

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

                video.addEventListener("ended", () => {
                    if (carousel) {
                        new bootstrap.Carousel(carousel).pause();
                    }
                });

                newItem.appendChild(video);
            } else {
                const img = document.createElement("img");

                img.src = item.src;

                img.className = "d-block w-100";

                newItem.appendChild(img);
            }

            // Deskripsi di bawah
            if (item.deskripsi) {
                const desc = document.createElement("p");

                desc.textContent = item.deskripsi;

                desc.className = "media-description mt-2";

                newItem.appendChild(desc);
            }

            carouselContent.appendChild(newItem);
        });

        // Setelah diberi item, inisialisasi carousel TANPA autoplay
        new bootstrap.Carousel(carousel, {
            interval: false,
            ride: false,
            wrap: true
        });
    }

    function loadPlaylist(){
        const categoryId = document.getElementById("categorySelect").value;

        const playlist = document.getElementById("playlist");

        playlist.innerHTML = ""; // Bersihkan dahulu

        const categoryKey = `category_${categoryId}`;

        if (!categoryId || !playlists[categoryKey]) return;

        // Tampilkan daftar media di sebelah
        playlists[categoryKey].forEach((item) => {
            const thumb = document.createElement(item.type === 'video' ? 'video' : 'img');
            thumb.src = item.src;
            thumb.className = "img-fluid playlist-thumbnail";

            if (item.type === 'video') {
                thumb.controls = true;
            }

            playlist.appendChild(thumb);
        });

        // Langsung tampil di carousel
        loadCarouselWithAllItems(playlists[categoryKey]);

    }

</script>
@endpush
