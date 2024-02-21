@extends('skeleton')

@section('page')

   <p>Detailed Results</p> {{-- todo: real content later - this page is a placeholder for now to get the flow working --}}

   <x-space-calculator.outputs.questions :inputs="$inputs" />

   <x-space-calculator.outputs.area-size :areaSize="$outputs->areaSize" />

   <x-space-calculator.outputs.capacity-types :capacityTypes="$outputs->capacityTypes" />

   <x-space-calculator.outputs.area-types :areaTypes="$outputs->areaTypes" />

   <x-space-calculator.outputs.assets :assets="$outputs->assets" />

   {{-- todo: real text and actions in the forms --}}

   {{-- detailed page forms here --}}

@endsection
