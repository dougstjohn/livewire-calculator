<div class="m-8">
    {{--
    <input class="hidden" wire:keydown.escape="clear">
    <input class="hidden" wire:keydown.shift.1="negate">
    <input class="hidden" wire:keydown.shift.5="percent">
    <input class="hidden" wire:keydown.add="add">
    <input class="hidden" wire:keydown.subtract="subtract">
    <input class="hidden" wire:keydown.multiply="multiply">
    <input class="hidden" wire:keydown.divide="divide">
    <input class="hidden" wire:keydown.decimal="decimal">
    <input class="hidden" wire:keydown.0="number(0)">
    <input class="hidden" wire:keydown.1="number(1)">
    <input class="hidden" wire:keydown.2="number(2)">
    <input class="hidden" wire:keydown.3="number(3)">
    <input class="hidden" wire:keydown.4="number(4)">
    <input class="hidden" wire:keydown.5="number(5)">
    <input class="hidden" wire:keydown.6="number(6)">
    <input class="hidden" wire:keydown.7="number(7)">
    <input class="hidden" wire:keydown.8="number(8)">
    <input class="hidden" wire:keydown.9="number(9)">
    <input class="hidden" wire:keydown.enter="equal">
    --}}

    <div class="flex">
        <div class="w-full bg-gray-600 h-18 text-right text-3xl sm:text-4xl md:text-5xl border border-b-0 border-gray-800 inline-block align-middle pr-4">{{ $display }}</div>
    </div>

    <div class="flex">
        <button class="w-1/4 bg-gray-500 border-t border-l border-gray-800 h-12" wire:click="clear" title="Clear">{{ $this->clearText }}</button>
        <button class="w-1/4 bg-gray-500 border-t border-l border-gray-800 h-12" wire:click="negate" title="Negate">&plusmn;</button>
        <button class="w-1/4 bg-gray-500 border-t border-l border-gray-800 h-12" wire:click="percent" title="Percent">&percnt;</button>
        <button class="w-1/4 bg-orange-400 border-gray-800 h-12 {{ $selectedOperator == '/' ? 'border-2' : 'border border-b-0' }}" wire:click="divide" title="Divide">&divide;</button>
    </div>

    <div class="flex">
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(7)">7</button>
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(8)">8</button>
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(9)">9</button>
        <button class="w-1/4 bg-orange-400 border-gray-800 h-12 {{ $selectedOperator == '*' ? 'border-2' : 'border border-b-0' }}" wire:click="multiply" title="Multiply">&times;</button>
    </div>

    <div class="flex">
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(4)">4</button>
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(5)">5</button>
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(6)">6</button>
        <button class="w-1/4 bg-orange-400 border-gray-800 h-12 {{ $selectedOperator == '-' ? 'border-2' : 'border border-b-0' }}" wire:click="subtract" title="Subtract">&minus;</button>
    </div>

    <div class="flex">
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(1)">1</button>
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(2)">2</button>
        <button class="w-1/4 bg-gray-400 border-t border-l border-gray-800 h-12" wire:click="number(3)">3</button>
        <button class="w-1/4 bg-orange-400 border-gray-800 h-12 {{ $selectedOperator == '+' ? 'border-2' : 'border border-b-0' }}" wire:click="add" title="Add">&plus;</button>
    </div>

    <div class="flex">
        <button class="w-1/2 bg-gray-400 border border-r-0 border-gray-800 h-12" wire:click="number(0)">0</button>
        <button class="w-1/4 bg-gray-400 border border-r-0 border-gray-800 h-12" wire:click="decimal">&middot;</button>
        <button class="w-1/4 bg-orange-400 border border-gray-800 h-12" wire:click="equal" title="Equal">&equals;</button>
    </div>

    <div class="sm:block md:flex mt-16 border border-gray-400 bg-gray-100">
        <div class="md:w-1/4 bg-gray-100 h-18 text-left sm:text-2xl md:text-3xl font-bold px-4">Stack</div>
        <div class="md:w-3/4 bg-gray-100 h-18 sm:text-left md:text-right sm:text-2xl md:text-3xl px-4">{{ $stack }}</div>
    </div>
</div>