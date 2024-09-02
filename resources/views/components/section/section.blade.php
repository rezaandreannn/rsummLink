@props([
'class' => 'section'
])
<section class="{{$class}}">
    {{ $slot ?? ''}}
</section>
