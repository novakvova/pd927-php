<!-- Modal -->
<div class="modal" data-backdrop="static" id="cropperModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-8">
                            <img src="/img/noimage.jpg" id="img_cropped" width="100%">
                        </div>
                        <div class="col-md-4">
                            <div class="preview ml-4"></div>
                            <button  type="button" class="btn btn-info ml-5 mt-3" id="rotate">Rotate</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnCroppeImage" class="btn btn-primary">Обрати фото</button>
            </div>
        </div>
    </div>
</div>
