<x-layout.layout>
    <h2 style="color:#D6336C; font-size:28px; margin-bottom:1rem; font-family:'Playfair Display', serif;">Dashboard</h2>

    @php
        $supplies = \App\Models\OfficeSupply::all();
        $totalSupplies = $supplies->count();
        $lowStockCount = $supplies->filter(fn($s) => $s->quantity <= $s->reorder_level)->count();
        $okStockCount = $totalSupplies - $lowStockCount;
    @endphp

    <!-- Summary Cards -->
    <div style="display:flex; gap:2rem; flex-wrap:wrap; margin-bottom:2rem;">
        <div style="background:#FCA5A5; color:white; padding:1.5rem; border-radius:10px; flex:1; min-width:200px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <h3 style="margin:0; font-size:20px;">Total Supplies</h3>
            <p style="font-size:24px; font-weight:bold;">{{ $totalSupplies }}</p>
        </div>

        <div style="background:#D6336C; color:white; padding:1.5rem; border-radius:10px; flex:1; min-width:200px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <h3 style="margin:0; font-size:20px;">Low Stock Items</h3>
            <p style="font-size:24px; font-weight:bold;">{{ $lowStockCount }}</p>
        </div>

        <div style="background:#FFF5F7; color:#4B4B4B; padding:1.5rem; border-radius:10px; flex:1; min-width:200px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <h3 style="margin:0; font-size:20px;">Total Categories</h3>
            <p style="font-size:24px; font-weight:bold;">
                {{ $supplies->unique('category')->count() }}
            </p>
        </div>
    </div>

    <!-- Line Chart and Materials List Side by Side -->
    <div style="display:flex; gap:2rem; flex-wrap:wrap; margin-bottom:2rem;">
        <!-- Line Chart -->
        <div style="flex:1; min-width:300px; background:#FFF5F7; padding:1rem; border-radius:10px;">
            <h3 style="color:#D6336C; font-size:20px; margin-bottom:0.5rem;">Supplies Overview</h3>
            <canvas id="suppliesLineChart"></canvas>
        </div>

        <!-- List of Materials -->
        <div style="flex:1; min-width:300px; background:#F9FAFB; padding:1rem; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
            <h3 style="color:#D6336C; font-size:20px; margin-bottom:0.5rem;">Available Materials</h3>
            <ul style="padding-left:1rem;">
                @foreach($supplies as $supply)
                    <li>{{ $supply->name }} ({{ $supply->quantity }} in stock)</li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxLine = document.getElementById('suppliesLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Total Supplies', 'Low Stock Items', 'OK Stock Items'],
                datasets: [{
                    label: 'Number of Items',
                    data: [{{ $totalSupplies }}, {{ $lowStockCount }}, {{ $okStockCount }}],
                    borderColor: '#D6336C',
                    backgroundColor: 'rgba(246, 178, 188, 0.3)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#FCA5A5'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#4B4B4B', font: { size: 14 } },
                        grid: { color: '#E5E7EB' }
                    },
                    x: {
                        ticks: { color: '#4B4B4B', font: { size: 14 } },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-layout.layout>
