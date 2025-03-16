 @forelse($wordLists as $list)
    <div class="bg-white shadow-md  border border-gray-100 p-5 rounded-2xl w-70">
        <h2 class="text-lg font-semibold mb-5">{{ $list['title'] }}</h2>
        <img class="mb-5" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
        <div class="h-30">{{ $list['description'] }}</div>
        <div class="flex justify-center">
            <a href="{{ route('admin.edit-list', $list['id']) }}" class="w-100 text-center bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded cursor-pointer">
                Редактировать словарь
            </a>
        </div>
        <div class="flex justify-center mt-3">
            <a href="{{ route('admin.edit-words', $list['id']) }}" class="w-100 text-center bg-sky-400 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded cursor-pointer">
                Редактировать слова
            </a>
        </div>
    </div>
@empty
    Не найдено
@endforelse


