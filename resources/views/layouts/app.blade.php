<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Testimoni Laser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom right, #e0f7fa, #fff);
        }

        .hamburger {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            z-index: 1050;
        }

        #categorySelect {
            display: none;
            position: absolute;
            top: 50px;
            right: 10px;
            z-index: 1040;
            width: 200px;
        }

        .playlist-thumbnail {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .playlist-thumbnail:hover {
            transform: scale(1.03);
        }

        .carousel-item video,
        .carousel-item img {
            max-height: 400px;
            object-fit: contain;
        }
    </style>
</head>

<body>

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
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('script-home')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('http://localhost:8000/api/categoris')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('categorySelect');
                    data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.nama
                    .toLowerCase(); // atau gunakan category.id jika ingin pakai ID
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

</body>

</html>
