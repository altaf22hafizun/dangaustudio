<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <h1>Cek Ongkir</h1>
        <form method="post" action="/cekongkir" class="w-50">
            @csrf
            <div class="mb-3">
              <label for="origin" class="form-label">Asal Kota</label>
              <select name="origin" id="origin" class="form-control">
                <option value="">Pilih Kota Asal</option>
                @foreach ($cities as $city )
                    <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="destination" class="form-label">Tujuan Kota</label>
              <select name="destination" id="destination" class="form-control">
                <option value="">Pilih Tujuan Kota</option>
                @foreach ($cities as $city )
                    <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="weight" class="form-label">Berat Paket</label>
             <input type="number" name="weight" id="weight" class="form-control">
            </div>
            <div class="mb-3">
              <label for="courier" class="form-label">Kurir Pengiriman</label>
              <select name="courier" id="courier" class="form-control">
                <option value="">Pilih Kurir Pengiriman</option>
                <option value="jne">JNE</option>
                <option value="pos">POS</option>
                <option value="tiki">TIKI</option>
              </select>
            </div>
            <button type="submit" name="cekOngkir" class="btn btn-primary">Submit</button>
          </form>
    </div>

    <div class="container">
        <div class="mt-5">
            @if ($ongkir != '')
                <h3>Rincian Ongkir</h3>

                <h4>
                    <ul>
                        <li>Asal Kota : {{ $ongkir['origin_details']['city_name'] }}</li>
                        <li>Tujuan Kota : {{ $ongkir['destination_details']['city_name'] }}</li>
                        <li>Berat : {{ $ongkir['query']['weight'] }} gram</li>
                    </ul>
                </h4>

                @foreach ($ongkir['results'] as $item )
                    <div class="mb-3">
                        <label for="name">{{ $item['name'] }}</label>
                        @foreach ($item['costs'] as $cost )
                            <div class="mb-3">
                                <label for="service">Service : {{ $cost['service'] }}</label>
                                @foreach ($cost['cost'] as $harga )
                                    <div class="">
                                        <label for="etd">Estimasi Waktu Pengiriman : {{ $harga['etd'] }} Hari</label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cost">Harga : {{ $harga['value'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
