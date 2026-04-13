<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-primary mb-0">Daftar Produk</h5>
                            <div style="width: 250px;">
                                <input type="text" class="form-control form-control-sm rounded-pill" placeholder="Cari produk..." wire:model.live="cari">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                            @foreach($semuaProduk as $produk)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm bg-white overflow-hidden m-1">
                                    <div style="height: 120px; overflow: hidden; background-color: #f8f9fa; cursor: pointer;" 
                                         data-bs-toggle="modal" 
                                         data-bs-target="#modalGambar{{ $produk->id }}"
                                         title="Klik untuk memperbesar">
                                        @if($produk->foto)
                                            <img src="{{ asset('storage/' . $produk->foto) }}" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="{{ $produk->nama_produk }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100 text-muted bg-light border-bottom">
                                                <i class="bi bi-image fs-2"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="card-body text-center p-2">
                                        <h6 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h6>
                                        <p class="card-text text-primary fw-bold mb-1 small">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                        <span class="badge {{ $produk->stok <= 5 ? 'bg-danger' : 'bg-light text-muted' }} mb-2 rounded-pill" style="font-size: 0.7rem;">
                                            Stok: {{ $produk->stok }}
                                        </span>
                                        <button wire:click="tambahKeKeranjang({{ $produk->id }})" 
                                                class="btn btn-primary btn-sm w-100 rounded-pill fs-7 py-1"
                                                {{ $produk->stok <= 0 ? 'disabled' : '' }}>
                                            {{ $produk->stok <= 0 ? 'Habis' : '+ Tambah' }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modalGambar{{ $produk->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-0 pb-0">
                                            <h6 class="modal-title fw-bold text-truncate">{{ $produk->nama_produk }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center p-3">
                                            @if($produk->foto)
                                                <img src="{{ asset('storage/' . $produk->foto) }}" class="img-fluid rounded shadow-sm" alt="{{ $produk->nama_produk }}">
                                            @else
                                                <div class="py-5 bg-light rounded text-muted">
                                                    <i class="bi bi-image fs-1 d-block mb-2"></i>
                                                    Tidak ada gambar tersedia
                                                </div>
                                            @endif
                                            <div class="mt-3 p-2 bg-light rounded text-start">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Harga:</span>
                                                    <span class="fw-bold text-primary">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Sisa Stok:</span>
                                                    <span class="fw-bold">{{ $produk->stok }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-white h-100">
                    <div class="card-header bg-white pt-4 pb-2 border-0">
                        <h5 class="fw-bold mb-0 text-dark">Keranjang Belanja</h5>
                    </div>
                    <div class="card-body p-0" style="max-height: 350px; overflow-y: auto;">
                        <ul class="list-group list-group-flush border-top border-bottom">
                            @forelse($keranjang as $index => $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center">
                                    @php $p = \App\Models\Produk::find($item['id']); @endphp
                                    @if($p && $p->foto)
                                        <img src="{{ asset('storage/' . $p->foto) }}" class="rounded me-2 border" style="width: 35px; height: 35px; object-fit: cover;">
                                    @else
                                        <div class="rounded me-2 border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 35px; height: 35px;">
                                            <i class="bi bi-image" style="font-size: 0.8rem;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="my-0 fw-bold fs-7">{{ $item['nama_produk'] }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $item['qty'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="d-block fw-bold fs-7">Rp {{ number_format($item['qty'] * $item['harga'], 0, ',', '.') }}</span>
                                    <button wire:click="hapusDariKeranjang({{ $index }})" class="btn btn-link text-danger p-0 mt-0" style="font-size: 0.75rem; text-decoration: none;">
                                        Hapus
                                    </button>
                                </div>
                            </li>
                            @empty
                            <li class="list-group-item text-center text-muted py-5 bg-light">
                                <i class="bi bi-cart-x fs-1 d-block mb-2 text-secondary"></i>
                                <small>Belum ada produk.</small>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                    
                    <div class="card-footer bg-white border-0 pb-4 mt-auto">
                        <div class="d-flex justify-content-between mb-3 pt-3 border-top">
                            <span class="fw-bold">Total Harga</span>
                            <span class="fw-bold text-primary fs-5">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold mb-1">JUMLAH BAYAR</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0 text-muted fs-6">Rp</span>
                                <input type="number" wire:model.live.debounce.500ms="bayar" wire:change="hitungKembalian" class="form-control border-start-0 ps-0 fw-bold text-primary fs-4" placeholder="0">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-4 p-2 rounded {{ $kembalian < 0 ? 'bg-danger-subtle' : 'bg-light' }}">
                            <span>Kembalian</span>
                            <span class="fw-bold {{ $kembalian < 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($kembalian, 0, ',', '.') }}
                            </span>
                        </div>

                        <button wire:click="checkout" class="btn btn-primary w-100 py-3 fw-bold shadow-sm rounded-pill fs-6" 
                                {{ empty($keranjang) || $kembalian < 0 || $bayar <= 0 ? 'disabled' : '' }}>
                            <i class="bi bi-printer me-2"></i>PROSES & CETAK STRUK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($transaksiTerakhir)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                    <h5 class="fw-bold">Berhasil!</h5>
                    <div class="d-grid gap-2 mt-3">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="bi bi-printer me-2"></i>Cetak Struk
                        </button>
                        <button onclick="downloadPDF()" class="btn btn-outline-danger">
                            <i class="bi bi-file-pdf me-2"></i>Download PDF
                        </button>
                        <button wire:click="$set('transaksiTerakhir', null)" class="btn btn-light mt-2">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div id="struk-area" class="d-none d-print-block" style="width: 80mm; background: #fff; padding: 20px; color: #000; font-family: monospace;">
        @if($transaksiTerakhir)
            <div style="text-align: center; margin-bottom: 10px;">
                <h4 style="margin: 0; font-weight: bold;">{{ config('app.name') }}</h4>
                <p style="margin: 0; font-size: 12px;">Kasir WIKRAMA</p>
                <p style="margin: 0; font-size: 12px;">Telp: 089654312</p>
                <p>--------------------------------</p>
            </div>

            <div style="font-size: 12px;">
                <table style="width: 100%;">
                    <tr><td>Nota</td><td>: {{ $transaksiTerakhir['kode'] }}</td></tr>
                    <tr><td>Kasir</td><td>: {{ $transaksiTerakhir['kasir'] }}</td></tr>
                    <tr><td>Waktu</td><td>: {{ $transaksiTerakhir['waktu'] }}</td></tr>
                </table>
                <p>--------------------------------</p>
                <table style="width: 100%;">
                    @foreach($transaksiTerakhir['items'] as $item)
                    <tr><td colspan="2">{{ $item['nama_produk'] }}</td></tr>
                    <tr>
                        <td>{{ $item['qty'] }} x {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item['qty'] * $item['harga'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </table>
                <p>--------------------------------</p>
                <table style="width: 100%;">
                    <tr><td>TOTAL</td><td style="text-align: right; font-weight: bold;">{{ number_format($transaksiTerakhir['total'], 0, ',', '.') }}</td></tr>
                    <tr><td>BAYAR</td><td style="text-align: right;">{{ number_format($transaksiTerakhir['bayar'], 0, ',', '.') }}</td></tr>
                    <tr><td>KEMBALI</td><td style="text-align: right; font-weight: bold;">{{ number_format($transaksiTerakhir['kembalian'], 0, ',', '.') }}</td></tr>
                </table>
                <div style="text-align: center; margin-top: 20px;">
                    <p>TERIMA KASIH</p>
                    <p>Selamat Belanja Kembali</p>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.getElementById('struk-area');
            element.classList.remove('d-none');
            const opt = {
                margin: 0,
                filename: 'Struk-{{ $transaksiTerakhir["kode"] ?? "TRX" }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: [80, 150], orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save().then(() => {
                element.classList.add('d-none');
            });
        }
        document.addEventListener('livewire:init', () => {
            Livewire.on('cetak-struk', () => {
                
            });
        });
    </script>

    <style>
        .fs-7 { font-size: 0.85rem; }
        .card-title.text-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            white-space: normal;
            height: 2.4em;
            line-height: 1.2em;
        }
        @media print {
            body * { visibility: hidden; }
            #struk-area, #struk-area * { visibility: visible; }
            #struk-area { position: absolute; left: 0; top: 0; display: block !important; width: 80mm; }
            @page { margin: 0; }
        }
    </style>
</div>