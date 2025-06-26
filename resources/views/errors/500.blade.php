@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('svg', asset('assets/svg/undraw_server-down_lxs9.svg'))
@section('message', __('Server Error'))
