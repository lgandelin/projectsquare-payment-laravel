<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inscription Projectsquare</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/css/bootstrap-slider.min.css">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.2.0/bootstrap-slider.min.js"></script>
</head>
<body>
    <div class="container signup-template">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ trans('projectsquare-payment::signup.title') }}</h1>
            </div>
        </div>

        <div class="stepwizard" style="margin-bottom: 2rem;">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <span data-tab="1" class="btn btn-primary btn-circle">1</span>
                    <p>{{ trans('projectsquare-payment::signup.step1_title') }}</p>
                </div>
                <div class="stepwizard-step">
                    <span data-tab="2" class="btn btn-default btn-circle" disabled="disabled">2</span>
                    <p>{{ trans('projectsquare-payment::signup.step2_title') }}</p>
                </div>
                <div class="stepwizard-step">
                    <span data-tab="3" class="btn btn-default btn-circle" disabled="disabled">3</span>
                    <p>{{ trans('projectsquare-payment::signup.step3_title') }}</p>
                </div>
            </div>
        </div>

        <form role="form" action="" method="post">
            <div class="row setup-content" id="step-1">
                @include('projectsquare-payment::signup.step1')
            </div>

            <div class="row setup-content" id="step-2">
                @include('projectsquare-payment::signup.step2')
            </div>

            <div class="row setup-content" id="step-3">
                @include('projectsquare-payment::signup.step3')
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {

            //Initialisation du slider
            var slider = $("#slider_users_count").slider({
                tooltip: 'always'
            });

            $("#slider_users_count").on("slide", function(slideEvt) {
                var users_count = slideEvt.value;
                $('input[name="users_count"]').val(users_count);
                var amount = 27 + 17 * users_count;
                $('.total').text(amount.toFixed(2));
            });

            $('#step-2, #step-3').hide();

            //Tab navigation
            $(".stepwizard-step span:not([disabled])").click(function() {
                displayTab($(this).attr('data-tab'));
            });

            $('.valid-step-1').click(function() {
                displayTab(2);
            });

            $('.valid-step-2').click(function() {
                displayTab(3);
            });

            function displayTab(tab) {
                $('.setup-content').hide();
                $('#step-' + tab).show();

                $('.stepwizard-step span').addClass('btn-default').removeClass('btn-primary');
                $('.stepwizard-step span[data-tab="' + tab + '"]').removeAttr('disabled').addClass('btn-primary').removeClass('btn-default');
            }
        });
    </script>

    <style>
        .signup-template h1 {
            margin-bottom: 3rem;
        }

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

        .amount {
            color: #337ab7;
        }
        
        .total {
            font-size: 30px;
        }
    </style>
</body>
</html>