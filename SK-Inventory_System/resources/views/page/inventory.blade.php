@extends('layouts.app')

@section('content')
    <!-- PAGE TITLE BANNER -->
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-l-4 border-l-blue-900">
        <div>
            <div class="flex items-center space-x-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                    Republic of the Philippines
                </span>
                <span class="text-slate-300">&bull;</span>
                <span class="text-xs font-semibold text-slate-500">Sangguniang Kabataan Portal</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 mt-1 tracking-tight">Supplies & Materials Inventory Management</h2>
            <p class="text-xs text-slate-500">Official registry of barangay youth council assets, equipment, and supplies</p>
        </div>
        <div class="flex items-center space-x-2 text-xs">
            <span class="bg-slate-100 text-slate-700 font-semibold px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                Total Tracked Items: <strong class="text-blue-900">{{ $inventories->total() }}</strong>
            </span>
        </div>
    </div>

    <!-- MAIN GRID CONTAINER: FORM + TABLE -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- FORM CONTAINER: ADD NEW SUPPLY ITEM -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-1 h-fit">
            <div class="bg-[#1B2A4A] text-white px-5 py-4 border-b border-blue-900 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-sm tracking-wide">Register New Supply</h3>
                    <p class="text-[11px] text-slate-300">Add property to inventory records</p>
                </div>
                <div class="w-2 h-2 rounded-full bg-yellow-400"></div>
            </div>
            
            <div class="p-5">
                <!-- Alerts -->
                @if (session('success'))
                    <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-lg font-medium flex items-center space-x-2">
                        <span>✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('inventory.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Item Code -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Item Code / Property No. <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="item_code" value="{{ old('item_code') }}" placeholder="e.g. SK-SPORTS-001" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] transition shadow-2xs font-mono" required>
                        @error('item_code') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Item Name -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Item Description / Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="item_name" value="{{ old('item_name') }}" placeholder="e.g. Molten Basketball GL7X" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] transition shadow-2xs" required>
                        @error('item_name') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] bg-white transition shadow-2xs" required>
                            <option value="">Select Category</option>
                            <option value="Sports Equipment" {{ old('category') == 'Sports Equipment' ? 'selected' : '' }}>Sports Equipment</option>
                            <option value="Office Supplies" {{ old('category') == 'Office Supplies' ? 'selected' : '' }}>Office Supplies</option>
                            <option value="IT & Electronics" {{ old('category') == 'IT & Electronics' ? 'selected' : '' }}>IT & Electronics</option>
                            <option value="Event Materials" {{ old('category') == 'Event Materials' ? 'selected' : '' }}>Event Materials</option>
                        </select>
                        @error('category') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Quantity & Unit Grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="quantity" value="{{ old('quantity') }}" placeholder="0" min="0"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] transition shadow-2xs" required>
                            @error('quantity') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                                Unit <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="unit" value="{{ old('unit') }}" placeholder="pcs / boxes" 
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] transition shadow-2xs" required>
                            @error('unit') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Unit Price -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Unit Price (PHP) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price') }}" placeholder="0.00" min="0"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] transition shadow-2xs" required>
                        @error('unit_price') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-[#1B2A4A] hover:bg-[#142038] text-white text-xs font-bold py-2.5 px-4 rounded-lg transition duration-150 shadow flex items-center justify-center space-x-2">
                            <span>+ Save Inventory Item</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-slate-50 px-5 py-3 border-t border-slate-100 text-[10px] text-slate-500 text-center">
                Property Accountability &bull; COA Standard Compliant
            </div>
        </div>

        <!-- TABLE CONTAINER: MASTER INVENTORY DIRECTORY -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="bg-slate-50 p-4 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm tracking-wide">Master Supply Registry</h3>
                        <p class="text-[11px] text-slate-500">Active stock levels and valuation status</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-[10px] font-bold bg-blue-50 text-blue-900 border border-blue-200 px-2.5 py-1 rounded-md uppercase tracking-wider">
                            Official Audit Ready
                        </span>
                    </div>
                </div>

                <!-- TABLE -->
             <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-[#1B2A4A] text-white uppercase text-[10px] tracking-wider border-b border-slate-300">
                                <th class="py-3.5 px-4 font-bold">Item Code</th>
                                <th class="py-3.5 px-4 font-bold">Item Description</th>
                                <th class="py-3.5 px-4 font-bold">Category</th>
                                <th class="py-3.5 px-4 font-bold">Stock Quantity</th>
                                <th class="py-3.5 px-4 font-bold">Unit Price</th>
                                <th class="py-3.5 px-4 font-bold">Status</th>
                                <th class="py-3.5 px-4 font-bold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-700">
                            @forelse ($inventories as $item)
                                <tr class="hover:bg-slate-50/90 transition-colors">
                                    <!-- Item Code -->
                                    <td class="py-3.5 px-4 font-mono font-bold text-blue-900">
                                        {{ $item->item_code }}
                                    </td>

                                    <!-- Item Name -->
                                    <td class="py-3.5 px-4">
                                        <p class="font-bold text-slate-900 text-xs">{{ $item->item_name }}</p>
                                        <p class="text-[10px] text-slate-500">SK Property Record</p>
                                    </td>

                                    <!-- Category -->
                                    <td class="py-3.5 px-4 font-medium text-slate-600">
                                        {{ $item->category }}
                                    </td>

                                    <!-- Quantity -->
                                    <td class="py-3.5 px-4 font-bold text-slate-800">
                                        {{ $item->quantity }} <span class="text-[10px] font-normal text-slate-500">{{ $item->unit }}</span>
                                    </td>

                                    <!-- Unit Price -->
                                    <td class="py-3.5 px-4 font-medium text-slate-600">
                                        ₱{{ number_format($item->unit_price, 2) }}
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="py-3.5 px-4">
                                        @if ($item->quantity > 10)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                                ● Available
                                            </span>
                                        @elseif ($item->quantity > 0)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                                ⚠ Low Stock
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-900 border border-rose-300">
                                                ✕ Out of Stock
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3.5 px-4 text-right space-x-1">
                                        <!-- EDIT BUTTON -->
                                        <button type="button" 
                                                data-id="{{ $item->id }}"
                                                data-code="{{ $item->item_code }}"
                                                data-name="{{ $item->item_name }}"
                                                data-category="{{ $item->category }}"
                                                data-quantity="{{ $item->quantity }}"
                                                data-unit="{{ $item->unit }}"
                                                data-price="{{ $item->unit_price }}"
                                                onclick="openEditInventoryModal(this)"
                                                class="inline-flex items-center space-x-1 px-2.5 py-1 text-[11px] font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-md transition shadow-2xs">
                                            <span>✏️ Edit</span>
                                        </button>

                                        <!-- DELETE BUTTON -->
                                        <form action="{{ route('inventory.delete', $item->id) }}" method="POST" 
                                            onsubmit="return confirm('OFFICIAL NOTICE: Are you sure you want to delete this property item from the inventory directory?');" 
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center space-x-1 px-2.5 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-md transition shadow-2xs">
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-400 text-xs italic">
                                        No supplies or materials currently recorded in the registry directory.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- TABLE FOOTER WITH PAGINATION -->
            <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-600">
                <div>
                    Showing <strong>{{ $inventories->firstItem() ?? 0 }}</strong> to <strong>{{ $inventories->lastItem() ?? 0 }}</strong> of <strong>{{$inventories->total() }}</strong> entries
                </div>
                <div class="text-xs">
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>

    </div>

    <!-- EDIT INVENTORY ITEM MODAL -->
    <div id="editInventoryModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="bg-[#1B2A4A] text-white px-5 py-4 border-b border-blue-900 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-sm tracking-wide">Update Property Record</h3>
                    <p class="text-[11px] text-slate-300">Modify supply parameters and stock quantities</p>
                </div>
                <button type="button" onclick="closeEditInventoryModal()" class="text-slate-300 hover:text-white text-lg font-bold">&times;</button>
            </div>

            <form id="editInventoryForm" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Item Code / Property No.</label>
                    <input type="text" id="edit_item_code" name="item_code" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Item Description / Name</label>
                    <input type="text" id="edit_item_name" name="item_name" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Category</label>
                    <select id="edit_category" name="category" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] bg-white" required>
                        <option value="Sports Equipment">Sports Equipment</option>
                        <option value="Office Supplies">Office Supplies</option>
                        <option value="IT & Electronics">IT & Electronics</option>
                        <option value="Event Materials">Event Materials</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Quantity</label>
                        <input type="number" id="edit_quantity" name="quantity" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Unit</label>
                        <input type="text" id="edit_unit" name="unit" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Unit Price (PHP)</label>
                    <input type="number" step="0.01" id="edit_unit_price" name="unit_price" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                </div>

                <div class="pt-2 flex items-center justify-end space-x-2">
                    <button type="button" onclick="closeEditInventoryModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#1B2A4A] text-white rounded-lg text-xs font-bold hover:bg-[#142038]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT FOR MODAL INTERACTION -->
    <script>
        function openEditInventoryModal(btn) {
            const modal = document.getElementById('editInventoryModal');
            const form = document.getElementById('editInventoryForm');

            const id = btn.getAttribute('data-id');
            const code = btn.getAttribute('data-code');
            const name = btn.getAttribute('data-name');
            const category = btn.getAttribute('data-category');
            const quantity = btn.getAttribute('data-quantity');
            const unit = btn.getAttribute('data-unit');
            const price = btn.getAttribute('data-price');

            form.action = `/inventory/${id}`;
            document.getElementById('edit_item_code').value = code;
            document.getElementById('edit_item_name').value = name;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_quantity').value = quantity;
            document.getElementById('edit_unit').value = unit;
            document.getElementById('edit_unit_price').value = price;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditInventoryModal() {
            const modal = document.getElementById('editInventoryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection