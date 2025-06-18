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
                        <button class="carousel-control-prev text-dark" type="button" data-bs-target="#mainCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                        </button>
                        <button class="carousel-control-next text-dark" type="button"
                            data-bs-target="#mainCarousel"data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>

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
    <script>
        let playlists = {};

        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById('categorySelect');
            let penyakitId = null;

            // Tambah opsi default "Semua"
            const allOption = document.createElement('option');
            allOption.value = 'all';
            allOption.textContent = 'Semua';
            select.appendChild(allOption);

            // Ambil kategori dari API
            fetch('{{ url('api/categoris') }}')
                .then(response => response.json())
                .then(data => {
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.nama;
                        select.appendChild(option);

                        if (category.nama === "Penyakit Lain-lainnya") {
                            penyakitId = category.id;
                        }
                    });

                    // Setelah kategori dimuat, ambil playlist
                    fetch('{{ url('api/playlist') }}')
                        .then(response => response.json())
                        .then(data => {
                            playlists = data.reduce((grouped, item) => {
                                const category = `category_${item.category_id}`;
                                if (!grouped[category]) grouped[category] = [];

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

                            // Tampilkan semua item default
                            select.value = "all";
                            loadPlaylist();
                        })
                        .catch(error => console.error('Gagal memuat playlist!', error));
                })
                .catch(error => console.error('Gagal memuat kategori!', error));
        });

        function toggleSelect() {
            const select = document.getElementById("categorySelect");
            select.style.display = 'block';
        }

        function getAllItemsFromAllCategories() {
            const allItems = [];
            for (const key in playlists) {
                if (playlists.hasOwnProperty(key)) {
                    allItems.push(...playlists[key]);
                }
            }
            return allItems;
        }

        function loadCarouselWithAllItems(items) {
            const carousel = document.querySelector("#carouselContent").closest('.carousel');
            const carouselContent = document.getElementById("carouselContent");
            carouselContent.innerHTML = "";

            items.forEach((item, index) => {
                const newItem = document.createElement("div");
                newItem.className = "carousel-item";
                if (index === 0) newItem.classList.add("active");

                // Buat wrapper tengah untuk center
                const centerWrapper = document.createElement("div");
                centerWrapper.style.textAlign = "center";

                // Frame mengikuti ukuran konten
                const frameWrapper = document.createElement("div");
                frameWrapper.className = "p-2 d-inline-block";
                frameWrapper.style.border = "1px solid #ddd";
                frameWrapper.style.borderRadius = "15px";
                frameWrapper.style.overflow = "hidden";
                frameWrapper.style.backgroundColor = "#fff";
                frameWrapper.style.boxShadow = "0 20px 25px rgba(0, 0, 0, 0.3)"; // 👉 backdrop shadow

                if (item.type === 'video') {
                    const video = document.createElement("video");
                    video.className = "w-100";
                    video.controls = true;
                    video.autoplay = true;
                    video.style.borderRadius = "20px";
                    video.innerHTML =
                        `<source src="${item.src}" type="video/mp4">Browser Anda tidak mendukung video.`;

                    video.addEventListener("play", () => {
                        new bootstrap.Carousel(carousel).pause();
                    });

                    video.addEventListener("pause", () => {
                        new bootstrap.Carousel(carousel).pause();
                    });

                    video.addEventListener("ended", () => {
                        new bootstrap.Carousel(carousel).next();
                    });

                    frameWrapper.appendChild(video);
                } else {
                    const img = document.createElement("img");
                    img.src = item.src;
                    img.className = "w-75";
                    img.style.borderRadius = "20px";
                    frameWrapper.appendChild(img);
                }

                centerWrapper.appendChild(frameWrapper);
                newItem.appendChild(centerWrapper);
                carouselContent.appendChild(newItem);
            });

            const carouselInit = new bootstrap.Carousel(carousel, {
                interval: false,
                ride: false,
                wrap: true
            });

            carousel.addEventListener('slid.bs.carousel', (event) => {
                const previous = event.from;
                const prevVideo = carouselContent.children[previous]?.querySelector("video");
                if (prevVideo && !prevVideo.paused) {
                    prevVideo.pause();
                }

                const active = event.to;
                const activeVideo = carouselContent.children[active]?.querySelector("video");
                if (activeVideo) {
                    activeVideo.play().catch(err => console.error(err));
                } else {
                    setTimeout(() => new bootstrap.Carousel(carousel).next(), 10000);
                }
            });

            if (items.length > 0 && items[0].type !== 'video') {
                setTimeout(() => new bootstrap.Carousel(carousel).next(), 10000);
            }
        }




        function loadPlaylist() {
            const categoryId = document.getElementById("categorySelect").value;
            const playlist = document.getElementById("playlist");
            playlist.innerHTML = "";

            let itemsToShow = [];

            if (categoryId === "all") {
                itemsToShow = getAllItemsFromAllCategories();
            } else {
                const categoryKey = `category_${categoryId}`;
                if (!playlists[categoryKey]) return;
                itemsToShow = playlists[categoryKey];
            }

            itemsToShow.forEach((item, index) => {
                const wrapper = document.createElement("div");
                wrapper.className = "d-flex align-items-center mb-2";

                const thumb = document.createElement("img");
                thumb.src = item.type === "video" ? item.thumb : item.src;
                thumb.className = "img-fluid playlist-thumbnail me-2";
                thumb.alt = item.judul || "thumbnail";

                const title = document.createElement("span");
                title.className = "playlist-title";
                // title.textContent = item.judul || "";

                wrapper.appendChild(thumb);
                wrapper.appendChild(title);

                wrapper.addEventListener("click", () => {
                    new bootstrap.Carousel(
                        document.querySelector("#carouselContent").closest('.carousel')
                    ).to(index);
                });

                playlist.appendChild(wrapper);
            });

            loadCarouselWithAllItems(itemsToShow);
        }
    </script>
@endpush
