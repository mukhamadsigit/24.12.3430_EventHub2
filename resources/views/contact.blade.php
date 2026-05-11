@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20 text-center">
    <div class="bg-white p-12 rounded-[2rem] shadow-xl border border-slate-100 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-100 rounded-full opacity-50"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-purple-100 rounded-full opacity-50"></div>
        
        <div class="relative z-10 space-y-6">
            <h1 class="text-4xl font-extrabold text-slate-800">Hubungi Kami</h1>
            <p class="text-lg text-slate-500 max-w-md mx-auto">Ada pertanyaan atau butuh bantuan? Tim kami siap membantu Anda 24/7.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-xs font-bold uppercase text-indigo-600 mb-2">Email</p>
                    <p class="font-bold text-slate-800">admin@amikomeventhub.com</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-xs font-bold uppercase text-indigo-600 mb-2">WhatsApp</p>
                    <p class="font-bold text-slate-800">+62 812 3456 7890</p>
                </div>
            </div>

            <div class="pt-8">
                <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white font-bold py-4 px-10 rounded-2xl shadow-lg shadow-indigo-200 hover:scale-105 transition duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection