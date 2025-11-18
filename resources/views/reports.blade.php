<x-layout.layout>

    <!-- PRINT HEADER -->
    <x-slot name="print">
        <div style="text-align:center; margin-bottom:2rem;">
            <h1 style="color:#D6336C; font-family:'Playfair Display', serif;">Office Supplies Inventory Report</h1>

            <p style="margin:0; font-size:16px;">
                Generated on: {{ now()->format('F j, Y g:i A') }}
            </p>

            <p style="margin-top:0.5rem; font-size:14px; color:#6B7280;">
                Prepared by: System Generated Report
            </p>

            <hr style="border:1px solid #FCA5A5; margin:1rem 0;">
        </div>
    </x-slot>


    <!-- PAGE TITLE -->
    <h2 style="color:#D6336C; font-size:28px; margin-bottom:1rem; font-family:'Playfair Display', serif;">Reports</h2>

    @php
        $supplies = \App\Models\OfficeSupply::all();
        $lowStock = $supplies->filter(fn($s) => $s->quantity <= $s->reorder_level);
        $outOfStock = $supplies->filter(fn($s) => $s->quantity == 0);
        $totalQuantity = $supplies->sum('quantity');

        $categoryCounts = $supplies->groupBy('category')->map->count();
    @endphp



    <!-- SUMMARY CARDS -->
    <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">

        <div style="background:#FFF5F7; padding:1rem; flex:1; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
            <h4 style="margin:0; color:#D6336C;">Total Items</h4>
            <p style="font-size:26px; font-weight:bold;">{{ $supplies->count() }}</p>
        </div>

        <div style="background:#FFE4E6; padding:1rem; flex:1; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
            <h4 style="margin:0; color:#B91C1C;">Low Stock</h4>
            <p style="font-size:26px; font-weight:bold;">{{ $lowStock->count() }}</p>
        </div>

        <div style="background:#FECDD3; padding:1rem; flex:1; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
            <h4 style="margin:0; color:#7F1D1D;">Out of Stock</h4>
            <p style="font-size:26px; font-weight:bold;">{{ $outOfStock->count() }}</p>
        </div>

        <div style="background:#FFF1F2; padding:1rem; flex:1; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
            <h4 style="margin:0; color:#C026D3;">Total Quantity</h4>
            <p style="font-size:26px; font-weight:bold;">{{ $totalQuantity }}</p>
        </div>

    </div>




    <!-- CHARTS -->
    <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:2rem;">

        <!-- Inventory Quantity Bar Chart -->
        <div style="flex:1 1 250px; max-width:700px; background:#FFF5F7; padding:0.8rem; border-radius:10px;">
            <h3 style="color:#D6336C;">Inventory Quantities</h3>
            <canvas id="inventoryBarChart" height="230"></canvas>
        </div>

        <!-- Category Pie Chart -->
        <div style="flex:1 1 250px; max-width:400px; background:#FFF5F7; padding:0.8rem; border-radius:10px;">
            <h3 style="color:#D6336C;">Category Breakdown</h3>
            <canvas id="categoryPieChart" height="230"></canvas>
        </div>

    </div>

    <!-- LOW STOCK LIST -->
    @if($lowStock->count() > 0)
    <h3 style="color:#B91C1C; margin-top:1rem;">⚠️ Low Stock Items</h3>

    <table style="width:100%; margin-bottom:1rem; background:#FFF1F2;">
        <thead style="background:#D6336C; color:white;">
            <tr>
                <th style="padding:8px;">Name</th>
                <th style="padding:8px;">Quantity</th>
                <th style="padding:8px;">Reorder Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStock as $item)
                <tr>
                    <td style="padding:8px;">{{ $item->name }}</td>
                    <td style="padding:8px;">{{ $item->quantity }}</td>
                    <td style="padding:8px;">{{ $item->reorder_level }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif



    <!-- MAIN TABLE (Your original table kept intact) -->
    <h3 style="color:#D6336C; margin-top:1rem;">List of Items</h3>
    <table style="width:100%; border-collapse:collapse; background:#F9FAFB; color:#4B4B4B;">
        <thead style="background:#D6336C; color:white;">
            <tr>
                <th style="padding:12px;">#</th>
                <th style="padding:12px;">Name</th>
                <th style="padding:12px;">Category</th>
                <th style="padding:12px;">Quantity</th>
                <th style="padding:12px;">Reorder Level</th>
                <th style="padding:12px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplies as $i => $supply)
                <tr style="background: {{ $i % 2 === 0 ? '#FFF5F7' : '#F9FAFB' }};">
                    <td style="padding:10px;">{{ $i+1 }}</td>
                    <td style="padding:10px;">{{ $supply->name }}</td>
                    <td style="padding:10px;">{{ $supply->category }}</td>
                    <td style="padding:10px;">{{ $supply->quantity }}</td>
                    <td style="padding:10px;">{{ $supply->reorder_level }}</td>
                    <td style="padding:10px; font-weight:bold; color:{{ $supply->quantity <= $supply->reorder_level ? '#B91C1C' : '#10B981' }}">
                        {{ $supply->quantity <= $supply->reorder_level ? 'Low Stock' : 'OK' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* BAR CHART */
        new Chart(document.getElementById('inventoryBarChart'), {
            type: 'bar',
            data: {
                labels: @json($supplies->pluck('name')),
                datasets: [{
                    data: @json($supplies->pluck('quantity')),
                    backgroundColor: @json($supplies->map(fn($s) => $s->quantity <= $s->reorder_level ? '#FCA5A5' : '#D6336C')),
                    borderWidth: 1
                }]
            }
        });

        /* PIE CHART */
        new Chart(document.getElementById('categoryPieChart'), {
            type: 'pie',
            data: {
                labels: @json($categoryCounts->keys()),
                datasets: [{
                    data: @json($categoryCounts->values()),
                }]
            }
        });
    </script>

    <!-- PRINT BUTTON -->
    <div style="text-align:right; margin-bottom:1rem;">
        <button onclick="window.print()" 
            style="background:#D6336C; color:white; padding:10px 18px; border:none; border-radius:8px; cursor:pointer;">
            🖨️ Print Report
        </button>
    </div>

    <style>
        @media print {

            header,
            footer,
            .layout-header,
            .layout-footer,
            nav,
            .sidebar,
            #sidebar,
            .navbar,
            .topbar {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .chart-container,
            div[style*="max-width:700px"],
            div[style*="max-width:400px"] {
                margin: 0 auto !important;  
                padding: 0 !important;
                width: 100% !important;    
            }

            canvas {
                width: 100% !important;
                height: auto !important;    
                display: block !important;
            }

            h3 {
                margin-top: 0 !important;
                margin-bottom: 0.3rem !important;
                padding: 0 !important;
            }

            body, html {
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            main, .content, .wrapper, .container {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            table {
                width: 100% !important;
                border-collapse: collapse !important;
                page-break-inside: auto !important;   
                table-layout: fixed !important;       
                word-wrap: break-word !important;
            }

            tr {
                page-break-inside: avoid !important;  
                page-break-after: auto !important;
            }

            th, td {
                border: 1px solid #ccc !important;
                padding: 6px !important;
            }

            button, .no-print, [wire\:click] {
                display: none !important;
            }
        }
</style>

</x-layout.layout>
