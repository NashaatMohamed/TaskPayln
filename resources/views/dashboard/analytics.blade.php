@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Analytics</h2>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <h5 class="card-title">Posts per Platform</h5>
                        <canvas id="platformChart" height="220"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <h5 class="card-title">Publishing Status</h5>
                        <canvas id="statusChart" height="220"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow rounded">
                    <div class="card-body">
                        <h5 class="card-title">Posts per Day</h5>
                        <canvas id="dailyChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const platformCtx = document.getElementById('platformChart').getContext('2d');
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');

        new Chart(platformCtx, {
            type: 'bar',
            data: {
                labels: @json($postsPerPlatform->pluck('platform.name')),
                datasets: [{
                    label: 'Posts',
                    data: @json($postsPerPlatform->pluck('count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                }
            }
        });

        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Scheduled', 'Published'],
                datasets: [{
                    label: 'Status',
                    data: [{{ $statusCounts['scheduled'] }}, {{ $statusCounts['published'] }}],
                    backgroundColor: ['#f39c12', '#27ae60'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: ctx => `${ctx.label}: ${ctx.raw}` } }
                }
            }
        });

        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: @json($dailyCounts->pluck('date')),
                datasets: [{
                    label: 'Posts per Day',
                    data: @json($dailyCounts->pluck('count')),
                    fill: true,
                    backgroundColor: 'rgba(41, 128, 185, 0.2)',
                    borderColor: '#2980b9',
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>
@endpush
