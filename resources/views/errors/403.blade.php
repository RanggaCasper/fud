@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('svg', asset('assets/svg/undraw_access-denied_krem.svg'))
@section('message', __($exception->getMessage() ?: 'Forbidden'))
