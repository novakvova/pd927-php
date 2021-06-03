

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


    $rotate.on("click", function() {
       cropper.rotate(90);
    });

    fileToUpload.onchange = function () {
        const [file] = fileToUpload.files

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

            reader.readAsDataURL(file);
            //cropper.replace();//cropper('destroy').cropper('replace', blah);
        }
    }
    $blah.on("click", function openFileOption()
    {
        document.getElementById("fileToUpload").click();
    });

    $btnCroppeImage.on("click", function(){
        $blah.attr("src", cropper.getCroppedCanvas().toDataURL());
        $cropperModal.modal("hide");
    });
});