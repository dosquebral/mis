@php $i = 0; @endphp

<div class="flex flex-col">
    <div class="flex items-center justify-between">
        <p class="text-[16px]">Task To Do</p>
        <span class="text-blue text-[16px] font-semibold mb-2">Completed Tasks: {{ $checked }} /
            {{ $taskPerReq->count() }}</span>
    </div>

    @foreach ($taskPerReq as $list)
        <div class="flex items-center mb-2 w-full">

            {{-- Clickable Task Button with Checkbox Inside --}}
            <button type="button"
                @click="if({{ $taskPerReq->count() - 1 }} == {{ $checked }} && !{{ $list->isCheck }}) { 
                if (confirm('Is task really completed?')) { 
                    $wire.checkTask({{ $list->id }}) 
                    } 
                } else { 
                    $wire.checkTask({{ $list->id }}) 
                }"
                class="w-full flex items-center gap-2 p-2 rounded-md text-gray-800 text-sm font-thin transition bg-gray-200 hover:bg-gray-300">

                {{-- Checkbox Inside Button --}}
                <div
                    class="w-5 h-5 flex items-center justify-center border rounded-full transition-all 
                           {{ $list->isCheck ? 'bg-blue-600 text-white border-blue-600' : 'border-blue-600 bg-white' }}">
                    @if ($list->isCheck)
                        <span class="text-[14px] font-bold">✓</span>
                    @endif
                </div>

                {{-- Task Name --}}
                <span>{{ $list->task }}</span>
            </button>
        </div>
    @endforeach
</div>
