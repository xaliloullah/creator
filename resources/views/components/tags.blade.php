{{-- <div> --}}
@if ($tag ?? null)
    <span class="badge bg-{{ $color ?? 'info' }}">{{ $tag }}</span>
@elseif ($badge ?? null)
    <span class="badge bg-{{ $badge->color }}">
        @if ($badge->icon)
            <i class="bi {{ $badge->icon }} me-2"></i>
        @endif
        {{ $badge->name }}
    </span>
@elseif ($tags ?? null)
    @foreach ($tags as $tag)
        <span class="badge bg-{{ $color ?? 'info' }}">{{ $tag }}</span>
    @endforeach
@elseif ($badges ?? null)
    @foreach ($badges as $badge)
        <span class="badge bg-{{ $badge->color ?? 'info' }}">
            @if ($badge->icon)
                <i class="bi {{ $badge->icon }} me-2"></i>
            @endif
            {{ $badge->name }}
        </span>
    @endforeach
@endif
{{-- </div> --}}
