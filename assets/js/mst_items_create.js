$('select').on('select2:select', function(e) {
    var name = $('[name="mst_items[type_id]"')[0].selectedOptions[0].label + ' ' + $('[name="mst_items[size_id]"')[0].selectedOptions[0].label + ' ' + $('[name="mst_items[brand_id]"')[0].selectedOptions[0].label + ' ' + $('[name="mst_items[motif_id]"')[0].selectedOptions[0].label + ' ' + $('[name="mst_items[color_id]"')[0].selectedOptions[0].label
    $('[name="mst_items[name]"').val(name.replaceAll('- Pilih -', '').trim());
})