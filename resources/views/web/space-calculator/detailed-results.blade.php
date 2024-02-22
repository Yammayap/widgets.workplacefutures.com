@extends('skeleton')

@section('page')

   <p>Detailed Results</p> {{-- todo: real content later - this page is a placeholder for now to get the flow working --}}

   <x-space-calculator.outputs.questions :inputs="$inputs" />

   <x-space-calculator.outputs.area-size :areaSize="$outputs->areaSize" />

   <x-space-calculator.outputs.capacity-types :capacityTypes="$outputs->capacityTypes" />

   <x-space-calculator.outputs.area-types :areaTypes="$outputs->areaTypes" />

   <x-space-calculator.outputs.assets :assets="$outputs->assets" />

   {{-- todo: real text and actions in the forms --}}
   <form method="post" action="{{ route('web.space-calculator.outputs.detailed.post', $inputs) }}">
      <h2>Get detailed results PDF</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sodales, magna sit amet vehicula laoreet, urna nulla mattis turpis, a ultricies neque turpis quis purus. Pellentesque viverra eu nibh sit amet condimentum. Nulla aliquet, nibh id facilisis consectetur, leo elit convallis mi, at consectetur mauris ligula sed metus. In vehicula enim et sem placerat, sit amet scelerisque sapien sagittis. Pellentesque eget aliquet purus. Praesent pretium luctus nibh, ac ullamcorper lacus dignissim pharetra. Nunc nec dictum augue, quis sollicitudin enim. Nulla vitae eros sem. Phasellus eu mauris quis justo interdum molestie vel ut ligula. Vivamus in nisl massa. Suspendisse porttitor efficitur erat, ut cursus metus fermentum eu. Phasellus dictum mauris urna, eget tincidunt ipsum venenatis at. Sed ac nulla sit amet purus ultricies eleifend. Nunc elementum varius metus ut eleifend. Duis lacus metus, convallis sit amet ultricies eu, cursus et sem. Mauris scelerisque, ipsum facilisis tristique imperdiet, metus nibh bibendum mi, nec euismod lectus erat nec ex.</p>
      <x-errors :errors="$errors" />
      @csrf
      <button type="submit" title="Get detailed results PDF">Get detailed results PDF</button>
   </form>

   @guest
      <form method="post" action="{{ route('web.auth.sign-in.post') }}"> {{-- todo: real wording here --}}
         <h2>Log in to view your portal</h2>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sodales, magna sit amet vehicula laoreet, urna nulla mattis turpis, a ultricies neque turpis quis purus. Pellentesque viverra eu nibh sit amet condimentum. Nulla aliquet, nibh id facilisis consectetur, leo elit convallis mi, at consectetur mauris ligula sed metus. In vehicula enim et sem placerat, sit amet scelerisque sapien sagittis. Pellentesque eget aliquet purus. Praesent pretium luctus nibh, ac ullamcorper lacus dignissim pharetra. Nunc nec dictum augue, quis sollicitudin enim. Nulla vitae eros sem. Phasellus eu mauris quis justo interdum molestie vel ut ligula. Vivamus in nisl massa. Suspendisse porttitor efficitur erat, ut cursus metus fermentum eu. Phasellus dictum mauris urna, eget tincidunt ipsum venenatis at. Sed ac nulla sit amet purus ultricies eleifend. Nunc elementum varius metus ut eleifend. Duis lacus metus, convallis sit amet ultricies eu, cursus et sem. Mauris scelerisque, ipsum facilisis tristique imperdiet, metus nibh bibendum mi, nec euismod lectus erat nec ex.</p>
         <x-errors :errors="$errors" />
         @csrf
         <button type="submit" title="Log in to view your portal">Log in to view your portal</button>
      </form>
   @endguest

@endsection
