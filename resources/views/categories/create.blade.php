@extends('layouts.app') @section('title','Tambah Kategori') @section('page-title','Tambah Kategori')
@section('content')<div class="mx-auto max-w-xl"><h2 class="mb-5 text-xl font-bold text-[#14264f]">Buat kategori baru</h2><form method="POST" action="{{ route('kategori.store') }}" class="rounded-2xl bg-white p-6 shadow-sm">@csrf @include('categories._form')</form></div>@endsection
