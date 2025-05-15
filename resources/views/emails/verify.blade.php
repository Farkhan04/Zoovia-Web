<x-mail::message>
# Halo {{ $name }},

Terima kasih telah mendaftar. Kode verifikasi akun Anda adalah:

# **{{ $otp }}**

Masukkan kode tersebut di aplikasi Anda untuk menyelesaikan proses verifikasi. Kode ini berlaku selama 10 menit.

Jika Anda tidak meminta kode ini, abaikan email ini.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
