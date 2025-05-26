<div> <!-- ROOT ELEMENT WAJIB -->

    <div id="main">
        <!-- Header Burger -->
        <header class="mb-4">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <!-- Page Heading -->
        <div class="page-heading">
            <div class="page-title mb-2">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3 class="fw-bold">Dashboard</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Section -->
        <section class="section">
            <!-- Stat Cards -->
            <div class="row">
                @php
                    $stats = [
                        ['icon' => 'bi-person-fill', 'label' => 'Total Users', 'value' => $totalUsers, 'color' => 'primary'],
                        ['icon' => 'bi-hospital-fill', 'label' => 'Total Clinics', 'value' => $totalClinics, 'color' => 'success'],
                        ['icon' => 'bi-person-lines-fill', 'label' => 'Total Pasien', 'value' => $totalPatients, 'color' => 'warning'],
                    ];
                @endphp

                @foreach($stats as $stat)
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm rounded-4 border-0 p-3 h-100 animate-card">
                            <div class="card-body text-center">
                                <i class="bi {{ $stat['icon'] }} fs-1 text-{{ $stat['color'] }} mb-2"></i>
                                <h6 class="mb-1">{{ $stat['label'] }}</h6>
                                <h3 class="text-{{ $stat['color'] }} fw-bold">{{ $stat['value'] }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm rounded-4 border-0 mb-4 animate-card">
                        <div class="card-body">
                            <h5 class="mb-4 fw-semibold">User Growth</h5>
                            <canvas id="userGrowthChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
           <!-- Recent Activities -->
<div class="card shadow-sm rounded-4 border-0 mb-4 animate-card">
    <div class="card-header bg-white border-bottom-0">
        <h5 class="mb-0 fw-semibold">Recent Activities</h5>
    </div>
    <div class="card-body">
        @if($recentUsers->count())
            <ul class="mb-0">
                @foreach($recentUsers as $user)
                    <li>
                        @if($user->created_at == $user->updated_at)
                            New user registered: <strong>{{ $user->name }}</strong>
                        @else
                            User updated: <strong>{{ $user->name }}</strong>
                        @endif
                        <span class="text-muted small">({{ $user->updated_at->diffForHumans() }})</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted mb-0">No recent activities.</p>
        @endif
    </div>
</div>


            <!-- Users Table -->
            <div class="card shadow-sm rounded-4 border-0 animate-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title fw-semibold mb-0">User List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle" id="table1" wire:ignore>
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Cabang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->cabang->nama ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a wire:navigate href="/users/{{ $user->id }}/edit" class="btn btn-sm btn-warning transition-btn">Edit</a>
                                                <button wire:click="delete({{ $user->id }})"
                                                    wire:confirm="Apakah anda yakin ingin menghapus data ini?"
                                                    class="btn btn-sm btn-danger transition-btn">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('userGrowthChart').getContext('2d');
        var userGrowthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($userGrowthLabels),
                datasets: [{
                    label: 'User Growth',
                    data: @json($userGrowthData),
                    borderColor: '#4BC0C0',
                    backgroundColor: 'rgba(75,192,192,0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

    <!-- Custom CSS -->
    <style>
        .animate-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .animate-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        }

        .transition-btn {
            transition: all 0.2s ease-in-out;
        }

        .transition-btn:hover {
            transform: scale(1.05);
        }
    </style>
</div>
