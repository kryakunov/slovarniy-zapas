
    @forelse($wordLists as $list)
        <div class="bg-white shadow-md border border-gray-100 rounded-xl flex flex-col hover:shadow-xl">
            <a href="{{ route('open-word-list', $list['slug']) }}">
                <img class="mb-5 rounded-t-xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
                <h2 class="text-sm h-20 font-semibold pl-4 pr-4">{{ $list['title'] }}</h2>
                <div class="flex-grow pl-4 mt-7 text-gray-400 mb-5">
                    <div class="font-semibold">{{ $list->type?->title }}</div>
                    <div>{{ $list['count'] }} слов</div>
                </div>
            </a>
        </div>

    @empty
        Не найдено
    @endforelse

