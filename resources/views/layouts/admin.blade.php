<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('admin/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('admin/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('ckeditor5/ckeditor5.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-define.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        @include('inc_admin.sidebar')
        <div id="page-wrapper" class="gray-bg">
            @include('inc_admin.header')
            @yield('content')
            @include('inc_admin.footer')
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('admin/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('admin/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/flot/jquery.flot.pie.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('admin/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('admin/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('admin/js/inspinia.js') }}"></script>
    <script src="{{ asset('admin/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('admin/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- GITTER -->
    <script src="{{ asset('admin/js/plugins/gritter/jquery.gritter.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('admin/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('admin/js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('admin/js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('admin/js/plugins/toastr/toastr.min.js') }}"></script>

    <!-- Jasny -->
    <script src="{{ asset('admin/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "/ckeditor5/ckeditor5.js",
                "ckeditor5/": "/ckeditor5/"
            }
        }
    </script>
    
    <!-- Custome Js -->
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    @yield('custom-js')

    <script type="module">
        import {
            ClassicEditor, Heading, Highlight, HorizontalLine, Font, Emoji, Mention, Bold, Code, Italic, Strikethrough, Subscript, Superscript, Underline,
            Indent, IndentBlock, CodeBlock, FindAndReplace, AutoLink, Link,
            Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage, ImageInsert,
            Undo , Alignment, Table, TableToolbar, List,
            SimpleUploadAdapter
        } from 'ckeditor5';

        const editorElement = document.querySelector('#editor');
        
        if(editorElement) {
        ClassicEditor
            .create(document.querySelector('#editor'), {
                licenseKey: 'GPL',
                plugins: [
                    Heading, Highlight, HorizontalLine, Font, Emoji, Mention,
                    Bold, Code, Italic, Strikethrough, Subscript, Superscript, Underline, Indent, IndentBlock,
                    CodeBlock, FindAndReplace,
                    Image, ImageToolbar, ImageCaption, ImageStyle, ImageResize, LinkImage, ImageInsert,
                    AutoLink, Link,
                    Undo, Alignment, Table, TableToolbar, List,
                    SimpleUploadAdapter
                ],
                toolbar: 
                {
                    items: [
                        'undo', 'redo', '|', 'heading', '|',
                        'bold', 'italic', 'underline','strikethrough', 'subscript', 'superscript', '|', 
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                        'highlight', 'alignment', 'emoji', '|',
                        'link', 'insertImage', 'insertTable', '|',
                        'bulletedList', 'numberedList', '|',
                        'horizontalLine', 
                        'code', '|', 
                        'outdent', 'indent', '|',
                        'codeBlock', 'findAndReplace',
                        
                    ],
                    shouldNotGroupWhenFull: true
                },
                image: {
                    toolbar: [ 'toggleImageCaption', 'imageTextAlternative', 'insertImageViaUrl' ],
                },
                link: {
                    toolbar: [ 'linkPreview', '|', 'editLink', 'linkProperties', 'unlink' ]
                },
                simpleUpload: {
                    uploadUrl: '/upload-image',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            // setTimeout(function () {
            //     toastr.options = {
            //         closeButton: true,
            //         progressBar: true,
            //         showMethod: 'slideDown',
            //         timeOut: 4000
            //     };
            //     toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

            // }, 1300);


            var data1 = [
                [0, 4], [1, 8], [2, 5], [3, 10], [4, 4], [5, 16], [6, 5], [7, 11], [8, 6], [9, 11], [10, 30], [11, 10], [12, 13], [13, 4], [14, 3], [15, 3], [16, 6]
            ];
            var data2 = [
                [0, 1], [1, 0], [2, 2], [3, 0], [4, 1], [5, 3], [6, 1], [7, 5], [8, 2], [9, 3], [10, 2], [11, 1], [12, 0], [13, 2], [14, 8], [15, 0], [16, 0]
            ];
            $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ],
                {
                    series: {
                        lines: {
                            show: false,
                            fill: true
                        },
                        splines: {
                            show: true,
                            tension: 0.4,
                            lineWidth: 1,
                            fill: 0.4
                        },
                        points: {
                            radius: 0,
                            show: true
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#d5d5d5",
                        borderWidth: 1,
                        color: '#d5d5d5'
                    },
                    colors: ["#1ab394", "#1C84C6"],
                    xaxis: {
                    },
                    yaxis: {
                        ticks: 4
                    },
                    tooltip: false
                }
            );

            var doughnutData = {
                labels: ["App", "Software", "Laptop"],
                datasets: [{
                    data: [300, 50, 100],
                    backgroundColor: ["#a3e1d4", "#dedede", "#9CC3DA"]
                }]
            };


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };


            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, { type: 'doughnut', data: doughnutData, options: doughnutOptions });

            var doughnutData = {
                labels: ["App", "Software", "Laptop"],
                datasets: [{
                    data: [70, 27, 85],
                    backgroundColor: ["#a3e1d4", "#dedede", "#9CC3DA"]
                }]
            };


            var doughnutOptions = {
                responsive: false,
                legend: {
                    display: false
                }
            };


            var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
            new Chart(ctx4, { type: 'doughnut', data: doughnutData, options: doughnutOptions });

        });
    </script>
</body>

</html>