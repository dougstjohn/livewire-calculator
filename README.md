## Livewire Calculator

This is a Laravel Livewire calculator component that mimics the basic Apple OS calculator. It uses [Laravel PHP](https://laravel.com) with [Blade templates](https://laravel.com/docs/master/blade), [Laravel Livewire](https://laravel-livewire.com), [Tailwind CSS](https://tailwindcss.com), and NO custom JavaScript.

### Preview:
<img src="docs/calculator-sm.png" width="300" title="Calculator Preview" />

### Things to try:
- Calculate with equals: `2+3=`
- Calculate with operator: `2+3+4+5+`
- Calculate with number and operator: `3*=`
- Start another calculation: `2+3= 4+5=`
- Percent: `2%`
- Negate: `2`&plusmn;
- Decimals and negatives: `-2.4`
- Change operator without calculating: `2+-*/4=`
- `2+3%` disregards first number
- `2+3`&plusmn; negates last number
- Edge cases:
    - Prepends 0 on decimal: `0.`
    - Blocks multiple decimals
    - Blocks first inputs as operators
    - Shows error for large numbers
    - Rounds large decimals
    - Divide by zero: `2/0=`

### Nice to haves:
- Code refactor and clean-up
- Support keydown actions for all calculator buttons
- Show error message on divide by zero
- Pressing equals multiple times applies last operation
