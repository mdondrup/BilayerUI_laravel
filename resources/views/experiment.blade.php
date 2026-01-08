<!doctype html>
<html class="welcome" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 
@include('layouts.head')
<style>
/* Custom pagination styling for dark theme */

.pagination {
    --bs-pagination-color: #fff;
    --bs-pagination-bg: #343a40;
    --bs-pagination-border-color: #495057;
    --bs-pagination-hover-color: #fff;
    --bs-pagination-hover-bg: #495057;
    --bs-pagination-hover-border-color: #6c757d;
    --bs-pagination-focus-color: #fff;
    --bs-pagination-focus-bg: #495057;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #0d6efd;
    --bs-pagination-active-border-color: #0d6efd;
    --bs-pagination-disabled-color: #6c757d;
    --bs-pagination-disabled-bg: #343a40;
    --bs-pagination-disabled-border-color: #495057;
    font-size: 0.875rem;
}
.page-link {
    color: var(--bs-pagination-color);
    background-color: var(--bs-pagination-bg);
    border-color: var(--bs-pagination-border-color);
    padding: 0.375rem 0.75rem;
}
.page-link:hover {
    color: var(--bs-pagination-hover-color);
    background-color: var(--bs-pagination-hover-bg);
    border-color: var(--bs-pagination-hover-border-color);
}
.page-link:focus {
    color: var(--bs-pagination-focus-color);
    background-color: var(--bs-pagination-focus-bg);
    box-shadow: var(--bs-pagination-focus-box-shadow);
}
.page-item.active .page-link {
    color: var(--bs-pagination-active-color);
    background-color: var(--bs-pagination-active-bg);
    border-color: var(--bs-pagination-active-border-color);
}
.page-item.disabled .page-link {
    color: var(--bs-pagination-disabled-color);
    background-color: var(--bs-pagination-disabled-bg);
    border-color: var(--bs-pagination-disabled-border-color);
}
</style>

