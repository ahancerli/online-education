<?= $this->extend('admin/layout') ?>

<?= $this->section('pageVendorStyles') ?>
<link href="<?= base_url('assets/admin') ?>/plugins/custom/jstree/jstree.bundle.css?v=7.0.8" rel="stylesheet" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('pageVendorScripts') ?>
<script src="<?= base_url('assets/admin') ?>/plugins/custom/jstree/jstree.bundle.js?v=7.0.8"></script>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    var categoryTree = null;

    function node_create() {
        var ref = $('#category_tree').jstree(true),
            sel = ref.get_selected();
        if (!sel.length) {
            return false;
        }
        sel = sel[0];
        sel = ref.create_node(sel, {"type": "file"});
        if (sel) {
            ref.edit(sel);
        }
    }

    function node_delete() {
        var ref = $('#category_tree').jstree(true),
            sel = ref.get_selected();
        if (!sel.length) {
            return false;
        }

        if (sel[0] === "j1_1") return false;

        $.showDeleteSwal(function () {
            $.get("/admin/category/delete/" + sel[0], function(response) {
                if (!response.success) {
                    $.showErrorNotification(response.message);
                    return;
                }

                ref.delete_node(sel);
                categoryTree.jstree("refresh");
            }, "JSON");
        });
    }

    $(function () {
        categoryTree = $('#category_tree').jstree({
            "plugins": ["wholerow", "checkbox", "types"],
            "core": {
                "animation": 0,
                "check_callback": true,
                'force_text': true,
                "themes": {"stripes": true, "responsive": true},
                'data': {
                    'url': "/admin/category/get_tree",
                    'dataType': 'json'
                }
            },
            "types": {
                "default": {
                    "icon": "flaticon2-folder"
                },
                "file": {
                    "icon": "flaticon2-file"
                }
            },
            "plugins": ["dnd", "search", "state", "types", "wholerow"],
            "state": {"key": "state_appventure"},
            "search": {
                "show_only_matches": true
            }
        });

        categoryTree.on("rename_node.jstree", function (e, data) {
            if (data.node.id > 0) {
                //rename
                var categoryId = data.node.id;
                var categoryName = data.text;
            } else {
                //create
                var parent = data.node.parent;
                var parentNode = categoryTree.jstree(true).get_node(parent);
                var sortOrder = parentNode.children.length;

                if (parent === "j1_1") parent = 0;

                var body = {"name": data.text, "parent_id": parent, "sort_order": sortOrder, "status": 1};
                $.post("/admin/category/create", body, function (response) {
                    if (!response.success)
                        return;

                    categoryTree.jstree("refresh");
                }, "JSON");
            }
        });

        categoryTree.on("move_node.jstree", function (e, data) {
            var categoryId = data.node.id;
            var parentId = data.parent;

            if (parentId === "j1_1") parentId = 0;

            var body = {"category_id": categoryId, "parent_id": parentId};
            $.post("/admin/category/move_category", body, function (response) {
                if (!response.success) {
                    $.showErrorNotification(response.message);
                }

                categoryTree.jstree("refresh");
            }, "JSON");
        });

        // Search
        var to = false;
        $('#tree_search').keyup(function () {
            if (to) {
                clearTimeout(to);
            }
            to = setTimeout(function () {
                var v = $('#tree_search').val();
                $('#category_tree').jstree(true).search(v);
            }, 250);
        });

        $("#edit_category_btn").click(function () {
            var categoryId = categoryTree.jstree(true).get_selected();

            if (!categoryId.length)
                return false;

            categoryId = categoryId[0];

            if (categoryId === "j1_1")
                return false;

            window.location.href = "/admin/category/edit/" + categoryId;
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('contentHead') ?>
<h3 class="kt-subheader__title">Kategoriler</h3>
<div class="kt-subheader__breadcrumbs">
    <a href="/admin" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="/admin/category" class="kt-subheader__breadcrumbs-link">Kategoriler</a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-lg-12">
            <!--begin::Portlet-->
            <div class="kt-portlet">
                <div class="card-body">
                    <div class="row" style="margin-top: 10px; margin-bottom: 20px">
                        <div class="col-md-4 col-sm-12">
                            <button id="btn_siralama" type="button" class="btn btn-success btn-sm" onclick="node_create();" data-toggle="tooltip" title="Altına kategori oluşturmak istediğiniz kategoriyi seçin">
                                <i class="flaticon2-plus"></i> Oluştur
                            </button>
                            <button type="button" class="btn btn-warning btn-sm text-white" id="edit_category_btn" data-toggle="tooltip" title="Düzenlemek istediğiniz kategoriyi seçin">
                                <i class="flaticon2-edit"></i> Düzenle
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="node_delete();" data-toggle="tooltip" title="Silmek istediğiniz kategoriyi seçin">
                                <i class="flaticon2-delete"></i> Sil
                            </button>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <input type="text" id="tree_search" class="form-control form-control-sm" placeholder="Kategori Ara...">
                        </div>
                    </div>
                    <div class="row">
                        <div id="category_tree" class="col-md-8 col-sm-12 jstree-default-large jstree-default-responsive"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
