<table>
    <tr>
        <td><b>Report Goods</b></td>
    </tr>
    <tr>
        <td>Date : {{ date('d m Y', strtotime($date_start)) }} / {{ date('d m Y', strtotime($date_end)) }}</td>
    </tr>
    <tr>
        <td>User : {{ Auth::user()->name }}</td>
    </tr>
</table>
<br>
<table border="1">
    <thead>
        <tr>
            <th style="text-align: center; background-color: #40c668;"><b>No</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Category</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Units</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Supplier</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Goods Name</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Brand</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Stock</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Description</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Created By</b></th>
            <th style="text-align: center; background-color: #40c668;"><b>Updated By</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->categories_name }}</td>
                <td>{{ $item->units_name }}</td>
                <td>{{ $item->suppliers_name }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->brand }}</td>
                <td style="color: {{ $item->stock <= 0 ? 'red' : 'black' }}">
                    {{ $item->stock <= 0 ? 'Stock is empty' : $item->stock }}
                </td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->created_by_name }}</td>
                <td>{{ $item->updated_by_name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
