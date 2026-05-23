@if($unlock)

<a href="{{ $route }}"
class="flex items-center gap-3 p-3 rounded-lg
{{ $active==$key ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'hover:bg-gray-100' }}">

@if($done)
<span>✓</span>
@elseif($active==$key)
<span>●</span>
@else
<span>{{ $step }}</span>
@endif

{{ $label }}

</a>

@else

<div class="flex items-center gap-3 p-3 text-gray-400">
<span>🔒</span> {{ $label }}
</div>

@endif
