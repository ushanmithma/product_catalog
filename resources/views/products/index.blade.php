@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row g-2 align-items-center mb-4">
                <div class="col">
                    <h3>{{ __('Products') }}</h3>
                </div>
                <div class="col-auto ms-auto d-print-none">
                  <div class="btn-list">
                    <a href="{{ route('products.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                      Create
                    </a>
                  </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif

                    <div class="table-responsive py-4">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script type="module">
    var productTable = $('#table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            fixedHeader: true,
            order: [[0, "desc"]],
            pageLength: 10,
            autoWidth: false,
            ajax: "{{ route('product-table') }}",
            columns: [
                { data: null, defaultContent: '', orderable: false  },
                { data: 'id', name: 'id', visible: false },
                { data: 'name', name: 'name', className: 'font-monospace' },
                { data: 'category', name: 'category' },
                { data: 'selling_price', name: 'selling_price' },
                { data: 'status', name: 'status' },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                    render(data, type, row) {
                        return `
                            <button type="button" class="btn btn-primary btn-sm btn-icon edit-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="m7 17.013 4.413-.015 9.632-9.54c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.756-.756-2.075-.752-2.825-.003L7 12.583v4.43zM18.045 4.458l1.589 1.583-1.597 1.582-1.586-1.585 1.594-1.58zM9 13.417l6.03-5.973 1.586 1.586-6.029 5.971L9 15.006v-1.589z"></path><path d="M5 21h14c1.103 0 2-.897 2-2v-8.668l-2 2V19H8.158c-.026 0-.053.01-.079.01-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2z"></path></svg>
                            </button>

                            <button type="button" class="btn btn-secondary btn-sm btn-icon show-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/></svg>
                            </button>

                            <button type="button" class="btn btn-danger btn-sm btn-icon delete-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                            </button>
                        `;
                    }
                },
            ]

        });

        $('#table tbody').on('click', '.edit-btn', function (e) {
            e.preventDefault();
            var data = productTable.row($(this).closest('tr')).data();

            // Check if the data is an object with an 'id' property
            if (data && typeof data === 'object' && data.id) {
                var id = data.id;
                window.location.href = `/products/${id}/edit`;
            }
        });

        $('#table tbody').on('click', '.show-btn', function (e) {
            e.preventDefault();
            var data = productTable.row($(this).closest('tr')).data();

            // Check if the data is an object with an 'id' property
            if (data && typeof data === 'object' && data.id) {
                var id = data.id;
                window.location.href = `/products/${id}`;
            }
        });


        $('#table tbody').on('click', '.delete-btn', function (e) {
            e.preventDefault();

            var data = productTable.row($(this).closest('tr')).data();

            if (data) {
                var id = data.id;

                var confirmation = window.confirm('Are you sure you want to delete this record?');

                if (confirmation){
                    $.ajax({
                        type: 'DELETE',
                        url: '/products/' + id,
                        success: function(response) {
                            if (response.status === 'success') {
                                productTable.ajax.reload();
                            } else {
                                console.log(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                }
            }
        });
</script>
@endpush
