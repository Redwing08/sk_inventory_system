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
            <h2 class="text-xl font-bold text-slate-800 mt-1 tracking-tight">User Account Management Directory</h2>
            <p class="text-xs text-slate-500">Official registry of authorized council members & administrative personnel</p>
        </div>
        <div class="flex items-center space-x-2 text-xs">
            <span class="bg-slate-100 text-slate-700 font-semibold px-3 py-1.5 rounded-lg border border-slate-200 shadow-2xs">
                Total Personnel: <strong class="text-blue-900">{{ count($users) }}</strong>
            </span>
        </div>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- FORM CONTAINER: REGISTER NEW USER -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-1 h-fit">
            <div class="bg-[#1B2A4A] text-white px-5 py-4 border-b border-blue-900 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-sm tracking-wide">Register New Official</h3>
                    <p class="text-[11px] text-slate-300">Issue government portal credentials</p>
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

                @if (session('error'))
                    <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-lg font-medium flex items-center space-x-2">
                        <span>⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('useraccount.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <!-- Profile Picture Circle with File Picker -->
                    <div class="flex flex-col items-center justify-center mb-2">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Profile Picture
                        </label>
                        <div class="relative group cursor-pointer">
                            <div class="w-20 h-20 rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden bg-slate-50 relative">
                                <img id="createAvatarPreview" class="hidden w-full h-full object-cover">
                                <div id="createAvatarPlaceholder" class="text-center p-2">
                                    <span class="text-xl text-slate-400 block">📷</span>
                                    <span class="text-[9px] text-slate-400 font-semibold block">Upload</span>
                                </div>
                            </div>
                            <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event, 'createAvatarPreview', 'createAvatarPlaceholder')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                        <span class="text-[10px] text-slate-400 mt-1">Click circle to choose image</span>
                        @error('profile_image') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Juan P. Dela Cruz" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] focus:border-[#1B2A4A] transition" required>
                        @error('name') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Official Email -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Official Gov Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="sk.member@barangay.gov.ph" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] focus:border-[#1B2A4A] transition" required>
                        @error('email') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- System Role Selection -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            System Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] focus:border-[#1B2A4A] transition bg-white" required>
                            <option value="User">User (Standard Access)</option>
                            <option value="Admin">Admin (Full Access)</option>
                        </select>
                        @error('role') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">
                            Initial Access Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" placeholder="••••••••" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] focus:border-[#1B2A4A] transition" required>
                        @error('password') <span class="text-red-600 text-[11px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-[#1B2A4A] hover:bg-[#142038] text-white text-xs font-bold py-2.5 px-4 rounded-lg transition duration-150 shadow flex items-center justify-center space-x-2">
                            <span>+ Save Official Account</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-slate-50 px-5 py-3 border-t border-slate-100 text-[10px] text-slate-500 text-center">
                Authorized Personnel Only &bull; Republic Act No. 10742
            </div>
        </div>

        <!-- GOVERNMENT STYLED TABLE: DIRECTORY -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-2">
            <div class="bg-slate-50 p-4 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                <div>
                    <h3 class="font-bold text-slate-800 text-sm tracking-wide">Official Registry Directory</h3>
                    <p class="text-[11px] text-slate-500">Active personnel with system clearance</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-[10px] font-bold bg-blue-50 text-blue-900 border border-blue-200 px-2.5 py-1 rounded-md uppercase tracking-wider">
                        Secure System
                    </span>
                </div>
            </div>

            <!-- TABLE CONTAINER -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-[#1B2A4A] text-white uppercase text-[10px] tracking-wider border-b border-slate-300">
                            <th class="py-3.5 px-4 font-bold">User Profile</th>
                            <th class="py-3.5 px-4 font-bold">Official Email</th>
                            <th class="py-3.5 px-4 font-bold">System Role</th>
                            <th class="py-3.5 px-4 font-bold">Access Status</th>
                            <th class="py-3.5 px-4 font-bold text-right">Action / Options</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                   @foreach ($users as $u)
                        <tr class="hover:bg-slate-50/90 transition-colors">
                            <!-- Profile Picture & Name Column -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center space-x-3">
                                    @if ($u->profile_image)
                                        <img src="{{ asset($u->profile_image) }}" alt="{{ $u->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-300 shadow-2xs">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-slate-200 text-[#1B2A4A] border border-slate-300 font-bold flex items-center justify-center text-xs shadow-2xs">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-slate-900 text-xs">{{ $u->name }}</p>
                                        <p class="text-[10px] text-slate-500">SK Council Official</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="py-3.5 px-4 font-medium text-slate-600">
                                {{ $u->email }}
                            </td>

                            <!-- Role -->
                            <td class="py-3.5 px-4">
                                @if ($u->role === 'Admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                        ⚡ Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-300">
                                        👤 User
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="py-3.5 px-4">
                                @if ($u->id === Auth::id())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-900 border border-blue-300">
                                        ● Active (You)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                        ● Active
                                    </span>
                                @endif
                            </td>

                            <!-- Actions: EDIT and DELETE -->
                            <td class="py-3.5 px-4 text-right space-x-1">
                                <!-- EDIT BUTTON using data attributes (Safe Blade Syntax) -->
                                <button type="button" 
                                        data-id="{{ $u->id }}"
                                        data-name="{{ $u->name }}"
                                        data-email="{{ $u->email }}"
                                        data-role="{{ $u->role }}"
                                        data-image="{{ $u->profile_image ? asset($u->profile_image) : '' }}"
                                        onclick="openEditModalFromBtn(this)"
                                        class="inline-flex items-center space-x-1 px-2.5 py-1 text-[11px] font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-md transition shadow-2xs">
                                    <span>✏️ Edit</span>
                                </button>

                                @if ($u->id !== Auth::id())
                                    <!-- DELETE BUTTON -->
                                    <form action="{{ route('useraccount.delete', $u->id) }}" method="POST" 
                                        onsubmit="return confirm('OFFICIAL NOTICE: Are you sure you want to revoke and delete this user account access?');" 
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center space-x-1 px-2.5 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-md transition shadow-2xs">
                                            <span>Revoke</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="p-3 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-[10px] text-slate-500">
                <p>SK Inventory System &bull; User Editor</p>
                <p class="font-bold text-blue-900">National Government Portal Format</p>
            </div>
        </div>

    </div>

    <!-- EDIT USER MODAL -->
    <div id="editUserModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center z-50 p-4">
        <div class="bg-white w-full max-w-md rounded-xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="bg-[#1B2A4A] text-white px-5 py-4 border-b border-blue-900 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-sm tracking-wide">Update Official Record</h3>
                    <p class="text-[11px] text-slate-300">Modify council member parameters</p>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-slate-300 hover:text-white text-lg font-bold">&times;</button>
            </div>

            <form id="editUserForm" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                @method('PUT')

                <!-- Circular Profile Picture Picker for Edit -->
                <div class="flex flex-col items-center justify-center mb-2">
                    <div class="relative group cursor-pointer">
                        <div class="w-20 h-20 rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden bg-slate-50 relative">
                            <img id="editAvatarPreview" class="w-full h-full object-cover">
                            <div id="editAvatarPlaceholder" class="hidden text-center p-2">
                                <span class="text-xl text-slate-400 block">📷</span>
                                <span class="text-[9px] text-slate-400 font-semibold block">Upload</span>
                            </div>
                        </div>
                        <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event, 'editAvatarPreview', 'editAvatarPlaceholder')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                    <span class="text-[10px] text-slate-400 mt-1">Click image to change profile photo</span>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Full Name</label>
                    <input type="text" id="edit_name" name="name" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">Official Email</label>
                    <input type="email" id="edit_email" name="email" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]" required>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">System Role</label>
                    <select id="edit_role" name="role" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A] bg-white" required>
                        <option value="User">User (Standard Access)</option>
                        <option value="Admin">Admin (Full Access)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-700 mb-1">New Password (Optional)</label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-[#1B2A4A]">
                </div>

                <div class="pt-2 flex items-center justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#1B2A4A] text-white rounded-lg text-xs font-bold hover:bg-[#142038]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT FOR IMAGE PREVIEW & MODAL EDIT -->
 <script>
    // Live Profile Image Preview Function
    function previewImage(event, previewId, placeholderId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Open Edit Modal using dataset attributes
    function openEditModalFromBtn(btn) {
        const modal = document.getElementById('editUserModal');
        const form = document.getElementById('editUserForm');

        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const email = btn.getAttribute('data-email');
        const role = btn.getAttribute('data-role');
        const image = btn.getAttribute('data-image');

        form.action = `/useraccount/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role || 'User';

        const preview = document.getElementById('editAvatarPreview');
        const placeholder = document.getElementById('editAvatarPlaceholder');

        if (image) {
            preview.src = image;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        } else {
            preview.classList.add('hidden');
            if (placeholder) placeholder.classList.remove('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editUserModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection