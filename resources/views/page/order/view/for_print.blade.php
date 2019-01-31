<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <title>@yield('title') | ERP optiks</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header card-no-border">


    <div id="main-wrapper">

        
        <div class="page-wrapper" style="margin-left: 0">
            <div class="container-fluid" style="padding-top: 15px;">

                <div class="row">
                    <div class="col-sm-8">
                        @include('page.order.view.__include.view_service_block')

                        @include('page.order.view.__include.view_product_block')
                    </div>
                    <div class="col-sm-4">
                        <a href="?for_print=0" class="btn btn-block btn-outline-secondary" style="margin-bottom: 10px;">
                            Назад
                        </a>
                        @include('page.order.view.__include.view_main')
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="/js/jquery.slimscroll.js"></script>
    <script src="/js/waves.js"></script>
    <script src="/js/sidebarmenu.js"></script>
    <script src="/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="/js/custom.min.js"></script>
    <script src="/js/jasny-bootstrap.js"></script>
    <script src="/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>

    @section('js_block')
    @show
</body>

</html>