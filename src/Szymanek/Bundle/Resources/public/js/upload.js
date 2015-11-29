jQuery(document).ready(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var length = input.files.length;
            for (var i = 0; i < length; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $( "form" ).before( "<img class=\"gelato-image img-thumbnail\" src=\"" + e.target.result + "\">" );
                };
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    $("#multipleImages_files").change(function () {
        $( ".gelato-image" ).remove();
        readURL(this);
    });

    $("#gelato_image_file").change(function () {
        $( ".gelato-image" ).remove();
        readURL(this);
    });

    $("#gelato_list").change(function () {
        $( ".gelato-image" ).remove();
        var i = this.selectedIndex;
        //alert(this[i].text);
        $( "form" ).before( "<img class=\"gelato-image img-thumbnail\" src=\"/bundles/todaysgelato/images/" + this[i].text + "\">" );
    });
});