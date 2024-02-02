@extends('skeleton')

@section('page')

    <h1>Space Calculator Inputs</h1>

    <p>Lorem ipsum dolor sit amet. This page is a WIP but demonstrates inputs and selects as view components below.</p>

    <form action="#" method="post" novalidate> {{-- real action url to come in next PR for posting/capturing this data --}}
        {{-- note: The questions/labels below have been copied from the spreadsheet --}}
        {{ csrf_field() }}
        <div>
            <x-selects.boolean name="checker" label="Lorem" :selected="true" :classes="['class1', 'class2', 'grid']" required allowBlank />
        </div>
        <div>
            <x-inputs.text name="total_people" label="How many people will be working out of this office?" type="number" required />
        </div>
        <div>
            <x-inputs.text name="growth_percentage" label="What percentage should be added for growth or flexibility if any?" type="number" required />
        </div>
        <div>
            <x-inputs.text name="desk_percentage" label="What percentage of the workers will be allocated a workstation that remains theirs (enter 100% if everyone has their own desk and 0% if everyone hot-desks)?" type="number" required />
        </div>
        <button type="submit">Submit Inputs</button> {{-- todo: discuss real submit button text - this is proably fine for now --}}
    </form>

@endsection