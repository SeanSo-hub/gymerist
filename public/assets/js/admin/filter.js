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

function clearFilters() {
    window.location.href = "/checkins";
}



