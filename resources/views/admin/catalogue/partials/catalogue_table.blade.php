<table class="table table-bordered align-middle" id="catalogueTable">
    <thead>
        <tr class="text-center">
            <th scope="col">SL</th>
            <th scope="col">Part No</th>
            <th scope="col">NSN</th>
            <th scope="col">Nomenclature</th>
            <th scope="col">Cat Location</th>
            <th scope="col">CAGEC</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cat_parts as $item)
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
                <td>
                    <a href="" class="btn btn-sm link-warning" title="Edit Part"><i
                            class="fa-solid fa-pen-to-square fs-5"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
