<div class="container">
    <div class="row my-2">
        <div class="col-12">
            <button wire:click="pilihMenu('lihat')" class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua Produk
            </button>
            <button wire:click="pilihMenu('tambah')" class="btn {{ $pilihanMenu == 'tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                Tambah Produk
            </button>
            <button wire:loading class="btn btn-info">
                Loading ...
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if($pilihanMenu == 'lihat')
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Semua Produk</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semuaProduk as $produk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $produk->kode_produk }}</td>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>
                                        <button wire:click="pilihEdit({{ $produk->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                        <button wire:click="pilihHapus({{ $produk->id }})" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif ($pilihanMenu == 'tambah')
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Tambah Produk</div>
                <div class="card-body">
                    <form wire:submit.prevent='simpan'>
                        <div class="mb-3">
                            <label>Kode Produk</label>
                            <input type="text" class="form-control" wire:model='kode_produk' />
                            @error('kode_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" wire:model='nama_produk' />
                            @error('nama_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" wire:model='harga' />
                            @error('harga') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control" wire:model='stok' />
                            @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        <button type="button" wire:click="batal" class="btn btn-secondary mt-3">Batal</button>
                    </form>
                </div>
            </div>
            @elseif ($pilihanMenu == 'edit')
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Edit Produk</div>
                <div class="card-body">
                    <form wire:submit.prevent='simpanEdit'>
                        <div class="mb-3">
                            <label>Kode Produk</label>
                            <input type="text" class="form-control" wire:model='kode_produk' />
                            @error('kode_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" wire:model='nama_produk' />
                            @error('nama_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" wire:model='harga' />
                            @error('harga') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control" wire:model='stok' />
                            @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                        <button type="button" wire:click="batal" class="btn btn-secondary mt-3">Batal</button>
                    </form>
                </div>
            </div>
            @elseif ($pilihanMenu == 'hapus')
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Hapus Produk</div>
                <div class="card-body">
                    <p>Anda yakin ingin menghapus produk ini?</p>
                    <p><strong>Kode:</strong> {{ $produkTerpilih->kode_produk }}</p>
                    <p><strong>Nama:</strong> {{ $produkTerpilih->nama_produk }}</p>
                    <button wire:click='hapus' class="btn btn-danger mt-3">Ya, Hapus</button>
                    <button wire:click='batal' class="btn btn-secondary mt-3">Batal</button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
