<x-mail::message>
{{-- Logo --}}
<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ url('assets/compiled/jpg/GIGI.jpg') }}" alt="Logo Klinik" style="height: 40px;">
</div>

{{-- Greeting --}}
# Halo!

{{-- Intro --}}
Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Jangan khawatir, kami siap membantu Anda!

{{-- Action Button --}}
<x-mail::button :url="$actionUrl" color="primary">
Atur Ulang Kata Sandi
</x-mail::button>

{{-- Outro --}}
Jika Anda tidak pernah meminta pengaturan ulang kata sandi, Anda dapat mengabaikan email ini. Akun Anda tetap aman.

{{-- Penutup --}}
Salam hangat,<br>
<strong>{{ config('app.name') }}</strong>

{{-- Subcopy --}}
<x-slot:subcopy>
Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:

<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
</x-mail::message>
