@extends('layouts.app')

@section('content')
    <!-- Page Title Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Dashboard</h2>
            <p class="text-xs text-slate-500">Supplies and Materials Inventory Overview</p>
        </div>
        <div class="bg-white px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-medium text-slate-600 shadow-sm flex items-center space-x-2">
            <span>As of <strong>{{ date('M d, Y') }}</strong></span>
        </div>
    </div>

    <!-- STAT CARDS ROW[cite: 6] -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Items -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Items</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">248</h3>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">📦</div>
            </div>
            <p class="text-[11px] text-green-600 font-semibold mt-3">↑ +12 this month</p>
        </div>

        <!-- Total Stock Quantity -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Stock Quantity</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">12,540</h3>
                </div>
                <div class="p-2 bg-green-50 text-green-600 rounded-lg">📊</div>
            </div>
            <p class="text-[11px] text-green-600 font-semibold mt-3">↑ +8% this month</p>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Low Stock Items</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">18</h3>
                </div>
                <div class="p-2 bg-red-50 text-red-600 rounded-lg">⚠️</div>
            </div>
            <p class="text-[11px] text-red-600 font-semibold mt-3">↓ -5% this month</p>
        </div>

        <!-- Pending Replenishment -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Replenishment</p>
                    <h3 class="text-2xl font-black text-slate-800 mt-1">7</h3>
                </div>
                <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">🛒</div>
            </div>
            <p class="text-[11px] text-green-600 font-semibold mt-3">↑ +2 this month</p>
        </div>
    </div>

    <!-- SUPPLIES AND MATERIALS TABLE SECTION -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="font-bold text-slate-800 text-sm">Supplies and Materials List</h3>
            <button class="bg-blue-900 hover:bg-blue-800 text-white text-xs font-semibold px-3 py-2 rounded-lg transition shadow-sm">
                + Add New Item
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <th class="p-3 font-bold">Item Code</th>
                        <th class="p-3 font-bold">Item Name</th>
                        <th class="p-3 font-bold">Category</th>
                        <th class="p-3 font-bold">Unit</th>
                        <th class="p-3 font-bold">Current Stock</th>
                        <th class="p-3 font-bold">Reorder Level</th>
                        <th class="p-3 font-bold">Status</th>
                        <th class="p-3 font-bold">Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50/80">
                        <td class="p-3 font-semibold text-blue-900">SUP-001</td>
                        <td class="p-3 font-medium">Bond Paper (A4)</td>
                        <td class="p-3">Office Supplies[cite: 6]</td>
                        <td class="p-3">ream[cite: 6]</td>
                        <td class="p-3 font-bold">150</td>
                        <td class="p-3">50</td>
                        <td class="p-3"><span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-[10px] font-bold">In Stock</span></td>
                        <td class="p-3">Main Storage[cite: 6]</td>
                    </tr>
                    <tr class="hover:bg-slate-50/80">
                        <td class="p-3 font-semibold text-blue-900">SUP-002</td>
                        <td class="p-3 font-medium">Printer Paper (A4)</td>
                        <td class="p-3">Office Supplies</td>
                        <td class="p-3">ream</td>
                        <td class="p-3 font-bold">45</td>
                        <td class="p-3">50</td>
                        <td class="p-3"><span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-[10px] font-bold">Low Stock</span></td>
                        <td class="p-3">Main Storage</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection