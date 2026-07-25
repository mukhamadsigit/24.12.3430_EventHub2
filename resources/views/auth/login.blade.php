<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .animate-blob {
            animation: blob 10s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.15); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center py-12 px-4 relative overflow-x-hidden">

    <!-- Decorative background elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-indigo-200 rounded-full filter blur-[120px] animate-blob opacity-70"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-purple-200 rounded-full filter blur-[120px] animate-blob animation-delay-2000 opacity-60"></div>
    <div class="absolute top-[30%] right-[10%] w-[30vw] h-[30vw] bg-blue-100 rounded-full filter blur-[100px] animate-blob animation-delay-4000 opacity-50"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo / Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 bg-white/80 px-4 py-2 rounded-2xl border border-slate-200/50 backdrop-blur-md mb-4 shadow-sm">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm shadow-md shadow-indigo-600/30">AH</div>
                <span class="text-sm font-bold text-slate-800 tracking-tight">AmikomEventHub</span>
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Masuk ke Akun</h1>
            <p class="text-slate-500 mt-1.5 text-sm font-medium">Temukan dan pesan tiket event menarik di Amikom</p>
        </div>

        <!-- Glassmorphic Login Card -->
        <div class="glass rounded-[2rem] p-8 shadow-xl border border-white">
            
            <!-- Login Type Selector Tabs -->
            <div class="flex bg-slate-100/80 p-1.5 rounded-2xl mb-6 border border-slate-200/50">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 rounded-xl text-xs font-bold transition duration-200 bg-white text-indigo-600 shadow-sm border border-slate-200/30">
                    Masuk Sebagai User
                </a>
                <a href="{{ route('admin.login') }}" class="flex-1 text-center py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:text-slate-700 transition duration-200">
                    Masuk Sebagai Admin
                </a>
            </div>
            
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-100 text-rose-700 text-xs px-4 py-3 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="font-semibold leading-snug">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" required
                               class="block w-full pl-11 pr-4 py-3.5 bg-white/70 focus:bg-white border border-slate-200 focus:border-indigo-500 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 text-slate-800 placeholder-slate-400 text-sm transition duration-200 shadow-sm"
                               placeholder="nama@email.com"
                               value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="block w-full pl-11 pr-4 py-3.5 bg-white/70 focus:bg-white border border-slate-200 focus:border-indigo-500 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 text-slate-800 placeholder-slate-400 text-sm transition duration-200 shadow-sm"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white rounded-2xl font-bold shadow-lg shadow-indigo-600/20 transition duration-150 text-sm">
                    Masuk
                </button>
            </form>

            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink mx-4 text-slate-400 text-xs font-bold uppercase tracking-wider">Atau masuk dengan</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <!-- Google SSO Button -->
            <a href="{{ route('google.login') }}"
               class="w-full py-3.5 border border-slate-200 hover:bg-slate-50 active:scale-[0.98] text-slate-700 bg-white rounded-2xl font-bold shadow-sm transition duration-150 flex items-center justify-center gap-3 text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                    <g transform="matrix(1, 0, 0, 1, 0, 0)">
                        <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.29c1.92,-1.77 3.02,-4.38 3.02,-7.38C21.65,11.83 21.54,11.45 21.35,11.1z" fill="#4285F4" />
                        <path d="M12,20.62c2.43,0 4.47,-0.81 5.96,-2.19l-3.29,-2.58c-0.91,0.61 -2.07,0.97 -3.37,0.97 -2.34,0 -4.33,-1.58 -5.04,-3.71H2.88v2.66c1.49,2.96 4.56,4.85 7.63,4.85z" fill="#34A853" />
                        <path d="M6.96,13.11c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7s0.11,-1.16 0.29,-1.7V7.05H2.88c-0.63,1.25 -0.99,2.67 -0.99,4.16s0.36,2.91 0.99,4.16L6.96,13.11z" fill="#FBBC05" />
                        <path d="M12,6.01c1.32,0 2.5,0.45 3.44,1.35l2.58,-2.58c-1.56,-1.46 -3.59,-2.34 -6.02,-2.34 -3.07,0 -6.14,1.89 -7.63,4.85l4.08,3.16c0.71,-2.13 2.7,-3.71 5.04,-3.71z" fill="#EA4335" />
                    </g>
                </svg>
                Continue with Google
            </a>

        </div>

        <!-- Back to site link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 text-xs font-bold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
