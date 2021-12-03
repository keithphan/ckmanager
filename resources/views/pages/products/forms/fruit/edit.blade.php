<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        {{ __('Nutrition Information') }}
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="mb-3">
                    <table id="nutritionTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Quantity Per Serving</th>
                                <th>Quantity Per 100g / 100mL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nutrition = json_decode($product->details);
                            @endphp
                            @foreach ($nutrition as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->display_name }}</td>
                                    @foreach ($item->data as $data)
                                        <td>
                                            <input class="form-control" type="text" name="{{ $item->name }}[]" placeholder="100kJ" value="{{ $data }}">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </div>
</div>
