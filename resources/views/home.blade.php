<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrean - Klinik dr. Haryo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://app.drharyoklinikmata.com/assets/images/background.png');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal {
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            max-height: 90vh;
        }
        .select-arrow {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .select-wrapper select {
            appearance: none;
            padding-right: 2.5rem;
        }
        .is-invalid {
            border-color: #dc2626 !important;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden max-w-lg mx-auto">
            <div class="bg-gradient-to-r from-indigo-800 to-purple-900 text-white p-6 text-center">
                <h1 class="text-2xl font-bold">Pengambilan Antrean</h1>
            </div>
            <div class="p-6 text-center">
                <img src="https://app.drharyoklinikmata.com/assets/images/logo-title.jpg" alt="Logo" class="mx-auto w-48 mb-6">
                <p class="text-lg text-gray-700 mb-6">Silakan pilih jenis pembayaran Anda untuk memulai.</p>
                <div class="flex flex-col md:flex-row gap-4">
                    <button onclick="openAntrianModal('Umum')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 text-xl">Umum</button>
                    <button onclick="openAntrianModal('BPJS')" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 text-xl">BPJS</button>
                </div>
            </div>
        </div>
    </div>

    @include('antrian-modal')

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function openAntrianModal(rencanaPembayaran) {
            resetFormAndErrors();
            document.getElementById('antrianModal').style.display = 'flex';
            document.getElementById('rencana_pembayaran').value = rencanaPembayaran;
            document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
            loadDokterOptions();
            loadScheduleTable();
        }

        function closeAntrianModal() {
            document.getElementById('antrianModal').style.display = 'none';
            resetFormAndErrors();
        }

        function resetFormAndErrors() {
            const form = document.getElementById('antrianForm');
            form.reset();
            document.querySelectorAll('[id^="error-"]').forEach(p => p.classList.add('hidden'));
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.getElementById('field_pesan').classList.add('hidden');
            document.getElementById('field_pesan').innerHTML = '';
            document.getElementById('dokter_id').innerHTML = '<option value="">Pilih Dokter</option>';
        }

        function loadDokterOptions() {
            const cabangId = document.getElementById('cabang_id').value;
            const dokterSelect = document.getElementById('dokter_id');
            dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';
            if (!cabangId) return;

            fetch('/v1/dokter')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const list = data.data.filter(d => d.id_cabang == cabangId);
                        list.forEach(dokter => {
                            let opt = document.createElement('option');
                            opt.value = dokter.id;
                            opt.textContent = dokter.nama_dokter;
                            dokterSelect.appendChild(opt);
                        });
                        getAntrianCount();
                        loadScheduleTable();
                    }
                });
        }

        function loadScheduleTable() {
            const cabangId = document.getElementById('cabang_id').value;
            const scheduleContent = document.getElementById('scheduleContent');
            if (!cabangId) {
                scheduleContent.innerHTML = '<p class="text-gray-600">Pilih cabang untuk melihat jadwal.</p>';
                return;
            }
            fetch('/jam-praktek')
                .then(res => res.json())
                .then(data => {
                    const jam = data.jam_praktek;
                    scheduleContent.innerHTML = `
                        <ul class="list-disc list-inside text-gray-600">
                            <li>Senin - Jumat: ${jam.senin_jumat}</li>
                            <li>Sabtu: ${jam.sabtu}</li>
                            <li>Minggu: ${jam.minggu}</li>
                        </ul>
                    `;
                });
        }

        function getAntrianCount() {
            const dokterId = document.getElementById('dokter_id').value;
            const tanggal = document.getElementById('tanggal').value;
            const pesan = document.getElementById('field_pesan');

            if (dokterId && tanggal) {
                fetch(`/antrian-by-dokter?dokter_id=${dokterId}&tanggal=${tanggal}`)
                    .then(res => res.json())
                    .then(data => {
                        const dokterName = document.getElementById('dokter_id').selectedOptions[0].text;
                        pesan.classList.remove('hidden');
                        pesan.classList.add('bg-green-100', 'text-green-700');
                        pesan.textContent = `Jumlah antrean ${dokterName}: ${data.length}`;
                    });
            }
        }

        function toggleJamPraktek() {
            document.getElementById('jadwalPraktek').classList.toggle('hidden');
        }
    </script>
</body>
</html>
