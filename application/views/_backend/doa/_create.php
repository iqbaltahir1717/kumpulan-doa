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
                        <?php echo form_open_multipart("admin/doa/create") ?>
                        <div class="box-header with-border">

                            <div class="box-tools pull-right">
                                <div style="padding-top:10px">
                                    <a href="<?php echo site_url('admin/doa') ?>" class="btn btn-warning btn-flat" title="kembali ke halaman sebelumnya">kembali</a>
                                    <button type="submit" class="btn btn-primary btn-flat" title="Tambah data"> tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php echo csrf(); ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Kategori <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" name="kategori_id" required style="width:100%">
                                            <option value="">-Pilih Kategori-</option>
                                            <?php
                                            foreach ($kategori as $nw) {
                                                echo '<option value="' . $nw->kategori_id . '">' . $nw->kategori_name . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Tingkat Hadits <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" name="tingkat_hadits" required style="width:100%">
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
                                        <label for=""><b style="color: black">Riwayat <span style="color:red">*</span></b></label>
                                        <select class="form-control select2" name="riwayat_id" required style="width:100%">
                                            <option value="">-Pilih Riwayat-</option>
                                            <?php
                                            foreach ($riwayat as $f) {
                                                echo '<option value="' . $f->riwayat_id . '">' . $f->riwayat_name . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b style="color: black">Judul Doa <span style="color:red">*</span></b></label>
                                        <input type="text" class="form-control" placeholder="Judul Doa" name="doa_title" required="required">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Cover/Thumbnail Doa</b></label>
                                        <input type="file" class="form-control" placeholder="Cover/Thumbnail Informasi" name="doa_cover" accept=".png, .jpeg, .jpg">
                                    </div>

                                    <div class="form-group">
                                        <label for=""><b style="color: black">Isi Doa <span style="color:red">*</span></b></label>
                                        <textarea cols="80" id="editor" name="doa_text" rows="10" style="resize:none;max-width:700px;"></textarea>
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