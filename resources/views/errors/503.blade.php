@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('svg', asset('assets/svg/undraw_server-down_lxs9.svg'))
@section('message', __('Service Unavailable'))
