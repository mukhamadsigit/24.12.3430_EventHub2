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
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
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
<body class="bg-[#0f111a] min-h-screen flex items-center justify-center py-12 px-4 relative overflow-x-hidden">

    <!-- Decorative background elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-indigo-600/20 rounded-full filter blur-[120px] animate-blob"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-purple-600/15 rounded-full filter blur-[120px] animate-blob animation-delay-2000"></div>
    <div class="absolute top-[30%] right-[10%] w-[30vw] h-[30vw] bg-blue-600/10 rounded-full filter blur-[100px] animate-blob animation-delay-4000"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo / Brand Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 bg-white/5 px-4 py-2 rounded-2xl border border-white/5 backdrop-blur-md mb-4">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm shadow-md shadow-indigo-600/30">AH</div>
                <span class="text-sm font-bold text-white tracking-tight">AmikomEventHub</span>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Selamat Datang</h1>
            <p class="text-indigo-200/50 mt-1.5 text-sm font-medium">Masuk untuk mengelola portal administrasi</p>
        </div>

        <!-- Glassmorphic Login Card -->
        <div class="glass rounded-[2rem] p-8 shadow-2xl">
            
            <!-- Login Type Selector Tabs -->
            <div class="flex bg-white/5 p-1.5 rounded-2xl mb-6 border border-white/5">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 rounded-xl text-xs font-bold text-indigo-200/50 hover:text-white transition duration-200">
                    Masuk Sebagai User
                </a>
                <a href="{{ route('admin.login') }}" class="flex-1 text-center py-2.5 rounded-xl text-xs font-bold transition duration-200 bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                    Masuk Sebagai Admin
                </a>
            </div>
            
            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-rose-500/10 border border-rose-500/20 text-rose-200 text-xs px-4 py-3 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="font-semibold leading-snug">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-bold text-indigo-200/60 uppercase tracking-wider mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" required
                               class="block w-full pl-11 pr-4 py-3.5 bg-slate-950/40 focus:bg-slate-950/60 border border-white/10 focus:border-indigo-500 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 text-white placeholder-white/20 text-sm transition duration-200"
                               placeholder="contoh@students.amikom.ac.id"
                               value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold text-indigo-200/60 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-white/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="block w-full pl-11 pr-4 py-3.5 bg-slate-950/40 focus:bg-slate-950/60 border border-white/10 focus:border-indigo-500 rounded-2xl outline-none focus:ring-4 focus:ring-indigo-500/10 text-white placeholder-white/20 text-sm transition duration-200"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 active:scale-[0.98] text-white rounded-2xl font-bold shadow-lg shadow-indigo-600/30 transition duration-150">
                    Masuk Sekarang
                </button>
            </form>

            <!-- Academic Footer Inside Card -->
            <div class="mt-8 pt-6 border-t border-white/5 text-center text-[10px] font-bold text-white/30 uppercase tracking-widest">
                Digital Bisnis [SI148] • Universitas AMIKOM Yogyakarta
            </div>

        </div>

        <!-- Back to site link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-indigo-300 hover:text-white text-xs font-bold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>