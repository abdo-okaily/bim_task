@extends('admin.layouts.master')
@section('title')
    @lang('admin.permission_vendor_roles')
@endsection
@section('css')
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header  border-0">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">@lang('admin.permission_vendor_roles')</h5>
                        <div class="flex-shrink-0">
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route("admin.roles.create") }}" class="btn btn-primary add-btn" id="create-btn">
                                    <i class="ri-add-line align-bottom me-1"></i>  @lang("admin.add")
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('admin.permission_vendor_role_name')</th>
                                <th scope="col">@lang('admin.permission_vendor_role_permissions')</th>
                                <th scope="col">@lang('admin.vendor_name')</th>
                                <th scope="col">@lang('admin.created_at')</th>
                                <th scope="col">@lang('admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 fs-16">
                                            @foreach ($role->permissions as $permission)
                                            <div class="badge fw-medium badge-info">@lang('translation.permissions_keys.' . $permission)</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ $role->vendor->name }}</td>
                                    <td>{{ date('d-m-Y h:i', strtotime($role->created_at)) }}</td>
                                    <td>
                                        <div class="hstack gap-3 flex-wrap">
                                            <a href="{{ route('admin.roles.edit', ['role' => $role]) }}" class="fs-15 link-success">
                                                <i class="ri-edit-2-line"></i>
                                            </a>
                                            <a href="{{ route('admin.roles.delete', ['role' => $role]) }}" class="fs-15 link-danger">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
