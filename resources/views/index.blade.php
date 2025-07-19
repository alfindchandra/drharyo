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
                <p class="text-lg text-gray-700 mb-6">Silakan pilih cabang untuk memulai.</p>
                <div class="select-wrapper relative">
                    <select id="initial_cabang_select" class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-lg">
                        <option value="">Pilih Cabang</option>
                        @foreach($cabang as $c)
                            <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                        @endforeach
                    </select>
                    <div class="select-arrow text-gray-400">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
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
        <form id="antrianForm" action="/api/v1/antrian" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <input type="hidden" id="form_cabang_id" name="cabang_id">
            
            <div>
                <label for="rencana_pembayaran" class="block text-sm font-medium text-gray-700">Rencana Pembayaran</label>
                <div class="relative mt-1">
                    <select id="rencana_pembayaran" name="rencana_pembayaran" required class="block w-full px-3 py-2 border rounded-md">
                        <option value="">Pilih Jenis Pembayaran</option>
                        <option value="Umum">Umum</option>
                        <option value="BPJS">BPJS</option>
                    </select>
                </div>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-rencana_pembayaran"></p>
            </div>
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required class="block w-full px-3 py-2 border rounded-md" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+3 days')) }}">
                <p class="text-red-500 text-xs mt-1 hidden" id="error-tanggal"></p>
            </div>
            <div>
                <label for="dokter_id" class="block text-sm font-medium text-gray-700">Dokter</label>
                <div class="relative mt-1">
                    <select id="dokter_id" name="dokter_id" required class="block w-full px-3 py-2 border rounded-md">
                        <option value="">Pilih Dokter</option>
                    </select>
                </div>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-dokter_id"></p>
            </div>
            <div>
                <label for="waktu" class="block text-sm font-medium text-gray-700">Waktu Sesi</label>
                <div class="relative mt-1">
                    <select id="waktu" name="waktu" required class="block w-full px-3 py-2 border rounded-md">
                        <option value="">Pilih Waktu Sesi</option>
                    </select>
                </div>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-waktu"></p>
            </div>
            <div class="md:col-span-2">
                <label for="nama_pasien" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama_pasien" name="nama_pasien" required class="block w-full px-3 py-2 border rounded-md">
                <p class="text-red-500 text-xs mt-1 hidden" id="error-nama_pasien"></p>
            </div>
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="number" id="nik" name="nik" maxlength="16" required class="block w-full px-3 py-2 border rounded-md" maxlength="16">
                <p class="text-red-500 text-xs mt-1 hidden" id="error-nik"></p>
            </div>
            <div>
                <label for="no_wa" class="block text-sm font-medium text-gray-700">No. WA</label>
                <input type="number" id="no_wa" name="no_wa" class="block w-full px-3 py-2 border rounded-md">
                <p class="text-xs text-gray-500 mt-1">* Format: 08xxxxxxxxxx</p>
                <p class="text-red-500 text-xs mt-1 hidden" id="error-no_wa"></p>
            </div>
            <div class="md:col-span-2 mt-2">
                <a href="#" onclick="toggleJamPraktek(event)" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Jam Praktek Dokter Minggu Ini</a>
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

    // Event listener for the initial branch selection dropdown
    document.getElementById('initial_cabang_select').addEventListener('change', function() {
        const selectedCabangId = this.value;
        if (selectedCabangId) {
            // Set the hidden input in the form
            document.getElementById('form_cabang_id').value = selectedCabangId;
            openAntrianModal(selectedCabangId);
        } else {
            closeAntrianModal(); // Close if no branch is selected
        }
    });

    function openAntrianModal(cabangId) {
        resetFormAndErrors();
        document.getElementById('antrianModal').style.display = 'flex';
        // Set the cabang_id in the form when the modal opens
        document.getElementById('form_cabang_id').value = cabangId;
        document.getElementById('tanggal').value = new Date().toISOString().split('T')[0]; // Set default date to today
        loadDokterOptions(cabangId); // Load doctors based on the selected branch
    }

    function closeAntrianModal() {
        document.getElementById('antrianModal').style.display = 'none';
        resetFormAndErrors();
        if (antrianInterval) {
            clearInterval(antrianInterval);
            antrianInterval = null;
        }
        // Reset the initial select dropdown as well
        document.getElementById('initial_cabang_select').value = '';
    }

    function resetFormAndErrors() {
        const form = document.getElementById('antrianForm');
        form.reset();
        document.querySelectorAll('[id^="error-"]').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.getElementById('field_pesan').classList.add('hidden');
        document.getElementById('field_pesan').innerHTML = '';
        document.getElementById('dokter_id').innerHTML = '<option value="">Pilih Cabang Dulu</option>';
        document.getElementById('scheduleContent').innerHTML = '<p class="text-gray-600">Pilih dokter untuk melihat jadwal.</p>';
        document.getElementById('waktu').innerHTML = '<option value="">Pilih Waktu Sesi</option>';
        if (antrianInterval) {
            clearInterval(antrianInterval);
            antrianInterval = null;
        }
    }

    document.getElementById('dokter_id').addEventListener('change', () => {
        loadScheduleTable(); // Memuat jadwal dokter
        updateWaktuOptions(); // Update waktu options after schedule is loaded
    });

    document.getElementById('tanggal').addEventListener('change', () => {
        updateWaktuOptions(); // Update opsi waktu berdasarkan tanggal
    });

    document.getElementById('waktu').addEventListener('change', getAntrianCount); // Start polling when session time is selected

    async function loadDokterOptions(cabangId) {
        const dokterSelect = document.getElementById('dokter_id');
        dokterSelect.innerHTML = '<option value="">Memuat Dokter...</option>';
        document.getElementById('scheduleContent').innerHTML = '<p class="text-gray-600">Pilih dokter untuk melihat jadwal.</p>';
        document.getElementById('waktu').innerHTML = '<option value="">Pilih Waktu Sesi</option>';
        if (antrianInterval) {
            clearInterval(antrianInterval);
            antrianInterval = null;
        }
        document.getElementById('field_pesan').classList.add('hidden');

        if (!cabangId) {
            dokterSelect.innerHTML = '<option value="">Pilih Cabang Dulu</option>';
            return;
        }

        try {
            const res = await fetch(`/api/v1/dokter?cabang_id=${cabangId}`);
            const data = await res.json();

            dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';
            if (data.success && data.data.length > 0) {
                data.data.forEach(dokter => {
                    let opt = document.createElement('option');
                    opt.value = dokter.id;
                    opt.textContent = dokter.nama_dokter;
                    dokterSelect.appendChild(opt);
                });
            } else {
                dokterSelect.innerHTML = '<option value="">Tidak ada dokter tersedia</option>';
            }
        } catch (error) {
            console.error('Error fetching doctors:', error);
            dokterSelect.innerHTML = '<option value="">Gagal memuat dokter</option>';
        }
    }

    async function loadScheduleTable() {
        const dokterId = document.getElementById('dokter_id').value;
        const scheduleContent = document.getElementById('scheduleContent');
        scheduleContent.innerHTML = '<p class="text-gray-600">Memuat jadwal...</p>';
        
        if (!dokterId) {
            scheduleContent.innerHTML = '<p class="text-gray-600">Pilih dokter untuk melihat jadwal.</p>';
            return;
        }

        try {
            const res = await fetch(`/api/v1/schedule?dokter_id=${dokterId}`);
            if (!res.ok) {
                throw new Error(`Network response was not ok, status: ${res.status}`);
            }
            const data = await res.json();

            if (data.success && data.jam_praktek) {
                const jam = data.jam_praktek;
                let scheduleHtml = '<ul class="list-disc list-inside text-gray-600">';
                for (const day in jam) {
                    scheduleHtml += `<li>${day}: ${jam[day]}</li>`;
                }
                scheduleHtml += '</ul>';
                scheduleContent.innerHTML = scheduleHtml;
                globalDetailedSchedules = data.detailed_schedules;
            } else {
                scheduleContent.innerHTML = '<p class="text-gray-600">Jadwal tidak ditemukan untuk dokter ini.</p>';
                globalDetailedSchedules = {};
            }
        } catch (error) {
            console.error('Error fetching schedules:', error);
            scheduleContent.innerHTML = '<p class="text-red-600">Gagal memuat jadwal dokter.</p>';
            globalDetailedSchedules = {};
        } finally {
            updateWaktuOptions(); // Always update waktu options after schedule load attempt
        }
    }

    function updateWaktuOptions() {
        const dokterId = document.getElementById('dokter_id').value;
        const tanggal = document.getElementById('tanggal').value;
        const waktuSelect = document.getElementById('waktu');
        waktuSelect.innerHTML = '<option value="">Pilih Waktu Sesi</option>';

        if (antrianInterval) {
            clearInterval(antrianInterval);
            antrianInterval = null;
        }
        document.getElementById('field_pesan').classList.add('hidden');

        if (!dokterId || !tanggal) {
            return;
        }

        const date = new Date(tanggal + 'T00:00:00');
        const dayOfWeek = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][date.getDay()];

        if (globalDetailedSchedules && globalDetailedSchedules[dayOfWeek]) {
            const slots = globalDetailedSchedules[dayOfWeek];
            const addedCategories = new Set(); 

            slots.forEach(slot => {
                const timeCategory = slot.tipe_sesi; // Directly use tipe_sesi from backend
                if (timeCategory && !addedCategories.has(timeCategory)) {
                    let opt = document.createElement('option');
                    opt.value = timeCategory;
                    opt.textContent = timeCategory;
                    waktuSelect.appendChild(opt);
                    addedCategories.add(timeCategory);
                }
            });
        }

        if (waktuSelect.options.length <= 1) { 
            waktuSelect.innerHTML = '<option value="">Tidak ada waktu sesi tersedia</option>';
        }
    }

    async function getAntrianCount() {
        const dokterId = document.getElementById('dokter_id').value;
        const tanggal = document.getElementById('tanggal').value;
        const sesi = document.getElementById('waktu').value; 
        const pesan = document.getElementById('field_pesan');

        if (antrianInterval) {
            clearInterval(antrianInterval);
            antrianInterval = null;
        }

        if (dokterId && tanggal && sesi) {
            const fetchData = async () => {
                try {
                    const res = await fetch(`/api/v1/antrian-count?dokter_id=${dokterId}&tanggal=${tanggal}&sesi=${sesi}`);
                    if (!res.ok) {
                        throw new Error(`HTTP error! status: ${res.status}`);
                    }
                    const data = await res.json();
                    
                    const dokterName = document.getElementById('dokter_id').selectedOptions[0].text;
                    const jumlah = data.count; // Use the 'count' directly from the API response

                    pesan.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                    pesan.classList.add('bg-green-100', 'text-green-700');
                    pesan.textContent = `Jumlah antrean ${dokterName} pada ${tanggal}, sesi ${sesi}: ${jumlah} pasien`;
                } catch (error) {
                    console.error('Error fetching antrian count:', error);
                    pesan.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                    pesan.classList.add('bg-red-100', 'text-red-700');
                    pesan.textContent = 'Gagal memuat jumlah antrean. Silakan coba lagi.';
                }
            };

            fetchData(); // Call immediately
            antrianInterval = setInterval(fetchData, 5000); // Poll every 5 seconds
        } else {
            pesan.classList.add('hidden');
        }
    }

    function toggleJamPraktek(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('jadwalPraktek').classList.toggle('hidden');
    }

    document.getElementById('antrianForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        document.querySelectorAll('[id^="error-"]').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.getElementById('field_pesan').classList.add('hidden');
        document.getElementById('field_pesan').innerHTML = '';

        const formData = new FormData(this);

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData,
            });

            const data = await response.json();
            const status = response.status;

            if (status === 200 || status === 201 || data.success) {
                showNotification('success', data.message || 'Antrean berhasil dibuat!');
                
                // Save the antrean data to localStorage
                let savedAntrean = JSON.parse(localStorage.getItem('savedAntrean')) || [];
                const newAntrean = {
                    id: data.data.id,
                    nomor_antrian: data.data.nomor_antrian,
                    sesi: data.data.sesi,
                    tanggal: data.data.tanggal,
                    nama_pasien: data.data.nama_pasien,
                    nik: data.data.nik,
                    barcode_data: data.data.barcode_data,
                    timestamp: new Date().toISOString()
                };
                savedAntrean.push(newAntrean);
                localStorage.setItem('savedAntrean', JSON.stringify(savedAntrean));

                // Show the detailed antrean modal
                showAntreanDetailModal(newAntrean);
                closeAntrianModal();

            } else if (status === 422) {
                for (const field in data.errors) {
                    const errorElement = document.getElementById(`error-${field}`);
                    const inputElement = document.getElementById(field);
                    if (errorElement) {
                        errorElement.textContent = data.errors[field][0];
                        errorElement.classList.remove('hidden');
                    }
                    if (inputElement) {
                        inputElement.classList.add('is-invalid');
                    }
                }
                document.getElementById('field_pesan').classList.remove('hidden', 'bg-green-100', 'text-green-700');
                document.getElementById('field_pesan').classList.add('bg-red-100', 'text-red-700');
                document.getElementById('field_pesan').textContent = 'Terdapat kesalahan validasi. Mohon periksa kembali isian Anda.';
            } else {
                showNotification('error', data.message || 'Terjadi kesalahan saat membuat antrean.');
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            showNotification('error', 'Terjadi kesalahan jaringan atau server.');
        }
    });

    function showNotification(type, message) {
        const notificationModal = document.getElementById('notificationModal');
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationMessage = document.getElementById('notificationMessage');

        notificationIcon.innerHTML = '';
        notificationMessage.textContent = message;

        if (type === 'success') {
            notificationIcon.innerHTML = '&#10003;';
            notificationIcon.style.color = '#10B981';
        } else {
            notificationIcon.innerHTML = '&#x2716;';
            notificationIcon.style.color = '#EF4444';
        }
        notificationModal.style.display = 'flex';
    }

    function closeNotificationModal() {
        document.getElementById('notificationModal').style.display = 'none';
    }

    // --- Fungsi Baru untuk Detail Antrean dan Penyimpanan Lokal ---

    function showAntreanDetailModal(antreanData) {
        document.getElementById('detail_nama_pasien').textContent = antreanData.nama_pasien;
        document.getElementById('detail_nik').textContent = antreanData.nik;
        document.getElementById('detail_nomor_antrian').textContent = antreanData.nomor_antrian;
        document.getElementById('detail_tanggal').textContent = antreanData.tanggal;
        document.getElementById('detail_sesi').textContent = antreanData.sesi;
        document.getElementById('barcode_text').textContent = antreanData.barcode_data;

        // Generate barcode using JsBarcode
        JsBarcode("#barcode", antreanData.barcode_data, {
            format: "CODE128", // Or "CODE39", "EAN13", etc.
            displayValue: true,
            height: 80,
            width: 2,
            background: "#ffffff",
            lineColor: "#000000",
        });

        document.getElementById('antreanDetailModal').style.display = 'flex';
    }

    function closeAntreanDetailModal() {
        document.getElementById('antreanDetailModal').style.display = 'none';
    }

    function showSavedAntrean() {
        const savedAntrean = JSON.parse(localStorage.getItem('savedAntrean')) || [];
        if (savedAntrean.length === 0) {
            showNotification('info', 'Anda belum memiliki antrean yang tersimpan.');
            return;
        }

        // For simplicity, let's just show the last saved antrean in the detail modal
        // You could extend this to show a list of all saved antrean if needed.
        const lastAntrean = savedAntrean[savedAntrean.length - 1];
        showAntreanDetailModal(lastAntrean);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
</body>
</html>