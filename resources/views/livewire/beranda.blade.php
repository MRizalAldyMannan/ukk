<div class="container-fluid">
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card bg-warning text-dark border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">TOTAL TRANSAKSI</h6>
                    <h3 class="fw-bold mb-0">{{ $totalTransaksi }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">TOTAL PRODUK</h6>
                    <h3 class="fw-bold mb-0">{{ $totalProduk }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">TOTAL USER</h6>
                    <h3 class="fw-bold mb-0">{{ $totalUser }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold opacity-75">TOTAL KEUNTUNGAN</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-4 text-center bg-light">
                <h4 class="fw-bold text-primary">Selamat Datang di Dashboard Kasir</h4>
                <p class="text-muted">Aplikasi ini mempermudah pekerjaan anda</p>
            </div>
        </div>
    </div>
</div>