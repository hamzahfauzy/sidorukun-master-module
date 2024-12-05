<?php get_header() ?>
<style>
table td img {
    max-width:150px;
}
table.table td, table.table th {
    white-space:nowrap;
}
</style>
<div class="card mb-3">
    <div class="card-header d-flex flex-grow-1 align-items-center">
        <p class="h4 m-0">Laporan Pengeluaran Barang</p>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <form action="" onsubmit="window.reportOutgoings.draw(); return false" class="d-flex flex-wrap" style="gap:10px;">
            <div class="form-group mb-1">
                <label for="">Dari Tgl</label>
                <input type="date" name="start_date" id="" class="form-control w-100" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group mb-1">
                <label for="">Sampai Tgl</label>
                <input type="date" name="end_date" id="" class="form-control w-100" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group mb-1">
                <label for="">Customer</label><br>
                <?= \Core\Form::input('options-obj:mst_customers,name,name|status,ACTIVE', 'customers', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Channel</label><br>
                <?= \Core\Form::input('options-obj:mst_channels,name,name', 'channels', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Jenis</label><br>
                <?= \Core\Form::input('options:{"- Pilih -":"","CARGO":"CARGO","HEMAT":"HEMAT","INSTANT":"INSTANT","REG":"REG"}', 'outgoing_type', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Tipe</label><br>
                <?= \Core\Form::input('options-obj:mst_types,name,name', 'types', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Ukuran</label><br>
                <?= \Core\Form::input('options-obj:mst_sizes,name,name', 'sizes', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Merk</label><br>
                <?= \Core\Form::input('options-obj:mst_brands,name,name', 'brands', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Motif</label><br>
                <?= \Core\Form::input('options-obj:mst_motifs,name,name', 'motifs', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">Warna</label><br>
                <?= \Core\Form::input('options-obj:mst_colors,name,name', 'colors', ['class' => 'form-control w-100']) ?>
            </div>
            <div class="form-group mb-1">
                <label for="">&nbsp;</label>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-primary w-100">Submit</button>
                    &nbsp;
                    <button type="button" class="btn btn-secondary w-100" onclick="downloadReportOutgoings()">Download</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped datatable-report-outgoings" style="width:100%">
                <thead>
                    <tr>
                        <th width="20px">#</th>
                        <?php 
                        foreach($fields as $field): 
                            $label = $field;
                            if(is_array($field))
                            {
                                $label = $field['label'];
                            }
                            $label = _ucwords($label);
                        ?>
                        <th><?=$label?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php get_footer() ?>
