@extends('skeleton')

@section('page')

   <h1>Space calculator summary results</h1>

   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>

   <x-space-calculator.outputs.questions :inputs="$inputs" />

   <x-space-calculator.outputs.area-size :areaSize="$outputs->areaSize" />

   <x-space-calculator.outputs.capacity-types :capacityTypes="$outputs->capacityTypes" />

   <x-space-calculator.outputs.area-types :areaTypes="$outputs->areaTypes" />

   <x-space-calculator.outputs.assets :assets="$outputs->assets" />


   @if($user)
      <form method="post" action="{{ route('web.space-calculator.outputs.profile.post', $inputs) }}">
         <h2>See detailed results</h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>
         @csrf
         <x-errors :errors="$errors" />
         <div>
            <x-forms.label for="first_name">First name *</x-forms.label>
            <x-forms.text type="text" name="first_name" id="first_name" :value="old('first_name')" />
         </div>
         <div>
            <x-forms.label for="last_name">Last name *</x-forms.label>
            <x-forms.text type="text" name="last_name" id="last_name" :value="old('last_name')" />
         </div>
         <div>
            <x-forms.label for="company_name">Company name</x-forms.label>
            <x-forms.text type="text" name="company_name" id="company_name" :value="old('company_name')" />
         </div>
         <div>
            <x-forms.label for="phone">Telephone Number</x-forms.label>
            <x-forms.text type="tel" name="phone" id="phone" :value="old('phone')" />
         </div>
         <div>
            <x-forms.label for="message">Message</x-forms.label>
            <x-forms.textarea name="message" id="message">{{ old('message') }}</x-forms.textarea>
         </div>
         <div>
            <x-forms.checkbox name="marketing_opt_in" id="marketing_opt_in" :checked="old('marketing_opt_in', false)" value="1">I'm happy to receive marketing from Workplace Futures Group</x-forms.checkbox>
         </div>
         <div>
            <x-forms.checkbox name="can_contact" id="can_contact" :checked="old('can_contact', false)" value="1">Happy for a consultant to get in touch?</x-forms.checkbox>
         </div>
         <div>
            <button type="submit" title="View detailed results">View detailed results</button>
         </div>
      </form>
   @else
      <form method="post" action="{{ route('web.space-calculator.outputs.summary.post', $inputs) }}">
         <h2>Get summary results PDF</h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>
         <x-errors :errors="$errors" />
         @csrf
         <x-forms.label for="email">Email address</x-forms.label>
         <x-forms.text type="email" name="email" id="email" value="{{ old('email') }}" />
         <button type="submit" title="Get summary results PDF">Get summary results PDF</button>
      </form>
   @endif

@endsection
