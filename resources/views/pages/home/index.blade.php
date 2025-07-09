@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row p-4 m-3">
            <div class="col-sm-7 col-lg-8">
                <video id="my-video" class="video-js video vjs-theme-city mb-3" controls preload="auto" width="640"
                    height="264" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
                    <source src="" type="video/mp4" />
                </video>

                <!-- Tombol Speed -->
                <div class="mb-3">
                    <strong>Speed:</strong>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="setSpeed(1)">1x</button>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="setSpeed(2)">2x</button>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="setSpeed(5)">5x</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="setSpeed(10)">10x</button>
                </div>


                <img id="main-image" class="w-100 mb-3 d-none" src="" alt="Image Preview" />

                <img src="{{ asset('logo/ezgif.com-animated-gif-maker.gif') }}" class="w-100 mb-2" alt="Banner Produk" />
                <h2 id="nama-video">Nama (Pekerjaan), umur</h2>
                <h5 id="judul-video">Judul</h5>
                <p id="deskripsi-video">Lorem ipsum dolor sit amet consectetur adipisicing elit...</p>

            </div>

            <div class="col-lg-4 mx-auto">
                <div class="d-flex justify-content-center">
                    <img src="assets/image/logo gogomall.svg" style="max-width: 75%" alt="Logo" />
                </div>

                <!-- Form Select -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="mb-2">
                            <select id="produk" class="form-control">
                                <option value="">Pilih Produk</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <select id="penyakit" class="form-control" disabled onchange="loadPlaylist()">
                                <option value="all">Semua</option>
                            </select>
                        </div>
                        <div class="mb-2" id="list_playlist" style="max-height: 300px; overflow-y: auto; display: none;">
                        </div>
                    </div>
                </div>

                <!-- Latest Videos -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="text-dark">Latest Videos</h4>
                        <div class="mb-2" id="playlist" style="max-height: 300px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let playlists = {};
        let allVideos = [];

        document.addEventListener("DOMContentLoaded", function() {
            const selectProduk = document.getElementById("produk");
            const selectPenyakit = document.getElementById("penyakit");

            // Load Produk
            fetch("api/barangs")
                .then(res => res.json())
                .then(dataProduk => {
                    dataProduk.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.nama;
                        selectProduk.appendChild(option);
                    });
                });

            selectProduk.addEventListener("change", function() {
                selectPenyakit.disabled = !this.value;
            });

            // Load Penyakit dan Playlist
            fetch("api/categoris")
                .then(res => res.json())
                .then(dataKategori => {
                    dataKategori.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.nama;
                        selectPenyakit.appendChild(option);
                    });

                    return fetch("api/playlist");
                })
                .then(res => res.json())
                .then(dataPlaylist => {
                    allVideos = dataPlaylist;

                    // Tampilkan video terbaru ke tampilan utama
                    if (allVideos.length > 0) {
                        const latest = allVideos[allVideos.length - 1];
                        setMainContent(latest);
                    }

                    // Group berdasarkan penyakit
                    dataPlaylist.forEach(item => {
                        const key = `penyakit_${item.category_id}`;
                        if (!playlists[key]) playlists[key] = [];
                        playlists[key].push(item);
                    });

                    loadPlaylist();
                })
                .catch(err => console.error("Gagal memuat:", err));
        });

        function loadPlaylist() {
            const penyakitId = document.getElementById("penyakit").value;
            const listDiv = document.getElementById("list_playlist");
            const playlistDiv = document.getElementById("playlist");

            listDiv.innerHTML = "";
            playlistDiv.innerHTML = "";

            if (penyakitId === "all") {
                allVideos.forEach(item => playlistDiv.appendChild(createVideoItem(item)));
                playlistDiv.style.display = "block";
                listDiv.style.display = "none";
            } else {
                const key = `penyakit_${penyakitId}`;
                const filtered = playlists[key] || [];
                filtered.forEach(item => listDiv.appendChild(createVideoItem(item)));
                playlistDiv.style.display = "none";
                listDiv.style.display = "block";
            }
        }

        function createVideoItem(item) {
            const wrapper = document.createElement("div");
            wrapper.className = "d-flex align-items-center mb-2 pointer";
            wrapper.style.cursor = "pointer";

            const thumb = document.createElement("img");
            thumb.src = `storage/${item.thumbnail}` || "{{ asset('images/images.jpg') }}";
            thumb.className = "img-fluid me-2";
            thumb.style.maxWidth = "80px";

            const title = document.createElement("span");
            title.textContent = item.judul;
            title.className = "text-dark";

            wrapper.appendChild(thumb);
            wrapper.appendChild(title);

            wrapper.addEventListener("click", function() {
                setMainContent(item);
            });

            return wrapper;
        }

        function setMainContent(item) {
            const video = document.getElementById("my-video");
            const videoSource = video.querySelector("source");
            const image = document.getElementById("main-image");

            if (item.type === 'video') {
                video.classList.remove("d-none");
                image.classList.add("d-none");

                videoSource.src = `storage/${item.video}` || "";
                video.poster = `storage/${item.thumbnail}` || "{{ asset('images/images.jpg') }}";
                video.load();

            } else if (item.type === 'image') {
                video.classList.add("d-none");
                image.classList.remove("d-none");

                image.src = `storage/${item.video}` || "{{ asset('images/images.jpg') }}";
            }

            document.getElementById("judul-video").textContent = item.judul || "Judul Tidak Diketahui";
            document.getElementById("deskripsi-video").textContent = item.deskripsi || "Deskripsi tidak tersedia";
            document.getElementById("nama-video").textContent = `${item.nama} (${item.perkerjaan}) ${item.umur} tahun` || "Nama (Pekerjaan), umur";
        }

        function setSpeed(rate) {
            const video = document.getElementById("my-video");
            video.playbackRate = rate;
        }
    </script>
@endpush
