<x-master>
    <x-slot:title>
        MAXXPRO Catalogue Parts List
    </x-slot:title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Catalogue Part List</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <form method="GET" action="{{ route('catalogue') }}">
                    <div class="mb-3">
                        <input type="text" name="search" class="form-control" id="search"
                            placeholder="Search by Part Number, NSN, or Nomenclature">
                    </div>
                </form>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                data-target="#uploadCatalogueModal">
                <span><i class="fa-solid fa-plus"></i></span>{{ __(' Upload Catalogue') }}
            </button>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="catalogueTable">
                <thead>
                    <tr class="text-center">
                        <th scope="col">SL</th>
                        <th scope="col">Part No</th>
                        <th scope="col">NSN</th>
                        <th scope="col">Nomenclature</th>
                        <th scope="col">Cat Location</th>
                        <th scope="col">CAGEC</th>
                        <th scope="col">Actin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cat_parts as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td @if (empty($item->part_no)) class="table-danger" @endif>{{ $item->part_no }}</td>
                            <td @if (empty($item->nsn)) class="table-danger" @endif>{{ $item->nsn }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                <table class="table table-bordered align-middle">
                                    <tbody>
                                        <tr>
                                            <td>Item No:</td>
                                            <td>{{ $item->item_no }}</td>

                                        </tr>
                                        <tr>
                                            <td>Page No:</td>
                                            <td>{{ $item->page_no }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td @if (empty($item->cagec)) class="table-danger" @endif>{{ $item->cagec }}</td>

                            {{-- {{ route('catalog_part_list.edit', $item->id) }} --}}
                            <td>
                                <a href="" class=" btn btn-sm link-warning" comment="Edit Part"><i
                                        class="fa-solid fa-pen-to-square fs-5"></i></a>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="7" class="text-danger fs-2">Not Matched!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $cat_parts->links('pagination::bootstrap-5') }}
        </div>
        {{-- <div class="d-flex justify-content-center">
            {{ $cat_parts->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div> --}}
    </div>


    <div class="modal fade" id="uploadCatalogueModal" tabindex="-1" aria-labelledby="uploadCatalogueModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="uploadCatalogueModalLabel"><span><i
                                class="fa-solid fa-plus"></i></span>{{ __(' Upload Catalogue') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('catalogue.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="cat_file" class="form-label">{{ __('Upload Excel') }}</label>
                            <input type="file" class="form-control" id="cat_file" name="cat_file">
                            @error('cat_file')
                                <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-secondary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                $('[data-toggle="modal"]').click(function() {
                    var targetModal = $(this).data('target');
                    $(targetModal).modal('show');
                });
            });
        </script>
    @endpush

</x-master>
