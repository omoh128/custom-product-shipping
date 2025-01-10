<div class="custom-shipping-notice">
    <p><strong><?php esc_html_e('Product Specific Shipping Costs:', 'custom-shipping'); ?></strong></p>
    <ul>
        <?php foreach ($shipping_items as $item): ?>
            <li>
                <?php echo esc_html(sprintf(
                    '%s: $%s per item',
                    $item['name'],
                    $item['cost']
                )); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
