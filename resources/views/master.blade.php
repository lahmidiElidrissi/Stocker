<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ env('APP_NAME') }} </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastify.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css')}}" />

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <script src="{{ asset('js/globalApp.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="/vendors/DataTables/datatables.min.css" />
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        /* Make warning toast more readable with dark text */
        .warning-toast {
            color: #333 !important;
        }

        /* Add a bit more margin between multiple toasts */
        .toastify {
            margin-top: 5px;
        }

        /* Add some custom animations - adjust as needed */
        .toastify.on {
            opacity: 1;
        }
    </style>
</head>

<body>
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row my-element">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
            <div class="me-3">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                    data-bs-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
            <div>
                <a class="navbar-brand brand-logo" href="{{ route('welcome') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" style="height: 50px;" />
                </a>
                <div id="Settings-Mobile">
                    <li class="dropdown" style="list-style-type: none;">
                        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img class="img-xs rounded-circle" src="{{ Auth::user()->profile_photo_url }}"
                                alt="Profile image" style="max-height: 42px;margin: 5px;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="rounded-circle" src="{{ Auth::user()->profile_photo_url }}"
                                    alt="Profile image" style="max-height: 42px;width: 42px;margin: 5px;">
                                <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
                                <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="user/profile" class="dropdown-item"><i
                                    class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"
                                ></i> {{ __('master.profile') }} </a>
                            <a class="dropdown-item"><i
                                    class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i>
                                {{ __('master.messages') }}</a>
                            <a class="dropdown-item signout" onclick="singout()"><i
                                    class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>{{ __('master.lougout') }}</a>
                            <form method="POST" action="{{ route('logout') }}" x-data=""
                                style="display: none;">
                                @csrf
                                <input class="dropdown-item input-submit-form" type="submit" value="">
                            </form>
                        </div>
                    </li>
                </div>

            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
            <ul class="navbar-nav">
                <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                    <h1 class="welcome-text">{{ __('Dashbord.Bonjour') }}, <span
                            class="text-black fw-bold">{{ Auth::user()->name }}</span></h1>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="#"
                        data-bs-toggle="dropdown">
                        <i class="mdi mdi-earth " style="margin-top: 5px"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                        style="top:30px !important;" aria-labelledby="notificationDropdown">
                        <a class="">
                            <div class="preview-item-content">
                                <div><button onclick="ChangeLang('fr')"
                                        style="background-color:white;border:0px solid; padding: 10px 60px;"><span
                                            class="fi fi-gp"></span>&nbsp;&nbsp;Fr</button></div>
                            </div>
                        </a>
                        <a class="">
                            <div class="preview-item-content">
                                <div><button onclick="ChangeLang('en')"
                                        style="background-color:white;border:0px solid; padding: 10px 59px;"><span
                                            class="fi fi-gb"></span>&nbsp;&nbsp;En</button></div>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator" id="notificationDropdown" href="#"
                        data-bs-toggle="dropdown">
                        <i class="icon-bell icon-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0"
                        aria-labelledby="notificationDropdown" style="top: 21px;">
                        <div class="card">
                            <div class="notificationMe">
                                Notifications
                            </div>
                            <hr>
                            <div class="card-body" id="notif" style="padding-top: 0px;">

                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                    <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <img class="img-xs rounded-circle" src="{{ Auth::user()->profile_photo_url }}"
                            alt="Profile image" style="max-height: 42px;margin: 5px;">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                            <img class="rounded-circle" src="{{ Auth::user()->profile_photo_url }}"
                                alt="Profile image" style="max-height: 42px;width: 42px;margin: 5px;">
                            <p class="mb-1 mt-3 font-weight-semibold">{{ Auth::user()->name }}</p>
                            <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="user/profile" class="dropdown-item"><i
                                class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"
                            ></i> {{ __('master.profile') }} </a>
                        <a class="dropdown-item"><i
                                class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"
                            ></i> {{ __('master.messages') }}</a>
                        <a class="dropdown-item signout" onclick="singout()"><i
                                class="dropdown-item-icon mdi mdi-power text-primary me-2"
                            ></i>{{ __('master.lougout') }}</a>
                        <form method="POST" action="{{ route('logout') }}" x-data style="display: none;">
                            @csrf
                            <input class="dropdown-item input-submit-form" type="submit" value="">
                        </form>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                data-bs-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas my-element" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">
                        <i class="mdi mdi-home  menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-category">{{ __('master.GESTION') }}</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
                        aria-controls="ui-basic">
                        <i class="menu-icon mdi mdi-folder-plus"></i>
                        <span class="menu-title">{{ __('master.GS') }}</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('achats.index') }}"
                                >{{ __('master.GA') }}</a></li>
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('viewGestionDesFournisseurs') }}"
                                >{{ __('master.GF') }}</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('viewGestionDesContenirs') }}"
                                >{{ __('master.GCN') }}</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('viewGestionDesCategories') }}"
                                >{{ __('master.GCT') }}</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('articles.index') }}"
                                >{{ __('master.GAR') }}</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('viewGestionDesClients') }}"
                                >{{ __('master.GC') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item nav-category">{{ __('master.LFS') }}</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false"
                        aria-controls="form-elements">
                        <i class="menu-icon mdi mdi-card-text-outline"></i>
                        <span class="menu-title">{{ __('master.Theorders') }}</span>
                    </a>
                    <div class="collapse" id="form-elements">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="{{ route('commandes.index') }}"
                                >{{ __('master.managerOrder') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('viewGestiondesCheqes') }}"
                                >{{ __('master.chequeManagement') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false"
                        aria-controls="charts">
                        <i class="menu-icon mdi mdi-chart-line"></i>
                        <span class="menu-title">{{ __('master.Rapports') }}</span>
                        <i class=""></i>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ route('RapportDeVente') }}"
                                >{{ __('master.VentesRapports') }}</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('produitPlusVente') }}"
                                >{{ __('master.ProduitsTop') }}</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ route('TopClient') }}"
                                >{{ __('master.ClientRapport') }}</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item nav-category">{{ __('master.GESTIONApp') }}</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false"
                        aria-controls="auth">
                        <i class="menu-icon mdi mdi-account-circle-outline"></i>
                        <span class="menu-title">{{ __('master.GestionUsers') }}</span>
                    </a>
                    <div class="collapse" id="auth">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link"
                                    href="{{ route('viewGestiondesUtilisateurs') }}">
                                    {{ __('master.Users') }} </a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item nav-category">Support</li>
                <li class="nav-item">
                    <a class="nav-link" href="mailto:fescrayze2016@gmail.com">
                        <i class="menu-icon mdi mdi-shield-outline"></i>
                        <span class="menu-title">Contact support</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel my-element" style="background-image: url('images/xs.jpg');">
            @yield('partialContent')
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2023. All
                        rights reserved.</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <div class="loading-overlay">
        <div class="spinner2">
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets6.lottiefiles.com/private_files/lf30_lndg7fhf.json"
                background="transparent" speed="1" style="width: 250px; height: 250px;" loop
                autoplay></lottie-player>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/toastify.js') }}"></script>

    @yield('js')

    <script>
        $.ajax({
            type: 'GET',
            url: "{{ Route('GetNotif') }}",
            data: {
                '_token': "{{ csrf_token() }}",
            },
            success: function(data) {
                for (let index = 0; index < data.length; index++) {
                    const element1 = data[index].codeCheqe;
                    const element2 = data[index].DateCheque;
                    const html = '<p style="font-size: 12px;font-weight: 600;"> ';
                    var element1String = element1.toString();
                    const html2 = ' </p><p style="color: red;font-weight: 600;"> ';
                    var element2String = element2.toString();
                    const html3 = ' </p>';
                    const hr = '<hr>';
                    var All = "";
                    document.getElementById("notif").insertAdjacentHTML("afterbegin", All.concat(html,
                        element1String, html2, element2String, html3, hr));
                }
            }
        });

        var inputsFrom = document.querySelectorAll(".input-submit-form");

        function singout() {
            console.log("ok");
            inputsFrom[0].click();
        }

        function ChangeLang(lang) {
            $(".loading-overlay").fadeIn(500);
            $.ajax({
                type: 'POST',
                url: "{{ Route('changeLan') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'lang': lang,
                },
                success: function(data) {
                    if (data == 1)
                        location.reload();
                }
            });
        }

        $(window).on('load', function() {
            $("body").css("overflow", "auto");
            $(".loading-overlay").fadeOut(500);
        });


        $.ajax({
            type: 'GET',
            url: "{{ Route('GetLocal') }}",
            data: {
                '_token': "{{ csrf_token() }}",
            },
            success: function(data) {
                try {
                    if (data == 'en' && window.location.pathname != "/ProduitPlusVente" && window.location
                        .pathname != "/TopClient") {
                        var table = new DataTable('#tableArticle', {});
                    }
                    if (data == 'fr' && window.location.pathname != "/ProduitPlusVente" && window.location
                        .pathname != "/TopClient") {
                        var table = new DataTable('#tableArticle', {
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/fr-FR.json',
                            },
                        });
                    }
                    if (window.location.pathname == "/ProduitPlusVente" || window.location.pathname ==
                        "/TopClient") {
                        var table = new DataTable('#tableArticle', {
                            "ordering": false,
                            "paging": false,
                        });
                    }
                } catch (error) {}
            }
        });

        setTimeout(() => {
            var width = document.body.clientWidth;
            if (width < 1350) {
                document.querySelector('.icon-menu').click();
            }
        }, 1000);

        /*$(".table td").click(function(){
          var buttonUpdate = document.querySelector(".mdi-lead-pencil").parentElement; 
          buttonUpdate.click();
        });*/

        function closeModal() {
            $('#btnAnnulerModifier').click();
        }

        $('document').ready(function() {
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    const activeElement = document.activeElement;
                    // Allow Enter in textareas and buttons
                    if (activeElement.tagName.toLowerCase() === 'textarea' ||
                        activeElement.tagName.toLowerCase() === 'button') {
                        return true;
                    }

                    // For all other elements, prevent default
                    event.preventDefault();
                    return false;
                }
            }, true);
        });


        // Function to show a success toast
        function showSuccessToast(message, duration = 3000) {
            Toastify({
                text: message,
                duration: duration,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50", // green
                stopOnFocus: true
            }).showToast();
        }

        // Function to show an error toast
        function showErrorToast(message, duration = 3000) {
            Toastify({
                text: message,
                duration: duration,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#F44336", // red
                stopOnFocus: true
            }).showToast();
        }

        // Function to show a warning toast
        function showWarningToast(message, duration = 3000) {
            Toastify({
                text: message,
                duration: duration,
                close: true,
                gravity: "top",
                position: "right",
                className: "info",
                style: {
                    background: "linear-gradient(to right, #E32636, #FF033E)",
                },
                stopOnFocus: true
            }).showToast();
        }

        // Function to show an info toast
        function showInfoToast(message, duration = 3000) {
            Toastify({
                text: message,
                duration: duration,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#2196F3", // blue
                stopOnFocus: true
            }).showToast();
        }

        // Custom confirmation dialog replacement
        function showConfirmDialog(message, confirmCallback, cancelCallback = null) {
            // Create container
            const confirmContainer = document.createElement('div');
            confirmContainer.className = 'toastify-confirm-container';
            confirmContainer.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            max-width: 320px;
            width: 100%;
            text-align: center;
        `;

            // Add message
            const messageElement = document.createElement('p');
            messageElement.textContent = message;
            messageElement.style.cssText = `
            margin-bottom: 20px;
            color: #333;
        `;
            confirmContainer.appendChild(messageElement);

            // Add buttons container
            const buttonContainer = document.createElement('div');
            buttonContainer.style.cssText = `
            display: flex;
            justify-content: space-between;
        `;

            // Add confirm button
            const confirmButton = document.createElement('button');
            confirmButton.textContent = 'Confirmer';
            confirmButton.style.cssText = `
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            flex: 1;
            margin-right: 10px;
        `;
            confirmButton.onclick = function() {
                document.body.removeChild(confirmContainer);
                document.body.removeChild(overlay);
                if (confirmCallback) confirmCallback();
            };
            buttonContainer.appendChild(confirmButton);

            // Add cancel button
            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Annuler';
            cancelButton.style.cssText = `
            padding: 8px 16px;
            background-color: #F44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            flex: 1;
        `;
            cancelButton.onclick = function() {
                document.body.removeChild(confirmContainer);
                document.body.removeChild(overlay);
                if (cancelCallback) cancelCallback();
            };
            buttonContainer.appendChild(cancelButton);

            confirmContainer.appendChild(buttonContainer);

            // Add overlay
            const overlay = document.createElement('div');
            overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 9998;
        `;

            // Add to DOM
            document.body.appendChild(overlay);
            document.body.appendChild(confirmContainer);
        }
    </script>
</body>
