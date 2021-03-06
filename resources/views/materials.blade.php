@extends('layouts.app')

@section('title', 'Materials')

@section('content')

<!-- Button trigger modal -->
<div class=" p-3 mb-5 bg-white rounded border">
    <div>
        @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
    </div>

    <button type="button" class="btn btn-primary float-right ml-2" data-toggle="modal" data-target="#materialModal">
        Add Material
    </button>

    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
        <label class="btn btn-secondary active">
            <input type="radio" name="options" id="active" autocomplete="off" checked> Active
        </label>
        <label class="btn btn-secondary">
            <input type="radio" name="options" id="archived" autocomplete="off"> Archived
        </label>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="materialModal" tabindex="-1" role="dialog" aria-labelledby="materialModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="materialModalLabel">Enter material details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ url('materials') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="material_archived" value="0">
                        <div class="form-row">
                            <div class="form-group col-sm">
                                <label for="input">Supplier item code</label>
                                <input type="text" class="form-control" id="itemCode" name="material_itemcode"
                                    placeholder="ELI-001">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm">
                                <label for="input">Material description</label>
                                <input type="text" class="form-control" id="materialDescription"
                                    name="material_description" placeholder="LED EMERGENCY oyster light">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm">
                                <label for="input">Material Cost</label>
                                <label class="sr-only" for="inlineFormInputGroup">Material cost</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                    </div>
                                    <input type="text" class="form-control" id="materialCost" name="material_cost"
                                        placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-sm">
                                <label for="input">Select supplier</label>
                                <select class="form-control" id="exampleFormControlSelect1" name="fk_supplier_id">
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier -> pk_supplier_id }}">
                                        {{ $supplier -> supplier_companyname }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Material</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="active_div">
        <div class="container float-left mb-3">
            <div class="row">
                <div class="col-4">
                    <input type="text" class="form-control float-left" id="active_input" onkeyup="activeFunction()"
                        placeholder="Search materials names">
                </div>
            </div>
        </div>
        <div class='table-responsive'>
    <h3>Materials</h3>
    <table id="active_table" class="display table table-hover table-sm mt-1">
            <thead>
                <tr>
                    <th scope="col" onclick="sortActive(0)">Item Code</th>
                    <th scope="col" onclick="sortActive(1)">Description</th>
                    <th scope="col" onclick="sortActive(2)">Material Cost</th>
                    <th scope="col" onclick="sortActive(3)">Supplier</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                @if($material->material_archived == '0')
                <tr>
                    <td>{{ $material->material_itemcode }}</td>
                    <td>{{ $material->material_description }}</td>
                    <td>{{ $material->material_cost }}</td>
                    <td>{{ $material->suppliers->supplier_companyname }}</td>
                    <td><a href="{{action('MaterialController@edit', $material['pk_material_id'])}}">Edit</a></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <div id="archived_div" style="display: none">
        <div class="container float-left mb-3">
            <div class="row">
                <div class="col-4">
                    <input type="text" class="form-control float-left" id="archived_input" onkeyup="archivedFunction()"
                        placeholder="Search materials names">
                </div>
            </div>
        </div>
        <div class='table-responsive'>
    <h3>Archived Materials</h3>
    <table id="archived_table" class="display table table-hover table-sm mt-1">
            <thead>
                <tr>
                    <th scope="col" onclick="sortArchived(0)">Item Code</th>
                    <th scope="col" onclick="sortArchived(1)">Description</th>
                    <th scope="col" onclick="sortArchived(2)">Material Cost</th>
                    <th scope="col" onclick="sortArchived(3)">Supplier</th>
                    <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                @if($material->material_archived == '1')
                <tr>
                    <td>{{ $material->material_itemcode }}</td>
                    <td>{{ $material->material_description }}</td>
                    <td>{{ $material->material_cost }}</td>
                    <td>{{ $material->suppliers->supplier_companyname }}</td>
                    <td><a href="{{action('MaterialController@edit', $material['pk_material_id'])}}">Edit</a></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>

@stop
