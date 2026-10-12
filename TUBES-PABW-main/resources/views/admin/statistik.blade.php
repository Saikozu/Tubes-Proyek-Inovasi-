@extends('layouts.admin')

@section('title', 'Statistik Laporan')

@section('content')
    <h2 class="mb-4">📊 Statistik Laporan</h2>

    <div class="card shadow-sm p-4 w-100">
        <div style="height:400px;">
            <canvas id="laporanChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('laporanChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($data->toArray())) !!},
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: {!! json_encode(array_values($data->toArray())) !!},
                    backgroundColor: ['#f59e0b', '#22c55e', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
@endsection
