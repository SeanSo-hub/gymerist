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
    customFilter.style.display = selectedFilter === 'custom' ? 'block' : 'none'; // Show custom filter if selected
});


//for cashflow
document.addEventListener('DOMContentLoaded', function () {

    const customFilter = document.getElementById('custom_filter');
    // Select the filter dropdown
    const filterDropdown = document.getElementById('filter_by');

    function toggleCustomFilterVisibility() {
        const selectedFilter = filterDropdown.value;
        customFilter.style.display = selectedFilter === 'custom' ? 'block' : 'none';
    }

    // Add an event listener to the filter dropdown to update the cards visibility and toggle custom filter visibility when the selected filter changes
    filterDropdown.addEventListener('change', function() {
        toggleCustomFilterVisibility();
    });

    toggleCustomFilterVisibility();
});


//for list filters

function clearFilters() {
    // Create a new URL object from the current URL
    const url = new URL(window.location.href);

    // Use URLSearchParams to manipulate the query string
    const params = new URLSearchParams(url.search);

    // Delete all parameters
    for (const key of params.keys()) {
        params.delete(key);
    }
    
    window.location.href = url.origin + url.pathname + '?';
}



