@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('svg', asset('assets/svg/undraw_secure-login_m11a.svg'))
@section('message', __('Unauthorized'))
