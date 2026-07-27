<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Resmi - {{ $transaction ? $transaction->event->title : 'AmikomEventHub' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .ticket-box { shadow: none !important; border: 2px solid #e2e8f0 !important; }
        }
    </style>
</head>

<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-4 sm:p-6">

    <div class="max-w-lg w-full space-y-6">
        <!-- Header Banner (No Print) -->
        <div class="text-center space-y-2 no-print">
            <div class="w-16 h-16 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto border border-emerald-500/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-black">E-Ticket Resmi Terbit</h1>
            <p class="text-slate-400 text-xs">Simpan atau tunjukkan E-Ticket ini saat memasuki venue acara.</p>
        </div>

        <!-- Ticket Card -->
        <div class="ticket-box bg-white text-slate-900 rounded-[2.5rem] overflow-hidden shadow-2xl relative border border-slate-200">
            <!-- Ticket Header -->
            <div class="p-8 bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 text-white text-center relative overflow-hidden">
                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-[10px] font-extrabold uppercase tracking-widest inline-block mb-3">
                    ✔ STATUS: TERKONFIRMASI LUNAS
                </span>
                <h2 class="text-2xl font-black leading-tight">
                    {{ $transaction ? $transaction->event->title : 'Event Amikom' }}
                </h2>
                <p class="text-indigo-200 text-xs mt-2 font-medium">
                    Kategori: {{ $transaction && $transaction->event->category ? $transaction->event->category->name : 'Umum' }}
                </p>

                <!-- Ticket Cut Out Notch -->
                <div class="absolute -left-4 -bottom-4 w-8 h-8 bg-slate-900 rounded-full border border-slate-200"></div>
                <div class="absolute -right-4 -bottom-4 w-8 h-8 bg-slate-900 rounded-full border border-slate-200"></div>
            </div>

            <!-- Ticket Body -->
            <div class="p-8 space-y-6 bg-white">
                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-6 text-left border-b border-slate-100 pb-6">
                    <div>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Nama Pemegang Tiket</p>
                        <p class="font-black text-slate-900 text-base truncate">{{ $transaction ? $transaction->customer_name : 'Peserta' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Order ID</p>
                        <p class="font-mono font-extrabold text-indigo-600 text-sm">{{ $transaction ? $transaction->order_id : 'TRX-SAMPLE' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Waktu Pelaksanaan</p>
                        <p class="font-bold text-slate-800 text-sm">
                            {{ $transaction ? \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') : '-' }} WIB
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Lokasi Venue</p>
                        <p class="font-bold text-slate-800 text-sm truncate">{{ $transaction ? $transaction->event->location : 'Venue Utama' }}</p>
                    </div>
                </div>

                <!-- QR Code Box -->
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200/80 flex flex-col items-center justify-center space-y-3 text-center">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">QR Code Validasi Check-In</p>
                    
                    <!-- Clean SVG QR Code Container -->
                    <div class="w-44 h-44 bg-white p-3 rounded-2xl shadow-md border border-slate-200 flex items-center justify-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($transaction ? $transaction->order_id : 'TICKET-TEST') }}" 
                             alt="QR Code Ticket" class="w-full h-full object-contain">
                    </div>

                    <div class="space-y-0.5">
                        <p class="font-mono font-black text-slate-900 text-sm tracking-wider">
                            {{ $transaction ? $transaction->order_id : 'TKT-001293848' }}
                        </p>
                        <p class="text-[10px] text-slate-400 font-semibold">Tunjukkan QR Code ini ke petugas pintu masuk.</p>
                    </div>
                </div>
            </div>

            <!-- Ticket Footer / Actions (No Print) -->
            <div class="p-8 pt-0 space-y-3 no-print">
                <button onclick="window.print()"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-sm shadow-xl shadow-indigo-200 transition active:scale-95 flex items-center justify-center gap-2">
                    <span>🖨️ Cetak / Simpan PDF Tiket</span>
                </button>
                <a href="{{ route('home') }}"
                    class="block text-center py-2 text-slate-500 font-bold hover:text-indigo-600 text-xs">
                    &larr; Kembali ke Beranda AmikomEventHub
                </a>
            </div>
        </div>
    </div>

</body>
</html>