<x-app-layout>
    <div class="flex flex-col w-full h-full items-center mt-2">
        <form action="/sales" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">
                + New Sale
            </button>
        </form>
        @if (count($sales) > 0)
            <div class="w-1/2">
                <div class="text-2xl">
                    All Sales
                </div>
                <div class="mt-4 w-full">
                    <table class="w-full">
                        <thead>
                            <th>Sale</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($sales as $s)
                                <tr>
                                    <td>
                                        {{ $s->id }}
                                    </td>
                                    <td class="flex flex-row w-full justify-end">
                                        <a href="/sales/{{ $s->id }}/edit"
                                            class="bg-green-500 p-1 rounded-lg">
                                            <span>Details</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="">
                <div class="text-2xl text-red-500">
                    No Sales yet!
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
