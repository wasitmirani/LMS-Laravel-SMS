@extends('backEnd.master')
@section('title')
@lang('lang.assignment') @lang('lang.list')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lang.assignment') @lang('lang.list') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('lang.dashboard')</a>
                <a href="#">@lang('lang.study_material')</a>
                <a href="#">@lang('lang.assignment') @lang('lang.list')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-4 no-gutters">
                <div class="main-title">
                    <h3 class="mb-0">@lang('lang.assignment') @lang('lang.list')</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <table id="table_id" class="display school-table" cellspacing="0" width="100%">

                    <thead>
                 
                       
                        <tr>
                            <th>@lang('lang.content_title')</th>
                            <th>@lang('lang.date')</th>
                            <th>@lang('lang.available_for')</th>
                            {{-- <th>@lang('lang.class_Sec')</th> --}}
                            <th style="max-width:30%">@lang('lang.description')</th>
                            <th>@lang('lang.action')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(isset($uploadContents))
                        @foreach($uploadContents as $value)
                        <tr>

                            <td>{{@$value->content_title}}</td>
                            <td  data-sort="{{strtotime(@$value->upload_date)}}" >
                                {{@$value->upload_date != ""? dateConvert(@$value->upload_date):''}}

                            </td>
                            <td>

                                @if(@$value->available_for_admin == 1)
                                    @lang('lang.all_admins')<br>
                                @endif
                                @if(@$value->available_for_all_classes == 1)
                                    @lang('lang.all_classes_student')
                                @endif

                                @if(@$value->classes != "" && $value->sections != "")
                                    @lang('lang.all_students_of') ({{@$value->classes->class_name.'->'.@$value->sections->section_name}})
                                @endif

                                @if(@$value->classes != "" && $value->sections == Null)
                                @lang('lang.all_students_of') ({{@$value->classes->class_name.'->'.'All Sections'}})
                            @endif
                            </td>
                            {{-- <td>

                            @if($value->class != "")
                                {{$value->classes->class_name}}
                            @endif 

                            @if($value->section != "")
                                ({{$value->sections->section_name}})
                            @endif


                            </td> --}}
                             <td>

                            {{@$value->description}}


                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        @lang('lang.select')
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">

                                     <a data-modal-size="modal-lg" title="View Content Details" class="dropdown-item modalLink" href="{{route('upload-content-student-view', $value->id)}}">@lang('lang.view') </a>

                                        @if(@$value->upload_file != "")
                                            @if(userPermission(28))
                                                <a class="dropdown-item" href="{{url(@$value->upload_file)}}" download>
                                                @lang('lang.download') <span class="pl ti-download"></span></a>
                                            @endif
                                        @endif
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                            @if(isset($uploadContents2))
                            @foreach($uploadContents2 as $value2)
                            @if($value2->available_for_all_classes==0 && !empty($value2->class) && $value2->section==null)
                            <tr>
    
                                <td>{{@$value2->content_title}}</td>
                                <td  data-sort="{{strtotime(@$value2->upload_date)}}" >
                                    {{@$value2->upload_date != ""? dateConvert(@$value2->upload_date):''}}
    
                                </td>
                                <td>
    
                                    @if(@$value2->available_for_admin == 1)
                                        @lang('lang.all_admins')<br>
                                    @endif
                                    @if(@$value2->available_for_all_classes == 1)
                                        @lang('lang.all_classes_student')
                                    @endif
    
                                    @if(@$value2->classes != "" && $value2->sections != "")
                                        @lang('lang.all_students_of') ({{@$value2->classes->class_name.'->'.@$value2->sections->section_name}})
                                    @endif
    
                                    @if(@$value2->classes != "" && $value2->section == Null)
                                    @lang('lang.all_students_of') ({{@$value2->classes->class_name.'->'}} @lang('lang.all_sections'))
                                @endif
                                </td>
                                {{-- <td>
    
                                @if($value->class != "")
                                    {{$value->classes->class_name}}
                                @endif 
    
                                @if($value->section != "")
                                    ({{$value->sections->section_name}})
                                @endif
    
    
                                </td> --}}
                                 <td>
    
                                {{@$value->description}}
    
    
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            @lang('lang.select')
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
    
                                         <a data-modal-size="modal-lg" title="View Content Details" class="dropdown-item modalLink" href="{{route('upload-content-student-view', $value->id)}}">@lang('lang.view') </a>
    
                                            @if(@$value->upload_file != "")
                                                @if(userPermission(28))
                                                    <a class="dropdown-item" href="{{url(@$value->upload_file)}}" download>
                                                    @lang('lang.download') <span class="pl ti-download"></span></a>
                                                @endif
                                            @endif
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
