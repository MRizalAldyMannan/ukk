<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white pt-4 pb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <h5 class="fw-bold mb-0">Laporan Transaksi</h5>
                            
                            <div class="d-flex align-items-center gap-2">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-muted">Dari</span>
                                    <input type="date" class="form-control" wire:model.live="tgl_mulai">
                                </div>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light text-muted">Sampai</span>
                                    <input type="date" class="form-control" wire:model.live="tgl_selesai">
                                </div>
                                
                                <button onclick="exportLaporanPDF()" class="btn btn-sm btn-danger text-nowrap">
                                    <i class="bi bi-file-pdf"></i> Export PDF
                                </button>

                                @if($tgl_mulai || $tgl_selesai)
                                    <button wire:click="$set('tgl_mulai', ''); $set('tgl_selesai', '')" class="btn btn-sm btn-outline-secondary">Reset</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- AREA YANG AKAN DIJADIKAN PDF --}}
                    <div class="card-body" id="area-laporan">
                        <div class="d-none d-print-block text-center mb-4">
                            <h4 class="fw-bold text-uppercase">{{ config('app.name') }}</h4>
                            <h5>LAPORAN TRANSAKSI PENJUALAN</h5>
                            <p>Periode: {{ $tgl_mulai ?: 'Semua' }} s/d {{ $tgl_selesai ?: 'Semua' }}</p>
                            <hr>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Waktu (WIB)</th>
                                        <th>Detail Barang</th>
                                        <th>Total Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($semuaTransaksi as $transaksi)
                                        <tr>
                                            <td>{{ $semuaTransaksi->firstItem() + $loop->index }}</td>
                                            <td><span class="badge bg-secondary">{{ $transaksi->kode_transaksi }}</span></td>
                                            <td>{{ $transaksi->created_at->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') }}</td>
                                            <td>
                                                <ul class="mb-0 ps-3 small">
                                                    @foreach($transaksi->detail as $item)
                                                        <li>{{ $item->produk->nama_produk ?? 'Produk Dihapus' }} (x{{ $item->qty }})</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Data tidak ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex justify-content-center">
                        {{ $semuaTransaksi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function exportLaporanPDF() {
            const element = document.getElementById('area-laporan');
            
            // Konfigurasi PDF
            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'Laporan-Transaksi.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            // Jalankan Export
            html2pdf().set(opt).from(element).save();
        }
    </script>
</div>