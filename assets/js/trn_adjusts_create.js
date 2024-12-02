$('select').on('select2:selecting', function(e) {
    if(e.currentTarget.name == 'trn_adjusts[item_id]')
    {
        const id = e.params.args.data.id;
        fetch('/api/crud/index?table=mst_items&filter[id]='+id)
        .then(res => res.json())
        .then(res => {
            $('[name="trn_adjusts[unit]"]').val(res.data[0].unit)
        })
    }
})