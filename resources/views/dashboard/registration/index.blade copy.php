@extends('elements.master-layout')
{{-- start main content --}}
@section('content')
<!--begin::Row-->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title alert alert-primary my-auto w-50" style="height: 30px; line-height:30px; paddingX:0px 15px" >Registration List of Older Persons </h3>

                <a href="{{route('old-persons-form')}}" class="dynamic-modal btn btn-sm btn-primary ml-auto my-auto fa fa-plus fa-lg fa fa-menu" data-modal-target="modal-large" stylxe="height: 30px; line-height:30px; paddingX:0px 15px" >Add Older Person </a>

            </div>
            <div class="menu-dropdown dropdown-inline mr-4 d-none">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropup
                </button>
                <div class="dropdown-menu">
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-user"></i> TestDropdown
                        <span class="caret"></span>
                      </a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void();" data-toggle='tooltip' data-placement='top' title='Click to view curriculum'><i class="fa fa-eye text-success btnViewCurri">View</i></a>
                    <div class="dropdown-divider"></div>
                    <a role='button' class='fas fa-trash  fa-lg text-danger btnDeleteCurri' data-toggle='tooltip' data-placement='top' title='Click to delete'> Delete</a>
                    <div class="dropdown-divider"></div>
                    <a class="text-warning fa fa-building fa-lg btnArchiveCurri" role="button" data-toggle='tooltip' data-placement='top' title='Click to archive'> Archive</a>
                
                </div>
            </div>

            <div class="card-body table-responsive">

                <?php //if (count($curricula) > 0) : ?>
                    <table class="table table-bordered table-hover" id="myTable">
                        <thead>
                            <tr>
                                <!-- <th class="hidden"></th> -->
                                <th class="d-none"></th>
                                <!-- <th class="d-none"></th>
                                <th class="d-none"></th>
                                <th class="d-none"></th> -->
                                <th>#</th>
                                <th>District</th>
                                <th>NIN</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Type</th>
                                <th>Telephone</th>
                                <th colspan="1" style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //$i = 1;
                            //foreach ($curricula as $curriculum) : ?>
                                <tr data-widget="expandable-tablex" aria-expanded="false" id='<?//= $curriculum->curriculum_id ?>'>
                                    <td class='curriculum_id' style='display:none;'><?//= $curriculum->curriculum_id ?></td>
                                    <td><?//= $i ?></td>
                                    <td><?//= ucwords($curriculum->class_name) ?></td>
                                    <td><?//= ucwords($curriculum->subject_name) ?></td>
                                    <td><?//= ucwords($curriculum->curriculum_title) ?></td>
                                    <td><?//= ucwords($curriculum->username) ?></td>
                                    <td><?//= date('jS l, F Y ', strtotime($curriculum->curriculum_created_at)) ?></td>
                                    <td><?//= date('jS l, F Y ', strtotime($curriculum->curriculum_created_at)) ?></td>
                                    <td><?//= date('jS l, F Y ', strtotime($curriculum->curriculum_created_at)) ?></td>

                                    <td>
                                        <div class="btn-group ml-4">
                                            <button type="button" class="btn btn-info fa fa-menu"> Action</button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu xmt-4 text-center">
                                                <!-- <a class="dropdown-item" href="#">Action</a> -->
                                                <!-- <div class="dropdown-divider"></div> -->
                                                <a href="<?//= base_url(route_to('save-curriculum')).'/'.$curriculum->reference_number?>"><i class="fa fa-pen text-primary " data-toggle='tooltip' data-placement='top' title='Click to edit'>Edit</i></a>
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:void();" data-toggle='tooltip' data-placement='top' title='Click to view curriculum'><i class="fa fa-eye text-success btnViewCurri">View</i></a>
                                                <div class="dropdown-divider"></div>
                                                <a role='button' class='fas fa-trash  fa-lg text-danger btnDeleteCurri' data-toggle='tooltip' data-placement='top' title='Click to delete'> Delete</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="text-warning fa fa-building fa-lg btnArchiveCurri" role="button" data-toggle='tooltip' data-placement='top' title='Click to archive'> Archive</a>
                                            </div>
                                        </div>
                                        <div class="dropdown dropdown-inline mr-4 d-none">
                                            <button type="button" class="btn btn-light-primary btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ki ki-bold-more-hor"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:void();" data-toggle='tooltip' data-placement='top' title='Click to view curriculum'><i class="fa fa-eye text-success btnViewCurri">View</i></a>
                                                <div class="dropdown-divider"></div>
                                                <a role='button' class='fas fa-trash  fa-lg text-danger btnDeleteCurri' data-toggle='tooltip' data-placement='top' title='Click to delete'> Delete</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="text-warning fa fa-building fa-lg btnArchiveCurri" role="button" data-toggle='tooltip' data-placement='top' title='Click to archive'> Archive</a>
                                            
                                            </div>
                                        </div>
                                    </td>


                                </tr>
                            <?//php $i++;
                            //endforeach; ?>


                        </tbody>
                    </table>
                <?//php else : ?>
                    <h5 class="text-danger mt-4 text-center">No Old Persons Found!</h5>
                <?//php endif; ?>
            </div>



        </div>
    </div>
</div>
<!--end::Row-->
@endsection
{{-- end main content --}}
@section('custom-js')
    {{-- @include('scripts.dashboard.main') --}}
    
@endsection
