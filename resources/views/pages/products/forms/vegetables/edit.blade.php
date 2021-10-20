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
                            <tr>
                                <td class="align-middle">Energy</td>
                                @foreach (explode(' | ', $nutrition->energy) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="energy[]" placeholder="100kJ" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">Protein</td>
                                @foreach (explode(' | ', $nutrition->protein) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="protein[]" placeholder="10g" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">Fat, Total</td>
                                @foreach (explode(' | ', $nutrition->fat) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="fat[]" placeholder="10g" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">– Saturated</td>
                                @foreach (explode(' | ', $nutrition->saturated) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="saturated[]" placeholder="10g" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">Carbohydrate</td>
                                @foreach (explode(' | ', $nutrition->carbohydrate) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="carbohydrate[]" placeholder="10g" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">– Sugars</td>
                                @foreach (explode(' | ', $nutrition->sugars) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="sugars[]" placeholder="10g" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">Dietary Fibre</td>
                                @foreach (explode(' | ', $nutrition->dietary_fibre) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="dietary_fibre[]" placeholder="10g" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="align-middle">Sodium</td>
                                @foreach (explode(' | ', $nutrition->sodium) as $item)
                                    <td>
                                        <input class="form-control" type="text" name="sodium[]" placeholder="10mg" value="{{ $item }}">
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </div>
</div>
