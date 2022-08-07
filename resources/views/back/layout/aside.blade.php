<div class="app-sidebar">
    <div class="logo">
        <a href="{{ route('back.home.index') }}" class="logo-icon"><span class="logo-text">Neptune</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="javascript:void(0)">
                @if(auth()->guard('yonetim')->user()->avatar != "" && \Illuminate\Support\Facades\File::exists("storage/".auth()->guard('yonetim')->user()->avatar))
                    <img src="{{ asset('storage/'.auth()->guard('yonetim')->user()->avatar) }}" alt="{{ auth()->guard('yonetim')->user()->name }}">
                @else
                    <img src="{{ asset('storage/resim-yok.webp') }}" alt="{{ auth()->guard('yonetim')->user()->name }}">
                @endif
                <span class="activity-indicator"></span>
                <span class="user-info-text">{{ auth()->guard('yonetim')->user()->name }}<br><span
                        class="user-state-info">{{ env("APP_NAME") }}</span></span>
            </a>
        </div>
    </div>
    <div class="app-menu">
        <ul class="accordion-menu">

            <li class="active-page">
                <a href="{{ route('back.home.index') }}" class="active"><i class="material-icons-two-tone">dashboard</i>Anasayfa</a>
            </li>

            {{-- DILLER KISMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("diller","aktiflik")===true)
                <li>
                    <a href=""><i class="material-icons-two-tone">translate</i>Diller<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.language.index') }}">Dil Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.language.create') }}">Dil Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- SERVISLER KISMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("servisler","aktiflik")===true)
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
            @endif

            {{-- DUYURU KATEGORİLERİ --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("duyuru_kategorileri","aktiflik")===true)
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
            @endif

            {{-- DUYURU EKLEME ISLEMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("duyurular","aktiflik")===true)
                <li>
                    <a href=""><i class="material-icons-two-tone">feed</i>Duyurular<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.duyurular.index') }}">Duyuru Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.duyurular.create') }}">Duyuru Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- DUYURU YORUMLARI ISLEMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("duyuru_yorumlar","aktiflik"))
                <li>
                    <a href=""><i class="material-icons-two-tone">comment</i>Duyuru Yorumları<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.duyuru_yorumlar.index') }}">Duyuru Yorumları Listesi</a>
                        </li>
                    </ul>
                </li>
            @endif


            {{-- SOSYAL MEDYA KISMI AYARLANMASI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("sosyal_medya","aktiflik")===true)
                <li>
                    <a href=""><i class="material-icons-two-tone">hub</i>Sosyal Medya<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.sosyal_medya.index') }}">Sosyal Medya Listesi</a>
                        </li>

                        <li>
                            <a href="{{ route('back.sosyal_medya.create') }}">Yeni Sosyal Medya Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif


            {{-- SLIDERLAR KISMI AYARLANMASI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("sliderlar","aktiflik")===true)
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
            @endif

            {{-- PARTNERLAER KISMI AYARLANSMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("partnerler","aktiflik")===true)
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
            @endif


            {{-- EKIP KISMI AYARLANSMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("ekibimiz","aktiflik")===true)
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
            @endif

            {{-- MENU KISMI AYARLANSMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("menuler","aktiflik")===true)
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
            @endif

            {{-- SAYUFA KISMI AYARLANAMSI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("sayfalar","aktiflik")===true)
                <li>
                    <a href=""><i class="material-icons-two-tone">auto_stories</i>Sayfalar<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.sayfalar.index') }}">Sayfa Listesi</a>
                        </li>

                        <li>
                            <a href="{{ route('back.sayfalar.create') }}">Yeni Sayfa Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- MUSTERI YORUMLARI KISMI AYARLANAMSI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("musteri_yorumlari","aktiflik")===true)
                <li>
                    <a href=""><i class="material-icons-two-tone">question_answer</i>Müşteri Yorumları<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.musteri_yorumlar.index') }}">Müşteri Yorumları Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.musteri_yorumlar.create') }}">Yeni Müşteri Yorumu Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- ILETISIM MESAJLARI KISMI AYARLANAMSI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("iletisim_mesajlari","aktiflik"))
                <li>
                    <a href=""><i class="material-icons-two-tone">email</i>İletişim Mesajları<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.iletisim_mesajlari.index') }}">İletişim Mesajları Listesi</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- ABONELER KISMI AYARLANAMSI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("aboneler","aktiflik"))
                <li>
                    <a href=""><i class="material-icons-two-tone">group_add</i>Aboneler<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.aboneler.index') }}">Abone Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.aboneler.create') }}">Yeni Abone Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- SERTIFIKALAR --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("sertifikalar","aktiflik"))
                <li>
                    <a href=""><i class="material-icons-two-tone">workspace_premium</i>Sertifikalar<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.sertifikalar.index') }}">Sertifika Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.sertifikalar.create') }}">Yeni Sertifika Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- YETKILER KISMI AYARLANMASI --}}
            @if(auth()->guard('yonetim')->user()->isSuperAdmin==1)
                <li>
                    <a href=""><i class="material-icons-two-tone">vpn_key</i>Yetkiler<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.yetkiler.index') }}">Yetki Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.yetkiler.create') }}">Yeni Yetki Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- KULLANICILAR KISMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("kullanicilar","aktiflik"))
                <li>
                    <a href=""><i class="material-icons-two-tone">people</i>Kullanıcılar<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.kullanicilar.index') }}">Kullanıcı Listesi</a>
                        </li>
                        <li>
                            <a href="{{ route('back.kullanicilar.create') }}">Yeni Kullanıcı Ekle</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- AYARLAR KISMI --}}
            @if(\App\Helpers\myHelper::yetkiKontrol("ayarlar","aktiflik"))
                <li>
                    <a href=""><i class="material-icons-two-tone">settings</i>Ayarlar<i
                            class="material-icons has-sub-menu">keyboard_arrow_right</i></a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('back.ayarlar.index') }}">Genel Ayarlar</a>
                        </li>
                        <li>
                            <a href="{{ route('back.ayarlar.webmaster') }}">Webmaster Ayarları</a>
                        </li>
                        <li>
                            <a href="{{ route('back.ayarlar.logo') }}">Logo Ayarları</a>
                        </li>
                        <li>
                            <a href="{{ route('back.ayarlar.favicon') }}">Favicon Ayarları</a>
                        </li>
                        <li>
                            <a href="{{ route('back.ayarlar.iletisim') }}">İletişim Ayarları</a>
                        </li>
                        <li>
                            <a href="{{ route('back.ayarlar.toplu_mesaj') }}">Toplu Mesaj</a>
                        </li>
                    </ul>
                </li>
            @endif


            <li>
                <a href="{{ route('back.logout') }}"><i class="material-icons-two-tone">logout</i>Çıkış Yap</a>
            </li>
        </ul>
    </div>
</div>
