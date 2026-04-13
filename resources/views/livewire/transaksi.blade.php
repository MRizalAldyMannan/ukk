<div class="container-fluid">
    <div class="row">
        <!-- Bagian Kiri: Daftar Produk -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold text-primary mb-0">Daftar Produk</h5>
                </div>
                <div class="card-body">
                    @if (session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach($semuaProduk as $produk)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title fw-bold text-dark">{{ $produk->nama_produk }}</h6>
                                    <p class="card-text text-muted mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    <span class="badge bg-secondary mb-3">Sisa Stok: {{ $produk->stok }}</span>
                                    <br>
                                    <button wire:click="tambahKeKeranjang({{ $produk->id }})" class="btn btn-primary btn-sm w-100 rounded-pill">
                                        + Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Keranjang Belanja -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-header bg-white pt-4 pb-3">
                    <h5 class="fw-bold mb-0">Keranjang Belanja</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($keranjang as $index => $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">
                            <div>
                                <h6 class="my-0">{{ $item['nama_produk'] }}</h6>
                                <small class="text-muted">{{ $item['qty'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</small>
                            </div>
                            <div class="text-end">
                                <span class="d-block">Rp {{ number_format($item['qty'] * $item['harga'], 0, ',', '.') }}</span>
                                <button wire:click="hapusDariKeranjang({{ $index }})" class="btn btn-link text-danger p-0 mt-1" style="font-size: 0.8rem; text-decoration: none;">
                                    Hapus
                                </button>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted py-4 bg-transparent">
                            Belum ada produk di keranjang.
                        </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 pb-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total Harga</span>
                        <span class="fw-bold text-primary fs-5">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Jumlah Bayar</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" wire:model.live.debounce.500ms="bayar" wire:change="hitungKembalian" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span>Kembalian</span>
                        <span class="fw-bold {{ $kembalian < 0 ? 'text-danger' : 'text-success' }}">
                            Rp {{ number_format($kembalian, 0, ',', '.') }}
                        </span>
                    </div>

                    <button wire:click="checkout" class="btn btn-primary w-100 py-2 fw-bold" {{ empty($keranjang) ? 'disabled' : '' }}>
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>