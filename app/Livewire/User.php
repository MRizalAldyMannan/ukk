<?php

namespace App\Livewire;

use App\Models\User as ModelUser;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    // Properti publik otomatis tersedia di file Blade
    public $pilihanMenu = 'lihat';
    public $nama;
    public $email;
    public $peran;
    public $password;
    public $penggunaTerpilih;

   
    public function mount()
    {
        if (!Auth::check() || strtolower(Auth::user()->peran) !== 'admin') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function simpan()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'peran' => 'required',
            'password' => 'required|min:3'
        ]);

        ModelUser::create([
            'name' => $this->nama,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'peran' => $this->peran,
        ]);

        $this->batal(); // Menggunakan fungsi batal untuk reset semua field
        session()->flash('message', 'User berhasil disimpan.');
    }

    public function pilihEdit($id)
    {
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->nama = $this->penggunaTerpilih->name;
        $this->email = $this->penggunaTerpilih->email;
        $this->peran = $this->penggunaTerpilih->peran;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->penggunaTerpilih->id,
            'peran' => 'required',
        ]);

        $data = [
            'name' => $this->nama,
            'email' => $this->email,
            'peran' => $this->peran,
        ];

        
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $this->penggunaTerpilih->update($data);

        $this->batal();
        session()->flash('message', 'User berhasil diperbarui.');
    }

    public function pilihHapus($id)
    {
        $this->penggunaTerpilih = ModelUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus()
    {
        if ($this->penggunaTerpilih) {
            $this->penggunaTerpilih->delete();
        }

        $this->batal();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function pilihMenu($menu)
    {
        $this->pilihanMenu = $menu;
    }

    public function batal()
    {
        $this->reset(['nama', 'email', 'password', 'peran', 'penggunaTerpilih']);
        $this->pilihanMenu = 'lihat';
    }

    public function render()
    {
        return view('livewire.user', [
            'semuaPengguna' => ModelUser::latest()->get()
        ]);
    }
}