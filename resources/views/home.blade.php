<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrian - Klinik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .select-wrapper {
            position: relative;
        }
        .select-wrapper select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="bg-indigo-600 text-white p-6 rounded-t-lg">
                <h1 class="text-2xl font-bold">Form Antrian</h1>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('antrian.store') }}" class="bg-white p-6 rounded-b-lg shadow-lg">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cabang -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cabang</label>
                        <div class="select-wrapper">
                            <select name="cabang_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Cabang</option>
                                @foreach($cabang as $c)
                                    <option value="{{ $c->id }}">{{ $c->nama_cabang }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('cabang_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rencana Pembayaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rencana Pembayaran</label>
                        <div class="select-wrapper">
                            <select name="rencana_pembayaran" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Rencana Pembayaran</option>
                                <option value="Umum">Umum</option>
                                <option value="BPJS">BPJS</option>
                                <option value="Asuransi">Asuransi</option>
                            </select>
                        </div>
                        @error('rencana_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" required 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               min="{{ date('Y-m-d') }}">
                        @error('tanggal')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                        <div class="select-wrapper">
                            <select name="waktu" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Waktu</option>
                                <option value="Pagi">Pagi</option>
                                <option value="Siang">Siang</option>
                                <option value="Sore">Sore</option>
                            </select>
                        </div>
                        @error('waktu')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dokter -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dokter</label>
                        <div class="select-wrapper">
                            <select name="dokter_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Pilih Dokter</option>
                                @foreach($dokter as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_dokter }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('dokter_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Pasien -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input type="text" name="nama_pasien" required 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Masukkan nama lengkap">
                        @error('nama_pasien')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIK</label>
                        <input type="text" name="nik" required maxlength="16" 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Masukkan NIK 16 digit">
                        @error('nik')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. WA -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. WA</label>
                        <input type="text" name="no_wa" required 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Masukkan nomor WhatsApp">
                        <p class="text-sm text-gray-500 mt-1">* Silahkan isi No. WA jika ingin mendapatkan pesan nomor antrian anda (Format: 08xxxxxxxxxx)</p>
                        @error('no_wa')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Jam Praktek Link -->
                <div class="mt-4">
                    <a href="#" onclick="showJamPraktek()" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Lihat Jam Praktek Klinik Minggu Ini
                    </a>
                </div>

                <!-- Info Antrian -->
                <div id="info-antrian" class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg hidden">
                    <p class="text-green-800 font-medium">Jumlah antrian dr. Haryo Bagus Trenggono, Sp.M sebanyak 9</p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 mt-6">
                    <button type="button" onclick="resetForm()" 
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        Kirim
                    </button>
                </div>
            </form>

            <!-- Antrian List -->
            <div id="antrian-list" class="mt-8 bg-white rounded-lg shadow-lg p-6 hidden">
                <h3 class="text-lg font-semibold mb-4">Daftar Antrian</h3>
                <div id="antrian-content">
                    <!-- Antrian items will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Jam Praktek -->
    <div id="modal-jam-praktek" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Jam Praktek Klinik</h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="jam-praktek-content">
                    <div class="space-y-2">
                        <p><strong>Senin - Jumat:</strong> 08:00 - 17:00</p>
                        <p><strong>Sabtu:</strong> 08:00 - 12:00</p>
                        <p><strong>Minggu:</strong> Tutup</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set CSRF token for AJAX requests
        document.querySelector('meta[name="csrf-token"]').setAttribute('content', '{{ csrf_token() }}');

        // Form validation
        document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) {
                value = value.slice(0, 16);
            }
            e.target.value = value;
        });

        document.querySelector('input[name="no_wa"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 15) {
                value = value.slice(0, 15);
            }
            e.target.value = value;
        });

        // Show jam praktek modal
        function showJamPraktek() {
            document.getElementById('modal-jam-praktek').classList.remove('hidden');
        }

        // Close modal
        function closeModal() {
            document.getElementById('modal-jam-praktek').classList.add('hidden');
        }

        // Reset form
        function resetForm() {
            document.querySelector('form').reset();
            document.getElementById('info-antrian').classList.add('hidden');
            document.getElementById('antrian-list').classList.add('hidden');
        }

        // Load antrian when dokter and tanggal are selected
        document.querySelector('select[name="dokter_id"]').addEventListener('change', loadAntrian);
        document.querySelector('input[name="tanggal"]').addEventListener('change', loadAntrian);

        function loadAntrian() {
            const dokterId = document.querySelector('select[name="dokter_id"]').value;
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            
            if (dokterId && tanggal) {
                fetch(`/antrian-by-dokter?dokter_id=${dokterId}&tanggal=${tanggal}`)
                    .then(response => response.json())
                    .then(data => {
                        const dokterName = document.querySelector('select[name="dokter_id"] option:checked').text;
                        document.getElementById('info-antrian').innerHTML = 
                            `<p class="text-green-800 font-medium">Jumlah antrian ${dokterName} sebanyak ${data.length}</p>`;
                        document.getElementById('info-antrian').classList.remove('hidden');
                        
                        // Show antrian list
                        if (data.length > 0) {
                            let antrianHtml = '<div class="space-y-2">';
                            data.forEach(antrian => {
                                antrianHtml += `
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium">${antrian.nama_pasien}</p>
                                            <p class="text-sm text-gray-600">Antrian: ${antrian.nomor_antrian}</p>
                                        </div>
                                        <span class="px-3 py-1 text-xs rounded-full ${getStatusColor(antrian.status)}">
                                            ${antrian.status}
                                        </span>
                                    </div>
                                `;
                            });
                            antrianHtml += '</div>';
                            document.getElementById('antrian-content').innerHTML = antrianHtml;
                            document.getElementById('antrian-list').classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading antrian:', error);
                    });
            }
        }

        function getStatusColor(status) {
            switch(status) {
                case 'Menunggu': return 'bg-yellow-100 text-yellow-800';
                case 'Dipanggil': return 'bg-blue-100 text-blue-800';
                case 'Selesai': return 'bg-green-100 text-green-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        // Close modal when clicking outside
        document.getElementById('modal-jam-praktek').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>