<!DOCTYPE html>
<html>
    <head>
        <title>Laravel Autocomplete</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    </head>
    <body>
        <h2>Laravel Autocomplete</h2>
        <form>
            <label for="auto">Find a color:</label>
            <input type="text" id="auto" name="auto" />
            <br>
            <label for="response">Our color key:</label>
            <input type="text" id="response" name="response" disabled="disabled" />
        </form>

        <script type="text/javascript">
            $(function() {
                $("#auto").autocomplete({
                    source: "getdata",
                    minLength: 1,
                    select: function (e,ui) {
                        $("#response").val(ui.item.id);
                    }
                });
            });
        </script>
    </body>
</html>