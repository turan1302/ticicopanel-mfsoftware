<?php

namespace App\Helpers;

use App\Models\YetkiModel;

class myHelper
{
    public static function get_yetkiler(){
        return [
            "diller" => "Diller",
            "servisler" => "Servisler",
            "duyuru_kategorileri" => "Duyuru Kategorileri",
            "duyurular" => "Duyurular",
            "sosyal_medya" => "Sosyal Medya",
            "sliderlar" => "Sliderlar",
            "partnerler" => "Partnerler",
            "ekibimiz" => "Ekibimiz",
            "sayfalar" => "Sayfalar",
            "menuler" => "Menüler",
            "musteri_yorumlari" => "Müşteri Yorumları",
            "iletisim_mesajlari" => "İletişim Mesajları",
            "aboneler" => "Aboneler",
            "sertifikalar" => "Sertifikalar",
            "duyuru_yorumlar" => "Duyuru Yorumlar",
            "yetkiler" => "Yetkiler",
            "kullanicilar" => "Kullanıcılar",
            "ayarlar" => "Ayarlar",
        ];
    }

    // GENİŞLETİLMİŞ YETKİ KONTROLUNU YAPALIM
    public static function yetkiKontrol($modul, $islem)
    {
        $yetki = YetkiModel::where("yt_id", auth()->guard('yonetim')->user()->yetki)->first()->yt_yetkiler;
        $yetki = json_decode($yetki, true);


        if (array_key_exists($modul, $yetki) && array_key_exists($islem, $yetki[$modul])) {
            return true;
        } else {
            return false;
        }

    }
}
