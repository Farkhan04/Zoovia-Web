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

@include('Admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('Admin.navbar')

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
                                                    class="icon-base bx bx-user icon-sm me-1_5"></i> Account</a>
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
                                                <label for="upload" class="btn btn-primary me-3 mb-4"
                                                    tabindex="0">
                                                    <span class="d-none d-sm-block">Upload new photo</span>
                                                    <i class="icon-base bx bx-upload d-block d-sm-none"></i>
                                                    <input type="file" id="upload" class="account-file-input"
                                                        hidden accept="image/png, image/jpeg" />
                                                </label>
                                                <button type="button"
                                                    class="btn btn-outline-secondary account-image-reset mb-4">
                                                    <i class="icon-base bx bx-reset d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Reset</span>
                                                </button>

                                                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <form id="formAccountSettings" method="POST" onsubmit="return false">
                                            <div class="row g-6">
                                                <div class="col-md-6">
                                                    <label for="firstName" class="form-label">First Name</label>
                                                    <input class="form-control" type="text" id="firstName"
                                                        name="firstName" value="John" autofocus />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="lastName" class="form-label">Last Name</label>
                                                    <input class="form-control" type="text" name="lastName"
                                                        id="lastName" value="Doe" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input class="form-control" type="text" id="email"
                                                        name="email" value="john.doe@example.com"
                                                        placeholder="john.doe@example.com" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="organization" class="form-label">Organization</label>
                                                    <input type="text" class="form-control" id="organization"
                                                        name="organization" value="ThemeSelection" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text">US (+1)</span>
                                                        <input type="text" id="phoneNumber" name="phoneNumber"
                                                            class="form-control" placeholder="202 555 0111" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address"
                                                        name="address" placeholder="Address" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="state" class="form-label">State</label>
                                                    <input class="form-control" type="text" id="state"
                                                        name="state" placeholder="California" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="zipCode" class="form-label">Zip Code</label>
                                                    <input type="text" class="form-control" id="zipCode"
                                                        name="zipCode" placeholder="231465" maxlength="6" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="country">Country</label>
                                                    <select id="country" class="select2 form-select">
                                                        <option value="">Select</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="China">China</option>
                                                        <option value="France">France</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="India">India</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Korea">Korea, Republic of</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Philippines">Philippines</option>
                                                        <option value="Russia">Russian Federation</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Emirates">United Arab Emirates
                                                        </option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="language" class="form-label">Language</label>
                                                    <select id="language" class="select2 form-select">
                                                        <option value="">Select Language</option>
                                                        <option value="en">English</option>
                                                        <option value="fr">French</option>
                                                        <option value="de">German</option>
                                                        <option value="pt">Portuguese</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="timeZones" class="form-label">Timezone</label>
                                                    <select id="timeZones" class="select2 form-select">
                                                        <option value="">Select Timezone</option>
                                                        <option value="-12">(GMT-12:00) International Date Line West
                                                        </option>
                                                        <option value="-11">(GMT-11:00) Midway Island, Samoa
                                                        </option>
                                                        <option value="-10">(GMT-10:00) Hawaii</option>
                                                        <option value="-9">(GMT-09:00) Alaska</option>
                                                        <option value="-8">(GMT-08:00) Pacific Time (US & Canada)
                                                        </option>
                                                        <option value="-8">(GMT-08:00) Tijuana, Baja California
                                                        </option>
                                                        <option value="-7">(GMT-07:00) Arizona</option>
                                                        <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan
                                                        </option>
                                                        <option value="-7">(GMT-07:00) Mountain Time (US & Canada)
                                                        </option>
                                                        <option value="-6">(GMT-06:00) Central America</option>
                                                        <option value="-6">(GMT-06:00) Central Time (US & Canada)
                                                        </option>
                                                        <option value="-6">(GMT-06:00) Guadalajara, Mexico City,
                                                            Monterrey</option>
                                                        <option value="-6">(GMT-06:00) Saskatchewan</option>
                                                        <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio
                                                            Branco</option>
                                                        <option value="-5">(GMT-05:00) Eastern Time (US & Canada)
                                                        </option>
                                                        <option value="-5">(GMT-05:00) Indiana (East)</option>
                                                        <option value="-4">(GMT-04:00) Atlantic Time (Canada)
                                                        </option>
                                                        <option value="-4">(GMT-04:00) Caracas, La Paz</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="currency" class="form-label">Currency</label>
                                                    <select id="currency" class="select2 form-select">
                                                        <option value="">Select Currency</option>
                                                        <option value="usd">USD</option>
                                                        <option value="euro">Euro</option>
                                                        <option value="pound">Pound</option>
                                                        <option value="bitcoin">Bitcoin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mt-6">
                                                <button type="submit" class="btn btn-primary me-3">Save
                                                    changes</button>
                                                <button type="reset"
                                                    class="btn btn-outline-secondary">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /Account -->
                                </div>
                                <div class="card">
                                    <h5 class="card-header">Delete Account</h5>
                                    <div class="card-body">
                                        <div class="mb-6 col-12 mb-0">
                                            <div class="alert alert-warning">
                                                <h5 class="alert-heading mb-1">Are you sure you want to delete your
                                                    account?</h5>
                                                <p class="mb-0">Once you delete your account, there is no going back.
                                                    Please be certain.</p>
                                            </div>
                                        </div>
                                        <form id="formAccountDeactivation" onsubmit="return false">
                                            <div class="form-check my-8 ms-2">
                                                <input class="form-check-input" type="checkbox"
                                                    name="accountActivation" id="accountActivation" />
                                                <label class="form-check-label" for="accountActivation">I confirm my
                                                    account deactivation</label>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-danger deactivate-account">Deactivate Account</button>
                                        </form>
                                    </div>
                                </div>
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
                                    , made with ❤️ by
                                    <a href="https://themeselection.com" target="_blank"
                                        class="footer-link">ThemeSelection</a>
                                </div>
                                <div class="d-none d-lg-inline-block">
                                    <a href="https://themeselection.com/item/category/admin-templates/"
                                        target="_blank" class="footer-link me-4">Admin Templates</a>

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

    <div class="buy-now">
        <a href="https://themeselection.com/item/sneat-dashboard-pro-bootstrap/" target="_blank"
            class="btn btn-danger btn-buy-now">Upgrade to Pro</a>
    </div>

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
</body>

</html>
