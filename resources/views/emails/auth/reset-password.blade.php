{{-- resources/views/emails/auth/reset-password.blade.php --}}
@component('mail::message')
<p style="text-align:center; margin:0 0 16px;">
  <img src="{{ $logoUrl }}" alt="ConectFit" width="160">
</p>

# Olá {{ $user->name ?? '' }}

Clique no botão abaixo para redefinir sua senha.

@component('mail::button', ['url' => $url])
Redefinir senha
@endcomponent

Este link expira em **{{ $expire }} minutos**.

Se você não solicitou a redefinição, ignore este e-mail.

Obrigado,<br>
**ConectFit**
@endcomponent
