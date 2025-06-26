@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('svg', asset('assets/svg/undraw_at-the-airport_z3b9.svg'))
@section('message', __('Too Many Requests'))
