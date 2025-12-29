@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center gap-2 px-4 py-2 hover:bg-slate-100 text-slate-700']) }}>
    {{ $slot }}
</a>
