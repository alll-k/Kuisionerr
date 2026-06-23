<form action="{{ route('questions.store', $questionnaire->id) }}" method="POST">
    @csrf
    <div>
        <label for="question_text">Teks Pertanyaan</label>
        <input type="text" name="question_text" required class="form-control">
    </div>

    <div>
        <label for="type">Tipe Pertanyaan</label>
        <select name="type" id="question_type" class="form-control" onchange="toggleOptions()">
            <option value="text">Teks Bebas</option>
            <option value="radio">Pilihan Ganda (Hanya 1 Jawaban)</option>
            <option value="checkbox">Kotak Centang (Banyak Jawaban)</option>
        </select>
    </div>

    <div id="options_area" style="display: none; margin-top: 15px;">
        <label>Pilihan Jawaban</label>
        <div id="options_container">
            <input type="text" name="options[]" class="form-control mb-2" placeholder="Opsi 1">
        </div>
        <button type="button" class="btn btn-sm btn-secondary" onclick="addOption()">+ Tambah Pilihan</button>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Simpan Pertanyaan</button>
</form>

<script>
    // Logika agar tombol dan form dinamis berfungsi
    function toggleOptions() {
        let type = document.getElementById('question_type').value;
        let optionsArea = document.getElementById('options_area');
        
        if(type === 'radio' || type === 'checkbox') {
            optionsArea.style.display = 'block';
        } else {
            optionsArea.style.display = 'none';
        }
    }

    function addOption() {
        let container = document.getElementById('options_container');
        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'options[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Opsi Tambahan';
        container.appendChild(input);
    }
</script>