

$(function() {

    const cropper = new Cropper(document.getElementById("img_cropped"), {
        aspectRatio: 1 / 1,
        preview: ".preview",
        crop(event) {
            console.log(event.detail.x);
            console.log(event.detail.y);
            console.log(event.detail.width);
            console.log(event.detail.height);
            console.log(event.detail.rotate);
            console.log(event.detail.scaleX);
            console.log(event.detail.scaleY);
        },
    });
    var fileToUpload = document.getElementsByName("fileToUpload")[0]
    var $blah = $("#blah");
    var $btnCroppeImage = $("#btnCroppeImage");
    var $cropperModal=$("#cropperModal");
    var $rotate=$("#rotate");

    var uploader;

    $rotate.on("click", function() {
       cropper.rotate(90);
    });
    $blah.on("click", function openFileOption()
    {
        if (uploader) {
            uploader.remove();
        }
        uploader = $('<input type="file" name="workImage" accept="image/* style="display:none"/>');
        uploader.click();

        uploader.on('change', function () {
            const [file] = uploader[0].files

            if (file) {
                var reader  = new FileReader();
                reader.onload = function(event)
                {
                    var data = event.target.result;

                    $cropperModal.modal("show");
                    cropper.replace(data);
                    setTimeout(function(){

                    },200);


                }
                //

                reader.readAsDataURL(uploader[0].files[0]);
                //cropper.replace();//cropper('destroy').cropper('replace', blah);
            }
        });
    });

    $btnCroppeImage.on("click", function(){
        var imgData = cropper.getCroppedCanvas().toDataURL()
        $blah.attr("src", imgData);

        $("#imageUpload").val(imgData);

        $cropperModal.modal("hide");
    });
});