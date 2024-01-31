@extends('layouts.admin.app')

@section('content')
    {{-- Page title --}}
    <x-header title="{{ __('admin.settings.attributes.title') }}" subtitle="{{ __('admin.settings.attributes.description') }}"
        size="text-3xl font-light" />
    {{-- Table --}}
    <div class="shadow  border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-none">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                        <span>Type</span>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                        <span>Groupes d'attribut</span>
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium whitespace-nowrap text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">
                        <span>Attributs</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none">
                @foreach ($datas as $data)
                    <tr class="bg-white dark:bg-gray-700 dark:text-white">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">
                            <a href="{{ route($route . 'edit', ['slug' => $data->slug]) }}"
                                class="flex items-center gap-1 hover:reduce-opacity hover:opacity-70 duration-300 text-primary">
                                <span class="underline decoration-dotted">{{ $data->class }}</span>
                                <x-icon name="o-pencil" class="w-4 h-4" />
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">
                            <span class="rounded-md border py-2 px-4 bg-white">{{ $data->group_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white">
                            <span class="rounded-md border py-2 px-4 bg-white">{{ $data->attribute_count }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
