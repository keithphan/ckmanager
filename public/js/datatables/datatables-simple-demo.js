window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    const nutritionTable = document.getElementById('nutritionTable');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    if (nutritionTable) {
        new simpleDatatables.DataTable(nutritionTable, {
            searchable: false,
            sortable: false,
            paging: false
        });
    }
});
