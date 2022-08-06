<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toplu Mail</title>
</head>
<body>
<b>Mail Konusu:</b> {{ $messageData['mail_konu'] }}
<p></p>
<b>Mail Başlığı:</b> {{ $messageData['mail_baslik'] }}
<p></p>
<b>Mail İçerik:</b> {!! $messageData['mail_icerik'] !!}

</body>
</html>
