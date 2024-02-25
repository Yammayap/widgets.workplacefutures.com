@extends('skeleton')

@section('page')

    <h1>Space calculator inputs</h1>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean arcu quam, blandit eget sagittis nec, venenatis nec tellus. Cras mollis egestas molestie. Nam elit felis, facilisis eu enim quis, molestie iaculis nisi.</p>

    <form action="{{ route('web.space-calculator.inputs.post') }}" method="post" novalidate>
        @csrf
        <x-errors :errors="$errors" />
        <div>
            <x-forms.label for="workstyle">
                Choose the sector or predominant work style that most closely matches your organisation
            </x-forms.label>
            <x-forms.select name="workstyle" id="workstyle" :selected="old('workstyle')" allowBlank :options="\App\Enums\Widgets\SpaceCalculator\Workstyle::toSelectOptions()" />
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
            <x-forms.label for="hybrid_working">
                What is your hybrid working policy (choose closest match)?
            </x-forms.label>
            <x-forms.select name="hybrid_working" id="hybrid_working" :selected="old('hybrid_working')" allowBlank :options="\App\Enums\Widgets\SpaceCalculator\HybridWorking::toSelectOptions()" />
        </div>
        <div>
            <x-forms.label for="mobility">
                Which of these best describes the level of mobility when in the office?
            </x-forms.label>
            <x-forms.select name="mobility" id="mobility" :selected="old('mobility')" allowBlank :options="\App\Enums\Widgets\SpaceCalculator\Mobility::toSelectOptions()" />
        </div>
        <div>
            <x-forms.label for="collaboration">
                Which of these best describes the level of team or focus working when in the office?
            </x-forms.label>
            <x-forms.select name="collaboration" id="collaboration" :selected="old('collaboration')" allowBlank :options="\App\Enums\Widgets\SpaceCalculator\Collaboration::toSelectOptions()" />
        </div>
        <button type="submit" title="Get Results">Get Results</button>
    </form>

@endsection
