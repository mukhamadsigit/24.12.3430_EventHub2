@extends('layouts.app')

@section('title', 'Pembayaran - ' . $transaction->event->title)

@section('content')
<main class="max-w-xl mx-auto px-6 py-16 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-8 md:p-12 shadow-xl space-y-6">
        <!-- Icon Banner -->
        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto shadow-inner">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>

        <div>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold uppercase tracking-wider">Menunggu Pembayaran</span>
            <h2 class="text-3xl font-black text-slate-900 mt-3">Selesaikan Pembayaran</h2>
            <p class="text-slate-500 text-sm mt-1">
                Event: <strong class="text-slate-800">{{ $transaction->event->title }}</strong>
            </p>
        </div>

        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 space-y-2 text-left">
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>ORDER ID</span>
                <span class="font-mono text-slate-800">{{ $transaction->order_id }}</span>
            </div>
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>NAMA PEMESAN</span>
                <span class="text-slate-800">{{ $transaction->customer_name }}</span>
            </div>
            <div class="flex justify-between text-xs font-semibold text-slate-500">
                <span>EMAIL TIKET</span>
                <span class="text-slate-800">{{ $transaction->customer_email }}</span>
            </div>

            <div class="pt-3 border-t border-slate-200 flex justify-between items-center">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Tagihan</span>
                <span class="text-3xl font-black text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <button id="pay-button" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-lg shadow-xl shadow-indigo-200 active:scale-95 transition-all flex items-center justify-center gap-2">
            <span>Bayar Melalui Midtrans</span>
            <span>&rarr;</span>
        </button>

        <p class="text-xs text-slate-400">
            Jendela pembayaran akan terbuka otomatis. Jika tidak muncul, silakan klik tombol <strong>Bayar Melalui Midtrans</strong> di atas.
        </p>
    </div>
</main>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onPending: function(result){
                window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
            },
            onError: function(result){
                alert("Pembayaran Gagal!");
            },
            onClose: function(){
                console.log("Jendela pembayaran ditutup.");
            }
        });
    };

    window.onload = function() {
        document.getElementById('pay-button').click();
    };
</script>
@endsection