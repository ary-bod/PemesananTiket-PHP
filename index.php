<?php

$daftar_stasiun = [
  'JKTKT' => [
    'detail' => "Jakarta-Kota",
    'value' => 1
  ],
  'JTNGR' => [
    'detail' => "Jatinegara",
    'value' => 2
  ],
  'CKG' => [
    'detail' => "Cakung",
    'value' => 3
  ],
  'BKS' => [
    'detail' => "Bekasi",
    'value' => 4
  ],
  'KRW' => [
    'detail' => "Karawang",
    'value' => 5
  ],
  'BDG' => [
    'detail' => "Bandung",
    'value' => 6
  ]
];

$pesan_error = [];

if ($_POST) {
  $default_harga = 15000;
  $persen_diskon = 20;
  $harga_diskon = 0;

  if (strlen($_POST['nama'])) {
    $nama = $_POST['nama'];
  } else {
    array_push($pesan_error, 'Nama masih kosong');
  }

  if (strlen($_POST['email'])) {
    $email = $_POST['email'];
  } else {
    array_push($pesan_error, 'Email masih kosong');
  }

  if (isset($_POST['keberangkatan']) && $_POST['keberangkatan'] != 'Pilih' && strlen($_POST['keberangkatan']) != 0) {
    $keberangkatan = $_POST['keberangkatan'];
    $jarak_keberangkatan = $daftar_stasiun[$keberangkatan]['value'];
  } else {
    array_push($pesan_error, 'Stasiun keberangkatan masih kosong');
  }

  if (isset($_POST['tujuan']) && $_POST['tujuan'] != 'Pilih' && strlen($_POST['tujuan']) != 0) {
    $tujuan = $_POST['tujuan'];
    $jarak_tujuan = $daftar_stasiun[$tujuan]['value'];

    if ($jarak_keberangkatan == $jarak_tujuan) {
      array_push($pesan_error, 'Stasiun tujuan tidak boleh sama dengan stasiun keberangkatan');
    }
  } else {
    array_push($pesan_error, 'Stasiun tujuan masih kosong');
  }

  if (isset($_POST['kelas']) && strlen($_POST['kelas']) != 0) {
    $kelas = $_POST['kelas'];
    switch ($kelas) {
      case 'Ekonomi':
        $harga_kelas = 25000;
        break;
      case 'Bisnis':
        $harga_kelas = 50000;
        break;
      case 'Eksekutif':
        $harga_kelas = 100000;
        break;
      default:
        $harga_kelas = 0;
        break;
    }
  } else {
    $harga_kelas = 0;
    array_push($pesan_error, 'Kelas masih kosong');
  }

  if (isset($_POST['jumlah_tiket']) && $_POST['jumlah_tiket'] > 0) {
    $jumlah_tiket = $_POST['jumlah_tiket'];
  } else {
    array_push($pesan_error, 'Jumlah tiket masih kosong');
  }

  if (isset($jarak_keberangkatan) && isset($jarak_tujuan)) {
    $harga_tiket = abs($jarak_keberangkatan - $jarak_tujuan) * $default_harga;
  }

  if (count($pesan_error) === 0) {
    $harga_per_tiket = $harga_tiket + $harga_kelas;
    $total_harga_tiket = ($harga_per_tiket * $jumlah_tiket);

    if ($jumlah_tiket >= 5) {
      $harga_diskon = ($total_harga_tiket) * $persen_diskon / 100;
      $total_harga_tiket = $total_harga_tiket - $harga_diskon;
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <title>Tiket</title>

  <style>
    .navbar {
      background-color: #14213d;
      font-size: 2vh;
      padding: 10px 0;
    }

    .navbar .navbar-brand {
      font-size: 2.5vh;
      font-weight: bold;
    }

    .navbar li {
      margin-left: 50px;
    }

    .main-jumbotron {
      background-color: #14213d;
      color: white;
    }

    .jumbotron {
      padding: 40px 0 60px 0;
      background-color: transparent;
    }

    .card {
      margin-top: 30px;
    }

    .card img,
    .card-img-top {
      max-width: 400px;
      max-height: 140px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">TiketanYuk</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Beranda <span class="sr-only">(current)</span></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main class="main-jumbotron">
    <div class="container jumbotron">
      <h1 class="display-4">Selamat datang di TiketanYuk</h1>
      <p class="lead">Tempat dimana memudahkan kamu untuk membeli tiket kereta api ke tujuan tertentu.</p>
    </div>
  </main>
  <section class="text-center container">
    <div class="row py-lg-4">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Daftar Stasiun Tujuan</h1>
        <p class="lead text-muted">Beberapa stasiun tujuan yang sudah menerima pembelian tiket dari TiketanYuk</p>
      </div>
    </div>
  </section>
  <section class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card shadow-sm">
          <img src="https://cdn0-production-images-kly.akamaized.net/WJ09bWMu2kkrUD4Z-U__ovwVEzk=/673x379/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/3249182/original/061306000_1601024894-Foto_01.jpg" class="bd-placeholder-img card-img-top" alt="Stasiun Bandung">
          <div class="card-body">
            <h5 class="card-title">Stasiun Bandung</h5>
            <p class="card-text">Sejak September 2020</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <img src="https://cdn-2.tstatic.net/wartakota/foto/bank/images/stasiun-bekasi-direvitalisasi.jpg" class="bd-placeholder-img card-img-top" alt="Stasiun Bekasi">
          <div class="card-body">
            <h5 class="card-title">Stasiun Bekasi</h5>
            <p class="card-text">Sejak November 2020</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <img src="https://upload.wikimedia.org/wikipedia/commons/7/7f/Stasiun_Karawang%2C_2019.jpg" class="bd-placeholder-img card-img-top" alt="Stasiun Karawang">
          <div class="card-body">
            <h5 class="card-title">Stasiun Karawang</h5>
            <p class="card-text">Sejak Januari 2021</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <img src="https://upload.wikimedia.org/wikipedia/commons/1/19/Stasiun_Jatinegara_JNG_fasad_depan_2020-12-14.jpg" class="bd-placeholder-img card-img-top" alt="Stasiun Jatinegara">
          <div class="card-body">
            <h5 class="card-title">Stasiun Jatinegara</h5>
            <p class="card-text">Sejak Februari 2021</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <img src="https://asset.kompas.com/crops/4j9X_JL0_W5Jd5E1iHxg9r9t6d8=/0x0:984x656/750x500/data/photo/2017/10/12/224157415047819858e4-stasiun-jakarta-kota-kereta-rel-listrik.jpg" class="bd-placeholder-img card-img-top" alt="Stasiun Jakarta-Kota">
          <div class="card-body">
            <h5 class="card-title">Stasiun Jakarta-Kota</h5>
            <p class="card-text">Sejak Februari 2021</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <img src="https://heritage.kai.id/media/STASIUN%20DAOP%201%20JAKARTA/Stasiun%20Cakung/stasiun-cakung-fasade-2015.jpg?1596774749011" class="bd-placeholder-img card-img-top" alt="Stasiun Cakung">
          <div class="card-body">
            <h5 class="card-title">Stasiun Cakung</h5>
            <p class="card-text">Sejak Maret 2021</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <svg class="bd-placeholder-img card-img-top" xmlns="http://www.w3.org/2000/svg" role="img" focusable="false">
            <rect width="100%" height="100%" fill="#6c757d"></rect><text x="43%" y="50%" fill="#dee2e6">Soon</text>
          </svg>
          <div class="card-body">
            <h5 class="card-title">Coming Soon</h5>
            <p class="card-text">~</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <svg class="bd-placeholder-img card-img-top" xmlns="http://www.w3.org/2000/svg" role="img" focusable="false">
            <rect width="100%" height="100%" fill="#6c757d"></rect><text x="43%" y="50%" fill="#dee2e6">Soon</text>
          </svg>
          <div class="card-body">
            <h5 class="card-title">Coming Soon</h5>
            <p class="card-text">~</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="beli_tiket" class="mt-lg-5 pb-5" style="background-color: #14213d;">
    <div class="container text-white">
      <h1 class="text-center py-lg-5">Beli Tiket Kuyyy</h1>
      <?php if (!$_POST || count($pesan_error) > 0) : ?>
        <?php if (count($pesan_error) > 0) : ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Wah, ada masalah nih!</strong></br>
            <?php $nomor = 1; ?>
            <?php foreach ($pesan_error as $pesan) : ?>
              <?= $nomor++ . ". " . $pesan . "</br>" ?>
            <?php endforeach; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <form action="index.php#beli_tiket" method="post">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="text" class="form-control" id="email" name="email">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="keberangkatan">Stasiun Keberangkatan</label>
                <select class="form-control" id="keberangkatan" name="keberangkatan">
                  <option>Pilih</option>
                  <?php foreach ($daftar_stasiun as $id => $value) : ?>
                    <option value="<?= $id ?>"><?= $daftar_stasiun[$id]['detail']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="tujuan">Stasiun Tujuan</label>
                <select class="form-control" id="tujuan" name="tujuan">
                  <option>Pilih</option>
                  <?php foreach ($daftar_stasiun as $id => $value) : ?>
                    <option value="<?= $id ?>"><?= $daftar_stasiun[$id]['detail']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <fieldset class="form-group">
                <legend class="col-form-label pt-0">Kelas</legend>
                <div class="col-sm-10">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelas" id="kelas_ekonomi" value="Ekonomi">
                    <label class="form-check-label" for="kelas_ekonomi">
                      Ekonomi
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelas" id="kelas_bisnis" value="Bisnis">
                    <label class="form-check-label" for="kelas_bisnis">
                      Bisnis
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="kelas" id="kelas_eksekutif" value="Eksekutif">
                    <label class="form-check-label" for="kelas_eksekutif">
                      Eksekutif
                    </label>
                  </div>
                </div>
              </fieldset>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="jumlah_tiket">Jumlah Tiket</label>
                <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket">
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Beli Tiket</button>
        </form>
    </div>
  <?php else : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong>Mantappp!</strong> Tiket berhasil dipesan dan sedang menunggu pembayaran kamu melalui email yang sudah kami kirim. Silahkan cek email kamu yaa!
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="nama">Nama</label>
          <input type="text" class="form-control" id="nonama" value="<?= $nama; ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="email">Alamat Email</label>
          <input type="text" class="form-control" id="email" value="<?= $email; ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="kelas">Kelas</label>
          <input type="text" class="form-control" id="kelas" value="<?= $kelas; ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="jumlah_tiket">Jumlah Tiket</label>
          <input type="text" class="form-control" id="jumlah_tiket" value="<?= $jumlah_tiket; ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="keberangkatan">Stasiun Keberangkatan</label>
          <input type="text" class="form-control" id="keberangkatan" value="<?= $daftar_stasiun[$keberangkatan]['detail']; ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="tujuan">Stasiun Tujuan</label>
          <input type="text" class="form-control" id="tujuan" value="<?= $daftar_stasiun[$tujuan]['detail']; ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="harga_tiket">Harga Tiket</label>
          <input type="text" class="form-control" id="harga_tiket" value="Rp <?= number_format($harga_tiket); ?> x <?= number_format($jumlah_tiket) ?> = Rp <?= number_format($total_harga_tiket + $harga_diskon) ?>" readonly>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="diskon">Potongan Harga (20%)</label>
          <input type="text" class="form-control" id="diskon" value="Rp <?= number_format($harga_diskon); ?>" readonly>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="total_harga_tiket">Total Harga Pembayaran</label>
          <input type="text" class="form-control" id="total_harga_tiket" value="Rp <?= number_format($total_harga_tiket); ?>" readonly>
        </div>
      </div>
    </div>
  <?php endif; ?>
  </section>
  <footer class="text-muted py-lg-5" style="background-color: #14213d; color: #fff !important;">
    <div class="container">
      <p class="float-right">
        <a href="#">Back to top</a>
      </p>
      <p>TiketinYuk! Tempatnya membeli tiket yang tidak jelas.</p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>