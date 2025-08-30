<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-10">
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="material-icons text-white text-5xl">lock</i>
                </div>
            </div>
            <h2 class="text-center text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Welcome Back</h2>
            <p class="text-center text-gray-600 dark:text-gray-300 mb-8">Sign in to continue</p>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @session('status')
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg text-sm">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="email"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-base" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white text-base" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                        <span class="ml-2">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
