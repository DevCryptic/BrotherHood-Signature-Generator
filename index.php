<!DOCTYPE html>
<html>
    <head>
        <title>Brotherhood Sig Generator</title>
        <style>

        html,body {
            padding: 0;
            margin: 0;
            width: 100%;
            height: 100%;
            font-family: sans-serif;
            background-color: #333;
            color: #ccc;
        }

        body, input {
            font-size: 18pt;
        }

        input {
            color: #000;
            background-color: #ccc;
            text-align: center;
        }

        #container {
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            -webkit-transform: translateY(-50%);
            -moz-transform: translateY(-50%);
            width: 600px;
            margin: 0 auto;
        }

        div.row {
            padding: 10px 0px 10px 0px;
            text-align: center;
            display: block;
        }

        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>

        $(document).ready(function () {
            $('#name').keyup(function () {
                if ($(this).val().length <= 0) {
                    $('#sig_img').hide();
                } else {
                    $('#sig_img').show();
                    $('#sig_img').attr('src', 'sig_generator.php?name=' + $(this).val());
                }
            });
        });

        </script>
    </head>

    <body>
        <div id="container">
            <div class="row">
                Type your name and save the image that appears.
            </div>
            <div class="row">
                <input type="text" id="name" style="width: 576px; padding: 10px;" autocomplete="off">
            </div>
            <div class="row" style="height: 175px">
                <img src="sig_generator.php?name=Your Name Here" id="sig_img" style="display: none">
            </div>
        </div>
    </body>
</html>