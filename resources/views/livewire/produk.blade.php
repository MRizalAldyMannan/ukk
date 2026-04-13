<div class="container">
    <div class="row my-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
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

            @if($pilihanMenu == 'lihat')
            <div style="width: 300px;">
                <input type="text" class="form-control" placeholder="Cari kode atau nama..." wire:model.live="cari">
            </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            {{-- MENU LIHAT --}}
            @if($pilihanMenu == 'lihat')
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Semua Produk</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th> {{-- Tambah Kolom Gambar --}}
                                <th style="cursor: pointer;" wire:click="urutkan('kode_produk')">
                                    Kode Produk 
                                    @if($sortKolom == 'kode_produk') {!! $sortOrder == 'asc' ? '↑' : '↓' !!} @endif
                                </th>
                                <th style="cursor: pointer;" wire:click="urutkan('nama_produk')">
                                    Nama Produk 
                                    @if($sortKolom == 'nama_produk') {!! $sortOrder == 'asc' ? '↑' : '↓' !!} @endif
                                </th>
                                <th style="cursor: pointer;" wire:click="urutkan('harga')">
                                    Harga 
                                    @if($sortKolom == 'harga') {!! $sortOrder == 'asc' ? '↑' : '↓' !!} @endif
                                </th>
                                <th style="cursor: pointer;" wire:click="urutkan('stok')">
                                    Stok 
                                    @if($sortKolom == 'stok') {!! $sortOrder == 'asc' ? '↑' : '↓' !!} @endif
                                </th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                                        <tbody>
                    @forelse ($semuaProduk as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}" 
                                        width="50" 
                                        class="img-thumbnail" 
                                        style="cursor: pointer; object-fit: cover; height: 50px;" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#detailFoto{{ $produk->id }}"
                                        title="Klik untuk memperbesar">

                                    <div class="modal fade" id="detailFoto{{ $produk->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">{{ $produk->nama_produk }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center p-4">
                                                    <img src="{{ asset('storage/' . $produk->foto) }}" class="img-fluid rounded shadow-sm mb-3" alt="{{ $produk->nama_produk }}">
                                                    <div class="bg-light p-3 rounded text-start">
                                                        <p class="mb-1"><strong>Kode:</strong> {{ $produk->kode_produk }}</p>
                                                        <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                                        <p class="mb-0"><strong>Stok:</strong> {{ $produk->stok }} unit</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button wire:click="pilihEdit({{ $produk->id }})" class="btn btn-primary" data-bs-dismiss="modal">Edit Data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <small class="text-muted">No Image</small>
                                @endif
                            </td>
                            <td>{{ $produk->kode_produk }}</td>
                            <td>{{ $produk->nama_produk }}</td>
                            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>
                                <button wire:click="pilihEdit({{ $produk->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                <button wire:click="pilihHapus({{ $produk->id }})" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
                    </table>
                </div>
            </div>

            {{-- MENU TAMBAH --}}
            @elseif($pilihanMenu == 'tambah')
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">Tambah Produk Baru</div>
                <div class="card-body">
                    <form wire:submit.prevent="simpan">
                        <div class="mb-3">
                            <label>Foto Produk</label>
                            <input type="file" class="form-control" wire:model="foto">
                            @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                            
                            {{-- Preview Gambar --}}
                            <div wire:loading wire:target="foto" class="text-primary small mt-1">Mengunggah Preview...</div>
                            @if ($foto)
                                <div class="mt-2">
                                    <img src="{{ $foto->temporaryUrl() }}" width="120" class="img-thumbnail">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Kode Produk</label>
                            <input type="text" class="form-control" wire:model="kode_produk">
                            @error('kode_produk') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" wire:model="nama_produk">
                            @error('nama_produk') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" wire:model="harga">
                            @error('harga') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control" wire:model="stok">
                            @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" wire:click="pilihMenu('lihat')" class="btn btn-secondary">Batal</button>
                    </form>
                </div>
            </div>

            {{-- MENU EDIT --}}
            @elseif($pilihanMenu == 'edit')
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">Edit Produk</div>
                <div class="card-body">
                    <form wire:submit.prevent="simpanEdit">
                        <div class="mb-3">
                            <label>Foto Baru (Kosongkan jika tidak ingin ganti)</label>
                            <input type="file" class="form-control" wire:model="foto">
                            @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                            
                            @if ($foto)
                                <div class="mt-2">
                                    <img src="{{ $foto->temporaryUrl() }}" width="120" class="img-thumbnail">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>Kode Produk</label>
                            <input type="text" class="form-control" wire:model="kode_produk">
                        </div>
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" wire:model="nama_produk">
                        </div>
                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" class="form-control" wire:model="harga">
                        </div>
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control" wire:model="stok">
                        </div>
                        <button type="submit" class="btn btn-warning">Update</button>
                        <button type="button" wire:click="pilihMenu('lihat')" class="btn btn-secondary">Batal</button>
                    </form>
                </div>
            </div>

            {{-- MENU HAPUS --}}
            @elseif($pilihanMenu == 'hapus')
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">Konfirmasi Hapus</div>
                <div class="card-body text-center">
                    <p>Apakah anda yakin ingin menghapus produk <strong>{{ $nama_produk }}</strong>?</p>
                    <button wire:click="hapus" class="btn btn-danger">Ya, Hapus</button>
                    <button wire:click="pilihMenu('lihat')" class="btn btn-secondary">Batal</button>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>