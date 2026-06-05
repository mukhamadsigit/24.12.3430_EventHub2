@extends('layouts.admin')

@section('title', 'Laporan Transaksi')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Daftar reservasi tiket event online yang terdaftar di sistem.')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h3 class="text-xl font-bold">Semua Transaksi</h3>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">ID Order</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Pelanggan</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Event</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Total Bayar</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Status</th>
                    <th class="px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-8 py-6 border-b font-mono text-sm font-bold text-slate-700">
                            {{ $transaction->order_id }}
                        </td>
                        <td class="px-8 py-6 border-b">
                            <div class="font-bold text-slate-800">{{ $transaction->customer_name }}</div>
                            <div class="text-xs text-slate-400 font-medium">{{ $transaction->customer_email }}</div>
                            <div class="text-[10px] text-slate-400 font-bold font-mono">{{ $transaction->customer_phone }}</div>
                        </td>
                        <td class="px-8 py-6 border-b">
                            <div class="font-semibold text-slate-800">{{ $transaction->event->title ?? 'N/A' }}</div>
                            <div class="text-xs text-indigo-600 font-bold">{{ $transaction->event->category->name ?? 'Uncategorized' }}</div>
                        </td>
                        <td class="px-8 py-6 border-b font-bold text-slate-800">
                            Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-6 border-b">
                            @if(strtolower($transaction->status) === 'pending')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 border border-amber-200 text-xs font-bold rounded-full uppercase tracking-wider">
                                    {{ $transaction->status }}
                                </span>
                            @elseif(strtolower($transaction->status) === 'success' || strtolower($transaction->status) === 'settlement')
                                <span class="px-3 py-1 bg-green-50 text-green-600 border border-green-200 text-xs font-bold rounded-full uppercase tracking-wider">
                                    {{ $transaction->status }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold rounded-full uppercase tracking-wider">
                                    {{ $transaction->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 border-b text-sm text-slate-500 font-medium">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-400 italic">
                            Belum ada riwayat transaksi yang tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transactions->hasPages())
        <div class="p-6 border-t border-slate-50">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection