
@extends('layout')

@section('title', 'Пример')

@section('content')
<!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Default Basic Forms</h4>
                <h6 class="card-subtitle"> All bootstrap element classies </h6>
                
                <form class="form">
                    <div class="form-group m-t-40 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">Text</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="Artisanal kale" id="example-text-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-search-input" class="col-md-2 col-form-label">Search</label>
                        <div class="col-md-10">
                            <input class="form-control" type="search" value="How do I shoot web" id="example-search-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-email-input" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" value="bootstrap@example.com" id="example-email-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-url-input" class="col-md-2 col-form-label">URL</label>
                        <div class="col-md-10">
                            <input class="form-control" type="url" value="https://getbootstrap.com" id="example-url-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-tel-input" class="col-md-2 col-form-label">Telephone</label>
                        <div class="col-md-10">
                            <input class="form-control" type="tel" value="1-(555)-555-5555" id="example-tel-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-password-input" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" value="hunter2" id="example-password-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-number-input" class="col-md-2 col-form-label">Number</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" value="42" id="example-number-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-datetime-local-input" class="col-md-2 col-form-label">Date and time</label>
                        <div class="col-md-10">
                            <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-date-input" class="col-md-2 col-form-label">Date</label>
                        <div class="col-md-10">
                            <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-month-input" class="col-md-2 col-form-label">Month</label>
                        <div class="col-md-10">
                            <input class="form-control" type="month" value="2011-08" id="example-month-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-week-input" class="col-md-2 col-form-label">Week</label>
                        <div class="col-md-10">
                            <input class="form-control" type="week" value="2011-W33" id="example-week-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-time-input" class="col-md-2 col-form-label">Time</label>
                        <div class="col-md-10">
                            <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-month-input" class="col-md-2 col-form-label">Select</label>
                        <div class="col-md-10">
                            <select class="custom-select col-12" id="inlineFormCustomSelect">
                                <option selected="">Choose...</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-color-input" class="col-md-2 col-form-label">Color</label>
                        <div class="col-md-10">
                            <input class="form-control" type="color" value="#563d7c" id="example-color-input">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-color-input" class="col-md-2 col-form-label">Input Range</label>
                        <div class="col-md-10">
                            <input type="range" class="form-control" id="range" value="50">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Default Horizontal Forms</h4>
            <h6 class="card-subtitle"> All bootstrap element classies </h6>
            <form class="form-horizontal m-t-40">
                <div class="form-group">
                    <label>Default Text <span class="help"> e.g. "George deo"</span></label>
                    <input type="text" class="form-control" value="George deo...">
                </div>
                <div class="form-group">
                    <label for="example-email">Email <span class="help"> e.g. "example@gmail.com"</span></label>
                    <input type="email" id="example-email" name="example-email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" value="password">
                </div>
                <div class="form-group">
                    <label>Placeholder</label>
                    <input type="text" class="form-control" placeholder="placeholder">
                </div>
                <div class="form-group">
                    <label>Text area</label>
                    <textarea class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Read only input</label>
                    <input class="form-control" type="text" placeholder="Readonly input here…" readonly>
                </div>
                <div class="form-group">
                    <fieldset disabled>
                        <label for="disabledTextInput">Disabled input</label>
                        <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input">
                    </fieldset>
                </div>
                <div class="form-group row p-t-20">
                    <div class="col-sm-4">
                        <div class="m-b-10">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Check this custom checkbox</span>
                            </label>
                        </div>
                        <div class="m-b-10 bd-example-indeterminate">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Check this custom checkbox</span>
                            </label>
                        </div>
                        <div class="m-b-10">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Check this custom checkbox</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="m-b-10">
                            <label class="custom-control custom-radio">
                                <input id="radio1" name="radio" type="radio" class="custom-control-input">
                                <span class="custom-control-label">Toggle this custom radio</span>
                            </label>
                        </div>
                        <div class="m-b-10">
                            <label class="custom-control custom-radio">
                                <input id="radio2" name="radio" type="radio" class="custom-control-input">
                                <span class="custom-control-label">Or toggle this other custom radio</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Input Select</label>
                    <select class="custom-select col-12" id="inlineFormCustomSelect">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Default file upload</label>
                    <input type="file" class="form-control" id="exampleInputFile" aria-describedby="fileHelp">
                </div>
                <div class="form-group">
                    <label>Custom File upload</label>
                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                        <div class="form-control" data-trigger="fileinput">
                            <i class="fa fa-file fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                        </div>
                        <span class="input-group-addon btn btn-secondary btn-file"> 
                            <span class="fileinput-new">Select file</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="...">
                        </span>
                        <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
                </div>
                <div class="form-group">
                    <label>Helping text</label>
                    <input type="text" class="form-control" placeholder="Helping text">
                    <span class="help-block"><small>A block of help text that breaks onto a new line and may extend beyond one line.</small></span> </div>
            </form>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- .row -->
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Input groups</h4>
            <h6 class="card-subtitle"> All bootstrap element classies </h6>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">@</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <br>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon1">@example.com</span>
                            </div>
                        </div>
                        <br>
                        <label for="basic-url">Your vanity URL</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">https://example.com/users/</span>
                            </div>
                            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                        </div>
                        <br>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <br>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <div class="input-group-prepend">
                                <span class="input-group-text">0.00</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                        </div>
                        <!-- form-group -->
                    </form>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <form>
                        <label class="control-label m-t-20" for="example-input1-group2">Checkboxes and radio addons</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with checkbox">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" aria-label="Radio button for following text input">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with radio button">
                                </div>
                            </div>
                        </div>
                        <label class="control-label m-t-20" for="example-input1-group2">Multiple addons</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">0.00</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with checkbox">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">0.00</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with radio button">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <form class="input-form">
                        <label class="control-label m-t-20" for="example-input1-group2">Button addons</label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-info" type="button">Go!</button>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search for...">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <div class="input-group-append">
                                        <button class="btn btn-info" type="button">Go!</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-danger" type="button">Hate It</button>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Product name">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button">Love It</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- form-group -->
                    </form>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <label class="control-label m-t-20" for="example-input1-group2">Multiple addons</label>
                    <form class="input-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                            <div role="separator" class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="javascript:void(0)">Separated link</a>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with dropdown button">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="Text input with dropdown button">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0)">Action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Another action</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Something else here</a>
                                            <div role="separator" class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="javascript:void(0)">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection

@section('css_block')
    <style>
    </style>
@endsection


@section('js_block')
    <script type="text/javascript">
	</script>
@endsection
