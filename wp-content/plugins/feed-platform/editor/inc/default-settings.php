<?php
    $shop_name = get_option("shop-name_{$current_gorod}_{$current_feed}");
    $shop_sales_note = get_option("shop-sales-note_{$current_gorod}_{$current_feed}");
    $shop_delivery = get_option("shop-delivery_{$current_gorod}_{$current_feed}");
    $shop_delivery_price = get_option("shop-delivery-price_{$current_gorod}_{$current_feed}");
    $shop_pickup = get_option("shop-pickup_{$current_gorod}_{$current_feed}");
    $shop_is_store = get_option("shop-is-store_{$current_gorod}_{$current_feed}");
    $shop_is_warranty = get_option("shop-is-warranty_{$current_gorod}_{$current_feed}");
?>
<table border="1" class="default-settings">
    <tr>
        <th>Название магазина</th>
        <th>Предложение</th>
        <th>Доставка</th>
        <th>Цена доставка</th>
        <th>Самовывоз</th>
        <th>Магазин</th>
        <th>Гарантия производителя</th>
    </tr>
    <tr>
        <td>
            <input type="text" class="def-set-item" name="shop-name" value="<?php echo $shop_name; ?>" />
        </td>
        <td>
            <input type="text" class="def-set-item" name="shop-sales-note" value="<?php echo $shop_sales_note; ?>" />
        </td>
        <td>
            <select class="def-set-item" name="shop-delivery">
                <option value="1" <?php if($shop_delivery == 1) echo 'selected'; ?>>Да</option>
                <option value="0" <?php if($shop_delivery == 0) echo 'selected'; ?>>Нет</option>
            </select>
        </td>
        <td>
            <input type="number" class="def-set-item" name="shop-delivery-price" value="<?php echo $shop_delivery_price; ?>" />
        </td>
        <td>
            <select class="def-set-item" name="shop-pickup">
                <option value="1" <?php if($shop_pickup == 1) echo 'selected'; ?>>Да</option>
                <option value="0" <?php if($shop_pickup == 0) echo 'selected'; ?>>Нет</option>
            </select>
        </td>
        <td>
            <select class="def-set-item" name="shop-is-store">
                <option value="1" <?php if($shop_is_store == 1) echo 'selected'; ?>>Да</option>
                <option value="0" <?php if($shop_is_store == 0) echo 'selected'; ?>>Нет</option>
            </select>
        </td>
        <td>
            <select class="def-set-item" name="shop-is-warranty">
                <option value="1" <?php if($shop_is_warranty == 1) echo 'selected'; ?>>Да</option>
                <option value="0" <?php if($shop_is_warranty == 0) echo 'selected'; ?>>Нет</option>
            </select>
        </td>
    </tr>
</table>
