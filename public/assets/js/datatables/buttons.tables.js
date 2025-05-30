$(document).ready(function () {
    var table = $("#dataTables").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copy",
                exportOptions: {
                    columns: ":visible:not(.no-print)",
                },
            },
            {
                extend: "csv",
                exportOptions: {
                    columns: ":visible:not(.no-print)",
                },
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":visible:not(.no-print)",
                },
            },
            {
                extend: "pdf",
                exportOptions: {
                    columns: ":visible:not(.no-print)",
                },
            },
            {
                extend: "print",
                exportOptions: {
                    columns: ":visible:not(.no-print)",
                },
            },
        ],
    });
});
