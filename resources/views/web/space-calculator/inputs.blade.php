@extends('skeleton')

@section('page')

    <h1>Space Calculator Inputs</h1>

    <p>Lorem ipsum dolor sit amet. This page is a WIP but demonstrates inputs and selects as view components below.</p>

    <x-inputs.text name="test" label="This is a test" type="email" value="lorem" placeholder="ipsum" :required="true" :disableLabel="true" :classes="['class1', 'class2', 'flex']" />

@endsection