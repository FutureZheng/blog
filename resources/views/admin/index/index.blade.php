@extends('admin.layout')

@section('content')
    <iframe src="{{ url('admin/index/info') }}" frameborder="0" width="100%" height="100%" name="main"></iframe>
@stop