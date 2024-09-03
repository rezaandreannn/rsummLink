@props(['action' => 'create'])

@php
$buttonLabels = [
'create' => 'Simpan',
'update' => 'Simpan Perubahan',
];

$buttonText = $buttonLabels[$action] ?? 'Submit';
@endphp

<button {{ $attributes->merge(['class' => 'btn btn-primary', 'type' => 'submit']) }}>
    {{ $buttonText }}
</button>
