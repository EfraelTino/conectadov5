 <div class="cont-profile">
                    <div class="swpa-profile">
                        <div class="cont-photo">
                            <div class="cont-info">
                                <p class="prev_text prf">Profile</p>
                                <p class="prev_text">I joined 2023</p>
                            </div>
                            <div class="cont_data">
                                <div class="cont_profession">
                                    <div class="pr">
                                        <img src="<?php echo 'userpics/' . $data[0]['img_profile']; ?>" alt="Profile <?php echo ' ' . $data[0]['fname'] ?>" class="img_profile">

                                        <div class="cont_edit">
                                            <p class="text_profesion">
                                                <?php if ($data[0]['profession'] != '' || $data[0]['profession'] != null) {
                                                    echo $data[0]['profession'];
                                                } else {
                                                    echo 'Profession not defined';
                                                } ?>
                                            </p>
                                            <button onclick="openModalP('updateprofile', <?php echo $data[0]['userid'] ?>);" class="text_edit">Edit <span class="icon-edit ic_ed"></span></button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="cont-name">
                            <p class="text_names"><?php echo $data[0]['fname'] . ' ' . $data[0]['lastname']; ?></p>
                            <button onclick="openModalP('updatename', <?php echo $data[0]['userid'] ?>);" class="text_rename">Rename <span class="icon-edit"></span></button>
                        </div>
                    </div>
                </div>