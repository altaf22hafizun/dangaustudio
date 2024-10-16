@extends('landing.layouts.index')
@section('title', 'Tentang | Dangau Studio')
@section('menuTentang','active')
@section('content')

{{-- TentangDangau --}}
<section>
    <div class="container-fluid tentang-kami">
        <div class="container">
            <div class="row flex-wrap-reverse">
                <div class="col-lg-5 col-md-12 text-lg-start">
                    <h2 class="text-dark mb-3 fw-bold ">TENTANG <span class="text-success fs-7 mb-3 fw-bold">KAMI</span></h2>
                    <p class="text-dark mb-4 pt-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aspernatur, nobis ipsum voluptatem perferendis veritatis unde quaerat saepe dolore ex deleniti reprehenderit repudiandae minus necessitatibus facere! Placeat, iure aspernatur! Modi esse odio placeat cumque recusandae debitis aliquid, dolorum porro ipsum quidem architecto, nam, quo quibusdam cum excepturi! Placeat, dignissimos? Blanditiis, eius?</p>
                    <p class="text-dark mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum ipsam ea libero dolorum, fuga in aperiam. Distinctio reiciendis ipsa iusto, omnis nemo totam adipisci, fugiat dolore nisi impedit, eum laboriosam fuga non tempore mollitia. Omnis repellat nulla placeat voluptatum voluptas nihil eveniet minus ratione sit reprehenderit asperiores, odit vero vel!</p>
                </div>
                <div class="col-lg-6 col-md-12 text-center mb-5 ms-auto">
                    <img src="{{ asset('assets/img/tentang.png') }}" class="img-fluid rounded-4" alt="background">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
