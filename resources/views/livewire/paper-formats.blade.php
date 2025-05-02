<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Формат бумаги') }}
            </h2>
        </x-slot>

        <div class="p-6 bg-gray-100 space-y-6 max-w-md mx-auto">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded">
                                    <table class="min-w-full divide-y divide-gray-200 w-full">
                                        <thead>
                                        <tr>
                                            <th scope="col" width="50" class="px-3 py-4 bg-gray-50 text-left text-sm font-medium text-gray-800">
                                                <div class="text-center">{{ __('#') }}</div>
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 bg-gray-50 text-left text-sm font-medium text-gray-800">
                                                <div class="pl-4">{{ __('Наименование') }}</div>
                                            </th>
                                            <th scope="col"
                                                class="px-2 py-3 bg-gray-50 text-left text-sm font-medium text-gray-800">
                                                <div class="pl-4">{{ __('Ширина') }}</div>
                                            </th>

                                            <th scope="col"
                                                class="px-2 py-3 bg-gray-50 text-left text-sm font-medium text-gray-800">
                                                <div class="pl-4">{{ __('Длина') }}</div>
                                            </th>

                                            <th scope="col" width="200"
                                                class="px-2 py-3 bg-gray-50 text-left text-sm font-medium text-gray-800">
                                                <div class="pl-4 border-l border-gray-200">{{ __('Действие') }}</div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @if (count((array)$formats) > 0)
                                            @foreach ($formats as $format)
                                                <tr>
                                                    <td class="px-6 py-1.5 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $format->id }}
                                                    </td>

                                                    <td class="px-6 py-1.5 text-sm text-gray-900">
                                                        {{ $format->name }}
                                                    </td>

                                                    <td class="px-6 py-1.5 text-sm text-gray-900">
                                                        {{ $format->width }}
                                                    </td>

                                                    <td class="px-6 py-1.5 text-sm text-gray-900">
                                                        {{ $format->height }}
                                                    </td>

                                                    <td class="px-6 py-1.5 whitespace-nowrap text-sm font-medium space-x-2 text-right">
                                                            <a href=""
                                                               class="text-blue-500 hover:text-blue-900 m-0 font-normal">{{ __('Редактировать') }}</a>
                                                            <button wire:click="$emit('triggerDelete',{{ $format->id }})"
                                                                    class="text-red-500 hover:text-red-900 bg-none border-0 m-0 cursor-pointer bg-transparent font-normal ">{{ __('Удалить') }}</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="h-48 w-full">
                                                <td scope="col" class="h-48 w-full text-center text-xs text-gray-500" colspan="3">
                                                    {{ __('admin.table.body.empty') }}
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
{{--                                    {{ $formats->appends(request()->query())->links('admin.common.pagination') }}--}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </div>

    </x-app-layout>
</div>
