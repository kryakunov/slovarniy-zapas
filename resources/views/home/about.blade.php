@extends('layouts.home')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">

        <div class="bg-white shadow-sm rounded-lg p-4">
            <div class="w-full">
                <h1 class="mb-5 text-xl font-semibold">О сервисе</h1>
                <div class="mb-4 flex mt-10">
                    <div>
                        <img src="me.png" class="rounded-full" width="1000" height="1000">
                    </div>
                    <div class="ml-5">
                        <div>Всем привет!</div>
                        <div class="mt-5">Меня зовут Крякунов Андрей. </div>
                        <div class="mt-5">Моей целью было сделать
                        удобный сервис, с помощью которого можно изучать новые слова.
                        Само обучение построено по принципу регулярного повторения слов.
                        При создании сервиса я опирался на данные о кривой Эббингауза, согласно
                        которой, если новые слова повторять с определенным промежутком, то можно
                        свести их забывание к нулю.</div>
                        <div class="mt-5">
                            <a href="https://vk.com/andrey.kryakunov" class="border-b text-sky-900 font-semibold border-dashed" target="_blank">Я в ВК</a>
                        </div>
                    </div>
               </div>
            </div>
            <div class="flex  justify-between">

            </div>
        </div>

    </main>
@endsection


