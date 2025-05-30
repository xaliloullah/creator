// $(document).ready(function () {
//     const table = $("#datatables").DataTable({
//         responsive: true,
//         language: {
//             search: "",
//             searchPlaceholder: "Rechercher...",
//         },
//         dom: "Bfrtip",
//         buttons: [
//             {
//                 extend: "colvis",
//                 text: '<i class="bi bi-eye-slash"></i> <span class="d-none d-sm-inline">Colonnes</span>',
//             },
//             {
//                 extend: "copy",
//                 text: '<i class="bi bi-clipboard"></i> <span class="d-none d-sm-inline">Copier</span>',
//                 exportOptions: {
//                     columns: ":not(.d-print-none):visible",
//                 },
//             },
//             {
//                 extend: "csv",
//                 text: '<i class="bi bi-file-earmark-spreadsheet"></i> <span class="d-none d-sm-inline">CSV</span>',
//                 exportOptions: {
//                     columns: ":not(.d-print-none):visible",
//                 },
//             },
//             {
//                 extend: "excel",
//                 text: '<i class="bi bi-file-earmark-excel"></i> <span class="d-none d-sm-inline">Excel</span>',
//                 exportOptions: {
//                     columns: ":not(.d-print-none):visible",
//                 },
//             },
//             {
//                 extend: "pdf",
//                 text: '<i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-sm-inline">PDF</span>',
//                 orientation: "landscape",
//                 pageSize: "A4",
//                 customize: function (doc) {
//                     doc.styles.title = {
//                         color: "black",
//                         fontSize: "20",
//                         alignment: "center",
//                         bold: true,
//                     };
//                     doc.styles.tableHeader = {
//                         bold: true,
//                         fontSize: 14,
//                         alignment: "center",
//                         color: "black",
//                     };
//                     doc.styles.tableBody = {
//                         fontSize: 12,
//                         alignment: "center",
//                     };
//                 },
//                 exportOptions: {
//                     columns: ":not(.d-print-none):visible",
//                 },
//             },
//             {
//                 extend: "print",
//                 text: '<i class="bi bi-printer"></i> <span class="d-none d-sm-inline">Imprimer</span>',
//                 exportOptions: {
//                     columns: ":not(.d-print-none):visible",
//                 },
//             },
//         ],
//         select: {
//             style: "multi",
//             selector: "td:not(.no-select)",
//         },
//     });
// });
$(document).ready(function () {
    $(".datatables").each(function () {
        $(this).DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Rechercher...",
            },
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "colvis",
                    text: '<i class="bi bi-eye-slash"></i> <span class="d-none d-sm-inline">Colonnes</span>',
                },
                {
                    extend: "copy",
                    text: '<i class="bi bi-clipboard"></i> <span class="d-none d-sm-inline">Copier</span>',
                    exportOptions: {
                        columns: ":not(.d-print-none):visible",
                    },
                },
                {
                    extend: "csv",
                    text: '<i class="bi bi-file-earmark-spreadsheet"></i> <span class="d-none d-sm-inline">CSV</span>',
                    exportOptions: {
                        columns: ":not(.d-print-none):visible",
                    },
                },
                {
                    extend: "excel",
                    text: '<i class="bi bi-file-earmark-excel"></i> <span class="d-none d-sm-inline">Excel</span>',
                    exportOptions: {
                        columns: ":not(.d-print-none):visible",
                    },
                },
                {
                    extend: "pdf",
                    text: '<i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-sm-inline">PDF</span>',
                    orientation: "landscape",
                    pageSize: "A4",
                    customize: function (doc) {
                        doc.styles.title = {
                            color: "black",
                            fontSize: "20",
                            alignment: "center",
                            bold: true,
                        };
                        doc.styles.tableHeader = {
                            bold: true,
                            fontSize: 14,
                            alignment: "center",
                            color: "black",
                        };
                        doc.styles.tableBody = {
                            fontSize: 12,
                            alignment: "center",
                        };
                    },
                    exportOptions: {
                        columns: ":not(.d-print-none):visible",
                    },
                },
                {
                    extend: "print",
                    text: '<i class="bi bi-printer"></i> <span class="d-none d-sm-inline">Imprimer</span>',
                    exportOptions: {
                        columns: ":not(.d-print-none):visible",
                    },
                },
            ],
            select: {
                style: "multi",
                selector: "td:not(.no-select)",
            },
        });
    });
});
