<table class="min-w-full mt-2">
    <thead class="bg-gray-100">
    <tr>
        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Autoriza
        </th>
        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Fecha
        </th>
        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Producto
        </th>
        <th scope="col" class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
            Cant.
        </th>
    </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    @foreach ($records as $item)
        <tr>
            <td class="px-4 py-2 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="ml-1">
                        <div class="text-sm font-medium text-gray-900">
                            {{$item->mantenimiento->autoriza->fullname}}
                        </div>
                    </div>
                </div>
            </td>
        <td class="px-4 py-2 whitespace-nowrap">
            <div class="flex items-center">
                <div class="ml-1">
                    <div class="text-sm font-medium text-gray-900">
                        {{$item->mantenimiento->fecha}}
                    </div>
                </div>
            </div>
        </td>
        <td class="px-4 py-2">
            <div class="flex items-center">
                <div class="ml-1">
                    <div class="text-sm font-medium text-gray-900">
                        <p class="text-xs">{{$item->producto->nombre}}</p>
                    </div>
                </div>
            </div>
        </td>
        <td class="px-2 py-2">
            <div class="flex items-center">
                <div class="ml-2">
                    <div class="text-sm font-medium text-gray-900">
                        {{$item->cantidad}}
                    </div>
                </div>
            </div>
        </td>
        </tr>
    @endforeach
    </tbody>
</table>