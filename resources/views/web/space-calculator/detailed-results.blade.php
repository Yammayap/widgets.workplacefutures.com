@extends('skeleton')

@section('page')

   <h1>Space calculator summary results</h1>

   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>

   <x-space-calculator.outputs.questions :inputs="$inputs" />

   <x-space-calculator.outputs.area-size :areaSize="$outputs->areaSize" />

   <x-space-calculator.outputs.capacity-types :capacityTypes="$outputs->capacityTypes" />

   <x-space-calculator.outputs.area-types :areaTypes="$outputs->areaTypes" />

   <x-space-calculator.outputs.assets :assets="$outputs->assets" />

   <x-errors :errors="$errors" />

   <form method="post" action="{{ route('web.space-calculator.outputs.detailed.post', $inputs) }}">
      <h2>Get detailed results PDF</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>
      @csrf
      <button type="submit" title="Get detailed results PDF">Get detailed results PDF</button>
   </form>

   @guest
      <form method="post" action="{{ route('web.auth.sign-in.post') }}">
         <input type="hidden" value="{{ $user->email }}" name="email">
         <h2>Log in to view your portal</h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>
         @csrf
         <button type="submit" title="Log in to view your portal">Log in to view your portal</button>
      </form>
   @endguest

@endsection
