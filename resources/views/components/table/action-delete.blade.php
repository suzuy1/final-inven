@props(['action', 'confirm', 'label' => 'Hapus'])

<form action="{{ $action }}" method="POST" onsubmit="return confirm('{{ $confirm }}')">
    @csrf @method('DELETE')
    <button type="submit"
        class="w-full text-left flex items-center gap-2 px-4 py-2 hover:bg-rose-100 text-rose-700 font-bold">
        🗑️ {{ $label }}
    </button>
</form>
