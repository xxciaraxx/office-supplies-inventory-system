<div>
    <h2 style="color:#D6336C; font-size:28px; margin-bottom:0.5rem; font-family:'Playfair Display', serif;">Inventory</h2>

    @if (session()->has('message'))
        <div style="background:#FCA5A5; color:white; padding:10px; margin-bottom:10px; border-radius:6px; font-weight:600;">
            {{ session('message') }}
        </div>
    @endif

    <!-- Form -->
    <div style="background:#FFF5F7; padding:20px; border-radius:10px; margin-bottom:20px; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
        <input type="text" placeholder="Name" wire:model="name" style="padding:10px; margin:5px; width:20%;">
        <input type="text" placeholder="Category" wire:model="category" style="padding:10px; margin:5px; width:20%;">
        <input type="number" placeholder="Quantity" wire:model="quantity" style="padding:10px; margin:5px; width:10%;">
        <input type="number" placeholder="Reorder Level" wire:model="reorder_level" style="padding:10px; margin:5px; width:10%;">

        @if($updateMode)
            <button wire:click="update()" style="background:#D6336C; color:white; padding:10px 20px; margin:5px;">Update</button>
        @else
            <button wire:click="store()" style="background:#D6336C; color:white; padding:10px 20px; margin:5px;">Add</button>
        @endif
    </div>

    <!-- Table -->
    <table id="inventory-table" style="width:100%; border-collapse: collapse; background:#F9FAFB; color:#4B4B4B; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
        <thead style="background:#D6336C; color:white;">
            <tr>
                <th style="padding:10px; border:1px solid #E5E7EB;">Name</th>
                <th style="padding:10px; border:1px solid #E5E7EB;">Category</th>
                <th style="padding:10px; border:1px solid #E5E7EB;">Quantity</th>
                <th style="padding:10px; border:1px solid #E5E7EB;">Reorder Level</th>
                <th style="padding:10px; border:1px solid #E5E7EB;">Alert</th>
                <th style="padding:10px; border:1px solid #E5E7EB;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplies as $supply)
                <tr class="supply-row" data-name="{{ $supply->name }}" data-quantity="{{ $supply->quantity }}" data-reorder="{{ $supply->reorder_level }}"
                    style="{{ $supply->quantity <= $supply->reorder_level ? 'background:#FCA5A5; color:white;' : '' }}">
                    <td style="padding:10px; border:1px solid #E5E7EB;">{{ $supply->name }}</td>
                    <td style="padding:10px; border:1px solid #E5E7EB;">{{ $supply->category }}</td>
                    <td style="padding:10px; border:1px solid #E5E7EB;">{{ $supply->quantity }}</td>
                    <td style="padding:10px; border:1px solid #E5E7EB;">{{ $supply->reorder_level }}</td>
                    <td style="padding:10px; border:1px solid #E5E7EB;">
                        @if($supply->quantity <= $supply->reorder_level)
                            <span class="low-stock-text" style="color:white; font-weight:bold;">Low Stock!</span>
                        @else
                            <span style="color:#4B4B4B;">OK</span>
                        @endif
                    </td>
                    <td style="padding:10px; border:1px solid #E5E7EB;">
                        <button wire:click="edit({{ $supply->id }})" style="background:#6B7280; color:white; padding:5px 10px; margin-right:5px;">Edit</button>
                        <button wire:click="delete({{ $supply->id }})" style="background:#D6336C; color:white; padding:5px 10px;">Archive</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Toggle Archive -->
    <button wire:click="toggleArchive"
        style="background:#6B7280; color:white; padding:10px 20px; border-radius:6px; margin-bottom:15px;">
        {{ $showArchive ? 'Hide Archive' : 'Show Archive' }}
    </button>
    
    <!-- Low Stock Alert JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#inventory-table .supply-row');
            rows.forEach(row => {
                const quantity = parseInt(row.dataset.quantity);
                const reorder = parseInt(row.dataset.reorder);
                const name = row.dataset.name;

                if (quantity <= reorder) {
                    row.style.transition = 'background 1s';
                    row.style.animation = 'pulse 2s infinite alternate';

                    setTimeout(() => {
                        alert(`⚠️ Low Stock Alert: ${name} (Quantity: ${quantity})`);
                    }, 100);
                }
            });
        });

        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes pulse {
                0% { background-color: #ec5da0ff; }
                50% { background-color: #FFF5F7; }
                100% { background-color: #fa6565ff; }
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- ARCHIVE TABLE -->
    @if($showArchive)
        <h3 style="margin-top:30px; color:#6B7280;">Archived Items</h3>
        <table id="archive-table" style="width:100%; margin-top:10px; border-collapse:collapse; background:#FEF2F2; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <thead style="background:#9CA3AF; color:white;">
                <tr>
                    <th style="padding:10px; border:1px solid #D1D5DB;">Name</th>
                    <th style="padding:10px; border:1px solid #D1D5DB;">Category</th>
                    <th style="padding:10px; border:1px solid #D1D5DB;">Quantity</th>
                    <th style="padding:10px; border:1px solid #D1D5DB;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archivedSupplies as $item)
                    <tr id="archived-item-{{ $item->id }}">
                        <td style="padding:10px; border:1px solid #D1D5DB;">{{ $item->name }}</td>
                        <td style="padding:10px; border:1px solid #D1D5DB;">{{ $item->category }}</td>
                        <td style="padding:10px; border:1px solid #D1D5DB;">{{ $item->quantity }}</td>
                        <td style="padding:10px; border:1px solid #D1D5DB;">
                            <button wire:click="restore({{ $item->id }})" onclick="flashRow('archived-item-{{ $item->id }}', 'green')"
                                style="background:#10B981; color:white; padding:5px 10px; margin-right:5px;">
                                Restore
                            </button>
                            <button wire:click="forceDelete({{ $item->id }})" onclick="flashRow('archived-item-{{ $item->id }}', 'red')"
                                style="background:#B91C1C; color:white; padding:5px 10px;">
                                Delete Permanently
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            // Function to flash a table row green or red
            function flashRow(rowId, color) {
                const row = document.getElementById(rowId);
                if (!row) return;

                row.style.transition = 'background 0.5s';
                row.style.backgroundColor = color === 'green' ? '#10B981aa' : '#B91C1Caa';

                setTimeout(() => {
                    row.style.backgroundColor = '';
                }, 1000);
            }
        </script>
    @endif

</div>
