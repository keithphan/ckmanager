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
                            <tr>
                                <td class="align-middle">Energy</td>
                                <td>
                                    <input class="form-control" type="text" name="energy[]" placeholder="100kJ" value="{{ old('energy.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="energy[]" placeholder="100kJ" value="{{ old('energy.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">Protein</td>
                                <td>
                                    <input class="form-control" type="text" name="protein[]" placeholder="10g" value="{{ old('protein.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="protein[]" placeholder="10g" value="{{ old('protein.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">Fat, Total</td>
                                <td>
                                    <input class="form-control" type="text" name="fat[]" placeholder="10g" value="{{ old('fat.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="fat[]" placeholder="10g" value="{{ old('fat.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">– Saturated</td>
                                <td>
                                    <input class="form-control" type="text" name="saturated[]" placeholder="10g" value="{{ old('saturated.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="saturated[]" placeholder="10g" value="{{ old('saturated.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">Carbohydrate</td>
                                <td>
                                    <input class="form-control" type="text" name="carbohydrate[]" placeholder="10g" value="{{ old('carbohydrate.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="carbohydrate[]" placeholder="10g" value="{{ old('carbohydrate.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">– Sugars</td>
                                <td>
                                    <input class="form-control" type="text" name="sugars[]" placeholder="10g" value="{{ old('sugars.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="sugars[]" placeholder="10g" value="{{ old('sugars.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">Dietary Fibre</td>
                                <td>
                                    <input class="form-control" type="text" name="dietary_fibre[]" placeholder="10g" value="{{ old('dietary_fibre.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="dietary_fibre[]" placeholder="10g" value="{{ old('dietary_fibre.1') }}">
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle">Sodium</td>
                                <td>
                                    <input class="form-control" type="text" name="sodium[]" placeholder="10mg" value="{{ old('sodium.0') }}">
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="sodium[]" placeholder="10mg" value="{{ old('sodium.1') }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

    </div>
</div>
