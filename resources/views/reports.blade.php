<x-layouts.app> 
    <h2 style="color:#D6336C; font-size:28px; margin-bottom:1rem; font-family:'Playfair Display', serif;">Reports</h2>

    @php
        $supplies = \App\Models\OfficeSupply::all();

        $chartLabels = $supplies->pluck('name');
        $chartData = $supplies->pluck('quantity');
        $chartColors = $supplies->map(fn($s) => $s->quantity <= $s->reorder_level ? '#FCA5A5' : '#D6336C');
        $lowStockCount = $supplies->where('quantity', '<=', 'reorder_level')->count();
        $okStockCount = $supplies->count() - $lowStockCount;
    @endphp

    <!-- Charts -->
    <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2rem;">
        <div style="flex:1 1 250px; max-width:700px; background:#FFF5F7; padding:0.8rem; border-radius:10px;">
            <h3 style="color:#D6336C; font-size:18px; margin-bottom:0.5rem;">Inventory Quantities</h3>
            <canvas id="inventoryBarChart" style="height:200px;"></canvas>
        </div>
    </div>

    <!-- Table -->
    <table style="width:100%; border-collapse:collapse; background:#F9FAFB; color:#4B4B4B; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <thead style="background:#D6336C; color:white;">
            <tr>
                <th style="padding:12px; border-bottom:2px solid #FCA5A5; text-align:left;">#</th>
                <th style="padding:12px; border-bottom:2px solid #FCA5A5; text-align:left;">Name</th>
                <th style="padding:12px; border-bottom:2px solid #FCA5A5; text-align:left;">Category</th>
                <th style="padding:12px; border-bottom:2px solid #FCA5A5; text-align:left;">Quantity</th>
                <th style="padding:12px; border-bottom:2px solid #FCA5A5; text-align:left;">Reorder Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplies as $index => $supply)
            <tr style="background: {{ $index % 2 == 0 ? '#FFF5F7' : '#F9FAFB' }};">
                <td style="padding:10px;">{{ $index + 1 }}</td>
                <td style="padding:10px;">{{ $supply->name }}</td>
                <td style="padding:10px;">{{ $supply->category }}</td>
                <td style="padding:10px;">{{ $supply->quantity }}</td>
                <td style="padding:10px;">{{ $supply->reorder_level }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button onclick="window.print()" 
        style="margin-top:1rem; padding:10px 20px; background:#D6336C; color:white; border:none; border-radius:6px; cursor:pointer;">
        Print Report
    </button>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctxBar = document.getElementById('inventoryBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Quantity',
                data: @json($chartData),
                backgroundColor: @json($chartColors),
                borderColor: '#4B4B4B',
                borderWidth: 1
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

    <!-- Print-friendly styles -->
    <style>
        @media print {
            body {
                background: white;
                color: black;
                -webkit-print-color-adjust: exact;
            }

            header {
                position: relative;
                top: 0;
                display: block;
                width: 100%;
                page-break-after: avoid;
                box-shadow: none;
                background: white !important;
                color: black !important;
                padding: 1rem 0;
                text-align: center;
            }

            button, nav, footer {
                display: none !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</x-layouts.app>
