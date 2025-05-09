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
                    <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                      <img src="{{ 'Admin/assets/img/avatars/1.png' }}" alt="user-avatar"
                        class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                      <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                          <span class="d-none d-sm-block">Unggah Foto Baru</span>
                          <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                          <input type="file" id="upload" class="account-file-input" hidden
                            accept="image/png, image/jpeg" />
                        </label>
                        <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
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
                          <input class="form-control" type="text" id="NamaDepan" name="NamaDepan"
                            placeholder="nama depan"
                            value="{{ old('first_name', explode(' ', $user->name)[0] ?? '') }}" />
                        </div>
                        <div class="col-md-12">
                          <label for="NamaBelakang" class="form-label">Nama Belakang</label>
                          <input type="text" class="form-control" id="NamaBelakang" name="NamaBelakang"
                            placeholder="nama belakang"
                            value="{{ old('last_name', explode(' ', $user->name)[1] ?? '') }}" />

                          <div class="col-md-12">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control  bg-light text-muted" type="text" id="email" name="email"
                              value="{{ $user->email }}" readonly placeholder />
                          </div>

                          <div class="col-md-12">
                            <label class="form-label" for="NomorTelepon">Nomor Telepon</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">IND (+62) </span>
                              <input type="text" id="nomortelepon" name="nomortelepon" class="form-control"
                                value="{{ $user->no_hp }}" />
                            </div>
                          </div>
                          <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="alamat" />
                          </div>


                          <div class="col-md-12">

                          </div>

                          <div class="col-md-12">
                            <label class="form-label" for="city">Kota di Indonesia</label>
                            <select id="city" name="city" class="select2 form-select">
                              <option value="">Pilih Kota</option>
                              <optgroup label="Aceh">
                                <option value="Banda Aceh" {{ old('city', $profile->city ?? '') == 'Banda Aceh' ? 'selected' : '' }}>Banda Aceh</option>
                                <option value="Langsa" {{ old('city', $profile->city ?? '') == 'Langsa' ? 'selected' : '' }}>Langsa</option>
                                <option value="Lhokseumawe"{{ old('city', $profile->city ?? '') == 'Lhokseumawe' ? 'selected' : '' }}>Lhokseumawe</option>
                                <option value="Sabang" {{ old('city', $profile->city ?? '') == 'Sabang' ? 'selected' : '' }}>Sabang</option>
                                <option value="Subulussalam" {{ old('city', $profile->city ?? '') == 'Subulussala' ? 'selected' : '' }}>Subulussalam</option>
                              </optgroup>
                              <optgroup label="Sumatera Utara">
                                <option value="Binjai" {{ old('city', $profile->city ?? '') == 'Binjai' ? 'selected' : '' }}>Binjai</option>
                                <option value="Gunungsitoli" {{ old('city', $profile->city ?? '') == 'Gunungsitol' ? 'selected' : '' }}>Gunungsitoli</option>
                                <option value="Medan" {{ old('city', $profile->city ?? '') == 'Medan' ? 'selected' : '' }}>Medan</option>
                                <option value="Padang Sidempuan" {{ old('city', $profile->city ?? '') == 'Padang Sidempuan' ? 'selected' : '' }}>Padang Sidempuan</option>
                                <option value="Pematangsiantar" {{ old('city', $profile->city ?? '') == 'Pematangsiantar' ? 'selected' : '' }}>Pematangsiantar</option>
                                <option value="Sibolga" {{ old('city', $profile->city ?? '') == 'Sibolga' ? 'selected' : '' }}>Sibolga</option>
                                <option value="Tanjungbalai" {{ old('city', $profile->city ?? '') == 'Tanjungbalai' ? 'selected' : '' }}>Tanjungbalai</option>
                                <option value="Tebing Tinggi" {{ old('city', $profile->city ?? '') == 'Bandung' ? 'selected' : '' }}>Tebing Tinggi</option>
                              </optgroup>
                              <optgroup label="Sumatera Barat">
                                <option value="Bukittinggi" {{ old('city', $profile->city ?? '') == 'Bukittinggi' ? 'selected' : '' }}>Bukittinggi</option>
                                <option value="Padang" {{ old('city', $profile->city ?? '') == 'Padang' ? 'selected' : '' }}>Padang</option>
                                <option value="Padang Panjang" {{ old('city', $profile->city ?? '') == 'Padang Panjang' ? 'selected' : '' }}>Padang Panjang</option>
                                <option value="Pariaman" {{ old('city', $profile->city ?? '') == 'Pariaman' ? 'selected' : '' }}>Pariaman</option>
                                <option value="Payakumbuh" {{ old('city', $profile->city ?? '') == 'Payakumbuh' ? 'selected' : '' }}>Payakumbuh</option>
                                <option value="Sawahlunto" {{ old('city', $profile->city ?? '') == 'Sawahlunto' ? 'selected' : '' }}>Sawahlunto</option>
                                <option value="Solok" {{ old('city', $profile->city ?? '') == 'Solok' ? 'selected' : '' }}>Solok</option>
                              </optgroup>
                              <optgroup label="Riau">
                                <option value="Dumai" {{ old('city', $profile->city ?? '') == 'Dumai' ? 'selected' : '' }}>Dumai</option>
                                <option value="Pekanbaru" {{ old('city', $profile->city ?? '') == 'Pekanbaru' ? 'selected' : '' }}>Pekanbaru</option>
                              </optgroup>
                              <optgroup label="Jambi">
                                <option value="Jambi" {{ old('city', $profile->city ?? '') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                                <option value="Sungai Penuh" {{ old('city', $profile->city ?? '') == 'Sungai Penuh' ? 'selected' : '' }}>Sungai Penuh</option>
                              </optgroup>
                              <optgroup label="Sumatera Selatan">
                                <option value="Lubuklinggau" {{ old('city', $profile->city ?? '') == 'Lubuklinggau' ? 'selected' : '' }}>Lubuklinggau</option>
                                <option value="Pagar Alam" {{ old('city', $profile->city ?? '') == 'Pagar Alam' ? 'selected' : '' }}>Pagar Alam</option>
                                <option value="Palembang" {{ old('city', $profile->city ?? '') == 'Palembang' ? 'selected' : '' }}>Palembang</option>
                                <option value="Prabumulih" {{ old('city', $profile->city ?? '') == 'Prabumulih' ? 'selected' : '' }}>Prabumulih</option>
                              </optgroup>
                              <optgroup label="Bengkulu">
                                <option value="Bengkulu" {{ old('city', $profile->city ?? '') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                              </optgroup>
                              <optgroup label="Lampung">
                                <option value="Bandar Lampung" {{ old('city', $profile->city ?? '') == 'Bandar Lampung' ? 'selected' : '' }}>Bandar Lampung</option>
                                <option value="Metro" {{ old('city', $profile->city ?? '') == 'Metro' ? 'selected' : '' }}>Metro</option>
                              </optgroup>
                              <optgroup label="Kepulauan Bangka Belitung">
                                <option value="Pangkalpinang" {{ old('city', $profile->city ?? '') == 'Pangkalpinang' ? 'selected' : '' }}>Pangkalpinang</option>
                              </optgroup>
                              <optgroup label="Kepulauan Riau">
                                <option value="Batam" {{ old('city', $profile->city ?? '') == 'Batam' ? 'selected' : '' }}>Batam</option>
                                <option value="Tanjungpinang" {{ old('city', $profile->city ?? '') == 'Tanjungpinang' ? 'selected' : '' }}>Tanjungpinang</option>
                              </optgroup>
                              <optgroup label="DKI Jakarta">
                                <option value="Jakarta Pusat" {{ old('city', $profile->city ?? '') == 'Jakarta Pusat' ? 'selected' : '' }}>Jakarta Pusat</option>
                                <option value="Jakarta Utara" {{ old('city', $profile->city ?? '') == 'Jakarta Utara' ? 'selected' : '' }}>Jakarta Utara</option>
                                <option value="Jakarta Barat" {{ old('city', $profile->city ?? '') == 'Jakarta Barat' ? 'selected' : '' }}>Jakarta Barat</option>
                                <option value="Jakarta Selatan" {{ old('city', $profile->city ?? '') == 'Jakarta Selatan' ? 'selected' : '' }}>Jakarta Selatan</option>
                                <option value="Jakarta Timur" {{ old('city', $profile->city ?? '') == 'Jakarta Timur' ? 'selected' : '' }}>Jakarta Timur</option>
                              </optgroup>
                              <optgroup label="Jawa Barat">
                                <option value="Bandung" {{ old('city', $profile->city ?? '') == 'Bandung' ? 'selected' : '' }}>Bandung</option>
                                <option value="Banjar" {{ old('city', $profile->city ?? '') == 'Banjar' ? 'selected' : '' }}>Banjar</option>
                                <option value="Bekasi" {{ old('city', $profile->city ?? '') == 'Bekasi' ? 'selected' : '' }}>Bekasi</option>
                                <option value="Bogor" {{ old('city', $profile->city ?? '') == 'Bogor' ? 'selected' : '' }}>Bogor</option>
                                <option value="Cimahi" {{ old('city', $profile->city ?? '') == 'Cimahi' ? 'selected' : '' }}>Cimahi</option>
                                <option value="Cirebon" {{ old('city', $profile->city ?? '') == 'Cirebon' ? 'selected' : '' }}>Cirebon</option>
                                <option value="Depok" {{ old('city', $profile->city ?? '') == 'Depok' ? 'selected' : '' }}>Depok</option>
                                <option value="Sukabumi" {{ old('city', $profile->city ?? '') == 'Sukabumi' ? 'selected' : '' }}>Sukabumi</option>
                                <option value="Tasikmalaya" {{ old('city', $profile->city ?? '') == 'Tasikmalaya' ? 'selected' : '' }}>Tasikmalaya</option>
                              </optgroup>
                              <optgroup label="Jawa Tengah">
                                <option value="Magelang" {{ old('city', $profile->city ?? '') == 'Magelang' ? 'selected' : '' }}>Magelang</option>
                                <option value="Pekalongan" {{ old('city', $profile->city ?? '') == 'Pekalongan' ? 'selected' : '' }}>Pekalongan</option>
                                <option value="Salatiga"> {{ old('city', $profile->city ?? '') == 'Salatiga' ? 'selected' : '' }}>Salatiga</option>
                                <option value="Semarang"> {{ old('city', $profile->city ?? '') == 'Semarang' ? 'selected' : '' }}>Semarang</option>
                                <option value="Surakarta"> {{ old('city', $profile->city ?? '') == 'Surakarta' ? 'selected' : '' }}>Surakarta</option>
                                <option value="Tegal" {{ old('city', $profile->city ?? '') == 'Tegal' ? 'selected' : '' }}>Tegal</option>
                              </optgroup>
                              <optgroup label="DI Yogyakarta">
                                <option value="Yogyakarta" {{ old('city', $profile->city ?? '') == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                              </optgroup>
                              <optgroup label="Jawa Timur">
                                <option value="Batu" {{ old('city', $profile->city ?? '') == 'Batu' ? 'selected' : '' }}>Batu</option>
                                <option value="Blitar" {{ old('city', $profile->city ?? '') == 'Blitar' ? 'selected' : '' }}>Blitar</option>
                                <option value="Kediri" {{ old('city', $profile->city ?? '') == 'Kediri' ? 'selected' : '' }}>Kediri</option>
                                <option value="Madiun" {{ old('city', $profile->city ?? '') == 'Madiun' ? 'selected' : '' }}>Madiun</option>
                                <option value="Malang" {{ old('city', $profile->city ?? '') == 'Malang' ? 'selected' : '' }}>Malang</option>
                                <option value="Mojokerto" {{ old('city', $profile->city ?? '') == 'Mojokerto' ? 'selected' : '' }}>Mojokerto</option>
                                <option value="Nganjuk" {{ old('city', $profile->city ?? '') == 'Nganjuk' ? 'selected' : '' }}>Nganjuk</option>
                                <option value="Pasuruan" {{ old('city', $profile->city ?? '') == 'Pasuruan' ? 'selected' : '' }}>Pasuruan</option>
                                <option value="Probolinggo" {{ old('city', $profile->city ?? '') == 'Probolinggo' ? 'selected' : '' }}>Probolinggo</option>
                                <option value="Surabaya" {{ old('city', $profile->city ?? '') == 'Surabaya' ? 'selected' : '' }}>Surabaya</option>
                              </optgroup>
                              <optgroup label="Banten">
                                <option value="Cilegon" {{ old('city', $profile->city ?? '') == 'Cilegon' ? 'selected' : '' }}>Cilegon</option>
                                <option value="Serang" {{ old('city', $profile->city ?? '') == 'Serang' ? 'selected' : '' }}>Serang</option>
                                <option value="Tangerang" {{ old('city', $profile->city ?? '') == 'Tangerang' ? 'selected' : '' }}>Tangerang</option>
                                <option value="Tangerang Selatan" {{ old('city', $profile->city ?? '') == 'Tangerang Selatan' ? 'selected' : '' }}>Tangerang Selatan</option>
                              </optgroup>
                              <optgroup label="Bali">
                                <option value="Denpasar" {{ old('city', $profile->city ?? '') == 'Denpasar' ? 'selected' : '' }}>Denpasar</option>
                              </optgroup>
                              <optgroup label="Nusa Tenggara Barat">
                                <option value="Bima" {{ old('city', $profile->city ?? '') == 'Bima' ? 'selected' : '' }}>Bima</option>
                                <option value="Mataram" {{ old('city', $profile->city ?? '') == 'Mataram' ? 'selected' : '' }}>Mataram</option>
                              </optgroup>
                              <optgroup label="Nusa Tenggara Timur">
                                <option value="Kupang" {{ old('city', $profile->city ?? '') == 'Kupang' ? 'selected' : '' }}>Kupang</option>
                              </optgroup>
                              <optgroup label="Kalimantan Barat">
                                <option value="Pontianak" {{ old('city', $profile->city ?? '') == 'Pontianak' ? 'selected' : '' }}>Pontianak</option>
                                <option value="Singkawang" {{ old('city', $profile->city ?? '') == 'Singkawang' ? 'selected' : '' }}>>Singkawang</option>
                              </optgroup>
                              <optgroup label="Kalimantan Tengah">
                                <option value="Palangka Raya" {{ old('city', $profile->city ?? '') == 'Palangka Raya' ? 'selected' : '' }}>Palangka Raya</option>
                              </optgroup>
                              <optgroup label="Kalimantan Selatan">
                                <option value="Banjarbaru" {{ old('city', $profile->city ?? '') == 'Banjarbaru' ? 'selected' : '' }}>Banjarbaru</option>
                                <option value="Banjarmasin" {{ old('city', $profile->city ?? '') == 'Banjarmasin' ? 'selected' : '' }}>Banjarmasin</option>
                              </optgroup>
                              <optgroup label="Kalimantan Timur">
                                <option value="Balikpapan" {{ old('city', $profile->city ?? '') == 'Balikpapan' ? 'selected' : '' }}>Balikpapan</option>
                                <option value="Bontang" {{ old('city', $profile->city ?? '') == 'Bontang' ? 'selected' : '' }}>Bontang</option>
                                <option value="Samarinda" {{ old('city', $profile->city ?? '') == 'Samarinda' ? 'selected' : '' }}>Samarinda</option>
                              </optgroup>
                              <optgroup label="Kalimantan Utara">
                                <option value="Tarakan" {{ old('city', $profile->city ?? '') == 'Tarakan' ? 'selected' : '' }}>Tarakan</option>
                              </optgroup>
                              <optgroup label="Sulawesi Utara">
                                <option value="Bitung" {{ old('city', $profile->city ?? '') == 'Bitung' ? 'selected' : '' }}>Bitung</option>
                                <option value="Kotamobagu" {{ old('city', $profile->city ?? '') == 'Kotamobagu' ? 'selected' : '' }}>Kotamobagu</option>
                                <option value="Manado" {{ old('city', $profile->city ?? '') == 'Manado' ? 'selected' : '' }}>Manado</option>
                                <option value="Tomohon" {{ old('city', $profile->city ?? '') == 'Tomohon' ? 'selected' : '' }}>Tomohon</option>
                              </optgroup>
                              <optgroup label="Sulawesi Tengah">
                                <option value="Palu" {{ old('city', $profile->city ?? '') == 'Palu' ? 'selected' : '' }}>Palu</option>
                              </optgroup>
                              <optgroup label="Sulawesi Selatan">
                                <option value="Makassar" {{ old('city', $profile->city ?? '') == 'Makassar' ? 'selected' : '' }}>Makassar</option>
                                <option value="Palopo" {{ old('city', $profile->city ?? '') == 'Palopo' ? 'selected' : '' }}>Palopo</option>
                                <option value="Parepare" {{ old('city', $profile->city ?? '') == 'Parepare' ? 'selected' : '' }}>Parepare</option>
                              </optgroup>
                              <optgroup label="Sulawesi Tenggara">
                                <option value="Baubau" {{ old('city', $profile->city ?? '') == 'Baubau' ? 'selected' : '' }}>Baubau</option>
                                <option value="Kendari" {{ old('city', $profile->city ?? '') == 'Kendari' ? 'selected' : '' }}>Kendari</option>
                              </optgroup>
                              <optgroup label="Gorontalo">
                                <option value="Gorontalo"> {{ old('city', $profile->city ?? '') == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                              </optgroup>
                              <optgroup label="Sulawesi Barat">
                                <option value="Mamuju" {{ old('city', $profile->city ?? '') == 'Mamuju' ? 'selected' : '' }}>Mamuju</option>
                              </optgroup>
                              <optgroup label="Maluku">
                                <option value="Ambon" {{ old('city', $profile->city ?? '') == 'Ambon' ? 'selected' : '' }}>Ambon</option>
                                <option value="Tual" {{ old('city', $profile->city ?? '') == 'Tual' ? 'selected' : '' }}>Tual</option>
                              </optgroup>
                              <optgroup label="Maluku Utara">
                                <option value="Ternate" {{ old('city', $profile->city ?? '') == 'Ternate' ? 'selected' : '' }}>Ternate</option>
                                <option value="Tidore Kepulauan" {{ old('city', $profile->city ?? '') == 'Tidore Kepulauan' ? 'selected' : '' }}>Tidore Kepulauan</option>
                              </optgroup>
                              <optgroup label="Papua">
                                <option value="Jayapura" {{ old('city', $profile->city ?? '') == 'Jayapura' ? 'selected' : '' }}>Jayapura</option>
                              </optgroup>
                              <optgroup label="Papua Barat">
                                <option value="Sorong"> {{ old('city', $profile->city ?? '') == 'Sorong' ? 'selected' : '' }}>Sorong</option>
                              </optgroup>
                              <option value="Lainnya" {{ old('city', $profile->city ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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

                    <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                    <a href="https://themeselection.com/item/category/bootstrap-admin-templates/" target="_blank"
                      class="footer-link me-4">Bootstrap Dashboard</a>

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