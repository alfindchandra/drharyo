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
            border-color: #dc2626 !important; /* Tailwind red-600 */
            box-shadow: 0 0 0 1px #dc2626;
        }
        /* CSS untuk menghilangkan panah di input type="number" (jika diperlukan untuk input nomor antrean atau lainnya) */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
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

   <div id="antrianModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Form Antrean</h2>
            <button onclick="closeAntrianModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
        </div>
        <form id="antrianFormfg" action="{{ route('antrian.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label for="cabang_id" class="block text-sm font-medium text-gray-700">Cabang</label>
                <div class="relative mt-1">
                    <select id="cabang_id" name="cabang_id" required class="block w-full px-3 py-2 border rounded-md">
                        <option value="">Pilih Cabang</option>
                        @foreach($cabang as $c)
                            <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-cabang_id"></p>
            </div>
            <div>
                <label for="rencana_pembayaran" class="block text-sm font-medium text-gray-700">Rencana Pembayaran</label>
                <select id="rencana_pembayaran" name="rencana_pembayaran" required disabled class="block w-full px-3 py-2 border rounded-md bg-gray-100 cursor-not-allowed">
                    <option value="Umum">Umum</option>
                    <option value="BPJS">BPJS</option>
                </select>
            </div>
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required class="block w-full px-3 py-2 border rounded-md" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+2 days')) }}">
                <p class="text-red-500 text-xs mt-1 hidden" id="error-tanggal"></p>
            </div>
            <div>
                <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu</label>
                <select id="waktu" name="waktu" required class="block w-full px-3 py-2 border rounded-md">
                    <option value="">Pilih Waktu</option>
                    
                </select>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-waktu"></p>
            </div>
            <div class="md:col-span-2">
                <label for="dokter_id" class="block text-sm font-medium text-gray-700">Dokter</label>
                <select id="dokter_id" name="dokter_id" required class="block w-full px-3 py-2 border rounded-md">
                    <option value="">Pilih Dokter</option>
                </select>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-dokter_id"></p>
            </div>
            <div>
                <label for="nama_pasien" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required class="block w-full px-3 py-2 border rounded-md">
                <p class="text-red-500 text-xs mt-1 hidden" id="error-nama_pasien"></p>
            </div>
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="number" id="nik" name="nik" maxlength="16" required class="block w-full px-3 py-2 border rounded-md">
                <p class="text-red-500 text-xs mt-1 hidden" id="error-nik"></p>
            </div>
            <div class="md:col-span-2">
                <label for="no_wa" class="block text-sm font-medium text-gray-700">No. WA</label>
                <input type="number" id="no_wa" name="no_wa" class="block w-full px-3 py-2 border rounded-md">
                <p class="text-xs text-gray-500 mt-1">* Format: 08xxxxxxxxxx</p>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-no_wa"></p>
            </div>
            <div class="md:col-span-2 mt-2">
                <a href="#" onclick="toggleJamPraktek()" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Jam Praktek Klinik Minggu Ini</a>
                <div id="jadwalPraktek" class="hidden mt-3 bg-gray-50 p-4 rounded border">
                    <h3 class="font-semibold mb-2">Jadwal Praktek Dokter</h3>
                    <div id="scheduleContent" class="text-gray-700 text-sm"></div>
                </div>
            </div>
            <div class="md:col-span-2 mt-4">
                <div id="field_pesan" class="py-2 px-4 rounded-md text-center text-sm font-medium hidden"></div>
            </div>
            <div class="md:col-span-2 flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeAntrianModal()" class="px-5 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">Kirim</button>
            </div>
        </form>
    </div>
</div>

<div id="notificationModal" class="modal">
    <div class="modal-content text-center max-w-sm p-6">
        <div id="notificationIcon" class="text-5xl mb-4"></div>
        <p id="notificationMessage" class="text-lg font-semibold text-gray-800 mb-6"></p>
        <button onclick="closeNotificationModal()" class="w-full px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">Tutup</button>
    </div>
