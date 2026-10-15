<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Inventory;
use App\Models\User;

class AuthController extends Controller
{
    // 1. Renders the SK Login page
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 2. Manual Login Processing (Guaranteed to work with your database user)
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Find the user manually by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and verify the password using Hash::check
        if ($user && Hash::check($request->password, $user->password)) {
            // Force log them in
            Auth::login($user, $request->boolean('remember'));
            
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        // If it fails, return error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // 3. Handles user logout safely
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


    public function showUserPage()
    {
        $users = User::all();
        return view('page.user', compact('users'));
    }

    // 2. Saves a new SK User Account into the database
    public function storeUser(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Create user in database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect back with success alert
        return back()->with('success', 'New SK User Account added successfully!');
    }
    public function deleteUser($id)
    {
        // Prevent user from deleting their own logged-in account
        if (Auth::id() == $id) {
            return back()->with('error', 'You cannot delete your own active account!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User account deleted successfully!');
    }

    public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    // 1. Validate form fields
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|in:Admin,User',
        'password' => 'nullable|min:6',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2. Handle image upload if a new picture is provided
    if ($request->hasFile('profile_image')) {
        // Optional: delete old image file if needed
        if ($user->profile_image && file_exists(public_path($user->profile_image))) {
            unlink(public_path($user->profile_image));
        }

        $file = $request->file('profile_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/users'), $filename);
        $user->profile_image = 'uploads/users/' . $filename;
    }

    // 3. Update fields
    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return back()->with('success', 'User official record updated successfully!');
}

// Show the inventory management directory
// Show the inventory management directory with pagination
public function showInventory()
{
    // Fetch 10 items per page
    $inventories = Inventory::latest()->paginate(10);
    
    return view('page.inventory', compact('inventories'));
}
// Store a new inventory item and calculate stock status
public function storeInventory(Request $request)
{
    $request->validate([
        'item_code'  => 'required|string|unique:inventories,item_code|max:50',
        'item_name'  => 'required|string|max:255',
        'category'   => 'required|string|max:100',
        'quantity'   => 'required|integer|min:0',
        'unit'       => 'required|string|max:50',
        'unit_price' => 'required|numeric|min:0',
    ]);

    // Automatically calculate stock status based on quantity level
    $qty = $request->quantity;
    if ($qty == 0) {
        $status = 'Out of Stock';
    } elseif ($qty <= 10) {
        $status = 'Low Stock';
    } else {
        $status = 'Available';
    }

    Inventory::create([
        'item_code'  => $request->item_code,
        'item_name'  => $request->item_name,
        'category'   => $request->category,
        'quantity'   => $qty,
        'unit'       => $request->unit,
        'unit_price' => $request->unit_price,
        'status'     => $status,
    ]);

    return back()->with('success', 'New inventory property registered successfully!');
}

// 1. Update Inventory Item
public function updateInventory(Request $request, $id)
{
    $item = Inventory::findOrFail($id);

    // Validate inputs
    $request->validate([
        'item_code'  => 'required|string|max:50|unique:inventories,item_code,' . $id,
        'item_name'  => 'required|string|max:255',
        'category'   => 'required|string|max:100',
        'quantity'   => 'required|integer|min:0',
        'unit'       => 'required|string|max:50',
        'unit_price' => 'required|numeric|min:0',
    ]);

    // Recalculate stock status based on quantity
    $qty = $request->quantity;
    if ($qty == 0) {
        $status = 'Out of Stock';
    } elseif ($qty <= 10) {
        $status = 'Low Stock';
    } else {
        $status = 'Available';
    }

    // Save changes
    $item->update([
        'item_code'  => $request->item_code,
        'item_name'  => $request->item_name,
        'category'   => $request->category,
        'quantity'   => $qty,
        'unit'       => $request->unit,
        'unit_price' => $request->unit_price,
        'status'     => $status,
    ]);

    return back()->with('success', 'Inventory item record updated successfully!');
}

// 2. Delete Inventory Item
public function deleteInventory($id)
{
    $item = Inventory::findOrFail($id);
    $item->delete();

    return back()->with('success', 'Inventory item removed from property registry!');
}

}