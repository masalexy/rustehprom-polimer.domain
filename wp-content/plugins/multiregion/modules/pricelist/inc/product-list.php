<div class="product-lists"> Выберите:
    <select name="list_id" id="list_form">
        <option value="1" <?php if($_GET['list_id'] == 1) echo 'selected'; ?>>Товары на маркете</option>
        <option value="2" <?php if($_GET['list_id'] == 2) echo 'selected'; ?>>Товары на сайте</option>
    </select>
</div>
