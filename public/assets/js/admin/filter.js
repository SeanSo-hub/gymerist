const filterBySelect = document.getElementById('filter_by');
const customFilter = document.getElementById('custom_filter');
const monthFilter = document.getElementById('month_filter');
const yearFilter = document.getElementById('year_filter');

filterBySelect.addEventListener('change', function () {
    const selectedFilter = this.value;
    monthFilter.style.display = selectedFilter === 'month' ? 'block' : 'none';
    yearFilter.style.display = selectedFilter === 'year' ? 'block' : 'none';
});

filterBySelect.addEventListener('change', function () {
    const selectedFilter = this.value;
    monthFilter.style.display = selectedFilter === 'month' ? 'block' : 'none';
    yearFilter.style.display = selectedFilter === 'year' ? 'block' : 'none';
    customFilter.style.display = selectedFilter === 'custom' ? 'block' : 'none';
});


//for cashflow
document.addEventListener('DOMContentLoaded', function () {

    const customFilter = document.getElementById('custom_filter');
    const filterDropdown = document.getElementById('filter_by');

    function toggleCustomFilterVisibility() {
        const selectedFilter = filterDropdown.value;
        customFilter.style.display = selectedFilter === 'custom' ? 'block' : 'none';
    }
    filterDropdown.addEventListener('change', function () {
        toggleCustomFilterVisibility();
    });

    toggleCustomFilterVisibility();
});


//for list filters
function clearFilters() {
    const url = new URL(window.location.href);

    const params = new URLSearchParams(url.search);

    for (const key of params.keys()) {
        params.delete(key);
    }

    window.location.href = url.origin + url.pathname + '?';
}



