
function init(){
   
    $("#socio_form").on("submit",function(e){
        guardaryeditar(e);	
    });
    
}

$(document).ready(function() {
    $('#descripcionSocio').summernote({
        height: 150,
        lang: "es-ES",
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $.post("../../controller/deporte.php?op=combo",function(data, status){
        $('#idDeporte').html(data);
    });

});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#socio_form")[0]);
    if ($('#descripcionSocio').summernote('isEmpty') || $('#nombreSocio').val()==''){
        swal("Advertencia!", "Campos Vacios", "warning");
    }else{
        var totalfiles = $('#fileElem').val().length;
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }

        $.ajax({
            url: "../../controller/socio.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos){
                console.log(datos);
                $('#nombreSocio').val('');
                $('#descripcionSocio').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }
        });
    }
}

init();