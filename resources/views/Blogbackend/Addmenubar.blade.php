@extends('Blogbackend.components.layout')
@section('content')
<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
    <script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/jquery-menu-editor.min.js"></script>
<style>
    .container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .sortableLists {
        width: 40%;
        list-style: none;
        padding: 0;
    }

    .card {
        width: 55%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        padding: 15px;
    }

    .card-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .card-footer {
        padding: 15px;
        text-align: right;
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .output-section {
        width: 100%;
        margin-top: 20px;
    }

    textarea {
        width: 100%;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        resize: none;
    }

    .delete-btn {
        margin-left: 10px;
        font-size: 0.9em;
    }
</style>

<div class="container">
    <ul id="myEditor" class="sortableLists list-group">
    </ul>

    <?php
    $id = $finalmenu_output['id'];
    // dd($id);
    $finalmenu_output = json_decode($finalmenu_output['json_output'], true);
    ?>
    <div class="card">
        <div class="card-header">Edit Item</div>
        <div class="card-body">
            <form id="frmEdit" class="form-horizontal">
                <div class="form-group">
                    <label for="text">Text</label>
                    <div class="input-group">
                        <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Text">
                        <div class="input-group-append">
                            <button type="button" id="myEditor_icon" class="btn btn-outline-secondary"></button>
                        </div>
                    </div>
                    <input type="hidden" name="icon" class="item-menu">
                </div>
                <div class="form-group">
                    <label for="href">URL</label>
                    <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                </div>
                <div class="form-group">
                    <label for="target">Target</label>
                    <select name="target" id="target" class="form-control item-menu">
                        <option value="_self">Self</option>
                        <option value="_blank">Blank</option>
                        <option value="_top">Top</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="Permission">Permission</label>
                    <input type="text" name="Permission" class="form-control item-menu" id="Permission" placeholder="Permission">
                </div>
                <div class="card-footer">
                    <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                    <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                </div>
            </form>
        </div>
    </div>

    <div class="output-section">
        <form action="/updatejsondata" method="POST" class="json-form">
            @csrf
            <h3>Generated Menu JSON</h3>
            <button type="button" id="outputbtn" class="btn btn-success">Output</button><br><br>
            <textarea id="myTextarea" class="form-control" rows="8" name="json_output" required></textarea>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    var iconPickerOptions = { searchText: "Search...", labelHeader: "{0}/{1}" };
    var sortableListOptions = { placeholderCss: { 'background-color': "#cccccc" } };
    var arrayjson = <?php echo json_encode($finalmenu_output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>;

    var editor = new MenuEditor('myEditor', {
        listOptions: sortableListOptions,
        iconPicker: iconPickerOptions,
        maxLevel: 2,
        formOptions: {
            icon: 'input[name="icon"]',
            text: '#text',
            href: '#href',
            target: '#target',
            title: '#title'
        }
    });

    editor.setForm($('#frmEdit'));
    editor.setUpdateButton($('#btnUpdate'));
    editor.setData(arrayjson);

    $('#btnAdd').click(function () {
        editor.add();
    });

    $("#btnUpdate").click(function () {
        editor.update();
    });

    $("#outputbtn").click(function () {
        var str = editor.getString();
        $("#myTextarea").text(str);
    });

    $('#myEditor_icon').iconpicker({
        placement: 'bottomLeft',
        animation: true
    }).on('iconpickerSelected', function (event) {
        $('input[name="icon"]').val(event.iconpickerValue);
    });
</script>

@endsection
