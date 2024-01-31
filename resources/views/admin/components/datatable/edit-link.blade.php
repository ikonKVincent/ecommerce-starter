<a href="{{ route($route . '.edit', ['id' => $id]) }} "
    class="flex items-center gap-1 hover:reduce-opacity hover:opacity-70 duration-300 text-primary">
    <span class="underline decoration-dotted">{{ $name }}</span>
    <x-icon name="o-pencil" class="w-4 h-4" />
</a>
