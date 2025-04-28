

 <div class="grid grid-cols-6 gap-6">
     @forelse($wordLists as $list)
         <div class="bg-white shadow-md border border-gray-100 rounded-xl flex flex-col hover:shadow-xl">

                 <img class="mb-5 rounded-t-xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
                 <h2 class="text-sm h-20 font-semibold pl-4 pr-4">{{ $list['title'] }}</h2>
                 <div class="flex-grow pl-4 mt-7 text-gray-400 mb-5">
                     <div class="font-semibold">{{ $list->type?->title }}</div>
                     <div>{{ $list['count'] }} слов</div>
                     <div class="flex justify-center">
                         <a href="{{ route('admin.edit-list', $list['id']) }}" class="text-center bg-orange-400 hover:bg-orange-500 text-white rounded cursor-pointer">
                             Редактировать словарь
                         </a>
                     </div>
                     <div class="flex justify-center mt-3">
                         <a href="{{ route('admin.edit-words', $list['id']) }}" class=" text-center bg-sky-400 hover:bg-sky-500 text-white rounded cursor-pointer">
                             Редактировать слова
                         </a>
                     </div>
                 </div>

         </div>

     @empty
         Не найдено
     @endforelse
 </div>

