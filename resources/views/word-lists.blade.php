 @forelse($wordLists as $list)
     <div class="bg-white shadow-md border border-gray-100 p-5 rounded-2xl w-70 flex flex-col h-full">
         <h2 class="text-lg font-semibold mb-5">{{ $list['title'] }}</h2>
         <img class="mb-5 rounded-2xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
         <div class="flex-grow h-30 mb-5">{{ $list['description'] }}</div>
         <div class="flex justify-center mb-0">
             <a href="{{ route('open-word-list', $list['id']) }}" class="w-full text-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                 Открыть
             </a>
         </div>
     </div>
@empty
    Не найдено
@endforelse




