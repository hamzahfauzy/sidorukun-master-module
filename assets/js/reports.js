window.reportReceives = $('.datatable-report-receives').DataTable({
    // stateSave:true,
    pagingType: 'full_numbers_no_ellipses',
    processing: true,
    search: {
        return: true
    },
    serverSide: true,
    ajax: {
        url: location.href,
        data: function(data){
            // Read values
            var startDate = $('input[name=start_date]').val()
            var endDate = $('input[name=end_date]').val()
            var suppliers = $('select[name=suppliers]').val()
            var types = $('select[name=types]').val()
            var sizes = $('select[name=sizes]').val()
            var brands = $('input[name=brands]').val()
            var colors = $('input[name=colors]').val()
            var motifs = $('input[name=motifs]').val()

            // Append to data
            data.searchByDate = {
                startDate,
                endDate
            }

            data.filter = {}
            if(suppliers)
            {
                data.filter.supplier_name = suppliers
            }
            
            if(types)
            {
                data.filter.type_name = types
            }
            
            if(sizes)
            {
                data.filter.size_name = sizes
            }
            
            if(brands)
            {
                data.filter.brand_name = brands
            }
            
            if(colors)
            {
                data.filter.color_name = colors
            }
            
            if(motifs)
            {
                data.filter.motif_name = motifs
            }

            if(!Object.keys(data.filter).length)
            {
                delete data.filter
            }

            // console.log(data)
        }
    },
    aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
})

window.reportOutgoings = $('.datatable-report-outgoings').DataTable({
    // stateSave:true,
    pagingType: 'full_numbers_no_ellipses',
    processing: true,
    search: {
        return: true
    },
    serverSide: true,
    ajax: {
        url: location.href,
        data: function(data){
            // Read values
            var startDate = $('input[name=start_date]').val()
            var endDate = $('input[name=end_date]').val()
            var customers = $('select[name=customers]').val()
            var channels = $('select[name=channels]').val()
            var outgoing_type = $('select[name=outgoing_type]').val()
            var types = $('select[name=types]').val()
            var sizes = $('select[name=sizes]').val()
            var brands = $('input[name=brands]').val()
            var colors = $('input[name=colors]').val()
            var motifs = $('input[name=motifs]').val()

            // Append to data
            data.searchByDate = {
                startDate,
                endDate
            }

            data.filter = {}
            if(types)
            {
                data.filter.type_name = types
            }
            
            if(sizes)
            {
                data.filter.size_name = sizes
            }
            
            if(brands)
            {
                data.filter.brand_name = brands
            }
            
            if(colors)
            {
                data.filter.color_name = colors
            }
            
            if(motifs)
            {
                data.filter.motif_name = motifs
            }
            
            if(customers)
            {
                data.filter.customer_name = customers
            }
            
            if(channels)
            {
                data.filter.channel_name = channels
            }
            
            if(outgoing_type)
            {
                data.filter.outgoing_type = outgoing_type
            }

            if(!Object.keys(data.filter).length)
            {
                delete data.filter
            }

            // console.log(data)
        }
    },
    aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
})

window.reportAdjusts = $('.datatable-report-adjusts').DataTable({
    // stateSave:true,
    pagingType: 'full_numbers_no_ellipses',
    processing: true,
    search: {
        return: true
    },
    serverSide: true,
    ajax: {
        url: location.href,
        data: function(data){
            // Read values
            var startDate = $('input[name=start_date]').val()
            var endDate = $('input[name=end_date]').val()
            var types = $('select[name=types]').val()
            var sizes = $('select[name=sizes]').val()
            var brands = $('input[name=brands]').val()
            var colors = $('input[name=colors]').val()
            var motifs = $('input[name=motifs]').val()

            // Append to data
            data.searchByDate = {
                startDate,
                endDate
            }

            data.filter = {}
            if(types)
            {
                data.filter.type_name = types
            }
            
            if(sizes)
            {
                data.filter.size_name = sizes
            }
            
            if(brands)
            {
                data.filter.brand_name = brands
            }
            
            if(colors)
            {
                data.filter.color_name = colors
            }
            
            if(motifs)
            {
                data.filter.motif_name = motifs
            }

            if(!Object.keys(data.filter).length)
            {
                delete data.filter
            }

            // console.log(data)
        }
    },
    aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
})

