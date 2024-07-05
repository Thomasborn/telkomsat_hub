<div class="form-row align-items-center">
        <div class="col-auto">
            <label for="bulan">Bulan:</label>
            <select name="bulan" id="bulan">
                <!-- Populate options dynamically -->
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-auto">
            <label for="tahun">Tahun:</label>
            <select name="tahun" id="tahun">
                <!-- Populate options dynamically -->
                <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                    <option value="<?= $i ?>" <?= $tahun == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit">Filter</button>
        </div>
    </div>