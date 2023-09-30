<!-- MODAL ADD -->
<div class="wrap_modal" id="modal_content" onclick="closeModal();">
    <div class="modal-content" onclick="event.stopPropagation();">
        <div class="head_modal">
            <h3 class="add_title" id="modalTitle">Add university</h3>
            <button class="option_close" onclick="closeModal();"><span class="icon-x"></span></button>
        </div>
        <form class="form_uni">
            <input id="university_id" value="" hidden>
            <div class="cont_message">
                <p id="response_value" style="text-align: center; display: flex !important; justify-content: center;" class="text_response"></p>
            </div>
            <div class="input_section">
                <label for="">
                    <small>University name*</small>
                </label>
                <input type="text" id="name_uni" placeholder="University name..." class="input_modal" value="">
            </div>
            <div class="input_section" id="photo_uni">
                <label for="">
                    <small>University photo*</small>
                </label>
 
                
                    <span id="photo_filename">
                        Do you want to update the photo?
                    </span>

                    <input type="file" id="file_uni" placeholder="Nombre de la universidad" class="" value="">
         
            </div>
            <div class="input_section">
                <label for="">
                    <small> Where is it located?*</small>
                </label>
                <input type="text" id="location_uni" placeholder="Where is it located?" class="input_modal" value="">
            </div>
            <div class="input_section">
                <label for="">
                    <small>Link to your website*</small>
                </label>
                <input type="text" id="link_uni" placeholder="Link to your website" class="input_modal" value="">
            </div>
            <div class="modal_options">
                <button type="button" class="btn_cancel" onclick="closeModal();">
                    Cancel
                </button>
                <button type="button" class="btn_save" id="saveButton">
                    Save
                </button>
            </div>

            </>
    </div>
</div>