@extends('skeleton')

@section('page')

   <p>Outputs page</p>

   <x-space-calculator.outputs.questions :inputs="$inputs" />

   <x-space-calculator.outputs.area-size :areaSize="$outputs->areaSize" />

   <x-space-calculator.outputs.capacity-types :capacityTypes="$outputs->capacityTypes" />

   <x-space-calculator.outputs.area-types :areaTypes="$outputs->areaTypes" />

   <x-space-calculator.outputs.assets :areaTypes="$outputs->assets" />

@endsection
