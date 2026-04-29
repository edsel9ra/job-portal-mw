<x-mail::message>
<div class="email-hero">
<div class="email-badge">
Seguridad de cuenta
</div>

<h1>
Restablecimiento de contraseña
</h1>

<p>
Recibimos una solicitud para restablecer la contraseña de tu cuenta en nuestro aplicativo de empleo.
</p>
</div>

<div class="email-content">
<p>
Hola,
</p>

<p>
Para continuar con el proceso, haz clic en el siguiente botón y crea una nueva contraseña segura.
</p>

<x-mail::button :url="$url" color="red">
Restablecer contraseña
</x-mail::button>

<div class="security-box">
<strong>Importante:</strong>
este enlace tiene una duración limitada por seguridad. Si no solicitaste este cambio, puedes ignorar este mensaje.
</div>

<p>
Gracias,<br>
<strong>Mister Wings Team</strong>
</p>
</div>

<x-slot:subcopy>
Si tienes problemas haciendo clic en el botón, copia y pega este enlace en tu navegador:

<span class="break-all">{{ $url }}</span>
</x-slot:subcopy>
</x-mail::message>