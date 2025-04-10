$(document).ready(function()
{   
    // initialize datatable
    $('#table-in-popup').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        "lengthMenu": [10, 100, 1000, 5000, 10000],
        "pageLength": 10,
        dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
        ],
        "oLanguage": {
            "sEmptyTable": "No data available"
        }
    });

    // initialize datatable
    $('#table-with-download').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        "lengthMenu": [100, 1000, 5000, 10000],
        "pageLength": 100,
        dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
        ],
        "oLanguage": {
            "sEmptyTable": "No data available"
        }
    });

    $('#dt-basic-example').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        "lengthMenu": [10, 100, 1000, 5000, 10000],
        "pageLength": 10,
        dom:
            /*  --- Layout Structure 
                --- Options
                l   -   length changing input control
                f   -   filtering input
                t   -   The table!
                i   -   Table information summary
                p   -   pagination control
                r   -   processing display element
                B   -   buttons
                R   -   ColReorder
                S   -   Select

                --- Markup
                < and >             - div element
                <"class" and >      - div with a class
                <"#id" and >        - div with an ID
                <"#id.class" and >  - div with an ID and a class

                --- Further reading
                https://datatables.net/reference/option/dom
                --------------------------------------
             */
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            /*{
                extend:    'colvis',
                text:      'Column Visibility',
                titleAttr: 'Col visibility',
                className: 'mr-sm-3'
            },*/
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                titleAttr: 'Generate PDF',
                className: 'btn-outline-danger btn-sm mr-1'
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Generate Excel',
                className: 'btn-outline-success btn-sm mr-1'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                titleAttr: 'Generate CSV',
                className: 'btn-outline-primary btn-sm mr-1'
            }
        ],
        "oLanguage": {
            "sEmptyTable": "No data available"
        }
    });

    $('#packages').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        "lengthMenu": [100, 1000, 5000, 10000],
        "pageLength": 100,
        dom:
            /*  --- Layout Structure 
                --- Options
                l   -   length changing input control
                f   -   filtering input
                t   -   The table!
                i   -   Table information summary
                p   -   pagination control
                r   -   processing display element
                B   -   buttons
                R   -   ColReorder
                S   -   Select

                --- Markup
                < and >             - div element
                <"class" and >      - div with a class
                <"#id" and >        - div with an ID
                <"#id.class" and >  - div with an ID and a class

                --- Further reading
                https://datatables.net/reference/option/dom
                --------------------------------------
             */
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            /*{
                extend:    'colvis',
                text:      'Column Visibility',
                titleAttr: 'Col visibility',
                className: 'mr-sm-3'
            },*/
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                titleAttr: 'Generate PDF',
                className: 'btn-outline-danger btn-sm mr-1'
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Generate Excel',
                className: 'btn-outline-success btn-sm mr-1'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                titleAttr: 'Generate CSV',
                className: 'btn-outline-primary btn-sm mr-1'
            }
        ],
        "oLanguage": {
            "sEmptyTable": "No data available"
        }
    });

    $('#payments_closing').dataTable({
        'paging':   true,  // Table pagination
        'ordering': true,  // Column ordering 
        'info':     true,  // Bottom left status text
        "lengthMenu": [2000],
        "pageLength": 2000,
        dom:
            /*  --- Layout Structure 
                --- Options
                l   -   length changing input control
                f   -   filtering input
                t   -   The table!
                i   -   Table information summary
                p   -   pagination control
                r   -   processing display element
                B   -   buttons
                R   -   ColReorder
                S   -   Select

                --- Markup
                < and >             - div element
                <"class" and >      - div with a class
                <"#id" and >        - div with an ID
                <"#id.class" and >  - div with an ID and a class

                --- Further reading
                https://datatables.net/reference/option/dom
                --------------------------------------
             */
            "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            /*{
                extend:    'colvis',
                text:      'Column Visibility',
                titleAttr: 'Col visibility',
                className: 'mr-sm-3'
            },*/
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                titleAttr: 'Generate PDF',
                className: 'btn-outline-danger btn-sm mr-1'
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                titleAttr: 'Generate Excel',
                className: 'btn-outline-success btn-sm mr-1'
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                titleAttr: 'Generate CSV',
                className: 'btn-outline-primary btn-sm mr-1'
            }
        ]
    });

});