<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Future Tech App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #667db6, #0082c8, #0082c8, #667db6);
            color: #333;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }
img{
    border: 1px solid #00000014;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 2px;
}
        .btn-primary {

            background-color: #4CAF50;
            border: none;
            color: white;

            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;

            transition-duration: 0.4s;
            cursor: pointer;

            outline: none;
        }

        .btn-primary:hover {
            background-color: #45a049;
            color: white;
        }

        .card {
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
        }


        .overflow-auto {
            overflow-y: auto;
        }

        .modal-dialog {
            max-width: 40%;
        }

        th,td{
            max-width: 120px;
        }
    </style>
</head>
<body>
    @include('inc.header')

        @yield('content')


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function() {

            jQuery('.editDataBtn').click(function() {
                var id = jQuery(this).data('id');
                var name = jQuery(this).data('name');
                var image = jQuery(this).data('image');
                var address = jQuery(this).data('address');
                var gender = jQuery(this).data('gender');

                jQuery('#editId').val(id);
                jQuery('#editName').val(name);
                jQuery('#editImage').attr('src', '/storage/'+image);
                jQuery('#editAddress').val(address);
                jQuery('#editGender').val(gender);
                jQuery('#editForm').attr('action', '/' + id);
                jQuery('#editDataForm').attr('action', '/data/' + id);
                jQuery('#editDataModal').modal('show');
            });
            jQuery('.viewDataBtn').click(function() {

                var id = jQuery(this).data('id');
                var name = jQuery(this).data('name');
                var image = jQuery(this).data('image');
                var address = jQuery(this).data('address');
                var gender = jQuery(this).data('gender');
                jQuery('#viewId').val(id);
                jQuery('#viewName').text(name);
                jQuery('#viewImage').attr('src', '/storage/'+image);
                jQuery('#viewAddress').text(address);
                jQuery('#viewGender').text(gender);

                jQuery('#viewDataModal').modal('show');
            });


        });
    </script>


</body>
</html>
