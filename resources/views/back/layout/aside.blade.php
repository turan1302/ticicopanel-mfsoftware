<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('back.home.index') }}" class="logo-icon"><span class="logo-text">Neptune</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="{{ asset('back') }}/images/avatars/avatar.png">
                <span class="activity-indicator"></span>
                <span class="user-info-text">{{ auth()->guard('yonetim')->user()->name }}<br><span class="user-state-info">{{ env("APP_NAME") }}</span></span>
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
                <a href=""><i class="material-icons-two-tone">design_services</i>Servisler<i
                        class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.service.index') }}">Servis Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.service.create') }}">Servis Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- DUYURU KATEGORİLERİ --}}
            <li>
                <a href=""><i class="material-icons-two-tone">view_list</i>Duyuru Kategorileri<i
                        class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.duyuru_kategoriler.index') }}">Duyuru Kategori Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.duyuru_kategoriler.create') }}">Duyuru Kategori Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- DUYURU EKLEME ISLEMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">feed</i>Duyurular<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.duyurular.index') }}">Duyuru Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.duyurular.create') }}">Duyuru Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- DUYURU YORUMLARI ISLEMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">comment</i>Duyuru Yorumları<i
                        class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.duyuru_yorumlar.index') }}">Duyuru Yorumları Listesi</a>
                    </li>
                </ul>
            </li>


            {{-- SOSYAL MEDYA KISMI AYARLANMASI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">hub</i>Sosyal Medya<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.sosyal_medya.index') }}">Sosyal Medya Listesi</a>
                    </li>

                    <li>
                        <a href="{{ route('back.sosyal_medya.create') }}">Yeni Sosyal Medya Ekle</a>
                    </li>
                </ul>
            </li>


            {{-- SLIDERLAR KISMI AYARLANMASI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">slideshow</i>Sliderlar<i
                        class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.sliderlar.index') }}">Slider Listesi</a>
                    </li>

                    <li>
                        <a href="{{ route('back.sliderlar.create') }}">Yeni Slider Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- PARTNERLAER KISMI AYARLANSMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">handshake</i>Partnerlar<i
                        class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.partnerlar.index') }}">Partner Listesi</a>
                    </li>

                    <li>
                        <a href="{{ route('back.partnerlar.create') }}">Yeni Partner Ekle</a>
                    </li>
                </ul>
            </li>


            {{-- EKIP KISMI AYARLANSMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">group</i>Ekip<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.ekip.index') }}">Ekip Listesi</a>
                    </li>

                    <li>
                        <a href="{{ route('back.ekip.create') }}">Yeni Üye Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- MENU KISMI AYARLANSMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">menu</i>Menüler<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.menuler.index') }}">Menü Listesi</a>
                    </li>

                    <li>
                        <a href="{{ route('back.menuler.create') }}">Yeni Menü Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- SAYUFA KISMI AYARLANAMSI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">auto_stories</i>Sayfalar<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.sayfalar.index') }}">Sayfa Listesi</a>
                    </li>

                    <li>
                        <a href="{{ route('back.sayfalar.create') }}">Yeni Sayfa Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- MUSTERI YORUMLARI KISMI AYARLANAMSI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">question_answer</i>Müşteri Yorumları<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.musteri_yorumlar.index') }}">Müşteri Yorumları Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.musteri_yorumlar.create') }}">Yeni Müşteri Yorumu Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- ILETISIM MESAJLARI KISMI AYARLANAMSI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">email</i>İletişim Mesajları<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.iletisim_mesajlari.index') }}">İletişim Mesajları Listesi</a>
                    </li>
                </ul>
            </li>

            {{-- ABONELER KISMI AYARLANAMSI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">group_add</i>Aboneler<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.aboneler.index') }}">Abone Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.aboneler.create') }}">Yeni Abone Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- SERTIFIKALAR --}}
            <li>
                <a href=""><i class="material-icons-two-tone">workspace_premium</i>Sertifikalar<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.sertifikalar.index') }}">Sertifika Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.sertifikalar.create') }}">Yeni Sertifika Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- YETKILER KISMI AYARLANMASI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">vpn_key</i>Yetkiler<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.yetkiler.index') }}">Yetki Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.yetkiler.create') }}">Yeni Yetki Ekle</a>
                    </li>
                </ul>
            </li>

            {{-- KULLANICILAR KISMI --}}
            <li>
                <a href=""><i class="material-icons-two-tone">people</i>Kullanıcılar<i class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ route('back.kullanicilar.index') }}">Kullanıcı Listesi</a>
                    </li>
                    <li>
                        <a href="{{ route('back.kullanicilar.create') }}">Yeni Kullanıcı Ekle</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
