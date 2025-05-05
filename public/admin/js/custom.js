$(document).ready(function () {
    $(".fileinput").each(function () {
        // Chọn ảnh
        const fileinput = $(this);
        const preview = fileinput.find(".fileinput-preview");

        const updatePreviewVisibility = () => {
            if (fileinput.hasClass("fileinput-exists")) {
                preview.show();
            } else {
                preview.hide();
            }
        };
        updatePreviewVisibility();
        new MutationObserver(updatePreviewVisibility).observe(this, {
            attributes: true,
            attributeFilter: ["class"]
        });

        // Xóa ảnh
        fileinput.find('[data-dismiss="fileinput"]').on('click', function () {
            const parent = fileinput.closest('.form-group');
            const inputFlag = parent.find('input.remove-image-flag');
            inputFlag.val(1);
        });
    });

    // Nhân bản item
    $(document).on('click', '.btn-add', function () {
        const $group = $(this).closest('.dynamic-group');
        const containerSelector = $group.data('container');
        const itemSelector = $group.data('item');
        const $container = $(containerSelector);
        const $item = $container.find(itemSelector).first();

        $item.find('.error').remove();
        // Clone item đầu tiên và reset input
        const $clone = $item.clone();
        console.log($clone);
        $clone.find('input').val('');
        $container.find('.btn-add').before($clone);
    });

    // Xóa item
    $(document).on('click', '.btn-remove', function () {
        const $group = $(this).closest('.dynamic-group');
        const containerSelector = $group.data('container');
        const itemSelector = $group.data('item');
        const $container = $(containerSelector);
        const itemsCount = $container.find(itemSelector).length;

        // Nếu còn hơn 1 thì cho phép xóa
        if (itemsCount > 1) {
            $(this).closest(itemSelector).remove();
        }
    });
});