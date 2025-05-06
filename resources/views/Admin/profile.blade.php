<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ 'Admin/assets/' }}"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo: Account settings - Account | Sneat - Bootstrap Dashboard FREE</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ 'Admin/assets/img/favicon/favicon.ico' }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/fonts/iconify-icons.css' }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/css/core.css' }}" />
    <link rel="stylesheet" href="{{ 'Admin/assets/css/demo.css' }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ 'Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css' }}" />

    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ 'Admin/assets/vendor/js/helpers.js' }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ 'Admin/assets/js/config.js' }}"></script>


</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('admin.navbar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="nav-align-top">
                                    <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-md-0 gap-2">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="javascript:void(0);"><i
                                                    class="icon-base bx bx-user icon-sm me-1_5"></i>Profil</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card mb-6">
                                    <!-- Account -->
                                    <div class="card-body">
                                        <div
                                            class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                                            <img src="{{ 'Admin/assets/img/avatars/1.png' }}" alt="user-avatar"
                                                class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Unggah Foto Baru</span>
                                                    <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                                                    <input type="file" id="upload" class="account-file-input" hidden
                                                        accept="image/png, image/jpeg" />
                                                </label>
                                                <button type="button"
                                                    class="btn btn-outline-secondary account-image-reset mb-4">
                                                    <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Atur Ulang</span>
                                                </button>

                                                <div><small style="font-size: 0.85em; color: #6c757d;">
                                                    Format: JPG, GIF, PNG · Maks: 800KB
                                                </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                                            <div class="row g-6">
                                                <div class="col-md-12">
                                                    <label for="NamaDepan" class="form-label">Nama Depan</label>
                                                    <input class="form-control" type="text" id="NamaDepan"
                                                        name="NamaDepan" placeholder="nama depan" />
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="NamaBelakang" class="form-label">Nama Belakang</label>
                                                    <input type="text" class="form-control" id="NamaBelakang" name="NamaBelakang"
                                                    placeholder="nama belakang" />
                                    
                                                <div class="col-md-12">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input class="form-control" type="text" id="email" name="email"
                                                        placeholder="shavaselvia@gmail.com" />
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label" for="NomorTelepon">Nomor Telepon</label>
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">IND (+62) </span>
                                                        <input type="text" id="nomortelepon" name="nomortelepon"
                                                            class="form-control" placeholder="812 3456 789" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                                        placeholder="alamat" />
                                                </div>


                                                <div class="col-md-12">
    <label class="form-label" for="capital">Ibukota Provinsi</label>
    <select id="capital" class="select2 form-select">
        <option value="">Pilih Ibukota</option>
        <option value="Banda Aceh">Banda Aceh (Aceh)</option>
        <option value="Medan">Medan (Sumatera Utara)</option>
        <option value="Padang">Padang (Sumatera Barat)</option>
        <option value="Pekanbaru">Pekanbaru (Riau)</option>
        <option value="Tanjungpinang">Tanjungpinang (Kepulauan Riau)</option>
        <option value="Jambi">Jambi (Jambi)</option>
        <option value="Palembang">Palembang (Sumatera Selatan)</option>
        <option value="Pangkalpinang">Pangkalpinang (Kepulauan Bangka Belitung)</option>
        <option value="Bengkulu">Bengkulu (Bengkulu)</option>
        <option value="Bandar Lampung">Bandar Lampung (Lampung)</option>
        <option value="Serang">Serang (Banten)</option>
        <option value="Jakarta">Jakarta (DKI Jakarta)</option>
        <option value="Bandung">Bandung (Jawa Barat)</option>
        <option value="Semarang">Semarang (Jawa Tengah)</option>
        <option value="Yogyakarta">Yogyakarta (DI Yogyakarta)</option>
        <option value="Surabaya">Surabaya (Jawa Timur)</option>
        <option value="Denpasar">Denpasar (Bali)</option>
        <option value="Mataram">Mataram (Nusa Tenggara Barat)</option>
        <option value="Kupang">Kupang (Nusa Tenggara Timur)</option>
        <option value="Pontianak">Pontianak (Kalimantan Barat)</option>
        <option value="Palangka Raya">Palangka Raya (Kalimantan Tengah)</option>
        <option value="Banjarmasin">Banjarmasin (Kalimantan Selatan)</option>
        <option value="Samarinda">Samarinda (Kalimantan Timur)</option>
        <option value="Tanjung Selor">Tanjung Selor (Kalimantan Utara)</option>
        <option value="Manado">Manado (Sulawesi Utara)</option>
        <option value="Gorontalo">Gorontalo (Gorontalo)</option>
        <option value="Palu">Palu (Sulawesi Tengah)</option>
        <option value="Mamuju">Mamuju (Sulawesi Barat)</option>
        <option value="Makassar">Makassar (Sulawesi Selatan)</option>
        <option value="Kendari">Kendari (Sulawesi Tenggara)</option>
        <option value="Ambon">Ambon (Maluku)</option>
        <option value="Sofifi">Sofifi (Maluku Utara)</option>
        <option value="Manokwari">Manokwari (Papua Barat)</option>
        <option value="Jayapura">Jayapura (Papua)</option>
        <option value="Nabire">Nabire (Papua Tengah)</option>
        <option value="Timika">Timika (Papua Selatan)</option>
        <option value="Merauke">Merauke (Papua Pegunungan)</option>
        <option value="Sorong">Sorong (Papua Barat Daya)</option>



    </select>
</div>

<div class="col-md-12">
  <label class="form-label" for="city">Kota di Indonesia</label>
  <select id="city" class="select2 form-select">
    <option value="">Pilih Kota</option>
    <optgroup label="Aceh">
      <option value="Banda Aceh">Banda Aceh</option>
      <option value="Langsa">Langsa</option>
      <option value="Lhokseumawe">Lhokseumawe</option>
      <option value="Sabang">Sabang</option>
      <option value="Subulussalam">Subulussalam</option>
    </optgroup>
    <optgroup label="Sumatera Utara">
      <option value="Binjai">Binjai</option>
      <option value="Gunungsitoli">Gunungsitoli</option>
      <option value="Medan">Medan</option>
      <option value="Padang Sidempuan">Padang Sidempuan</option>
      <option value="Pematangsiantar">Pematangsiantar</option>
      <option value="Sibolga">Sibolga</option>
      <option value="Tanjungbalai">Tanjungbalai</option>
      <option value="Tebing Tinggi">Tebing Tinggi</option>
    </optgroup>
    <optgroup label="Sumatera Barat">
      <option value="Bukittinggi">Bukittinggi</option>
      <option value="Padang">Padang</option>
      <option value="Padang Panjang">Padang Panjang</option>
      <option value="Pariaman">Pariaman</option>
      <option value="Payakumbuh">Payakumbuh</option>
      <option value="Sawahlunto">Sawahlunto</option>
      <option value="Solok">Solok</option>
    </optgroup>
    <optgroup label="Riau">
      <option value="Dumai">Dumai</option>
      <option value="Pekanbaru">Pekanbaru</option>
    </optgroup>
    <optgroup label="Jambi">
      <option value="Jambi">Jambi</option>
      <option value="Sungai Penuh">Sungai Penuh</option>
    </optgroup>
    <optgroup label="Sumatera Selatan">
      <option value="Lubuklinggau">Lubuklinggau</option>
      <option value="Pagar Alam">Pagar Alam</option>
      <option value="Palembang">Palembang</option>
      <option value="Prabumulih">Prabumulih</option>
    </optgroup>
    <optgroup label="Bengkulu">
      <option value="Bengkulu">Bengkulu</option>
    </optgroup>
    <optgroup label="Lampung">
      <option value="Bandar Lampung">Bandar Lampung</option>
      <option value="Metro">Metro</option>
    </optgroup>
    <optgroup label="Kepulauan Bangka Belitung">
      <option value="Pangkalpinang">Pangkalpinang</option>
    </optgroup>
    <optgroup label="Kepulauan Riau">
      <option value="Batam">Batam</option>
      <option value="Tanjungpinang">Tanjungpinang</option>
    </optgroup>
    <optgroup label="DKI Jakarta">
      <option value="Jakarta Pusat">Jakarta Pusat</option>
      <option value="Jakarta Utara">Jakarta Utara</option>
      <option value="Jakarta Barat">Jakarta Barat</option>
      <option value="Jakarta Selatan">Jakarta Selatan</option>
      <option value="Jakarta Timur">Jakarta Timur</option>
    </optgroup>
    <optgroup label="Jawa Barat">
      <option value="Bandung">Bandung</option>
      <option value="Banjar">Banjar</option>
      <option value="Bekasi">Bekasi</option>
      <option value="Bogor">Bogor</option>
      <option value="Cimahi">Cimahi</option>
      <option value="Cirebon">Cirebon</option>
      <option value="Depok">Depok</option>
      <option value="Sukabumi">Sukabumi</option>
      <option value="Tasikmalaya">Tasikmalaya</option>
    </optgroup>
    <optgroup label="Jawa Tengah">
      <option value="Magelang">Magelang</option>
      <option value="Pekalongan">Pekalongan</option>
      <option value="Salatiga">Salatiga</option>
      <option value="Semarang">Semarang</option>
      <option value="Surakarta">Surakarta</option>
      <option value="Tegal">Tegal</option>
    </optgroup>
    <optgroup label="DI Yogyakarta">
      <option value="Yogyakarta">Yogyakarta</option>
    </optgroup>
    <optgroup label="Jawa Timur">
      <option value="Batu">Batu</option>
      <option value="Blitar">Blitar</option>
      <option value="Kediri">Kediri</option>
      <option value="Madiun">Madiun</option>
      <option value="Malang">Malang</option>
      <option value="Mojokerto">Mojokerto</option>
      <option value="Nganjuk">Nganjuk</option>
      <option value="Pasuruan">Pasuruan</option>
      <option value="Probolinggo">Probolinggo</option>
      <option value="Surabaya">Surabaya</option>
    </optgroup>
    <optgroup label="Banten">
      <option value="Cilegon">Cilegon</option>
      <option value="Serang">Serang</option>
      <option value="Tangerang">Tangerang</option>
      <option value="Tangerang Selatan">Tangerang Selatan</option>
    </optgroup>
    <optgroup label="Bali">
      <option value="Denpasar">Denpasar</option>
    </optgroup>
    <optgroup label="Nusa Tenggara Barat">
      <option value="Bima">Bima</option>
      <option value="Mataram">Mataram</option>
    </optgroup>
    <optgroup label="Nusa Tenggara Timur">
      <option value="Kupang">Kupang</option>
    </optgroup>
    <optgroup label="Kalimantan Barat">
      <option value="Pontianak">Pontianak</option>
      <option value="Singkawang">Singkawang</option>
    </optgroup>
    <optgroup label="Kalimantan Tengah">
      <option value="Palangka Raya">Palangka Raya</option>
    </optgroup>
    <optgroup label="Kalimantan Selatan">
      <option value="Banjarbaru">Banjarbaru</option>
      <option value="Banjarmasin">Banjarmasin</option>
    </optgroup>
    <optgroup label="Kalimantan Timur">
      <option value="Balikpapan">Balikpapan</option>
      <option value="Bontang">Bontang</option>
      <option value="Samarinda">Samarinda</option>
    </optgroup>
    <optgroup label="Kalimantan Utara">
      <option value="Tarakan">Tarakan</option>
    </optgroup>
    <optgroup label="Sulawesi Utara">
      <option value="Bitung">Bitung</option>
      <option value="Kotamobagu">Kotamobagu</option>
      <option value="Manado">Manado</option>
      <option value="Tomohon">Tomohon</option>
    </optgroup>
    <optgroup label="Sulawesi Tengah">
      <option value="Palu">Palu</option>
    </optgroup>
    <optgroup label="Sulawesi Selatan">
      <option value="Makassar">Makassar</option>
      <option value="Palopo">Palopo</option>
      <option value="Parepare">Parepare</option>
    </optgroup>
    <optgroup label="Sulawesi Tenggara">
      <option value="Baubau">Baubau</option>
      <option value="Kendari">Kendari</option>
    </optgroup>
    <optgroup label="Gorontalo">
      <option value="Gorontalo">Gorontalo</option>
    </optgroup>
    <optgroup label="Sulawesi Barat">
      <option value="Mamuju">Mamuju</option>
    </optgroup>
    <optgroup label="Maluku">
      <option value="Ambon">Ambon</option>
      <option value="Tual">Tual</option>
    </optgroup>
    <optgroup label="Maluku Utara">
      <option value="Ternate">Ternate</option>
      <option value="Tidore Kepulauan">Tidore Kepulauan</option>
    </optgroup>
    <optgroup label="Papua">
      <option value="Jayapura">Jayapura</option>
    </optgroup>
    <optgroup label="Papua Barat">
      <option value="Sorong">Sorong</option>
    </optgroup>
    <option value="Lainnya">Lainnya</option>
  </select>
</div>


                                            </div>
                                            <div class="mt-6">
                                                <button type="submit" class="btn btn-primary me-3">Simpan Perubahan</button>
                                                <button type="reset" class="btn btn-outline-secondary">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /Account -->
                                </div>
                            
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    &#169;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    Zoovia
                                
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="https://themeselection.com/item/category/admin-templates/" target="_blank"
                                        class="footer-link me-4">Admin Templates</a>

                                    <a href="https://themeselection.com/license/" class="footer-link me-4"
                                        target="_blank">License</a>
                                    <a href="https://themeselection.com/item/category/bootstrap-admin-templates/"
                                        target="_blank" class="footer-link me-4">Bootstrap Dashboard</a>

                                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                                        target="_blank" class="footer-link me-4">Documentation</a>

                                    <a href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free/issues"
                                        target="_blank" class="footer-link">Support</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->

    <script src="{{ 'Admin/assets/vendor/libs/jquery/jquery.js' }}"></script>

    <script src="{{ 'Admin/assets/vendor/libs/popper/popper.js' }}"></script>
    <script src="{{ 'Admin/assets/vendor/js/bootstrap.js' }}"></script>

    <script src="{{ 'Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js' }}"></script>

    <script src="{{ 'Admin/assets/vendor/js/menu.js' }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{ 'Admin/assets/js/main.js' }}"></script>

    <!-- Page JS -->
    <script src="{{ 'Admin/assets/js/pages-account-settings-account.js' }}"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

</script>
</body>

</html>