<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Cabang; // Tambahkan import untuk model Cabang
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    #[Title('Dashboard')]
    public $users;
    public $totalUsers;
    public $totalClinics;
    public $totalPatients;
    public $userGrowthLabels = [];
    public $userGrowthData = [];
    public $recentUsers = [];

    public function mount()
    {
        // Ambil data users
        $this->users = User::all();

        // Total Users, Clinics, and Pasien
        $this->totalUsers = User::count();
        $this->totalClinics = Cabang::count();
        $this->totalPatients = User::where('role', 'pasien')->count();
        $this->recentUsers = User::latest()->take(5)->get(); // Ambil 5 user terbaru

        // Ambil data user growth per bulan
        $growth = User::selectRaw("DATE_FORMAT(created_at, '%b') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderByRaw("MIN(created_at)")
            ->get();

        $this->userGrowthLabels = $growth->pluck('month'); // Ambil bulan
        $this->userGrowthData = $growth->pluck('total'); // Ambil jumlah user tiap bulan
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        session()->flash('message', 'User berhasil dihapus!');
        $this->users = User::all(); // Refresh data setelah hapus
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
