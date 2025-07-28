(function () {
    fetchCompanyList('initial');


})();

function fetchCompanyList(type) {
    if (document.getElementById('companyList_table')) {
        var useroptions = {
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "iDisplayLength": 25,
            "order": [1, 'desc'],
            "destroy": true,
            language: {
                search: "",
                searchPlaceholder: "Search"
            },
            "stateSave": type === 'initial' ? false : true,
            "ajax": {
                "url": "/crm/admin/companies/getcompanylist",
                "dataType": "json",
                "type": "GET",
                "data": function (data) {
                    data._token = $('meta[name="csrf-token"]').attr('content');
                },
                "error": function (xhr, error, thrown) {
                    console.error("Error fetching data: ", error);
                }
            },
            "columns": [{
                    "data": "company_id"
                },
                {
                    "data": "company_name"
                },
                {
                    "data": "vat_id"
                },
                {
                    "data": "invoice_email"
                },
                {
                    "data": "company_phone"
                },
                {
                    "data": "zipcode"
                },
                {
                    "data": "city"
                },
                {
                    "data": "country"
                },
            ]
        };

        var moduleTable = $('#companyList_table').DataTable(useroptions);

        $('#companyList_table_filter input').unbind().bind('keyup', function (e) {
            if (e.keyCode == 13) {
                moduleTable.search(this.value).draw();
            }
        });

        $('#companyList_table').parent().addClass('table-responsive');
    }
}
