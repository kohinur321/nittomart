@extends('backend.master')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Home Banner</h3>
                        </div>
                        <form action="{{url('/admin/home-banner/update')}}" method="post" enctype="multipart/form-data" required>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="banner">Banner</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="banner" name="banner" accept="image/*">
                                            <label class="custom-file-label" for="banner"">Choose file</label>
                                        </div>
                                    </div>
                                    <img src="{{asset('backend/images/settings/'.$homeBanner->banner)}}" height="300" width="400">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- general form elements -->
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
<script>
    $(function () {
      // Summernote
      $('#summernote').summernote()

      // CodeMirror
      CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
      });
    })
  </script>


@endpush




