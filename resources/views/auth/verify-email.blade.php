@extends('auth.layouts.main')
@section('title', 'Verifikasi Email | Dangau Studio')
@section('content')

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif


<div class="mb-4">
    <p class="text-muted"><span class="fw-bold">Terima kasih telah mendaftar! </span><br> Sebelum mulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkannya lagi.</p>
</div>

<div class="d-flex justify-content-between mb-2">
    <form id="formAuthentication" action="{{ route('verification.send') }}" method="POST" class="me-2">
        @csrf
        <button type="submit" class="btn btn-custom fs-3" style="background-color: #1a5319; color: #fff;">
            Kirim ulang email verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="align-self-center">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none fs-3">
            Logout
        </button>
    </form>
</div>



@endsection
