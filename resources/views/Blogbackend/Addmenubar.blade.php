@extends('Blogbackend.components.layout')

@section('title', 'Menulist')

@section('content')
<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js"></script>
<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js"></script>
<script src="http://127.0.0.1:8000/bootstrap-iconpicker/js/jquery-menu-editor.min.js"></script>
<link rel="stylesheet" href='{{ asset('css/addmenubar.css') }}'>

<h1 style="text-align: center; background-color:rgb(54, 148, 192); padding:10px; border-radius:10px;">Menu Editor</h1>
<div class="containersss">
    <ul id="myEditor" class="sortableLists list-group"></ul>
    <?php
    $id = $finalmenu_output['id'];
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
                <!-- Hidden Fields for modulesname and moduleid -->
                <input type="hidden" name="modulesname" class="item-menu" id="modulesname">
                <input type="hidden" name="moduleid" class="item-menu" id="moduleid">

                <div class="card-footer">
                    <button type="button" id="Saveoutput" class="btn btn-success">Save</button>
                    <button type="button" id="btnUpdate" class="btn btn-primary"><i class="fas fa-sync-alt"></i> Update</button>
                    <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                </div>
            </form>
        </div>
    </div>

    <div class="output-section">
        <form action="/updatejsondata" method="POST" class="json-form">
            @csrf
            <textarea id="myTextarea" class="form-control" rows="8" name="json_output" required></textarea>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Save" id="Save" class="btn btn-primary m-2 width-100">
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    // Helper Function to Convert Text to Camel Case
    function toCamelCase(str) {
        return str
            .replace(/[-_\s/]+(.)?/g, (match, chr) => (chr ? chr.toUpperCase() : '')) // Remove spaces, slashes, underscores
            .replace(/^(.)/, (match, chr) => chr.toLowerCase()); // Ensure first character is lowercase
    }

    // Helper Function to Create a Simple Hash from a String
    String.prototype.hashCode = function () {
        var hash = 0, i, chr;
        for (i = 0; i < this.length; i++) {
            chr = this.charCodeAt(i);
            hash = (hash << 5) - hash + chr;
            hash |= 0; // Convert to 32bit integer
        }
        return hash;
    };

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
            title: '#title',
            modulesname: '#modulesname', 
            moduleid: '#moduleid'        
        }
    });

    editor.setForm($('#frmEdit'));
    editor.setUpdateButton($('#btnUpdate'));
    editor.setData(arrayjson);

    function updateModulesData(item) {
        if (!item.text) return;
        item.modulesname = toCamelCase(item.text);
        item.moduleid = item.text.hashCode();
        if (item.children && item.children.length > 0) {
            item.children.forEach(updateModulesData);
        }
    }

    // Automatically Populate Hidden Fields
    $('#text').on('input', function () {
        var textValue = $(this).val();
        var camelCaseValue = toCamelCase(textValue);
        $('#modulesname').val(camelCaseValue);
        $('#moduleid').val(camelCaseValue.hashCode());
    });

    $('#btnAdd').click(function () {
        editor.add();
        updateTextarea();
    });

    $('#btnUpdate').click(function () {
        editor.update();
        updateTextarea();
    });

    $('#Saveoutput').click(function (event) {
        updateTextarea();
        document.querySelector('.json-form').submit();
    });

    function updateTextarea() {
    var jsonString = editor.getString(); // Get the JSON string
    var jsonData = JSON.parse(jsonString); // Parse it into an object

    // Update modulesname and moduleid for all items (parents and children)
    jsonData.forEach(updateModulesData);

    // Set the updated JSON back to the textarea
    $('#myTextarea').val(JSON.stringify(jsonData, null, 2));
}


    $('#myEditor_icon').iconpicker({
        placement: 'bottomLeft',
        animation: true
    }).on('iconpickerSelected', function (event) {
        $('input[name="icon"]').val(event.iconpickerValue);
    });

    $(document).ready(function () {
        $(window).resize(function () {
            var screenWidth = $(window).width();
            if (screenWidth < 1060) {
                $('.containersss').css({
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                    justifyContent: 'center'
                });
                $('#myEditor').css('width', '70%');
            } else {
                $('.containersss').css('flexDirection', 'row');
            }
            if (screenWidth < 500) {
                $('#myEditor').css('width', '30%');
            }
        }).resize();
    });
</script>
@endsection
