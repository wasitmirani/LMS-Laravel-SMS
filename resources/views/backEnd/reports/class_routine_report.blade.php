@extends('backEnd.master')
@section('title')
@lang('lang.class_routine_report')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.class_routine_report')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.reports')</a>
                <a href="#">@lang('lang.class_routine_report')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area">
    <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">@lang('lang.select_criteria') </h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if(session()->has('message-success') != "")
                        @if(session()->has('message-success'))
                        <div class="alert alert-success">
                            {{ session()->get('message-success') }}
                        </div>
                        @endif
                    @endif
                    @if(session()->has('message-danger') != "")
                        @if(session()->has('message-danger'))
                        <div class="alert alert-danger">
                            {{ session()->get('message-danger') }}
                        </div>
                        @endif
                    @endif
                    <div class="white-box">
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'class_routine_report', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_student']) }}
                            <div class="row">
                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                                <div class="col-lg-6 mt-30-md col-md-6">
                                    <select class="w-100 bb niceSelect form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class">
                                        <option data-display="@lang('lang.select_class') *" value="">@lang('lang.select_class') *</option>
                                        @foreach($classes as $class)
                                        <option value="{{$class->id}}"  {{isset($class_id)? ($class_id == $class->id?'selected':''):''}}>{{$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('class') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 mt-30-md col-md-6" id="select_section_div">
                                    <select class="w-100 bb niceSelect form-control{{ $errors->has('section') ? ' is-invalid' : '' }}" id="select_section" name="section">
                                        <option data-display="@lang('lang.select_section') *" value="">@lang('lang.select_section') *</option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                    </div>
                                    @if ($errors->has('section'))
                                    <span class="invalid-feedback invalid-select" role="alert">
                                        <strong>{{ $errors->first('section') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-lg-12 mt-20 text-right">
                                    <button type="submit" class="primary-btn small fix-gr-bg">
                                        <span class="ti-search pr-2"></span>
                                        @lang('lang.search')
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
    </div>
</section>

@if(isset($sm_routine_updates))
<section class="mt-20">
    <div class="container-fluid p-0">
        <div class="row mt-40">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-30">@lang('lang.class_routine')</h3>
                </div>
            </div>
            <div class="col-lg-8 pull-right mb-30">
                <a href="{{route('classRoutinePrint', [$class_id, $section_id])}}" class="primary-btn small fix-gr-bg pull-right" target="_blank"><i class="ti-printer"> </i> @lang('lang.print')</a>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table id="default_table" class="display school-table " cellspacing="0" width="100%">
                    <thead>
                        @if(session()->has('success') != "")
                        <tr>
                            <td colspan="8">
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>@lang('lang.class_period')</th>
                            @foreach($sm_weekends as $sm_weekend)
                            <th>{{$sm_weekend->name}}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($class_times as $class_time)
                        <tr>
                            <td>{{@$class_time->period}}<br>{{date('h:i A', strtotime(@$class_time->start_time)).' - '.date('h:i A', strtotime(@$class_time->end_time))}}</td>
                            @foreach($sm_weekends as $sm_weekend)

                            <td>
                                @if(@$class_time->is_break == 0)
                                @if(@$sm_weekend->is_weekend != 1)


{{--                                        @$assinged_class_routine = App\SmClassRoutineUpdate::assingedClassRoutine($class_time->id, $sm_weekend->id, $class_id, $section_id);--}}
                                @php
                                    // @$assinged_class_routine = $class_time->routineUpdates->where('day',$sm_weekend->id)->where('class_id',$class_id)->where('section_id',$section_id)->frist();
                                    @$assinged_class_routine = App\SmClassRoutineUpdate::assingedClassRoutine($class_time->id, $sm_weekend->id, $class_id, $section_id);
                                @endphp
                                @if(@$assinged_class_routine != "")
                                    <span class="">{{@$assinged_class_routine->subject->subject_name}}</span>
                                    <br>
                                    <span class="">{{@$assinged_class_routine->classRoom->room_no}}</span></br>
                                    <span class="tt">{{@$assinged_class_routine->teacherDetail->full_name}}</span></br>
                                @endif

                                
                                @else
                                @lang('lang.weekend')

                                @endif
                                @endif
                            </td>

                            @endforeach
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endif



@endsection
