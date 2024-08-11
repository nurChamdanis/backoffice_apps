@extends('layouts.app')

@section('template_title')
  {!! trans('usersmanagement.showing-user', ['name' => $user->name]) !!}
@endsection

@php
  $levelAmount = trans('usersmanagement.labelUserLevel');
  if ($user->level() >= 2) {
    $levelAmount = trans('usersmanagement.labelUserLevels');
  }
@endphp

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header text-white @if ($user->activated == 1) bg-success @else bg-danger @endif">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              {!! trans('usersmanagement.showing-user-title', ['name' => $user->name]) !!}
              <div class="float-right">
                <a href="{{ route('users') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                  <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                  {!! trans('usersmanagement.buttons.back-to-users') !!}
                </a>
              </div>
            </div>
          </div>

          <div class="card-body">

            <div class="row">
              <div class="col-sm-4 offset-sm-2 col-md-2 offset-md-3">
                <a href="">
                <img src="@if ($user->profile && $user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="rounded-circle center-block mb-3 mt-4 user-image">
                </a>
              </div>
              <div class="col-sm-4 col-md-6">
                <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                  {{ $user->name }}
                </h4>
                <p class="text-center text-left-tablet">
                  <strong>
                    {{ $user->first_name }} {{ $user->last_name }}
                  </strong>
                  @if($user->email)
                    <br />
                    <span class="text-center" data-toggle="tooltip" data-placement="top" title="{{ trans('usersmanagement.tooltips.email-user', ['user' => $user->email]) }}">
                      {{ Html::mailto($user->email, $user->email) }}
                    </span>
                  @endif
                </p>
                @if ($user->profile)
                  <div class="text-center text-left-tablet mb-4" style="text-align: center !important; display: flex; flex-wrap: wrap; align-content: flex-start; align-items: stretch; flex-direction: row;">
   -----
                  </div>
                @endif
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

       

@endsection

@section('footer_scripts')
  @include('scripts.delete-modal-script')
  @if(config('usersmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
@endsection