function downloadReportReceives()
{
    var data = {}
    var startDate = $('input[name=start_date]').val()
    var endDate = $('input[name=end_date]').val()
    var suppliers = $('select[name=suppliers]').val()
    var types = $('select[name=types]').val()
    var sizes = $('select[name=sizes]').val()
    var brands = $('input[name=brands]').val()
    var colors = $('input[name=colors]').val()
    var motifs = $('input[name=motifs]').val()

    // Append to data
    data.searchByDate = {
        startDate,
        endDate
    }

    data.filter = {}
    if(suppliers)
    {
        data.filter.supplier_name = suppliers
    }
    
    if(types)
    {
        data.filter.type_name = types
    }
    
    if(sizes)
    {
        data.filter.size_name = sizes
    }
    
    if(brands)
    {
        data.filter.brand_name = brands
    }
    
    if(colors)
    {
        data.filter.color_name = colors
    }
    
    if(motifs)
    {
        data.filter.motif_name = motifs
    }

    if(!Object.keys(data.filter).length)
    {
        delete data.filter
    }
    
    var search = window.reportReceives.search()
    if(search)
    {
        data.search = search
    }
    const url = Qs.stringify(data, { encode: false })

    window.location = "/master/reports/receives/download?"+url
}

function downloadReportOutgoings()
{
    var data = {}
    var startDate = $('input[name=start_date]').val()
    var endDate = $('input[name=end_date]').val()
    var customers = $('select[name=customers]').val()
    var channels = $('select[name=channels]').val()
    var outgoing_type = $('select[name=outgoing_type]').val()
    var types = $('select[name=types]').val()
    var sizes = $('select[name=sizes]').val()
    var brands = $('input[name=brands]').val()
    var colors = $('input[name=colors]').val()
    var motifs = $('input[name=motifs]').val()

    // Append to data
    data.searchByDate = {
        startDate,
        endDate
    }

    data.filter = {}
    
    if(types)
    {
        data.filter.type_name = types
    }
    
    if(sizes)
    {
        data.filter.size_name = sizes
    }
    
    if(brands)
    {
        data.filter.brand_name = brands
    }
    
    if(colors)
    {
        data.filter.color_name = colors
    }
    
    if(motifs)
    {
        data.filter.motif_name = motifs
    }
    
    if(customers)
    {
        data.filter.customer_name = customers
    }
    
    if(channels)
    {
        data.filter.channel_name = channels
    }
    
    if(outgoing_type)
    {
        data.filter.outgoing_type = outgoing_type
    }

    if(!Object.keys(data.filter).length)
    {
        delete data.filter
    }
    
    var search = window.reportOutgoings.search()
    if(search)
    {
        data.search = search
    }
    const url = Qs.stringify(data, { encode: false })

    window.location = "/master/reports/outgoings/download?"+url
}

function downloadReportAdjusts()
{
    var data = {}
    var startDate = $('input[name=start_date]').val()
    var endDate = $('input[name=end_date]').val()
    var types = $('select[name=types]').val()
    var sizes = $('select[name=sizes]').val()
    var brands = $('input[name=brands]').val()
    var colors = $('input[name=colors]').val()
    var motifs = $('input[name=motifs]').val()

    // Append to data
    data.searchByDate = {
        startDate,
        endDate
    }

    data.filter = {}
    if(types)
    {
        data.filter.type_name = types
    }
    
    if(sizes)
    {
        data.filter.size_name = sizes
    }
    
    if(brands)
    {
        data.filter.brand_name = brands
    }
    
    if(colors)
    {
        data.filter.color_name = colors
    }
    
    if(motifs)
    {
        data.filter.motif_name = motifs
    }

    if(!Object.keys(data.filter).length)
    {
        delete data.filter
    }
    
    var search = window.reportReceives.search()
    if(search)
    {
        data.search = search
    }
    const url = Qs.stringify(data, { encode: false })

    window.location = "/master/reports/adjusts/download?"+url
}

try {
    $('select').select2()
} catch (error) {
    
}