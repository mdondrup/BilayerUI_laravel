<!doctype html>
<html class="welcome" lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 


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
                    <h3 class="text-white text-center mt-0">{{ $entity['type'] }} Experiment</h3>
                    <?php 
                        $entity = $entity ?? [];
                        $properties = $properties ?? []; 
                    ?>
                    <!-- Bootstrap Tabs -->
                    <ul class="nav nav-pills justify-content-start" id="experimentTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="properties-tab" data-bs-toggle="tab"     data-bs-target="#properties" type="button" role="tab">Properties</button>
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
                                            <th scope="row">Type</th>
                                            <td>{{ $entity['type'] }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Path</th>
                                            <td>{{ $entity['path'] }}</td>
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
                                        <th scope="col">Description</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($properties as $prop)
                                    <tr>
                                        <td>{{ $prop->name }}</td>
                                        <td>{{ $prop->description }}</td>
                                        <td>{{ $prop->value }}</td>
                                        <td>{{ $prop->unit }}</td>
                                        <td>{{ $prop->type }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    </main>
    @include('layouts.foot')
   
</body>