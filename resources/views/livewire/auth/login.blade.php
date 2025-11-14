<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="flex items-center justify-center space-x-2 mb-6">
                <i data-lucide="book-open" class="h-12 w-12 text-primary"></i>
                <span class="text-3xl font-bold text-gray-900">EduLearn</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-gray-600">
                Belum punya akun?
                <a href="/register" class="text-primary hover:underline font-medium">Daftar sekarang</a>
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form wire:submit.prevent="login" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">
                        <i data-lucide="mail"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5"></i>
                        <input wire:model="email" type="email" required
                            class="pl-10 w-full px-3 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-colors"
                            placeholder="Masukkan email Anda" />
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5"></i>
                        <input wire:model="password" type="password" required
                            class="pl-10 w-full px-3 py-3 border border-gray-300 rounded-lg focus:border-primary focus:ring-2 focus:ring-primary transition-colors"
                            placeholder="Masukkan password Anda" />
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input wire:model="remember" id="remember-me" type="checkbox"
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" />
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="text-primary hover:underline font-medium">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                        <i data-lucide="log-in" class="h-5 w-5 mr-2"></i>
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
