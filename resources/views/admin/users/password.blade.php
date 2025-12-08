<div class="border-t pt-3 mt-2">
    <div class="text-xs font-semibold text-slate-600 mb-2">Ubah Password (opsional)</div>

    <div class="mb-3">
        <label class="block text-xs text-slate-500 mb-1">Password Baru</label>
        <div class="relative">
            <input type="password" name="password" id="admin_password"
                class="w-full rounded-lg border-slate-300 text-sm px-3 py-2 pr-16"
                placeholder="Kosongkan jika tidak diubah">
            <button type="button" onclick="togglePassword('admin_password', this)"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-indigo-600 font-medium">
                Lihat
            </button>
        </div>
    </div>

    <div>
        <label class="block text-xs text-slate-500 mb-1">Konfirmasi Password Baru</label>
        <div class="relative">
            <input type="password" name="password_confirmation" id="admin_password_confirmation"
                class="w-full rounded-lg border-slate-300 text-sm px-3 py-2 pr-16" placeholder="Ulangi password baru">
            <button type="button" onclick="togglePassword('admin_password_confirmation', this)"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-indigo-600 font-medium">
                Lihat
            </button>
        </div>
    </div>
</div>

<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = 'Sembunyi';
        } else {
            input.type = 'password';
            btn.textContent = 'Lihat';
        }
    }
</script>
