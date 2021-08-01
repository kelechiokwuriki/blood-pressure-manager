@extends('layouts.app')

@section('content')
<div class="container">
    <single-patient :userid="{{$id}}"></single-patient>
</div>
@endsection
