<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="flex items-center justify-center space-x-2 mb-6">
                <i data-lucide="book-open" class="h-12 w-12 text-primary"></i>
                <span class="text-3xl font-bold text-gray-900">EduLearn</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
            <p class="mt-2 text-gray-600">
                Sudah punya akun?
                <a href="/login" class="text-primary hover:underline font-medium">Masuk di sini</a>
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form wire:submit.prevent="register" class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Depan</label>
                        <input wire:model="first_name" type="text" required
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" />
                        @error('first_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Belakang</label>
                        <input wire:model="last_name" type="text" required
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" />
                        @error('last_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input wire:model="email" type="email" required
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input wire:model="phone" type="tel" required
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" />
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input wire:model="password" type="password" required
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input wire:model="confirm_password" type="password" required
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" />
                    @error('confirm_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input wire:model="agree_terms" type="checkbox"
                        class="h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" />
                    <label class="ml-2 block text-sm text-gray-700">
                        Saya setuju dengan
                        <a href="#" class="text-primary hover:underline">Syarat & Ketentuan</a>
                        dan
                        <a href="#" class="text-primary hover:underline">Kebijakan Privasi</a>
                    </label>
                </div>
                @error('agree_terms')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:ring-2 focus:ring-offset-2 focus:ring-primary transition">
                        <i data-lucide="user-plus" class="h-5 w-5 mr-2"></i>
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

