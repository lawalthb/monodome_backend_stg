@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="https://monodone-frontend-4fvblmg1q-talosmartmonodome.vercel.app/_next/image?url=%2Fimg%2Fmonodomelogo.png&w=256&q=75" class="logo" alt="monodomelogo Logo">
{{-- {{ $slot }} --}}
@endif
</a>
</td>
</tr>
