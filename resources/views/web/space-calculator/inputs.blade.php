@extends('skeleton')

@section('page')

    <h1>Space Calculator Inputs</h1>

    <p>Lorem ipsum dolor sit amet. This page is a WIP but demonstrates inputs and selects as view components below.</p>

    <form action="{{ route('web.space-calculator.inputs.post') }}" method="post" novalidate>
        {{-- note: The questions/labels below have been copied from the spreadsheet --}}
        @csrf
        <x-errors :errors="$errors" />
        <div> {{-- naming these selects the same as the enums --}}
            <x-selects.workstyle label="Choose the sector or predominant work style that most closely matches your organisation" :selected="old('workstyle')" allowBlank />
        </div>

        <div>
            <x-forms.label for="total_people">
                How many people will be working out of this office?
            </x-forms.label>
            <x-forms.text name="total_people" id="total_people" type="number" :value="old('total_people')" />
        </div>
        <div>
            <x-forms.label for="growth_percentage">
                What percentage should be added for growth or flexibility if any?
            </x-forms.label>
            <x-forms.text name="growth_percentage" id="growth_percentage" type="number" :value="old('growth_percentage')" />
        </div>
        <div>
            <x-forms.label for="desk_percentage">
                What percentage of the workers will be allocated a workstation that remains theirs (enter 100% if everyone has their own desk and 0% if everyone hot-desks)?
            </x-forms.label>
            <x-forms.text name="desk_percentage" id="desk_percentage" type="number" :value="old('desk_percentage')" />
        </div>

        <div>
            <x-selects.hybrid-working label="What is your hybrid working policy (choose closest match)?" :selected="old('hybrid_working')" allowBlank />
        </div>
        <div>
            <x-selects.mobility label="Which of these best describes the level of mobility when in the office?" :selected="old('mobility')" allowBlank />
        </div>
        <div>
            <x-selects.collaboration label="Which of these best describes the level of team or focus working when in the office?" :selected="old('collaboration')" allowBlank />
        </div>
        <button type="submit" title="Submit Inputs">Submit Inputs</button> {{-- todo: discuss real submit button text - this is proably fine for now --}}
    </form>

@endsection