</div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let globalDetailedSchedules = {}; // Global variable to store detailed schedules
        let antrianInterval; // Variabel untuk menyimpan ID interval

        function openAntrianModal(rencanaPembayaran) {
            resetFormAndErrors();
            document.getElementById('antrianModal').style.display = 'flex';
            document.getElementById('rencana_pembayaran').value = rencanaPembayaran;
            document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
            loadDokterOptions();
        }

        function closeAntrianModal() {
            document.getElementById('antrianModal').style.display = 'none';
            resetFormAndErrors();
            // Penting: Hentikan interval saat modal ditutup
            if (antrianInterval) {
                clearInterval(antrianInterval);
            }
        }

        function resetFormAndErrors() {
            const form = document.getElementById('antrianForm');
            form.reset();
            document.querySelectorAll('[id^="error-"]').forEach(p => p.classList.add('hidden'));
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.getElementById('field_pesan').classList.add('hidden');
            document.getElementById('field_pesan').innerHTML = '';
            document.getElementById('dokter_id').innerHTML = '<option value="">Pilih cabang dulu</option>';
            document.getElementById('scheduleContent').innerHTML = '<p class="text-gray-600">Pilih cabang dan dokter untuk melihat jadwal.</p>';
            document.getElementById('waktu').innerHTML = '<option value="">Pilih Waktu</option>'; // Reset waktu options
            // Hentikan interval saat form di-reset
            if (antrianInterval) {
                clearInterval(antrianInterval);
                antrianInterval = null; // Set to null agar bisa dimulai lagi
            }
        }

        document.getElementById('cabang_id').addEventListener('change', loadDokterOptions);

        document.getElementById('dokter_id').addEventListener('change', () => {
            loadScheduleTable(); // Memuat jadwal dokter
            getAntrianCount(); // Memulai polling antrean
        });

        // Add event listener for tanggal change
        document.getElementById('tanggal').addEventListener('change', () => {
            updateWaktuOptions(); // Update opsi waktu berdasarkan tanggal
            getAntrianCount(); // Memulai polling antrean dengan tanggal baru
        });

        // Add event listener for waktu change (jam)
        document.getElementById('waktu').addEventListener('change', getAntrianCount); // Memulai polling antrean dengan waktu baru

        function loadDokterOptions() {
            const cabangId = document.getElementById('cabang_id').value;
            const dokterSelect = document.getElementById('dokter_id');
            document.getElementById('scheduleContent').innerHTML = '<p class="text-gray-600">Pilih dokter untuk melihat jadwal.</p>';
            document.getElementById('waktu').innerHTML = '<option value="">Pilih Waktu</option>'; // Clear waktu options
            
            // Hentikan polling saat dokter atau cabang berubah sebelum dokter baru dipilih
            if (antrianInterval) {
                clearInterval(antrianInterval);
                antrianInterval = null;
            }
            document.getElementById('field_pesan').classList.add('hidden'); // Sembunyikan pesan antrean

            if (!cabangId) {
                dokterSelect.innerHTML = '<option value="">Pilih cabang dulu</option>';
                return;
            }

            dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';

            fetch('/api/v1/dokter')
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const list = data.data.filter(d => d.id_cabang == cabangId);
                        if (list.length > 0) {
                            list.forEach(dokter => {
                                let opt = document.createElement('option');
                                opt.value = dokter.id;
                                opt.textContent = dokter.nama_dokter;
                                dokterSelect.appendChild(opt);
                            });
                        } else {
                            dokterSelect.innerHTML = '<option value="">Tidak ada dokter tersedia</option>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    dokterSelect.innerHTML = '<option value="">Gagal memuat dokter</option>';
                });
        }

        function loadScheduleTable() {
            const dokterId = document.getElementById('dokter_id').value;
            const scheduleContent = document.getElementById('scheduleContent');
            if (!dokterId) {
                scheduleContent.innerHTML = '<p class="text-gray-600">Pilih dokter untuk melihat jadwal.</p>';
                return;
            }

            fetch(`/api/v1/schedule?dokter_id=${dokterId}`)
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.success && data.jam_praktek) {
                        const jam = data.jam_praktek;
                        let scheduleHtml = '<ul class="list-disc list-inside text-gray-600">';

                        for (const day in jam) {
                            scheduleHtml += `<li>${day}: ${jam[day]}</li>`;
                        }
                        scheduleHtml += '</ul>';
                        scheduleContent.innerHTML = scheduleHtml;

                        globalDetailedSchedules = data.detailed_schedules; // Store detailed schedules

                        // After updating general schedule display, update 'Waktu' dropdown
                        updateWaktuOptions();

                    } else {
                        scheduleContent.innerHTML = '<p class="text-gray-600">Jadwal tidak ditemukan untuk dokter ini.</p>';
                        globalDetailedSchedules = {}; 
                        updateWaktuOptions(); 
                    }
                })
               
        }

        function updateWaktuOptions() {
            const dokterId = document.getElementById('dokter_id').value;
            const tanggal = document.getElementById('tanggal').value; // YYYY-MM-DD format
            const waktuSelect = document.getElementById('waktu');
            waktuSelect.innerHTML = '<option value="">Pilih Waktu</option>'; // Clear previous options

            // Hentikan polling jika ada perubahan pada waktu
            if (antrianInterval) {
                clearInterval(antrianInterval);
                antrianInterval = null;
            }
            document.getElementById('field_pesan').classList.add('hidden'); // Sembunyikan pesan antrean

            if (!dokterId || !tanggal) {
                return; 
            }

            const date = new Date(tanggal + 'T00:00:00'); // Tambahkan 'T00:00:00' untuk menghindari masalah timezone
            const dayOfWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date.getDay()];

            if (globalDetailedSchedules && globalDetailedSchedules[dayOfWeek]) {
                const slots = globalDetailedSchedules[dayOfWeek];
                const addedTimes = new Set(); // To prevent duplicate "Pagi" or "Malam" options

                slots.forEach(slot => {
                    const startTime = slot.start_time; // e.g., "08:00:00"
                    const hour = parseInt(startTime.substring(0, 2));

                    let timeCategory = '';
                    if (hour >= 6 && hour < 12) { // 6 AM to 11:59 AM
                        timeCategory = 'Pagi';
                    } else if (hour >= 12 && hour < 17) { // 12 PM to 4:59 PM
                        timeCategory = 'Siang';
                    } else if (hour >= 17 && hour <= 23) { // 5 PM to 11 PM
                        timeCategory = 'Malam';
                    }

                    if (timeCategory && !addedTimes.has(timeCategory)) {
                        let opt = document.createElement('option');
                        opt.value = timeCategory;
                        opt.textContent = timeCategory;
                        waktuSelect.appendChild(opt);
                        addedTimes.add(timeCategory);
                    }
                });
            }

            if (waktuSelect.options.length <= 1) { // Only "Pilih Waktu" option exists
                waktuSelect.innerHTML = '<option value="">Tidak ada waktu tersedia</option>';
            }
        }

        /**
         * Mengambil jumlah antrean secara real-time.
         * Filter berdasarkan dokter, tanggal, dan jam.
         */
        function getAntrianCount() {
            const dokterId = document.getElementById('dokter_id').value;
            const tanggal = document.getElementById('tanggal').value;
            const jam = document.getElementById('waktu').value; // Mengambil nilai dari dropdown 'waktu'
            const pesan = document.getElementById('field_pesan');

            // Hentikan interval sebelumnya jika ada
            if (antrianInterval) {
                clearInterval(antrianInterval);
                antrianInterval = null; // Reset agar bisa dimulai lagi
            }

            if (dokterId && tanggal && jam) { // Pastikan semua field terisi
                const fetchData = () => {
                    fetch(`/api/v1/antrian?dokter_id=${dokterId}&tanggal=${tanggal}&jam=${jam}`) // Tambahkan parameter jam
                        .then(res => {
                            if (!res.ok) {
                                throw new Error(`HTTP error! status: ${res.status}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            const dokterName = document.getElementById('dokter_id').selectedOptions[0].text;
                            const jumlah = data.data.length; // Asumsi data.data adalah array antrean

                            pesan.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                            pesan.classList.add('bg-green-100', 'text-green-700');
                            // Update teks pesan dengan jumlah antrean
                            pesan.textContent = `Jumlah antrean ${dokterName} pada ${tanggal}, sesi ${jam}: ${jumlah}`;
                        })
                        .catch(error => {
                            console.error('Error fetching antrian count:', error);
                            pesan.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                            pesan.classList.add('bg-red-100', 'text-red-700');
                            pesan.textContent = 'Gagal memuat jumlah antrean. Silakan coba lagi.';
                        });
                };

                // Panggil fetchData segera setelah input valid
                fetchData();

                // Set interval untuk polling setiap beberapa detik (misal: 5 detik)
                antrianInterval = setInterval(fetchData, 5000); // Polling setiap 5 detik
            } else {
                pesan.classList.add('hidden');
            }
        }

        function toggleJamPraktek() {
            document.getElementById('jadwalPraktek').classList.toggle('hidden');
        }

        document.getElementById('antrianForm').addEventListener('submit', function(event) {
            event.preventDefault();

            document.querySelectorAll('[id^="error-"]').forEach(p => p.classList.add('hidden'));
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.getElementById('field_pesan').classList.add('hidden');
            document.getElementById('field_pesan').innerHTML = '';

            const formData = new FormData(this);
            formData.set('rencana_pembayaran', document.getElementById('rencana_pembayaran').value);

            // Tambahkan nilai waktu/jam ke formData sebelum submit
            formData.set('waktu', document.getElementById('waktu').value); 

            fetch(this.action || '{{ route("antrian.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData,
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200 || status === 201 || body.success) {
                    showNotification('success', body.message || 'Antrian berhasil dibuat!', body.data);
                    closeAntrianModal();
                    // Setelah sukses membuat antrean, panggil getAntrianCount untuk update real-time
                    getAntrianCount(); 
                } else if (status === 422) {
                    for (const field in body.errors) {
                        const errorElement = document.getElementById(`error-${field}`);
                        const inputElement = document.getElementById(field);
                        if (errorElement) {
                            errorElement.textContent = body.errors[field][0];
                            errorElement.classList.remove('hidden');
                        }
                        if (inputElement) {
                            inputElement.classList.add('is-invalid');
                        }
                    }
                    document.getElementById('field_pesan').classList.remove('hidden');
                    document.getElementById('field_pesan').classList.remove('bg-green-100', 'text-green-700');
                    document.getElementById('field_pesan').classList.add('bg-red-100', 'text-red-700');
                    document.getElementById('field_pesan').textContent = 'Terdapat kesalahan validasi. Mohon periksa kembali isian Anda.';
                } else {
                    showNotification('error', body.message || 'Terjadi kesalahan saat membuat antrean.');
                }
            })
            .catch(error => {
                console.error('Error submitting form:', error);
                showNotification('error', 'Terjadi kesalahan jaringan atau server.');
            });
        });

        function showNotification(type, message, data = null) {
            const notificationModal = document.getElementById('notificationModal');
            const notificationIcon = document.getElementById('notificationIcon');
            const notificationMessage = document.getElementById('notificationMessage');

            notificationIcon.innerHTML = '';
            notificationMessage.textContent = message;

            if (type === 'success') {
                notificationIcon.innerHTML = '&#10003;';
                notificationIcon.style.color = '#10B981';
                // MODIFIKASI DI SINI: Tampilkan nomor antrean dari 'data.nomor_antrian'
                if (data && data.nomor_antrian) {
                    notificationMessage.textContent = `Antrean Anda berhasil dibuat! Nomor Antrean: ${data.nomor_antrian}`;
                    // Anda bisa tambahkan info sesi jika mau
                    if (data.sesi) { // Asumsi backend juga mengirimkan `sesi`
                        notificationMessage.textContent += ` (Sesi ${data.sesi})`;
                    }
                } else {
                    notificationMessage.textContent = message; // Fallback jika data.nomor_antrian tidak ada
                }
            } else {
                notificationIcon.innerHTML = '&#x2716;';
                notificationIcon.style.color = '#EF4444';
            }
            notificationModal.style.display = 'flex';
        }

        function closeNotificationModal() {
            document.getElementById('notificationModal').style.display = 'none';
        }
    </script>
</body>
</html>