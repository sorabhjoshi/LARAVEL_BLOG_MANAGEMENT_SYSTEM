@extends('Blogbackend.components.layout')
@section('content')
<style>
    .card .card-header + .card-body, .card .card-header + .card-content > .card-body:first-of-type {
    padding-top: 0;
    margin-left: -135px;
    width: 118%;
}
</style>
<div class="container">
<ul id="myEditor" class="sortableLists list-group" style="width:38%; margin-top:-30px;">
</ul>
<?php

$id = $finalmenu_output['id'];

$finalmenu_output = json_decode($finalmenu_output['json_output'] ,true);

?>
<div class="card border-primary mb-3"  style="margin-top:-30%;">
    <div class="card-header bg-primary text-white">Edit item</div>

        <div class="card-body">
       <!-- start  -->
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
        <label for="title">Permission </label>
        <input type="text" name="Permission" class="form-control item-menu" id="Permission" placeholder="Permission">
        </div>
        <div class="card-footer">
        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
    </div>
        </form>
        </div>

        </div>
</div>


</div>
<div class="output-section" style="margin-top:-24%; margin-left:-11px">
            
            <form action="/updatejsondata" method="POST" class="json-form" style=" margin-left: 84px;
                width: 45%;
                margin-top: 249px;
            ">
                @csrf<h3>Generated Menu JSON</h3>
            <button type="button" id="outputbtn" class="btn btn-success">Output </button><br><br>
            <!-- <button type="button" id="remove" class="btn btn-danger">remove </button> -->
            <br><br>
            <textarea id="myTextarea" class="form-control" rows="8" name="json_output"  required></textarea>
            <input type="hidden" name="id" value="<?php echo $id ;?>">
            <input type="submit" value="save"class="btn btn-primary">
            </form>
        </div>
@endsection
@section('js')

 <script>
  var iconPickerOptions = { searchText: "Buscar...", labelHeader: "{0}/{1}" };
  var sortableListOptions = {
      placeholderCss: { 'background-color': "#cccccc" }
  };

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

  // Update item
  $("#btnUpdate").click(function () {
      editor.update();
  });

  // Add item
  $('#btnAdd').click(function () {
      editor.add();
  });

  // Output menu as a string
  $("#outputbtn").click(function () {
      var str = editor.getString();
      $("#myTextarea").text(str);
  });

  // Initialize Icon Picker
  $('#myEditor_icon').iconpicker({
      placement: 'bottomLeft',
      animation: true
  }).on('iconpickerSelected', function (event) {
      $('input[name="icon"]').val(event.iconpickerValue);
  });
</script>


@endsection