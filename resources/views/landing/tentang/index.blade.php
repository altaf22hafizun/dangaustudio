@extends('landing.layouts.index')
@section('title', 'Tentang | Dangau Studio')
@section('menuTentang','active')
@section('content')

{{-- TentangDangau --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Tentang Dangau Studio</h2>
        <div class="row flex-wrap-reverse">
            <div class="col-lg-5 col-md-12 text-lg-start">
                <p class="text-dark mb-4">Dangau Studio adalah sebuah komunitas seni yang berlokasi di Jl. Simpang Akhirat, Kec. Kuranji, Kota Padang, Sumatra Barat. Sejak didirikan pada tahun 2015, komunitas ini telah berkomitmen untuk menjadi wadah bagi para seniman dan pecinta seni dalam menjelajahi berbagai ekspresi kreatif. Dengan berbagai program yang dirancang untuk meningkatkan apresiasi seni, Dangau Studio telah berhasil menarik perhatian masyarakat luas, khususnya kalangan muda yang kini semakin antusias untuk terlibat dalam kegiatan seni.</p>
                <p class="text-dark mb-4">Salah satu program unggulan yang diinisiasi oleh Dangau Studio adalah Art Therapy, yang bertujuan untuk meningkatkan minat kawula muda terhadap seni sekaligus memberikan mereka ruang untuk mengekspresikan diri. Melalui pendekatan ini, peserta tidak hanya belajar tentang teknik seni, tetapi juga menemukan cara untuk menyalurkan emosi dan pengalaman hidup mereka. Dengan dukungan berbagai kegiatan dan workshop, Dangau Studio terus berupaya untuk memperkaya budaya seni di daerahnya dan menciptakan lingkungan yang inspiratif bagi generasi mendatang.
                </p>
            </div>
            <div class="col-lg-6 col-md-12 text-center mb-5 ms-auto">
                <img src="{{ asset('assets/img/tentang.png') }}" class="img-fluid rounded-4" alt="background">
            </div>
        </div>
    </div>
</section>

@endsection
