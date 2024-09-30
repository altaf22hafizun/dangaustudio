<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Foto Profil</th>
                <th scope="col">Nama</th>
                <th scope="col">Bio</th>
                <th scope="col">Media Sosial</th>
                <th scope="col">Telepon</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($senimans as $key => $seniman)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>
                        <img src="{{ Storage::url($seniman->foto_profile) }}" alt="{{ $seniman->name }}" style="width: 50px; height: auto;">
                    </td>
                    <td>{{ $seniman->name }}</td>
                    <td>{{ Str::limit($seniman->bio, 100) }}</td>
                    <td><a href="{{ $seniman->medsos }}" target="_blank">@ {{ $seniman->medsos_name }}</a></td> <!-- Menambahkan link ke medsos -->
                    <td>{{ $seniman->telp }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada seniman yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
