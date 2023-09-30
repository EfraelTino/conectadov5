<!-- MODAL ADD -->
<div class="wrap_modal" id="modal_content" onclick="closeModalId();">
    <div class="modal-content" onclick="event.stopPropagation();">
        <div class="head_modal">
            <h3 class="add_title" id="modalTitle">Add university</h3>
            <button class="option_close" onclick="closeModalId();"><span class="icon-x"></span></button>
        </div>
        <form class="form_uni" id=form_options>
            
            <div class="cont_message">
                <p id="response_value" class="text_response"></p>
            </div>
            <div id="append_items">
                
            </div>
            <div class="modal_options">
                <button type="button" class="btn_cancel" onclick="closeModalId();">
                    Cancel
                </button>
                <button type="button" class="btn_save" id="saveButton">
                    Save
                </button>
            </div>
    </div>
</div>