<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('back.home.index') }}" class="logo-icon"><span class="logo-text">Neptune</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="{{ asset('back') }}/images/avatars/avatar.png">
                <span class="activity-indicator"></span>
                <span class="user-info-text">Chloe<br><span class="user-state-info">On a call</span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">

            <li class="active-page">
                <a href="{{ route('back.home.index') }}" class="active"><i class="material-icons-two-tone">dashboard</i>Anasayfa</a>
            </li>

            {{-- DILLER KISMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">translate</i>Diller<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.language.index') }}">Dil Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.language.create') }}">Dil Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- SERVISLER KISMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">design_services</i>Servisler<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.service.index') }}">Servis Listesi</a>
                    </li>
                    <li>
                        <a href="">Servis Ekle</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
