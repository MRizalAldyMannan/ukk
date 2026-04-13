<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pt-4 pb-3">
                    <h5 class="fw-bold mb-0">Laporan Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Waktu</th>
                                    <th>Detail Barang</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semuaTransaksi as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="badge bg-secondary">{{ $transaksi->kode_transaksi }}</span></td>
                                        <td>{{ $transaksi->created_at->format('d M Y, H:i') }}</td>
                                        <td>
                                            <ul class="mb-0 ps-3">
                                                @foreach($transaksi->detail as $item)
                                                    <li>{{ $item->produk->nama_produk ?? 'Produk Dihapus' }} (x{{ $item->qty }})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="fw-bold text-success">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        <td><span class="badge bg-success">{{ $transaksi->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Belum ada data transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>