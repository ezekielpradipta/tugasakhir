<!--MODAL Tambah Kategori -->
<div class="modal hide fade" id="modalTambahKategoriTak">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="formKategoriTAK" name="formKategoriTAK" enctype="multipart/form-data">
                @csrf
                <div class="alert alert-danger" style="display:none"></div>
                <input type="hidden" name="kategoritak_id" id="kategoritak_id">
                <div class="form-group">
                    <div class="form-group">
                        <label for="inputNamaProdi">Nama Kategori</label>
                        <input type="text" name="namakategoritak" class="form-control" id="namakategoritak" placeholder="Nama Kategori">
                        <label id="kategoritersedia" class=" text-success " style="display:none">Kategori Tersedia</label>
                        <label id="kategoritidaktersedia" class="text-danger" style="display:none">Kategori Sudah Digunakan</label>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" value="tambah" id="savekategoritak">Save data</button>
            </div>
        </div>
    </div>
</div>
<!--MODAL List Kategori -->
<div class="modal hide fade" id="modalListKategoriTAK">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="formListKategoriTAK" name="formListKategoriTAK" enctype="multipart/form-data">
                @csrf
                <div class="alert alert-danger" style="display:none"></div>
               
                <table id="kategoritak_table" class="table table-bordered table-striped">
                    <thead>
                        <th>No.</th>
                        <th>Nama Kategori TAK</th>
                        <th>Aksi</th>
                    </thead>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>
