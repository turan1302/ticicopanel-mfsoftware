<div class="app-header">
    <nav class="navbar navbar-light navbar-expand-lg">
        <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                    </li>
                </ul>

            </div>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown"><img src="{{ asset('back') }}/images/flags/us.png" alt=""></a>
                        <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                            <li><a class="dropdown-item" href="#"><img src="{{ asset('back') }}/images/flags/germany.png" alt="">German</a></li>
                            <li><a class="dropdown-item" href="#"><img src="{{ asset('back') }}/images/flags/italy.png" alt="">Italian</a></li>
                            <li><a class="dropdown-item" href="#"><img src="{{ asset('back') }}/images/flags/china.png" alt="">Chinese</a></li>
                        </ul>
                    </li>
                    <li class="nav-item hidden-on-mobile">
                        <a class="nav-link nav-notifications-toggle" href="{{ route('back.profil.index') }}">
                            <span class="material-icons">account_circle</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
