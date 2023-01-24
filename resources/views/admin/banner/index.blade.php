@extends('admin.index')
@section('content')
<style>
    .table td,
    .table th {
        vertical-align: middle
    }
</style>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>{{__('Banners')}}</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">{{__('Banners')}}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="javascript:void(0)" class="btn btn-primary btn-flat m-b-30 m-t-30" data-toggle="modal"
                        data-target="#addBanner">Add New</a>
                    <div class="table-responsive dtdiv">
                        <table class="table table-striped dttablewidth">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Order Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><img src="{{ asset('public/upload/images/no-image.jpg') }}"
                                            class="border rounded" width="200" height="150" alt="">
                                    </td>
                                    <td>1</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="mr-2 ml-2" data-toggle="modal" data-target="#editBanner"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="#" onclick="return confirm('Are you sure to want to delete?');"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><img src="{{ asset('public/upload/images/no-image.jpg') }}"
                                            class="border rounded" width="200" height="150" alt="">
                                    </td>
                                    <td>2</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>
                                        <a class="mr-2 ml-2" data-toggle="modal" data-target="#editSlider"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="#" onclick="return confirm('Are you sure to want to delete?');"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- Banner Add Modal -->
<div class="modal fade" id="addBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class="row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-12">
                        <label for="image" class="form-label">Image <span class="text-danger">*</span> <br />
                            <span class="text-danger"> (Small image Recommended Size:
                                558*205px)</span><br />
                            <span class="text-danger"> (Big image Recommended Size:
                                640*480px)</span>
                        </label>
                        <input type="file" name="image" id="image" class="form-control" required>
                    </div>

                    <div class="form-group col-12">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control" required>
                    </div>

                    <div class="form-group col-12">
                        <label for="order" class="form-label">Order Number</label>
                        <input type="number" name="order" id="order" class="form-control">
                    </div>


                    <div class="form-group col-12">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="" class="d-none">-- Select One --</option>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-md form-control">Add</button>
                        </div>
                        <div class="col-md-6">
                            <input type="button" class="btn btn-secondary btn-md form-control" data-dismiss="modal"
                                value="Close">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Banner Edit Modal -->
<div class="modal fade" id="editBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class="row" method="post" enctype="multipart/form-data">
                    <div class="form-group col-12">
                        <img src="{{ asset('public/upload/images/no-image.jpg') }}" class="border rounded" width="120"
                            alt="">
                    </div>
                    <div class="form-group col-12">
                        <label for="image" class="form-label">Image <span class="text-danger">*</span> <br />
                            <span class="text-danger"> (Small image Recommended Size:
                                558*205px)</span><br />
                            <span class="text-danger"> (Big image Recommended Size:
                                640*480px)</span>
                        </label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="form-group col-12">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control" required>
                    </div>

                    <div class="form-group col-12">
                        <label for="order" class="form-label">Order Number</label>
                        <input type="number" name="order" id="order" class="form-control">
                    </div>


                    <div class="form-group col-12">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
                        </select>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-md form-control">Update</button>
                        </div>
                        <div class="col-md-6">
                            <input type="button" class="btn btn-secondary btn-md form-control" data-dismiss="modal"
                                value="Close">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection
