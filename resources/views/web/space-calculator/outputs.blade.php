@extends('skeleton')

@section('page')

   <p>Outputs page</p>

   <x-space-calculator.outputs.questions :inputs="$inputs" />

   <x-space-calculator.outputs.area-size :areaSize="$outputs->areaSize" />

   <x-space-calculator.outputs.capacity-types :capacityTypes="$outputs->capacityTypes" />

   <x-space-calculator.outputs.area-types :areaTypes="$outputs->areaTypes" />

   <x-space-calculator.outputs.assets :assets="$outputs->assets" />

   {{-- todo: real text and actions in the forms --}}

   @if($user)
      <form method="post" action="{{ route('web.space-calculator.outputs.full-details.post', $inputs) }}">
         <h2>Capture full details</h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sodales, magna sit amet vehicula laoreet, urna nulla mattis turpis, a ultricies neque turpis quis purus. Pellentesque viverra eu nibh sit amet condimentum. Nulla aliquet, nibh id facilisis consectetur, leo elit convallis mi, at consectetur mauris ligula sed metus. In vehicula enim et sem placerat, sit amet scelerisque sapien sagittis. Pellentesque eget aliquet purus. Praesent pretium luctus nibh, ac ullamcorper lacus dignissim pharetra. Nunc nec dictum augue, quis sollicitudin enim. Nulla vitae eros sem. Phasellus eu mauris quis justo interdum molestie vel ut ligula. Vivamus in nisl massa. Suspendisse porttitor efficitur erat, ut cursus metus fermentum eu. Phasellus dictum mauris urna, eget tincidunt ipsum venenatis at. Sed ac nulla sit amet purus ultricies eleifend. Nunc elementum varius metus ut eleifend. Duis lacus metus, convallis sit amet ultricies eu, cursus et sem. Mauris scelerisque, ipsum facilisis tristique imperdiet, metus nibh bibendum mi, nec euismod lectus erat nec ex.</p>
         @csrf
         <x-errors :errors="$errors" />
         <div>
            <x-forms.label for="first_name">First name</x-forms.label>
            <x-forms.text type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" />
         </div>
         <div>
            <x-forms.label for="last_name">Last name</x-forms.label>
            <x-forms.text type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" />
         </div>
         <div>
            <x-forms.label for="company_name">Company name</x-forms.label>
            <x-forms.text type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" />
         </div>
         <div>
            <x-forms.label for="telephone">Telephone Number</x-forms.label>
            <x-forms.text type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}" />
         </div>
         <div>
            <x-forms.label for="message">Message</x-forms.label>
            <x-forms.textarea name="message" id="message" value="{{ old('message') }}" />
         </div>
         {{-- checkboxes next --}}
      </form>
   @else
      <form method="post" action="{{ route('web.space-calculator.outputs.index.post', $inputs) }}">
         <h2>Get results PDF</h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sodales, magna sit amet vehicula laoreet, urna nulla mattis turpis, a ultricies neque turpis quis purus. Pellentesque viverra eu nibh sit amet condimentum. Nulla aliquet, nibh id facilisis consectetur, leo elit convallis mi, at consectetur mauris ligula sed metus. In vehicula enim et sem placerat, sit amet scelerisque sapien sagittis. Pellentesque eget aliquet purus. Praesent pretium luctus nibh, ac ullamcorper lacus dignissim pharetra. Nunc nec dictum augue, quis sollicitudin enim. Nulla vitae eros sem. Phasellus eu mauris quis justo interdum molestie vel ut ligula. Vivamus in nisl massa. Suspendisse porttitor efficitur erat, ut cursus metus fermentum eu. Phasellus dictum mauris urna, eget tincidunt ipsum venenatis at. Sed ac nulla sit amet purus ultricies eleifend. Nunc elementum varius metus ut eleifend. Duis lacus metus, convallis sit amet ultricies eu, cursus et sem. Mauris scelerisque, ipsum facilisis tristique imperdiet, metus nibh bibendum mi, nec euismod lectus erat nec ex.</p>
         <x-errors :errors="$errors" />
         @csrf
         <x-forms.label for="email">Email address</x-forms.label>
         <x-forms.text type="email" name="email" id="email" value="{{ old('email') }}" />
         <button type="submit" title="Get results PDF">Get results PDF</button>
      </form>
   @endif

@endsection
