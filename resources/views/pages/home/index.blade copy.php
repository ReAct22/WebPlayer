@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <!-- Hamburger Menu -->
    <div class="hamburger">
        <button class="btn btn-outline-dark" onclick="toggleSelect()">
            ☰
        </button>
        <select id="categorySelect" class="form-select mt-2" onchange="loadPlaylist()">
            <option value="">Pilih Kategori</option>
        </select>
    </div>
    <div class="container mt-5">
        <div class="row">
            <!-- Carousel utama -->
            <div class="col-md-8">
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselContent">
                        <div class="carousel-item active">
                            <h5>Judul</h5>
                            <p>Deskripsi</p>
                            <video class="d-block w-100" autoplay controls>
                                <source src="" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Playlist Thumbnail -->
            <div class="col-md-3">
                <h5>Playlist</h5>
                <div id="playlist" class="d-flex flex-column gap-2"></div>
            </div>
        </div>
    </div>


@endsection
@push('script-home')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('{{url("api/categoris")}}')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('categorySelect');
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id // atau gunakan category.id jika ingin pakai ID
                        option.textContent = category.nama;
                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Gagal memuat kategori:', error);
                });
        });

        function loadPlaylist() {
            const selected = document.getElementById('categorySelect').value;
            console.log("Kategori dipilih:", selected);
            // Tambahkan logic selanjutnya untuk memuat playlist
        }
    </script>
    <script>
        let playlists = {}; // Akan diisi dari API
        // Panggil API untuk load data
        fetch('{{url("api/playlist")}}')
            .then(response => response.json())
            .then(data => {
                console.log(data)
                // Group data berdasarkan category_id
                playlists = data.reduce((grouped, item) => {
                    const category = `category_${item.category_id}`; // bisa diganti ke nama jika perlu
                    console.log(category)
                    if (!grouped[category]) {
                        grouped[category] = [];
                    }
                    grouped[category].push({
                        type: item.type,
                        src: 'storage/' + item.video // asumsi file video/image ada di public/
                    });
                    return grouped;
                }, {});
            });

        // console.log(playlists)

        function toggleSelect() {
            const select = document.getElementById("categorySelect");
            select.style.display = select.style.display === "block" ? "none" : "block";
        }

        function loadPlaylist() {
            const categoryId = document.getElementById("categorySelect").value;
            // console.log(categoryId)
            const playlist = document.getElementById("playlist");
            playlist.innerHTML = "";

            const categoryKey = `category_${categoryId}`;
            if (!categoryId || !playlists[categoryKey]) return;

            playlists[categoryKey].forEach((item) => {
                const thumb = document.createElement(item.type === 'video' ? 'video' : 'img');
                thumb.src = item.src;
                thumb.className = "img-fluid playlist-thumbnail";
                if (item.type === 'video') {
                    thumb.controls = true;
                }
                thumb.onclick = () => changeMainMedia(item);
                playlist.appendChild(thumb);
            });
        }

        function changeMainMedia(item) {
            const carouselContent = document.getElementById("carouselContent");
            const active = carouselContent.querySelector(".carousel-item.active");
            if (active) active.classList.remove("active");

            const newItem = document.createElement("div");
            newItem.className = "carousel-item active";

            if (item.type === 'video') {
                const video = document.createElement("video");
                video.className = "d-block w-100";
                video.controls = true;
                video.innerHTML = `<source src="${item.src}" type="video/mp4">Browser Anda tidak mendukung video.`;
                newItem.appendChild(video);
            } else {
                const img = document.createElement("img");
                img.src = item.src;
                img.className = "d-block w-100";
                newItem.appendChild(img);
            }

            carouselContent.appendChild(newItem);
        }
    </script>
@endpush
