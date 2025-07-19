<div id="antrianModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Form Antrean</h2>
            <button onclick="closeAntrianModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
        </div>
        <form id="antrianForm" action="{{ route('antrian.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
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