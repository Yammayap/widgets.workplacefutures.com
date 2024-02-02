@extends('skeleton')

@section('page')

    <h1>Space Calculator Inputs</h1>

    <p>Lorem ipsum dolor sit amet. This page is a WIP but demonstrates inputs and selects as view components below.</p>

    <form action="#" method="post" novalidate> {{-- real action url to come in next PR for posting/capturing this data --}}
        {{-- note: The questions/labels below have been copied from the spreadsheet --}}
        {{ csrf_field() }}
        <div> {{-- naming these selects the same as the enums --}}
            <x-selects.workstyle label="Choose the sector or predominant work style that most closely matches your organisation" :selected="old('workstyle')" allowBlank />
        </div>
        <div>
            <x-inputs.text name="total_people" label="How many people will be working out of this office?" type="number" :value="old('total_people')" required />
        </div>
        <div>
            <x-inputs.text name="growth_percentage" label="What percentage should be added for growth or flexibility if any?" type="number" :value="old('growth_percentage')" required />
        </div>
        <div>
            <x-inputs.text name="desk_percentage" label="What percentage of the workers will be allocated a workstation that remains theirs (enter 100% if everyone has their own desk and 0% if everyone hot-desks)?" type="number" :value="old('desk_percentage')" required />
        </div>
        <div>
            <x-selects.hybrid-working label="What is your hybrid working policy (choose closest match)?" :selected="old('hybrid_working')" allowBlank />
        </div>
        <button type="submit" title="Submit Inputs">Submit Inputs</button> {{-- todo: discuss real submit button text - this is proably fine for now --}}
    </form>

@endsection