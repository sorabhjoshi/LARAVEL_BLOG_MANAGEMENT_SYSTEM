@extends('Blogbackend.components.layout')

@section('content')
<div class="form-container"
    style="max-width: 600px; margin: 20px auto; padding: 25px; background: #ffffff; border-radius: 12px; box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);">
    <form action="{{ route('Generating') }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        <input type="hidden" name="model" value="{{ $modelName }}">
        <input type="hidden" name="table" value="{{ $tableName }}">
        <h1 style="text-align: center; color: #000000; font-size: 26px; font-weight: bold; margin-bottom: 15px;">Generate MVC</h1>
        <div style="display: flex; flex-direction: column; gap: 15px; margin: 0 auto;">
            <h4 style="font-size: 18px; font-weight: 500; color: #444;">Select listing columns:</h4>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach ($columns as $item)
                    <label style="display: flex; align-items: center; gap: 10px; font-size: 16px; color: #555; width: 48%;">
                        <input type="checkbox" name="columns[]" value="{{ $item }}"
                            style="transform: scale(1.3); margin-right: 8px;">
                        {{ ucfirst($item) }}
                    </label>
                @endforeach
            </div>
        </div>
        <div>
            <h5 style="font-size: 18px; font-weight: 500;">Select Input Fields to edit and create data</h5>
            @foreach ($columns as $item)
                <div style="display: flex; align-items: center; gap: 15px; margin: 10px 0; justify-content: space-between;">
                    <select name="fields[{{ $item }}]" class="field-select"
                        style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; width: 70%; background: #f5f5f5;">
                        <option selected disabled>Select input type</option>
                        <option value="text">Text</option>
                        <option value="file">File</option>
                        <option value="textarea">Textarea</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="date">Date</option>
                        <option value="radio">Radio</option>
                        <option value="email">Email</option>
                        <option value="select">Select</option>
                    </select>
                    <label style="font-size: 16px; color: #555; font-weight: 500; width: 25%;"
                        for="{{ $item }}">{{ ucfirst($item) }}</label>
                </div>
            @endforeach
        </div>
        <button type="submit"
            style="padding: 12px 25px; background: #0056b3; color: #ffffff; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; transition: background-color 0.3s;">
            Generate
        </button>
    </form>
</div>

<div id="dynamicModal" class="modal" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background-color: #0056b3; color: white;">
                <h5 class="modal-title">Select the data for select input</h5>
                <button type="button" class="btn-close" style="background: none; border: none; font-size: 18px;" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Please choose one of the options below:</p>
                <div style="margin-bottom: 20px;">
                    <label for="tableOption" style="margin-right: 20px;">
                        <input type="radio" name="optionType" value="table" id="tableOption"> Table
                    </label>
                    <label for="customOption">
                        <input type="radio" name="optionType" value="custom" id="customOption"> Custom
                    </label>
                </div>
                <!-- Section to show if 'Table' is selected -->
                <div id="tableFields" style="display: none; margin-top: 20px;">
                    <label for="tableDropdown">Select table:</label>
                    <select id="tableDropdown" name="table" style="margin-bottom: 10px; padding: 8px; width: 100%;">
                        <option value="" disabled selected>Select a table</option>
                        @foreach ($tableNames as $table)
                            <option value="{{ $table }}">{{ ucfirst($table) }}</option>
                        @endforeach
                    </select>
                    <div id="tableColumns" style="margin-top: 10px;">
                        <!-- Dynamically populated columns will appear here -->
                    </div>
                </div>
                <!-- Section to show if 'Custom' is selected -->
                <div id="customField" style="display: none; margin-top: 20px;">
                    <label for="customInput">Custom Input</label>
                    <input type="text" id="customInput" name="customInput" placeholder="Enter custom data"
                        style="width: 100%; padding: 8px; margin-top: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
            </div>
            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()" 
                    style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px;">Close</button>
                <button type="button" class="btn btn-primary"
                    style="padding: 10px 20px; background: #0056b3; color: white; border: none; border-radius: 5px;">Save changes</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script>const modal = document.getElementById('dynamicModal');
    const tableFields = document.getElementById('tableFields');
    const customField = document.getElementById('customField');
    const tableDropdown = document.getElementById('tableDropdown');
    const tableColumns = document.getElementById('tableColumns');
    
    // Add event listener to all .field-select elements
    document.querySelectorAll('.field-select').forEach(select => {
        select.addEventListener('change', (event) => {
            const selectedValue = event.target.value;
    
            if (selectedValue === 'select') {
                openModal();
            }
        });
    });
    
    // Add event listener for radio buttons in modal
    document.querySelectorAll('input[name="optionType"]').forEach(radio => {
        radio.addEventListener('change', (event) => {
            if (event.target.value === 'table') {
                tableFields.style.display = 'block';
                customField.style.display = 'none';
            } else if (event.target.value === 'custom') {
                tableFields.style.display = 'none';
                customField.style.display = 'block';
            }
        });
    });
    
    // Event listener for table dropdown change
    tableDropdown.addEventListener('change', (event) => {
        const selectedTable = event.target.value;
    
        if (selectedTable) {
            // AJAX request to fetch columns for the selected table
            fetch(`/api/get-table-columns/${selectedTable}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    tableColumns.innerHTML = ''; // Clear previous content
                    if (data.columns && data.columns.length > 0) {
                        const columnSelect = document.createElement('select');
                        columnSelect.name = 'tableColumns';
                        columnSelect.style = 'width: 100%; padding: 8px; margin-top: 10px;';
                        data.columns.forEach(column => {
                            const option = document.createElement('option');
                            option.value = column;
                            option.textContent = column;
                            columnSelect.appendChild(option);
                        });
                        tableColumns.appendChild(columnSelect);
                    } else {
                        tableColumns.innerHTML = '<p>No columns found for the selected table.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching table columns:', error);
                    tableColumns.innerHTML = '<p>Error loading columns. Please try again.</p>';
                });
        }
    });
    
    // Function to open the modal
    function openModal() {
        modal.style.display = 'block';
    }
    
    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
        tableFields.style.display = 'none';
        customField.style.display = 'none';
        tableColumns.innerHTML = ''; // Clear columns on close
        document.querySelectorAll('input[name="optionType"]').forEach(radio => radio.checked = false);
    }
    
</script>
@endsection
