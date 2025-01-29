@extends('Blogbackend.components.layout')

@section('content')
<style>
    :root {
        --back: whitesmoke;
        --text: #2c3e50;
        --texth2: #6c757d;
        --textwhite:white;
    }

    .dark {
        --back: #333;
        --text: white;
        --texth2: white;
        --textwhite:black;
    }

    .form-label {
        color: black;
    }

    .module-selection {
        background: var(--back);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        margin: 2rem auto;
        max-width: 800px;
    }

    .module-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        padding-bottom: 1rem;
    }

    .module-header h2 {
        color: var(--text);
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .module-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #3498db, #2980b9);
        border-radius: 2px;
    }

    .columns-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .columns-grid::-webkit-scrollbar {
        width: 8px;
    }

    .columns-grid::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .columns-grid::-webkit-scrollbar-thumb {
        background: #3498db;
        border-radius: 4px;
    }

    .columns-grid::-webkit-scrollbar-thumb:hover {
        background: #2980b9;
    }

    .column-item {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e1e8ed;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
    }

    .column-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #3498db;
    }

    .custom-checkbox {
        display: flex;
        align-items: center;
        width: 100%;
        cursor: pointer;
    }

    .custom-checkbox input[type="checkbox"] {
        width: 30px;
        height: 18px;
        margin-right: 10px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .custom-checkbox label {
        color: #34495e;
        font-size: 0.95rem;
        cursor: pointer;
        user-select: none;
        margin-left: 10px;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .submit-btn {
        display: block;
        width: 100%;
        max-width: 200px;
        margin: 2rem auto 0;
        padding: 0.8rem 1.5rem;
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        background: linear-gradient(135deg, #2980b9, #3498db);
    }

    .overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px);
    z-index: 1000;
    transition: all 0.3s ease;
}

.overlay.active {
    display: flex;
    animation: fadeIn 0.3s ease;
}

.overlay-content {
    background: var(--back, #fff);
    padding: 2rem;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    position: relative;
    animation: slideUp 0.3s ease;
}

/* Selection Method Styles */
.overlay-content h3 {
    color: var(--text, #2c3e50);
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    text-align: center;
    font-weight: 600;
}

.method-selection {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: rgba(52, 152, 219, 0.1);
    border-radius: 10px;
}

/* Radio Button Styling */
.method-selection input[type="radio"] {
    display: none;
}

.method-selection label {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    color: var(--text, #2c3e50);
}

.method-selection label::before {
    content: '';
    width: 20px;
    height: 20px;
    border: 2px solid #3498db;
    border-radius: 50%;
    margin-right: 10px;
    transition: all 0.3s ease;
}

.method-selection input[type="radio"]:checked + label {
    background: rgba(52, 152, 219, 0.2);
}

.method-selection input[type="radio"]:checked + label::before {
    background: #3498db;
    box-shadow: inset 0 0 0 4px var(--back, #fff);
}

/* Table Selection Styles */
.table-selection, .customize-selection {
    display: none;
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    margin-top: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.table-selection.active, .customize-selection.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

.table-selection label, .customize-selection label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--textwhite);
    font-weight: 500;
}

.table-selection select, .customize-selection input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e1e8ed;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
}

.table-selection select:focus, .customize-selection input:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    outline: none;
}

/* Submit Button */
.overlay-content button {
    display: block;
    width: 100%;
    max-width: 200px;
    margin: 2rem auto 0;
    padding: 0.8rem 1.5rem;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.overlay-content button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    background: linear-gradient(135deg, #2980b9, #3498db);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
#close-btn {
        position: absolute;
        right: 15px;
        top: 15px;
        background: none;
        border: none;
        font-size: 24px;
        color: red;
        cursor: pointer;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    #close-btn:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: rotate(90deg);
    }
    @media (max-width: 768px) {
        .module-selection {
            padding: 1.5rem;
            margin: 1rem;
        }

        .module-header h2 {
            font-size: 1.75rem;
        }

        .columns-grid {
            grid-template-columns: 1fr;
            max-height: 60vh;
        }
    }
</style>

<div class="module-selection">
    <div class="container">
        <div class="module-header">
            <h2>Table View</h2>
            <p class="text-muted">Choose the columns you want to include</p>
        </div>

        <form action="/createmvc" method="POST">
            @csrf

            <div class="columns-grid">
                @foreach ($columns as $column)
                    @if (in_array($column, ['id']))
                        <input type="checkbox" class="form-check-input" id="column_{{ $loop->index }}" name="columns[]"
                            value="{{ $column }}" checked hidden>
                    @else
                        <div class="column-item">
                            <div class="custom-checkbox">
                                <input type="checkbox" class="form-check-input" id="column_{{ $loop->index }}" name="columns[]"
                                    value="{{ $column }}">
                                <label class="form-check-label" for="column_{{ $loop->index }}">{{ $column }}</label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="module-header">
                <h2>Select Input Type</h2>
                <p class="text-muted">Assign input types to the columns</p>
            </div>

            <div class="columns-grid">
                @foreach ($columns as $column)
                    <div class="column-item">
                        <label for="inputType_{{ $loop->index }}" class="form-label">{{ $column }}</label>
                        <select name="inputTypes[{{ $column }}]" id="inputType_{{ $loop->index }}" class="custom-select"
                            style="margin-left: 10px; flex: 1;" onchange="handleSelectTypeChange(this)">
                            <option value="text">Text</option>
                            <option value="select2">Select</option>
                            <option value="number">Number</option>
                            <option value="email">Email</option>
                            <option value="password">Password</option>
                            <option value="textarea">Textarea</option>
                            <option value="date">Date</option>
                            <option value="file">File</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                @endforeach
            </div>

            <!-- Hidden input to store selected data -->
            <input type="hidden" name="selected_data" id="selected_data">

            <input type="hidden" name="modelName" value="{{ old('modelName', $modelName) }}" readonly>
            <input type="hidden" name="tablename" value="{{ old('tablename', $tablename) }}" readonly>

            <button type="submit" class="submit-btn">
                Submit Selection
            </button>
        </form>
    </div>
</div>

<div class="overlay" id="select2Overlay">
    <div class="overlay-content">
        <h3>Select by</h3>
        <button type="button" class="close-overlay-btn" id="close-btn" onclick="closeOverlay()">x</button>
        <div>
            <input type="radio" id="byTable" name="selectMethod" value="table" onclick="toggleOverlayContent()"> 
            <label for="byTable">By Table</label>
            <input type="radio" id="byCustomize" name="selectMethod" value="customize" onclick="toggleOverlayContent()"> 
            <label for="byCustomize">By Customize</label>
        </div>

        <div id="tableSelection" class="table-selection">
            <label for="tableDropdown">Select Table:</label>
            <select id="tableDropdown" onchange="updateColumnsDropdown()">
                <option value="">Select a table</option>
                @foreach($tableNames as $table)
                    <option value="{{ $table }}">{{ $table }}</option>
                @endforeach
            </select>

            <br><label for="columnsDropdown">Select Column:</label>
            <select id="columnsDropdown">
                <option value="">Select a column</option>
            </select>
        </div>

        <div id="customizeSelection" class="customize-selection">
            <label for="keyInput">Key:</label>
            <input type="text" id="keyInput" name="keyInput">

            <br> <label for="valueInput">Value:</label>
            <input type="text" id="valueInput" name="valueInput">
        </div>

        <button type="button" onclick="submitSelect2Data()">Submit</button>
    </div>
</div>


<script>
    function handleSelectTypeChange(selectElement) {
    if (selectElement.value === 'select2') {
        // Store the current select element being configured
        currentSelectElement = selectElement;
        document.getElementById('select2Overlay').classList.add('active');
        
        // Reset radio buttons and form fields
        document.querySelectorAll('input[name="selectMethod"]').forEach(radio => radio.checked = false);
        document.getElementById('tableSelection').classList.remove('active');
        document.getElementById('customizeSelection').classList.remove('active');
        document.getElementById('tableDropdown').value = '';
        document.getElementById('columnsDropdown').innerHTML = '<option value="">Select Column</option>';
        document.getElementById('keyInput').value = '';
        document.getElementById('valueInput').value = '';
    }
}
</script>


<script>
    let select2Configurations = {};
    let currentSelectElement = null;

    function closeOverlay() {
        console.log('red');
        document.getElementById('select2Overlay').classList.remove('active');
        currentSelectElement = null;
    }

    document.getElementById('tableDropdown').addEventListener('change', function() {
        var selectedTable = this.value;
        document.getElementById('selected_table').value = selectedTable;
    });

    
    

    function toggleOverlayContent() {
        const method = document.querySelector('input[name="selectMethod"]:checked').value;
        if (method === 'table') {
            document.getElementById('tableSelection').classList.add('active');
            document.getElementById('customizeSelection').classList.remove('active');
        } else {
            document.getElementById('customizeSelection').classList.add('active');
            document.getElementById('tableSelection').classList.remove('active');
        }
    }

    function updateColumnsDropdown() {
    const table = document.getElementById('tableDropdown').value;
    const columnsDropdown = document.getElementById('columnsDropdown');
    columnsDropdown.innerHTML = '<option value="">Select Column</option>';

    if (table) {
        fetch(`/getColumns/${table}`)
            .then(response => response.json())
            .then(data => {
                if (data.columns) {
                    data.columns.forEach(column => {
                        columnsDropdown.innerHTML += `<option value="${column}">${column}</option>`;
                    });
                }
            })
            .catch(error => console.error('Error fetching columns:', error));
    }
}


function submitSelect2Data() {
    if (!currentSelectElement) return;

    const columnName = currentSelectElement.closest('.column-item').querySelector('label').textContent.trim();
    const method = document.querySelector('input[name="selectMethod"]:checked')?.value;

    if (!method) {
        alert('Please select a method.');
        return;
    }

    let configuration = {
        columnName: columnName,
        inputType: 'select2',
        method: method
    };

    if (method === 'table') {
        configuration.table = document.getElementById('tableDropdown').value.trim();
        configuration.column = document.getElementById('columnsDropdown').value.trim();

        if (!configuration.table || !configuration.column) {
            alert('Please select both a table and a column.');
            return;
        }
    } else {
        configuration.key = document.getElementById('keyInput').value.trim();
        configuration.value = document.getElementById('valueInput').value.trim();

        if (!configuration.key || !configuration.value) {
            alert('Please enter both key and value.');
            return;
        }
    }

    // Store configuration for this column
    select2Configurations[columnName] = configuration;

    // Update hidden input with all configurations
    document.getElementById('selected_data').value = JSON.stringify(Object.values(select2Configurations));

    // Close overlay
    document.getElementById('select2Overlay').classList.remove('active');
    currentSelectElement = null;

    // Show success message
    alert(`Select configuration saved for ${columnName}`);
}


    // Add form submit handler to validate all select2 fields are configured
    document.querySelector('form').addEventListener('submit', function(e) {
        const select2Fields = Array.from(document.querySelectorAll('select.custom-select'))
            .filter(select => select.value === 'select2');
        
        const unconfiguredFields = select2Fields.filter(select => {
            const columnName = select.closest('.column-item').querySelector('label').textContent.trim();
            return !select2Configurations[columnName];
        });

        if (unconfiguredFields.length > 0) {
            e.preventDefault();
            alert('Please configure all Select2 fields before submitting');
            return false;
        }
    });
</script>
@endsection