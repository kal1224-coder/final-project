<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - YG Training</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="shortcut icon" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-xl space-y-6">

    {{-- Back link --}}
    <a href="{{ Auth::user()->usertype === 'admin' ? route('admin.dashboard') : route('trainee.dashboard') }}"
       class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    {{-- Success / Error alerts --}}
    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
        </div>
    @endif

    {{-- Profile Picture & Name --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-base font-bold text-slate-800 mb-5">
            <i class="fas fa-user-circle text-blue-500 mr-2"></i>Profile Information
        </h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PATCH')

            {{-- Avatar preview --}}
            <div class="flex items-center gap-5">
                <div class="relative">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}"
                             id="avatar-preview"
                             class="w-20 h-20 rounded-full object-cover border-4 border-blue-100 shadow">
                    @else
                        <div id="avatar-placeholder"
                             class="w-20 h-20 rounded-full bg-[#0b132b] text-white flex items-center justify-center text-2xl font-bold border-4 border-blue-100 shadow">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <img id="avatar-preview" class="w-20 h-20 rounded-full object-cover border-4 border-blue-100 shadow hidden">
                    @endif
                    <label for="profile_picture"
                           class="absolute bottom-0 right-0 w-7 h-7 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center cursor-pointer shadow transition">
                        <i class="fas fa-camera text-xs"></i>
                    </label>
                </div>
                <div class="text-sm text-slate-500">
                    <p class="font-medium text-slate-700">{{ $user->name }}</p>
                    <p>{{ $user->email }}</p>
                    <p class="text-xs mt-1">JPG, PNG, WEBP — max 2MB</p>
                </div>
            </div>

            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="hidden"
                   onchange="previewAvatar(event)">

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                <i class="fas fa-save mr-2"></i>Save Changes
            </button>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-base font-bold text-slate-800 mb-5">
            <i class="fas fa-lock text-amber-500 mr-2"></i>Change Password
        </h2>

        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                <input type="password" name="password" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2.5 rounded-xl text-sm font-semibold transition">
                <i class="fas fa-key mr-2"></i>Update Password
            </button>
        </form>
    </div>

    {{-- Danger Zone --}}
    <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-6">
        <h2 class="text-base font-bold text-red-700 mb-2">
            <i class="fas fa-trash-alt mr-2"></i>Delete Account
        </h2>
        <p class="text-sm text-slate-500 mb-4">This will permanently delete your account and all data.</p>

        <form action="{{ route('profile.destroy') }}" method="POST"
              onsubmit="return confirm('Are you sure? This cannot be undone.')">
            @csrf @method('DELETE')
            <div class="flex gap-3">
                <input type="password" name="password" placeholder="Enter your password" required
                       class="flex-1 border border-red-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                    Delete
                </button>
            </div>
            @error('password', 'userDeletion')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </form>
    </div>

</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const preview = document.getElementById('avatar-preview');
    const placeholder = document.getElementById('avatar-placeholder');
    preview.src = URL.createObjectURL(file);
    preview.classList.remove('hidden');
    if (placeholder) placeholder.classList.add('hidden');
}
</script>

</body>
</html>
