            <div class="content-wrapper">
                <section class="content-header">
                    <h1 class="fontPoppins">
                        <?php echo strtoupper($title); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
                        <?php
                        if ($this->uri->segment(3)) {
                            echo '<li class="active"><a href="' . site_url('admin/' . $this->uri->segment(2)) . '">' . strtoupper($title) . '</a></li>';
                            echo '<li class="active">' . strtoupper($this->uri->segment(3)) . '</li>';
                        } else {
                            echo '<li class="active">' . strtoupper($title) . '</li>';
                        }
                        ?>

                    </ol>
                </section>

                <section class="content">
                    <div class="box">
                        <?php echo form_open_multipart("admin/doa/update") ?>
                        <div class="box-header with-border">

                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/doa') ?>" class="btn btn-warning btn-flat" title="kembali ke halaman sebelumnya">kembali</a>
                                    <button type="submit" class="btn btn-warning btn-flat" title="Update data"> update</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php echo csrf(); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?php if ($doa[0]->doa_sumber == "Al-Qur'an") { ?>
                                            <label for=""><b style="color: black">Sumber <span style="color:red">*</span></b></label><br>
                                            <input type="radio" id="sumber" checked name="doa_sumber" value="Al-Qur'an">
                                            <span for="">&nbsp; Al-Qur'an</span>
                                            <br>
                                            <input type="radio" id="sumber2" name="doa_sumber" value="Hadits">
                                            <span for="">&nbsp; Hadits</span>
                                        <?php }  ?>
                                        <?php if ($doa[0]->doa_sumber == "Hadits") { ?>
                                            <label for=""><b style="color: black">Sumber <span style="color:red">*</span></b></label><br>
                                            <input type="radio" id="sumber" name="doa_sumber" value="Al-Qur'an">
                                            <span for="">&nbsp; Al-Qur'an</span>
                                            <br>
                                            <input type="radio" id="sumber2" checked name="doa_sumber" value="Hadits">
                                            <span for="">&nbsp; Hadits</span>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Kategori <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" id="kategori" name="kategori_id" required style="width:100%">
                                            <option value="">-Pilih Kategori-</option>
                                            <?php
                                            foreach ($kategori as $nw) {
                                                if ($doa[0]->kategori_id == $nw->kategori_id) {
                                                    echo '<option value="' . $nw->kategori_id . '" selected>' . $nw->kategori_name . '</option>';
                                                } else {
                                                    echo '<option value="' . $nw->kategori_id . '">' . $nw->kategori_name . '</option>';
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Riwayat <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" id="riwayat" name="riwayat_id[]" multiple required style="width:100%">
                                            <?php
                                            $rsmex = explode(", ", $doa[0]->riwayat_id);
                                            foreach ($rsmex as $t) {
                                                foreach ($riwayat as $f) {
                                                    if ($t == $f->riwayat_id) {
                                                        echo '<option value="' . $f->riwayat_id . '" selected>' . $f->riwayat_name . '</option>';
                                                    } else {
                                                        echo '<option value="' . $f->riwayat_id . '">' . $f->riwayat_name . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Tingkat Hadits <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" id="tingkat" name="tingkat_hadits" required style="width:100%">
                                            <option value="">-Pilih Tingkat Hadits-</option>
                                            <?php
                                            $hadits = array('Hadits Shahih', 'Hadits Hasan', 'Hadits Dho’if', 'Hadits Maudhu');
                                            for ($c = 0; $c < count($hadits); $c++) {
                                                if ($hadits[$c] == $doa[0]->tingkat_hadits) {
                                                    echo '<option value="' . $hadits[$c] . '" selected>' . $hadits[$c] . '</option>';
                                                } else {
                                                    echo '<option value="' . $hadits[$c] . '">' . $hadits[$c] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Judul Doa <span style="color:red">*</span></b></label>
                                        <input type="text" class="form-control" placeholder="Judul Doa" name="doa_title" required="required" value="<?php echo $doa[0]->doa_title; ?>">
                                        <input type="hidden" class="form-control" name="doa_id" required="required" value="<?php echo $doa[0]->doa_id; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Isi Doa <span style="color:red">*</span></b></label>
                                        <textarea cols="80" id="editor" name="doa_text" rows="10" style="resize:none;max-width:700px;"><?php echo $doa[0]->doa_text; ?></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <small>Page rendered in <strong>{elapsed_time}</strong> seconds.</small>
                        </div>
                        <?php echo form_close(); ?>

                    </div>
                </section>
            </div>
            <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
            <script>
                var update_sumber = function() {
                    if ($("#sumber").is(":checked")) {
                        $('#riwayat').prop('disabled', 'disabled');
                        $('#tingkat').prop('disabled', 'disabled');
                        $('#tingkat').removeAttr('required', false);
                        $('#riwayat').removeAttr('required', false);
                    }
                    if ($("#sumber2").is(":checked")) {
                        $('#riwayat').removeAttr('disabled', false);
                        $('#tingkat').removeAttr('disabled', false);
                        $('#riwayat').prop('required', 'required');
                        $('#tingkat').prop('required', 'required');
                    }
                };
                $(update_sumber);
                $("#sumber").change(update_sumber);
                $("#sumber2").change(update_sumber);
            </script>