<body id="page-top">
    <!-- Navigation-->
     <main>
     <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1 class="text-white   font-weight-bold">NMRlipids Databank</h1>
                     <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
                         <div class="container px-4 px-lg-5">
                            <a class="navbar-brand" href="/#page-top">NMRlipids Databank</a>
                            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                               data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                                  aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                             </button>
                                <div class="collapse navbar-collapse" id="navbarResponsive">
                                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                                        <li class="nav-item"><a class="nav-link" href="/#about">About</a></li>
                                    </ul>
                                </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    <!-- Main page -->
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-10">
                    <hr class="divider divider-light" />
                    <h3 class="text-white text-center mt-0">@if (! empty($experiments_list)) Experiments @else {{ $entity['type'] }} Experiment @endif</h3>
                    <?php 
                        $experiments_list = $experiments_list ?? [];
                        $entity = $entity ?? [];
                        $properties = $properties ?? []; 
                    ?>
                    @if (! empty($experiments_list))
                        <div class="text-white text-center mt-0">
                        <table class="table table-bordered table-striped table-sm table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">DOI</th>
                                    <th scope="col">Data DOI</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Number of lipids</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($experiments_list as $experiment)
                                <tr>
                                    <td>{{ $experiment->id }}</td>
                                    <td>{{ $experiment->article_doi }}</td>
                                    <td>{{ $experiment->data_doi }}</td>
                                    <td>{{ $experiment->type }}</td>
                                    
                                    <td>{{ $experiment->section }}</td>
                                    <td>{{ $experiment->lipid_count }}</td>
                                    <td><a href="{{ route('experiments.show', ['type' => $experiment->type, 'doi' => $experiment->article_doi, 'section' => $experiment->section]) }}" class="btn btn-primary btn-sm">View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                        {{ $experiments_list->links() }}
                        </div>
                        </div>
                    @else
                        
                    <!-- Bootstrap Tabs -->
                    <ul class="nav nav-pills justify-content-start" id="experimentTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="properties-tab" data-bs-toggle="tab"     data-bs-target="#properties" type="button" role="tab">Properties</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="analysis-tab" data-bs-toggle="tab" data-bs-target="#analysis" type="button" role="tab">Analysis (coming soon)</button>
                        </li>
                    </ul>
                    <!-- Tab Contents -->
                    <div class="tab-content" id="experimentTabContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <br/>
                                <table class="table table-bordered table-striped table-sm table-dark">
                                    <tbody>
                                        <tr>
                                            <th scope="row">DOI</th>
                                            <td>{{ $entity['doi'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Data DOI</th>
                                            <td>{{ $entity['data_doi'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Type</th>
                                            <td>{{ $entity['type'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Path</th>
                                            <td>{{ $entity['path'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Section</th>
                                            <td>{{ $entity['section'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Membrane composition</th>

                                            <td>
                                            <table class="table table-striped table-sm ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Lipid</th>
                                                        <th scope="col">Molar Fraction</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ( $entity['membrane_composition'] as $component )
                                                    <tr>
                                                        <td><a href="/lipid/{{ $component->id }}"> {{ $component->name }}</a></td>
                                                        <td>{{ $component->mol_fraction }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>  
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Solution composition</th>
                                            <td>
                                            <table class="table table-striped table-sm ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Compound</th>
                                                        <th scope="col">Mass %</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ( $entity['solution_composition'] as $component )
                                                    <tr>
                                                        <td> {{ $component->compound }}</td>
                                                        <td>{{ $component->concentration }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            </table>  
                                            </td>
                                        </tr>    
                                    </tbody>
                                </table>
                        </div>
                        <!-- Properties Tab -->
                        <div class="tab-pane fade" id="properties" role="tabpanel" aria-labelledby="properties-tab">
                            <br/>
                            <table class="table table-bordered table-striped table-sm table-dark">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <!-- th scope="col">Description</th -->
                                        <th scope="col">Value</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($properties as $prop)
                                    <tr>
                                        <td>{{ $prop->name }}</td>
                                        <!--td>{{ $prop->description }}</td-->
                                        <td>
                                         @if( preg_match('/^(array|dict)$/', $prop->type) )
                                          <!-- Format arrays and dictionaries nicely using html in nested tables -->
                                            @php
                                                $decoded_value = $prop->value;
                                            @endphp
                                            @if (is_array($decoded_value))
                                                @if (array_keys($decoded_value) === range(0, count($decoded_value) - 1))
                                                    <!-- It's an array -->
                                                    <table class="table table-striped table-sm table-dark">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Index</th>
                                                                <th scope="col">Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($decoded_value as $index => $item)
                                                            <tr>
                                                                <td>{{ $index }}</td>
                                                                <td>{{ is_array($item) ? json_encode($item) : $item }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <!-- It's a dictionary -->
                                                    <table class="table table-striped table-sm table-dark">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Key</th>
                                                                <th scope="col">Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($decoded_value as $key => $value)
                                                            <tr>
                                                                <td>{{ $key }}</td>
                                                                <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @else
                                                <!-- Not a valid array or dictionary -->
                                                {{ $prop->value }}
                                            @endif
                                            <!-- pre style="white-space: pre-wrap; color: white">{{ print_r($prop->value, true) }}</pre -->
                                            @else
                                            {{ $prop->value }}
                                            @endif
                                        </td>
                                        <td>{{ $prop->unit }}</td>
                                        <td>{{ $prop->type }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Analysis Tab -->
                        <div class="tab-pane fade" id="analysis" role="tabpanel" aria-labelledby="analysis-tab">
                            <br/>
                            <p class="text-white">Analysis features are coming soon. Stay tuned!</p>
                            <h5 class="text-white">Membrane Composition</h5>
                            <table class="table table-bordered table-striped table-sm table-dark">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Lipid</th>
                                                            <th scope="col">PATH</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                             @foreach ( $entity['membrane_composition'] as $component )
                                                    <tr>
                                                        <td><a href="/lipid/{{ $component->id }}"> {{ $component->molecule }}</a></td>
                                                        <td>{{ $entity['path'] }}</td>
                                                    </tr>
                                                @endforeach
                                                    </tbody>
                            </table>

                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </header>
    </main>
    @include('layouts.foot')

    <!-- Bootstrap core JS--><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
   
</body>